Mumble Music Bot
================

This repository contains an lightweight and simple webinterface for MPD (music player daemon). It can for example be used to control a Musicbot running in an Mumbleserver but can be used for other purposes as well.

Setup
-----
First, install the needed bower-components.
Copy the ```config.php.example``` in the ````htdocs/``` directory to ```config.php``` and modify it to suit your needs.
Modify the ```start.sh``` file in the first lines to fit your setup.
Link the ```htdocs/``` directory to your webroot.
The directory you intent to store the music in must pe public writable, so set it's chmod to 777.

	music@server:~/mumble-music-bot/$ cd htdocs/
	music@server:~/mumble-music-bot/htdocs/$ bower install
	music@server:~/mumble-music-bot/htdocs/$ cp config.php.example config.php
	music@server:~/mumble-music-bot/htdocs/$ nano config.php
	music@server:~/mumble-music-bot/htdocs/$ cd ..
	music@server:~/mumble-music-bot/$ nano start.sh
	music@server:~/mumble-music-bot/$ sudo ln -s /home/music/mumble-music-bot/htdocs /var/www/mumble-music-bot
	music@server:~/mumble-music-bot/$ chmod 777 /home/music/music


Startup
-------

There is a bashscript included which will take care of starting MPD and the Mumble Musicbot called ```start.sh```.

You could for exmaple start both by invoking

	music@server:~/mumble-music-bot/$ ./start.sh start
	
You might as well use the script as an init.d script.

License
-------
This software is distributed under the terms of the GNU General Public License.

Contributors
-------------
 * Prior (Frederick Gnodtke)
