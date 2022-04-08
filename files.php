<?php
	
	function open_file($name) {
        $tmp = fopen($name . ".tmp", "w");
        flock($tmp, LOCK_EX);
        return array("tmp" => $tmp, "name" => $name, "content" => json_decode(file_get_contents($name), true), "modified" => false);
	}

	function get_file_content(&$file) {
		return $file["content"];
	}

	function set_file_content(&$file, $content) {
		$file["content"] = $content;
		$file["modified"] = true;
	}

	function close_file(&$file) {
		if ($file["modified"]) {
			file_put_contents($file["name"], json_encode($file["content"]));
		}
		flock($file["tmp"], LOCK_UN);
		fclose($file["tmp"]);
		@unlink($file["name"] . ".tmp");
	}
?>