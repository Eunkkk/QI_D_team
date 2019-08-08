direction = open("/gpio/pin25/direction").read()
print direction

value = int(open("/gpio/pin25/value").read())
print value
