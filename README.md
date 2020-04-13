# Trilateration
Simple Trilateration for Geolocalization Using Circle-Circle Intersection

Tip: Use Python version 3.7+ to have the support of nanosecond time readings. Following things to remember while the configuration of LoRa.

•	Always use "mac pause" before every radio trans-receiving radio command

•	Select regional frequency (Example Europe 869100000 Hz)

•	Watchdog time should be zero for continuous receiving mode

•	A unique HWEUI of LoRa with a unique packet number is transmitted to all the reference nodes

•	Regional duty cycle restrictions must be followed.

Sending:
1.	msg = "{{pn"+temp_packet_number+"hweui@"+str(hweui)+"@ts@"+str(time.time_ns())+"}}"  
2.	sp.write("mac pause\x0d\x0a".encode())  
3.	msg = msg.encode().hex()  
4.	sp.write(("radio tx "+str(msg)+"\x0d\x0a").encode())  


Receiving: 
1.	sp.write("mac pause\x0d\x0a".encode())  
2.	sp.write("radio rx 0\x0d\x0a".encode())  
