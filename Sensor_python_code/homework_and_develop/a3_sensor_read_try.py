import time
select_pin = [24, 25, 26, 27]
en_bit = 28
mode = 0

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
        print "pin{0} is HIGH".format(pin_num)
    elif value == 0:
        filename = "/gpio/pin" + str(pin_num) + "/value"
        file = open(filename, 'w')
        file.write("0")
        file.close()
        print "pin{0} is LOW".format(pin_num)
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

def temperature():
    degK = input_analog_value()
    degV = degK + 1.0*(25.9 - 25.3) # kT/q (20'C) = 8.62*10^-5 / 293.15 V 
   
    return degV


print "Hello"
while True:
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