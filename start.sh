#!/bin/bash

# This file is part of mumble-music-bot.
#
# mumble-music-bot is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# mumble-music-bot is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.


HOME="/home/music"

HOST="localhost"
PORT="64738"
NAME="DJ-Bot"
PASSWORD=""
CHANNEL="Disko"
BITRATE="128000"
MPD_FIFO="$HOME/mpd/mpd.fifo"
MPD_HOST="localhost"
MPD_PORT="7701"
MPD_CONF="$HOME/mpd/mpd.conf"
LOGFILE="$HOME/mumble.log"
PIDFILE="$HOME/mumble.pid"
MPD_PIDFILE="$HOME/mpd/pid"

source ~/.rvm/scripts/rvm
rvm use @music >> "$LOGFILE" 2>&1

function start_mpd {
	echo "Starting music player daemon MPD ..."
        mpd "$MPD_CONF"
	mpc -p $MPD_PORT consume on
        echo "Done! PID " $(cat "$MPD_PIDFILE")
}

function start_mumble {
	echo "Starting mumble bot ..."
        if [ ! -e ".stdin" ]; then mkfifo ".stdin"; fi
	cat ".stdin" | ruby "/home/music/scripts/mumble-ruby-mpd-bot.rb" "$HOST" $PORT "$NAME" "$PASSWORD" "$CHANNEL" $BITRATE "$MPD_FIFO" "$MPD_HOST" $MPD_PORT >> "$LOGFILE" 2>&1 &
	echo $! > "$PIDFILE"
	echo "Done! PID " $(cat "$PIDFILE")
}

function start {
	if [ -e "$MPD_PIDFILE" ] && [ -e  "/proc/$(cat $MPD_PIDFILE)" ]; then
		echo "MPD is already running. Not starting."
	else
		echo "MPD not running."
		start_mpd
	fi
	if [ -e "$PIDFILE" ] && [ -e "/proc/$(cat $PIDFILE)" ]; then
		echo "Mumble is already running. Not starting."
	else
		echo "Mumble not running."
		start_mumble
	fi
}

function stop_mumble {
	echo "Stopping mumble bot ..."
	kill $(cat $PIDFILE)
	while [ -e "/proc/$(cat $PIDFILE)" ]; do sleep 1; done
	rm "$PIDFILE"
	echo "Done."
}

function stop_mpd {
	echo "Stopping music player daemon MPD ..."
        kill $(cat $MPD_PIDFILE)
        while [ -e "$MPD_PIDFILE" ] && [ -e "/proc/$(cat $MPD_PIDFILE)" ]; do sleep 1; done
	echo "Done."
}

function stop {
	if [ -e "$PIDFILE" ] && [ -e "/proc/$(cat $PIDFILE)" ]; then
		echo "Mumble is running."
		stop_mumble
        else
                echo "Mumble is not running. Not stopping."
        fi
        if [ -e "$MPD_PIDFILE" ] && [ -e  "/proc/$(cat $MPD_PIDFILE)" ]; then
                echo "MPD is running."
		stop_mpd
        else
                echo "MPD is not running. Not stopping."
        fi
}

function status {
        if [ -e "$PIDFILE" ] && [ -e "/proc/$(cat $PIDFILE)" ]; then
                echo "Mumble is running. PID $(cat $PIDFILE)"
        else
                echo "Mumble is not running."
        fi
        if [ -e "$MPD_PIDFILE" ] && [ -e  "/proc/$(cat $MPD_PIDFILE)" ]; then
                echo "MPD is running. PID $(cat $MPD_PIDFILE)"
        else
                echo "MPD is not running."
        fi
}

case "$1" in
start)
	start
;;
stop)
	stop
;;
restart)
	stop
	start
;;
status)
	status
;;
*)
	echo "Usage $0 {start|stop|status|restart}"
;;
esac

