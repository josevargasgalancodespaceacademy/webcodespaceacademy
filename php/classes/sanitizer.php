<?php

class Sanitizer
{

	private $request;

	public function __construct($request) {
		$this->request = $request;
		return $this;
	}

	public function sanitizeRequest() {
		$this->request = $this->sanitize($this->request);
		return $this->request;
	}

	private function cleanInput($input) {

		$search = array(
			'@<script[^>]*?>.*?</script>@si',  
			'@<[\/\!]*?[^<>]*?>@si',            
			'@<style[^>]*?>.*?</style>@siU',    
			'@<![\s\S]*?--[ \t\n\r]*>@'         
		);

		$output = preg_replace($search, '', $input);
		return $output;
	}

	private function sanitize($input) {
		if (is_array($input)) {
			foreach($input as $var=>$val) {
				$output[$var] = $this->sanitize($val);
			}
		}
		else {
			if (get_magic_quotes_gpc()) {
				$input = stripslashes($input);
			}
			$input  = $this->cleanInput($input);
			$output = mysql_real_escape_string($input);
		}
		
		return $output;
	}

}