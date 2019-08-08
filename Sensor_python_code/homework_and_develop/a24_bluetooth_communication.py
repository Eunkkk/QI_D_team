from bluetooth import *
import time
import sqlite3
from datetime import datetime

server_sock=BluetoothSocket( RFCOMM )
server_sock.bind(("",PORT_ANY))
server_sock.listen(1)

conn = sqlite3.connect("aqi.db")
conn = sqlite3.connect("cal_aqi.db")
c = conn.cursor()
d = conn.cursor()
c.execute("CREATE TABLE IF NOT EXISTS history (time REAL PRIMARY KEY NOT NULL, temp REAL, no2 REAL, o3 REAL, co REAL, so2 REAL, pm25 REAL)")
d.execute("CREATE TABLE IF NOT EXISTS history (time REAL PRIMARY KEY NOT NULL, no2_aqi REAL, o3_aqi REAL, co_aqi REAL, so2_aqi REAL)")
conn.close()

'''
sensor_value[0] : temperature   /   sensor_value[1] : pm    /   sensor_value[2] : NO2
sensor_value[3] : O3            /   sensor_value[4] : CO    /   sensor_value[5] : SO2
'''
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
    

def bluetooth_communication(send_data):
    for i in range (0,6):
        client_sock.send(str(i) + '-st ' + str(send_data[i]) + '\n')
        #if i == 5: client_sock.send('\n')
        #elif i == 11: client_sock.send('\n')
        #elif i == 17: client_sock.send('\n')
        #elif i == 23: client_sock.send('\n')
        #elif i == 29: client_sock.send('\n')

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


bluetooth_init()
client_sock, client_info = server_sock.accept()
print("Accepted connection from ", client_info)
count = 1


def cal_avg_5sec(tmp,n):
    result[n] += tmp[n]
    tmp += tmp

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
                
        conn = sqlite3.connect("aqi.db")
        c = conn.cursor()
        c.execute("INSERT INTO history VALUES (?,?,?,?,?,?,?)", (datetime.now(), sensor_value[(6*i)+0], sensor_value[(6*i)+1], sensor_value[(6*i)+2], sensor_value[(6*i)+3], sensor_value[(6*i)+4], sensor_value[(6*i)+5]))
        conn.commit()
        conn.close()
        time.sleep(1)
        num += 1
        if num == 5:
            bluetooth_communication(sensor_value)
            num = 0


try:
    while Running:
        main_process(count)
    
except IOError:
    pass

blutooth_end()