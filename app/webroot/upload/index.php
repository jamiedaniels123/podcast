<?PHP

#session_start(); putenv("PHP_ENC_USERDIR=$username"); # may need to use the call_fc.php method.

if(function_exists('virtual'))
{
	virtual("/cgi-bin/filechucker.cgi?" . $_SERVER['QUERY_STRING']);
}
else
{
	require("call_fc.php");
}

?>
