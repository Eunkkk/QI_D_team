from bluetooth import *
import time
import sqlite3
from datetime import datetime

server_sock=BluetoothSocket( RFCOMM )
server_sock.bind(("",PORT_ANY))
server_sock.listen(1)

conn = sqlite3.connect("aqi.db")
c = conn.cursor()
c.execute("CREATE TABLE IF NOT EXISTS history (time REAL PRIMARY KEY NOT NULL, temp REAL, pm25 REAL, no2 REAL, o3 REAL, co REAL, so2 REAL)")
conn.close()

'''
sensor_value[0] : temperature   /   sensor_value[1] : pm    /   sensor_value[2] : NO2
sensor_value[3] : O3            /   sensor_value[4] : CO    /   sensor_value[5] : SO2
'''
c_values_pm25 = [ [0.0, 12, 0, 50],
                  [12.1, 35.4, 51, 100],
                  [35.5, 55.4, 101, 150],
                  [55.5, 150.4, 151, 200],
                  [150.5, 250.4, 201, 300],
                  [250.5, 350.4, 301, 400],
                  [350.5, 500.4, 401, 500],]
c_values_co = [ [0.0, 4.4, 0, 50],
                [4.5, 9.4, 51, 100],
                [9.5, 12.4, 101, 150],
                [12.5, 15.4, 151, 200],
                [15.5, 30.4, 201, 300],
                [30.5, 40.4, 301, 400],
                [40.5, 50.4, 401, 500],]
c_values_so2 = [[0, 35, 0, 50],
                [36, 75, 51, 100],
                [76, 185, 101, 150],
                [186, 304, 151, 200],
                [305, 604, 201, 300],
                [805, 1004, 401, 500],]              
c_values_no2 = [[0, 53, 0, 50],
                [54, 100, 51, 100],
                [101, 360, 101, 150],
                [361, 649, 151, 200],
                [650, 1249, 201, 300],
                [1250, 1649 ,301, 400],
                [1650, 2049, 401, 500],]
c_values_o3_8hr = [[0, 54, 0, 50],
                   [55, 70, 51, 100],
                   [71, 85, 101, 150],
                   [86, 105, 151, 200],
                   [106, 200, 201, 300],
                   [405, 504 ,301, 400],
                   [505, 604, 401, 500],]              
c_values_o3_1hr = [[125, 164, 101, 150],
                   [165, 204, 151, 200],
                   [205, 404, 201, 300],
                   [405, 504 ,301, 400],
                   [505, 604, 401, 500],]
tmp = [0,0,0,0,0]
result_aqi = [0,0,0,0,0]
sensor_value = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
WE0, AE0 = [295,391,347,345], [282, 390, 296, 255]
select_pin, Sen = [24, 25, 26, 27], [0.228, 0.399, 0.267, 0.318]
n, en_bit, mode= [1.18, 0.18, 0.03, 1.15], 28, 0
delay = 1
Running = True

for i in range(0, 5):
    pin_direction = open("/gpio/pin" + str(i + 24) + "/direction", 'w')
    pin_direction.write("out")
    pin_direction.close()


def cal_aqi(breakpoints, C):
    Clow = breakpoints[0]
    Chigh = breakpoints[1]
    Ilow = breakpoints[2]
    Ihigh = breakpoints[3]
    aqi = (((Ihigh-Ilow)/(Chigh-Clow))*(C-Clow)) + Ilow
    
    return aqi


def determin_aqi(result_aqi):
    aqi_level = result_aqi
    
    if 0 <= aqi_level <= 50:        return "GOOD"
    elif 51 <= aqi_level <= 100:    return "Moderate"
    elif 101 <= aqi_level <= 150:   return "Unhealthy for Sensitive Groups"
    elif 151 <= aqi_level <= 200:   return "Unhealthy"
    elif 201 <= aqi_level <= 300:   return "Very Unhealthy"
    elif 301 <= aqi_level <= 400:   return "Hazard"
    elif 401 <= aqi_level <= 500:   return "Hazard"
    else:
        if aqi_level < 0: return "Please re-enter."
        else: return "Hazard"    


