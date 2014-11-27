#! /usr/bin/env python
# -*-coding:Utf8-*

port = 4242
user = "viller_m"
pssd = "1d+gr(io"
host = "ns-server.epitech.eu"

import md5
import sys
import time
import socket

def connect():
    print("Connection ...")

    try:
        netsoul = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        netsoul.connect((host, port))
    except:
        print("Step 0 failed (connection)")
        time.sleep(5)
        return connect()

    print("Connected")
    print("Authentication ...")

    msg = netsoul.recv(1024).split()
    enc = md5.new(msg[2] + "-" + msg[3] + "/" + msg[4] + pssd).hexdigest()

    netsoul.send("auth_ag ext_user none none\n")     
    netsoul.send("ext_user_log " + user + " " + enc + " " + " loc comp\n")
    netsoul.send("user_cmd state actif:" + str(int(time.time())) + "\n")

    if netsoul.recv(1024).find("rep 002 -- cmd end") != 0:
        print("Step 1 failed (Headers)")
        return connect()
    if netsoul.recv(1024).find("rep 002 -- cmd end") != 0:
        print("Step 2 failed (Authentication)")
        return connect()

    print("Authentified")
    listen(netsoul)

def listen(netsoul):
    while True:
        try:
            data = netsoul.recv(1024)
        except KeyboardInterrupt:
            print("\rAbort")
            disconnect(netsoul)
            sys.exit(0)

        if not data:
            print("Disconnected")
            netsoul.close()
            return connect()
        if data.find("ping") == 0:
            netsoul.send(data)
        else:
            print(data)

def disconnect(netsoul):
    netsoul.send("user_cmd exit\n")
    netsoul.close()

connect()
#root :
#killall netsoul_auth
#killall netsoul_host
#killall netsoul_client
#killall *xm*
