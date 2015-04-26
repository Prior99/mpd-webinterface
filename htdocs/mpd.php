<?php
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
			print_r($this->send("status"));
		}

		private function send($string) {
			$string = $string."\n";
			socket_write($this->socket, $string, strlen($string));
			return socket_read($this->socket, 2048);
		}

		public function __destruct() {
			if($this->socket !== null) {
				socket_close($this->socket);
			}
		}
	}

?>