def o3_to_aqi(o3):
    gas=o3
    if gas < 125:
        o3_aqi = 0
    elif gas > 604:
        o3_aqi = 500
    else:
        for values in c_values_o3_1hr:
            if values[0] <= gas <= values[1]:
                o3_aqi = cal_aqi(values, gas)
    
    return int(o3_aqi)


def co_to_aqi(co):    
    gas=co
    if gas > 50.4:
        co_aqi = 500
    elif gas < 0:
        co_aqi = 0
    else:
        for values in c_values_co:
            if values[0] <= gas <= values[1]:
                co_aqi = cal_aqi(values, gas)
    
    return int(co_aqi)                           
    
    
def so2_to_aqi(so2):    
    gas=so2
    if gas > 1004:
        so2_aqi = 500
    elif gas < 0:
        so2_aqi = 0
    else:
        for values in c_values_so2:
            if values[0] <= gas <= values[1]:
                so2_aqi = cal_aqi(values, gas)
    
    return int(so2_aqi)


def no2_to_aqi(no2):   
    gas=no2
    if gas > 2049:
        no2_aqi = 500
    elif gas < 0:
        no2_aqi = 0
    else:
        for values in c_values_no2:
            if values[0] <= gas <= values[1]:
                no2_aqi = cal_aqi(values, gas)
    
    return int(no2_aqi)

   
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
    return s


def input_analog_value():
    raw = int(open("/sys/bus/iio/devices/iio:device0/in_voltage0_raw").read())
    scale = float(open("/sys/bus/iio/devices/iio:device0/in_voltage_scale").read())
    result = raw * scale
    real_value = ((result - 3122.2)/1041.2) + 3
    
    #return result 
    return real_value


def cal_temp36(ADC_value):
    temp = (ADC_value-0.76)/0.010 + 22 # unit => V
    
    return int(temp)


def cal_gas(WE, AE, state):
    for i in range(1,5):
        if state == i:
            ppb = ((WE - WE0[i-1]) - (n[i-1]*(AE - AE0[i-1]))) / Sen[i-1]
            
            return int(ppb)
    

def cal_pm(voltage):
    hppcf = 50.0 + (2433.0*voltage) + 1386.0*(voltage**2)
    pm = 0.518 + (0.00274*hppcf)
    
    return int(pm)
    
'''
send_aqi[6] = o3    send_aqi[7] = pm25      send_aqi[8] = co       send_aqi[9] = so2  send_aqi[10] = no2
'''
def bluetooth_communication(send_data, send_aqi):
    for i in range (0,6):
        client_sock.send(str(i) + '-st ' + str(send_data[i]) + '\n')
        time.sleep(0.010)
    for j in range (0,5):
        client_sock.send(str(j+6) + '-st ' + str(send_aqi[j]) + '\n')
        time.sleep(0.010)

def blutooth_end():
    print("disconnected")
    client_sock.close()
    server_sock.close()
    print("all done")


def bluetooth_init():
    port = server_sock.getsockname()[1]
    uuid = "fa87c0d0-afac-11de-8a39-0800200c9a66"
    advertise_service( server_sock, "SampleServer",
                   service_id = uuid,
                   service_classes = [ uuid, SERIAL_PORT_CLASS ],
                   profiles = [ SERIAL_PORT_PROFILE ], 
                        )
    print("Waiting for connection on RFCOMM channel %d" % port) 


def write_sensor_on_DB(k):
    conn = sqlite3.connect("aqi.db")
    c = conn.cursor()
    c.execute("INSERT INTO history VALUES (?,?,?,?,?,?,?)", (datetime.now(),
                                                            sensor_value[(6*k)+0],
                                                            sensor_value[(6*k)+1],
                                                            sensor_value[(6*k)+2],
                                                            sensor_value[(6*k)+3],
                                                            sensor_value[(6*k)+4],
                                                            sensor_value[(6*k)+5]))
    conn.commit()
    conn.close()


