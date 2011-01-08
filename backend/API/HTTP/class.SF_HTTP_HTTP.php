<?php
class SF_HTTP_HTTP extends SF_API_Object {
	
	
	public static function redirect($URL, $code = 302, $delay = null)
	{
		// redefine url
		$URL = self::sf_header_redirecturl($URL);
		$code = SpoonFilter::getValue($code, array(301, 302), 302, 'int');

		self::sf_header_setHeadersByCode($code);

		if($delay !== null) sleep((int) $delay);

		// redirect
		self::setHeaders("Location: $URL");

		// stop execution
		exit;
	}
	
  function sf_header_redirect($url_location, $shutdown = true) {
	global $area;
		echo ($url_location);
	$url_location = str_replace('&amp;', '&', $url_location);
	//header ('HTTP/1.1 302 Moved Temporarily');
	header("HTTP/1.1 301 Moved Permanently");
        header ('Location:' . $url_location );
	if ($shutdown) {
		if ($area != 'logout') {
			page_close();
		}
		
		exit;
	}
}

  public function sf_header_redirecturl($URL)
	{
		self::sf_header_redirect(str_replace('&amp;', '&', (string) $URL));
	}
	
  public static function sf_header_setHeadersByCode($code = 200)
	{
		$aCodes[200] = '200 OK';
		$aCodes[301] = '301 Moved Permanently';
		$aCodes[302] = '302 Found';
		$aCodes[304] = '304 Not Modified';
		$aCodes[307] = '307 Temporary Redirect';
		$aCodes[400] = '400 Bad Request';
		$aCodes[401] = '401 Unauthorized';
		$aCodes[403] = '403 Forbidden';
		$aCodes[404] = '404 Not Found';
		$aCodes[410] = '410 Gone';
		$aCodes[500] = '500 Internal Server Error';
		$aCodes[501] = '501 Not Implemented';


		$code = (int) $code;
		if(!isset($aCodes[$code])) $code = 200;

		self::sf_header_setHeaders('HTTP/1.1 '. $aCodes[$code]);
	}
	
	private static function sf_header_isSent()
	{
		return headers_sent();
	}
}
?>
