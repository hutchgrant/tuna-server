<?php
/*
 * Copyright 2013 Grant Hutchinson
*/

class dbConnect
{
	var $link;
	
	function __construct() {
		$this->sqlConn();
	}	
	function sqlConn(){
		require_once __DIR__ . '/config.php';
		$this->link = mysql_connect(dbAddress, dbUser, dbPass) or die(mysql_error());
		$db = mysql_select_db(dbName) or die("couldn't select db: " . mysql_error());
	}
	/*
	 * Main Qry - tries to query any string or gives error
	* @param: any string query
	*/
	function finQry($qry){
		mysql_query($qry) or die("couldn't query: " . mysql_error());
	}
	function __destruct() {
		$this->sqlClose();
	}
	function sqlClose() {
		mysql_close();
	}

	/*
	 * Generate random string for token
	*/
	
	function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
	{
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}
}

?>