def read_avg_sqi_DB():
    conn = sqlite3.connect("aqi.db")
    c = conn.cursor()
    
    c.execute("SELECT AVG(o3) FROM history ORDER BY time DESC LIMIT 5")
    avg_o3_1hr = c.fetchone()  
    tmp[0] = avg_o3_1hr[0]  
    result_aqi[0] = o3_to_aqi(tmp[0]+1010)
    print "o3 1hr avg_value is : {0}       o3 1hr aqi_value is : {1}\n".format(tmp[0],result_aqi[0])    
    
    
    c.execute("SELECT AVG(pm25) FROM history ORDER BY time DESC LIMIT 5")
    avg_pm_24hr = c.fetchone()  
    tmp[1] = avg_pm_24hr[0]  
    result_aqi[1] = ugm3_to_aqi(tmp[1])
    print "pm25 24hr avg_value is : {0}       pm25 24hr aqi_value is : {1}\n".format(tmp[1], result_aqi[1])    
    
    
    c.execute("SELECT AVG(co) FROM history ORDER BY time DESC LIMIT 5")
    avg_co_8hr = c.fetchone() 
    tmp[2] = avg_co_8hr[0]  
    result_aqi[2] = co_to_aqi(tmp[2]+1300)
    print "co 8hr avg_value is : {0}       co 8hr aqi_value is : {1}\n".format(tmp[2], result_aqi[2])    
    
    
    c.execute("SELECT AVG(so2) FROM history ORDER BY time DESC LIMIT 5")
    avg_so2_1hr = c.fetchone() 
    tmp[3] = avg_so2_1hr[0]
    result_aqi[3] = so2_to_aqi(tmp[3]+170)
    print "so2 1hr avg_value is : {0}       so2 1hr aqi_value is : {1}\n".format(tmp[3], result_aqi[3])    
    
    '''
    c.execute("SELECT AVG(so2) FROM history ORDER BY time DESC LIMIT 5")
    avg_so2_24hr = c.fetchone() 
    tmp[4] = avg_so2_24hr[0]
    result_aqi[4] = so2_to_aqi(tmp[4]+170)
    print "so2 24hr avg_value is : {0}       so2 24hr aqi_value is : {1}\n".format(tmp[4],result_aqi[4])
    '''
    
    c.execute("SELECT AVG(no2) FROM history ORDER BY time DESC LIMIT 5")
    avg_no2_1hr = c.fetchone() 
    tmp[4] = avg_no2_1hr[0]
    result_aqi[4] = no2_to_aqi(tmp[4])
    print "no2 avg_value is : {0}       no2 aqi_value is : {1}\n".format(tmp[4],result_aqi[4])
    
    '''  
    tmp = avg_no2[0]
    result_1 = no2_to_aqi(tmp)
    print result_1
    print "\n"
    
    result_2 = o3_to_aqi(avg_o3[0])
    print result_2 
    print "\n"
    
    result_3 = co_to_aqi(avg_co[0])
    print result_3
    print "\n"
    
    result_4 = so2_to_aqi(avg_so2[0])
    print result_4 
    print "\n"
    '''  
    
    
def main_process(num):
    for i in range (0,5):
        print num
        for j in range (0,5):
            mux(2*j)
            sn_WE = input_analog_value()
            mux(2*j+1)
            sn_AE = input_analog_value()
            if j == 0:
                sensor_value[(6*i)+j] = cal_temp36(sn_WE)
                sensor_value[(6*i)+j+1] = cal_pm(sn_AE)
                print "\nTemperature value is {0}".format(sensor_value[(6*i)+j])
                print "PM2.5 value is {0}".format(sensor_value[(6*i)+j+1])
            else:
                sensor_value[(6*i)+j+1] = cal_gas(sn_WE, sn_AE, j)
                if j == 1: print "NO2 value is {0}".format(sensor_value[(6*i)+j+1])
                elif j == 2: print "O3 value is {0}".format(sensor_value[(6*i)+j+1])
                elif j == 3: print "CO value is {0}".format(sensor_value[(6*i)+j+1])
                elif j == 4: print "SO2 value is {0}\n".format(sensor_value[(6*i)+j+1])
                
        write_sensor_on_DB(i)
        read_avg_sqi_DB()
        time.sleep(1)
        num += 1
        if num == 5: 
            bluetooth_communication(sensor_value, result_aqi)
            num = 0


bluetooth_init()
client_sock, client_info = server_sock.accept()
print("Accepted connection from ", client_info)
count = 1
try:
    while Running:
        main_process(count)
    
except IOError:
    pass

blutooth_end()