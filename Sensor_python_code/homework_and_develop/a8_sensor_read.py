import time
WE0, AE0, Sen = [295,391,347,345], [282, 390, 296, 255], [0.228, 0.399, 0.267, 0.318]
select_pin = [24, 25, 26, 27]
n = [1.18, 0.18, 0.03, 1.15]
en_bit = 28
mode = 0
delay = 1

for i in range(0, 4):
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
    
    return raw*scale

def cal_temp36(ADC_value):
    voltage = ADC_value*3.34/4096.0 # ADC Convert / 3.34 => my board voltage.
    temp = voltage*100-50
    
    return temp


def cal_gas(WE, AE, state):
    for i in range(0,4):
        if state == i:
            ppb = ((WE - WE0[i]) - (n[i]*(AE - AE0[i]))) / Sen[i]
            
            return ppb
    

def cal_pm(voltage):
    hppcf = 50.0 + (2433.0*voltage) + 1386.0*(voltage**2)
    pm = 0.518 + (0.00274*hppcf)
    
    return pm
    
Running = True
while Running:
    for i in range(0,5):                            #alpha_sensor
        mux(2*i)
        sn_WE = input_analog_value()
        mux(2*i+1)
        sn_AE = input_analog_value()
        alpha_sn = cal_gas(sn_WE, sn_AE, i)
        if i == 0:  print "NO2 value is {0}".format(alpha_sn)#no2
        elif i == 1: print "O3 value is {0}".format(alpha_sn)#o3
        elif i == 2: print "CO value is {0}".format(alpha_sn)#CO
        elif i == 3: print "SO2 value is {0}".format(alpha_sn)#So2
        elif i == 4: 
            temperature = cal_temp36(sn_WE)         # C8, TMP36 Sensor
            time.sleep(0.1)
            pm_value = cal_pm(sn_AE)                # C9, PM2.5 Sensor
            print "Temperature value is {0}".format(temperature)
            time.sleep(delay)
            print "PM2.5 value is {0}\n".format(pm_value)
	    print "\n"
        time.sleep(delay)
