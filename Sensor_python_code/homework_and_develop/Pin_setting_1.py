import time
select_pin = [24, 25, 26, 27]
en_bit = 28
mode = 0

for i in range(0, 4):
    pin_direction = open("/gpio/pin" + str(i + 24) + "/direction", 'w')
    pin_direction.write("out")
    pin_direction.close()


def tmp():
    raw = int(open("/sys/bus/iio/devices/iio:device0/in_voltage0_raw").read())
    scale = float(open("/sys/bus/iio/devices/iio:device0/in_voltage_scale").read())
    result = raw*scale


def pin_mask(bit):
    if bit == 0:
        return 1
    if bit == 1:
        return 2
    if bit == 2:
        return 4
    if bit == 3:
        return 8

# def pin():
#     for i in range(0, 4):
#         if select_bits[i] == 0:
#             filename = "/gpio/pin" + str(i + 24) + "/value"
#             file = open(filename, 'w')
#             file.write("0")
#             file.close()
#             print select_bits[i]
#         if select_bits[i] == 1:
#             filename = "/gpio/pin" + str(i + 24) + "/value"
#             file = open(filename, 'w')
#             file.write("1")
#             file.close()
#             print select_bits[i]







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


def temperature(degK):
    tmp()
    degV = degK + 0.0010*(0.0259 - 0.0253)
    print degV
    return degV


print "Hello"
while True:
    mode = int(raw_input("Select the pins that you want"))
    if mode == 0:                   # temperature
        select_bits = mux(mode)
        temperature(result)
        print select_bits
        print "\n"
    # if mode >= 0:
    #     if mode <= 15:
    #         select_bits = mux(mode)
    #         time.sleep(0.1)
    #         print select_bits
    #         print "\n"
    else:
        print "Try again"
        print "\n"

# for i in range(0,4):
#        filename = "/gpio/pin" + str(i+24) + "/value"
#        file = open(filename,'w')
#        file.write("0")
#        file.close()
#        print select_bits[i]
#        time.sleep(5)
