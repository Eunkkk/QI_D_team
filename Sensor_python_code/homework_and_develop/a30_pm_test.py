import time
import sqlite3
from datetime import datetime
conn = sqlite3.connect("pm_aqi.db")
c = conn.cursor()
c.execute("CREATE TABLE IF NOT EXISTS history (time REAL PRIMARY KEY NOT NULL, pm REAL, pm_aqi REAL)")
conn.close()

select_pin = [24, 25, 26, 27]
en_bit = 28
mode = 0

c_values_pm25 = [ [0.0, 12, 0, 50],
                  [12.1, 35.4, 51, 100],
                  [35.5, 55.4, 101, 150],
                  [55.5, 150.4, 151, 200],
                  [150.5, 250.4, 201, 300],
                  [250.5, 350.4, 301, 400],
                  [350.5, 500.4, 401, 500],]

for i in range(0, 4):
    pin_direction = open("/gpio/pin" + str(i + 24) + "/direction", 'w')
    pin_direction.write("out")
    pin_direction.close()


    
def ugm3_to_aqi(ugm3):
    gas=ugm3
    if gas > 500.4:
        pm_aqi = 500
    elif gas < 0:
        return "Please re-enter."
    else:
        for values in c_values_pm25:
            if values[0] <= gas <= values[1]:
                pm_aqi = cal_aqi(values, gas)
    return int(pm_aqi)    

def cal_aqi(breakpoints, C):
    Clow = breakpoints[0]
    Chigh = breakpoints[1]
    Ilow = breakpoints[2]
    Ihigh = breakpoints[3]
    aqi = (((Ihigh-Ilow)/(Chigh-Clow))*(C-Clow)) + Ilow
    
    return aqi

def pin_mask(bit):
    if bit == 0:
        return 1
    if bit == 1:
        return 2
    if bit == 2:
        return 4
    if bit == 3:
        return 8


def write_bit_to_gpio_pin(pin_num, value):
    if value == 1:
        filename = "/gpio/pin" + str(pin_num) + "/value"
        file = open(filename, 'w')
        file.write("1")
        file.close()
        #print "pin{0} is HIGH".format(pin_num)
    elif value == 0:
        filename = "/gpio/pin" + str(pin_num) + "/value"
        file = open(filename, 'w')
        file.write("0")
        file.close()
        #print "pin{0} is LOW".format(pin_num)
    else:
        return 0


def map_select_gpio_pin(bit):
    if bit == 0:
        return 24
    if bit == 1:
        return 25
    if bit == 2:
        return 26
    if bit == 3:
        return 27


def mux(channel, en=True):
    write_bit_to_gpio_pin(en_bit, ~en)
    s = [0, 0, 0, 0]
    for i in range(0, 4):
        s[i] = (channel & pin_mask(i)) >> i
        write_bit_to_gpio_pin(map_select_gpio_pin(i), s[i])
    #return s


def temperature(degK):
    #tmp()
    degV = degK + 0.0010*(0.0259 - 0.0253)
    print degV
    return degV
    
    
def input_analog_value():
    raw = int(open("/sys/bus/iio/devices/iio:device0/in_voltage0_raw").read())
    scale = float(open("/sys/bus/iio/devices/iio:device0/in_voltage_scale").read())
    result = raw * scale
    real_value = ((result - 0.31222)/1.0412) + 3
    #tmp = ((result - 0.2) / 1.0417) + 0.171
    
    
    #return tmp
    #return result
    return real_value # return value is [V]


def cal_pm(voltage):
    hppcf = 50.0 + (2433.0*voltage) + 1386.0*(voltage**2)
    pm = 0.518 + (0.00274*hppcf)
    
    return pm/1000


print "Hello"
while True:
    select_bits = mux(1)
        
    con = input_analog_value()
    a = cal_pm(con)
    b = ugm3_to_aqi(a)
    conn = sqlite3.connect("pm_aqi.db")
    c = conn.cursor()
    c.execute("INSERT INTO history VALUES (?,?,?)", (datetime.now(), a, b))
    conn.commit()
    conn.close()   
    print '\n'
    print con
    print a
    print b
    time.sleep(1)