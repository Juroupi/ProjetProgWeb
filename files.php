<?php

	function open_file($name) {
        $fp = fopen($name, "r+");
        flock($fp, LOCK_EX);
        return array("fp" => $fp, "content" => json_decode(fread($fp, filesize($name)), true), "modified" => false);
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
			ftruncate($file["fp"], 0);
			fseek($file["fp"], 0);
			fwrite($file["fp"], json_encode($file["content"]));
		}
		flock($file["fp"], LOCK_UN);
		fclose($file["fp"]);
	}
?>