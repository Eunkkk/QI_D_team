import time
select_pin = [24, 25, 26, 27]
en_bit = 28
mode = 0
delay = 3

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

def cal_temp(degK, no):
    #degK = input_analog_value()
    degV = (0.297*degK) + 0.0010*(0.0259 - 0.0253) # kT/q (20'C) = 8.62*10^-5 / 293.15 V 
   
    return degV


'''
Sn1,Sn2,Sn3,Sn4
WE0 = 295,391,347,345
AE0 = 282,390,296,255
Sen = 0.228, 0.399, 0.267, 0.318
'''

def cal_gas(WE, AE, state):
    if state == 0: # Sn1,NO2
        ppb = ((WE - 295) - (1.18*(AE - 282))) / 0.228
        return ppb
        ppb == 0
    
    elif state == 1: # sn2,O3
        ppb = ((WE - 391) - (0.18*(AE - 390))) / 0.399
        return ppb
        ppb == 0
        
    elif state == 2: # sn3,CO
        ppb = ((WE - 347) - (0.03*(AE - 296))) / 0.267
        return ppb
        ppb == 0
        
    elif state == 3: # sn4,SO2
        ppb = ((WE - 345) - (1.15*(AE - 255))) / 0.318
        return ppb
        ppb == 0


Running = True
while Running:
    for i in range(0,6):                            #alpha_sensor
        mux(2*i)
        sn_WE = input_analog_value()
        mux(2*i+1)
        sn_AE = input_analog_value()
        alpha_sn = cal_gas(sn_WE, sn_AE, i)
        if i == 0:  print "NO2 value is {0}\n".format(alpha_sn)
        elif i == 1: print "O3 value is {0}\n".format(alpha_sn)
        elif i == 2: print "CO value is {0}\n".format(alpha_sn)
        elif i == 3: print "SO2 value is {0}\n".format(alpha_sn)
        elif i == 4: print "Temperature value is {0}\n".format(alpha_sn)
        elif i == 5: print "Temperature value is {0}\n".format(sn_WE)
        time.sleep(delay)
'''
        if i == 0:
            mux(2*i)  # C0
            alpha_temp = cal_temp()
            
            print alpha_temp
            time.sleep(3)
        
        elif i == 1:
            mux(2*i)
            sn1_WE = input_analog_value()
            mux(2*i+1)
            sn1_AE = input_analog_value()
            
            alpha_sn1 = cal_gas(sn1_WE, sn1_AE, i)
            
            print alpha_sn1
            time.sleep(3)
        
        elif i == 2:
            mux(2*i)
            sn2_WE = input_analog_value()
            mux(2*i+1)
            sn2_AE = input_analog_value()
            
            alpha_sn2 = cal_gas(sn2_WE, sn2_AE, i)
            
            print alpha_sn2
            time.sleep(3)
        
'''
'''
    mode = int(raw_input("Select the pins that you want"))
    if mode == 0:                   # temperature
        select_bits = mux(mode)
        a = temperature()
    
        print select_bits
        print "Current Temperature is {0}".format(a)
        print "\n"
    
    elif mode == 1:                   # temperature
        select_bits = mux(mode)
        a = input_analog_value()
    
        print select_bits
        print "Current Temperature is {0}".format(a)
        print "\n"    
    
    else:
        print "Try again"
        print "\n"
'''