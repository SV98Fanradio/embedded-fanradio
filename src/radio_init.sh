#!/bin/bash

echo "DEV"

/usr/bin/play ../audio/hello.wav >/dev/null 2>&1
/usr/bin/play ../audio/checking_onemoment.wav >/dev/null 2>&1

/usr/bin/pkill vlc
/usr/bin/cvlc -I http --http-host 127.0.0.1 --http-port 8000 --http-password sv98fanradio </dev/null >/dev/null 2>&1 &

lastrun_ok=false

# loop forever
while true
do
	# conn check
	/usr/bin/curl -sSf --connect-timeout 10 --max-time 14 https://public.radio.co/stations/sb5fc57b15/status >/dev/null 2>&1
	if [ $? = 0 ]; then
		# check ok
		if [ "$lastrun_ok" != true ]; then
			lastrun_ok=true
			/usr/bin/play ../audio/readytogo.wav >/dev/null 2>&1
			#echo $lastrun_ok
			/usr/bin/wget -qO- -d --user="" --password=sv98fanradio "http://127.0.0.1:8000/requests/status.xml?command=in_play&input=https://s4.radio.co/sb5fc57b15/listen" &> /dev/null
			fi
	else
		# check failed
		lastrun_ok=false
		/usr/bin/wget -qO- -d --user="" --password=sv98fanradio "http://127.0.0.1:8000/requests/status.xml?command=pl_stop" &> /dev/null
		/usr/bin/play ../audio/noconn.wav >/dev/null 2>&1
		/bin/sleep 30
	fi
	/bin/sleep 2
done
