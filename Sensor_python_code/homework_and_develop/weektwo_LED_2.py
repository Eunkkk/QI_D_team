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
       
while True:
    pin_number_state(0, 1)      # Green LED turn on
    time.sleep(1)               # Operating 1sec
    pin_number_state(0, 0)      # Green LED turn off
    
    
    pin_number_state(3, 1)      # Red LED turn on
    time.sleep(1)               # Operating 1sec
    pin_number_state(0, 0)      # Red LED turn off
    
    
    pin_number_state(15, 1)     # Blue LED turn on
    time.sleep(1)               # Operating 1sec
    pin_number_state(0, 0)      # Blue LED turn off