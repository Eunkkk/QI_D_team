from bluetooth import *
import sys

if sys.version < '3':
    input = raw_input

first_match = service_matches[0]
port = first_match["port"]
name = first_match["name"]
host = first_match["host"]
    
server_sock=BluetoothSocket( RFCOMM )
server_sock.bind(("",PORT_ANY))
server_sock.listen(1)
server_sock.connect((host, port))

port = server_sock.getsockname()[1]

uuid = "94f39d29-7d6d-437d-973b-fba39e49d4ee"

advertise_service( server_sock, "SampleServer",
                   service_id = uuid,
                   service_classes = [ uuid, SERIAL_PORT_CLASS ],
                   profiles = [ SERIAL_PORT_PROFILE ], 
#                   protocols = [ OBEX_UUID ] 
                    )
                   
print("Waiting for connection on RFCOMM channel %d" % port)

client_sock, client_info = server_sock.accept()
print("Accepted connection from ", client_info)

try:
    while True:
        data = input()
        if len(data) == 0: break
        server_sock.send(data)
        
except Exception:
    pass

print("disconnected")

client_sock.close()
server_sock.close()
print("all done")
