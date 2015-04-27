MPD Webinterface
================

This repository contains an lightweight and simple webinterface for MPD (music player daemon).

Setup
-----
First, install the needed bower-components.

	user@server:~/mpd-webinterface/$ cd htdocs/
	user@server:~/mpd-webinterface/htdocs/$ bower install

Copy the ```config.php.example``` in the ````htdocs/``` directory to ```config.php``` and modify it to suit your needs.

	user@server:~/mpd-webinterface/htdocs/$ cp config.php.example config.php
	user@server:~/mpd-webinterface/htdocs/$ nano config.php


Link the ```htdocs/``` directory to your webroot.
The directory you intent to store the music in must be public writable, so set it's chmod to 777.

	user@server:~/mpd-webinterface/htdocs/$ cd ..
	user@server:~/mpd-webinterface/$ sudo ln -s /home/music/mpd-webinterface/htdocs /var/www/mpd-webinterface
	user@server:~/mpd-webinterface/$ chmod 777 /home/music/music


You will need a webserver that supports PHP. You will need the package ```php-getid3```. On Debian or Ubuntu you could install it like this:

	user@server:~/$ sudo apt-get install php-getid3

Usage
-----
Just open the webpage in your browser. There is nothing more to do. As long as your mpd is running the webpage will manage everything you need for you.

License
-------
This software is distributed under the terms of the GNU General Public License.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.


Contributors
-------------
 * Prior (Frederick Gnodtke)
