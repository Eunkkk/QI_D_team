import time

for i in range(0,3):
    f_pin_d = open("/gpio/pin" + str(i+24) "/direction", 'w')
    f_pin_d.write("out")
    f_pin_d.close()

def pin_number_state(num, mode):
    if mode == 1:           # on
        for i in range(0:3):
            if num == (i+24):
                pin_v = open("/gpio/pin" + str(i+24) "/value", 'w')
                pin_v.write("1")
                pin_v.close()
            else:
                continue
        
    elif mode == 0:         # off
        for i in range(0:3):
            if num == (i+24):
                pin_v = open("/gpio/pin" + str(i+24) "/value", 'w')
                pin_v.write("0")
                pin_v.close()
            else:
                continue
        
    else:
        return 0
       
number = 0
tmp = 0       
tmp_1 = -1
while True:
    if number >= 24 and number <= 26:
        tmp = int(raw_input("Select the number"))
        tmp_1 = int(raw_input("Select the state"))
        pin_number_state(tmp,tmp_1)
        
    else:
        print "Try again"
