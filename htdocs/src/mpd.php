<?php
	/*
	 * This file is part of mumble-music-bot.
	 *
	 * mumble-music-bot is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * mumble-music-bot is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 * 
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */
	require_once("config.php");

	class MPD {
		private $socket;

		public function __construct() {
			if(($this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
				print_r("Could not create socket: " . socket_strerror(socket_last_error()));
			}
			if(!socket_connect($this->socket, $GLOBALS["config"]["host"], $GLOBALS["config"]["port"])) {
				print_r("Could not connect socket: " . socket_strerror(socket_last_error($this->socket)));
			}
			$welcome = socket_read($this->socket, 2048);
			if(preg_match('/OK\sMPD\s\d+\.\d+\.\d+/', $welcome) !== 1) {
				print_r("Error when connecting to MPD. Message: \"".$welcome."\"");
			}
		}

		public function status() {
			$result = array();
			$input = $this->send("status");
			$array = explode("\n", $input);
			foreach($array as $line) {
				$kv = explode(":", $line);
				$key = trim($kv[0]);
				switch($key) {
					case "volume":
						$result["volume"] = trim($kv[1]);
						break;
					case "repeat":
						$result["repeat"] = (trim($kv[1]) == 1);
						break;
					case "random":
						$result["random"] = (trim($kv[1]) == 1);
						break;
					case "single":
						$result["single"] = (trim($kv[1]) == 1);
						break;
					case "consume":
						$result["consume"] = (trim($kv[1]) == 1);
						break;
					case "playlistlength":
						$result["playlistlength"] = trim($kv[1]);
						break;
					case "state":
						$result["state"] = trim($kv[1]);
						break;
					case "song":
						$result["song"] = intval(trim($kv[1]));
						break;
					case "time":
						$result["elapsed"] = intval(trim($kv[1]));
						$result["length"] = intval(trim($kv[2]));
						break;
					case "bitrate":
						$result["bitrate"] = intval(trim($kv[1]));
						break;
				}
			}
			return $result;
		}

		public function pause() {
			return trim($this->send("pause")) === "OK";
		}

		public function play() {
			return trim($this->send("play")) === "OK";
		}

		public function next() {
			return trim($this->send("next")) === "OK";
		}

		public function update() {
			return trim($this->send("update")) === "OK";
		}

		public function listall() {
			$result = $this->send("listall");
			$result = str_replace("file: ", "", $result);
			$array = explode("\n", $result);
			$result = array();
			for($i = 0; $i < count($array) - 2; $i++) {
				$result[] = $array[$i];
			}
			return $result;
		}

		public function add($name) {
			$result = $this->send("add \"$name\"");
			$result = trim($result);
			if($result === "OK") {
				$result = $this->send("play");
				$result = trim($result);
				return $result === "OK";
			}
			else {
				return false;
			}
		}

		public function playlist() {
			$result = $this->send("playlist");
			$array = explode("\n", $result);
			$result = array();
			foreach($array as $entry) {
				if(preg_match('/(\d+):\s*file:\s*(.*)/', $entry, $matches) === 1) {
					$result[$matches[1]] = $matches[2];
				}
			}
			return $result;
		}

		private function send($string) {
			$string = $string."\n";
			socket_write($this->socket, $string, strlen($string));
			return socket_read($this->socket, 32000);
		}

		public function __destruct() {
			if($this->socket !== null) {
				socket_close($this->socket);
			}
		}
	}

?>
