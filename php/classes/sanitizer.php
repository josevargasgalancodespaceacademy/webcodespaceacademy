<?php

/**
* MySQL Sanitizer class
* Sanitizes sql inputs before sending to the database
* 
* @author  David Fisher <davidfisher@codespaceacademy.com>
*/


class Sanitizer
{

	private $request;

	public function __construct($request) {
		$this->request = $request;
		return $this;
	}

	/**
	 *
	 * Sanitizes the request in the object
	 *
	 * @return array $request  sanitized request
	 *
	*/

	public function sanitizeRequest() {
		$this->request = $this->sanitize($this->request);
		return $this->request;
	}

	/**
	 *
	 * Cleans Input of javascript, HTML, and CSS tages
	 *
	 * @param  string  $input  the unsanitized input
	 * @return string $output  sanitized string
	 *
	*/

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

	/**
	 *
	 * Sanitizes the sql input parameters
	 *
	 * @param  string/array  $input  The data to sanitize
	 * @return string/array  $output  The data sanitized
	 *
	*/

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
			$output  = $this->cleanInput($input);
		}
		return $output;
	}

}