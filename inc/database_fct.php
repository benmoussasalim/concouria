<?php
#session_start();

define('MYSQL_ONCE', '1');
define('MYSQL_FOREACH_ARRAY', '2');
define('MYSQL_INSERT_ID', '3');
define('MYSQL_NUM_ROW', '4');
define('MYSQL_FOR_ARRAY', '5');
define('MYSQL_AFFECTED', '6');
define('MYSQL_NUM_ARRAY', '7');
define('MYSQL_OBJ_ARRAY', '8');
/*
* Fonction de connection a la base de donnee
*/
global $cn;
function DB_Init(){
	/*global $cn;
	$svr = DB_SERVER;     # name of your MY SQL server
	$uid = DB_USERNAME;      # user id and password
	$pwd = DB_PASSWORD;
	$db  = DB_DB;    # database name
	$cn = mysql_connect($svr, $uid, $pwd);
	if(!$cn)
		return 0;
	mysql_select_db($db);
	return $cn;*/
	return true;
}

function connect_db($svr, $uid, $pwd, $db){
	global $cn;
	$cn = mysql_connect($svr, $uid, $pwd);
	if(!$cn)
		return 0;
	return $cn;
}

function execSQL($sql, $return='1', $debug=false){
	try {
		$conf = include(dirname(__FILE__) . DIRECTORY_SEPARATOR .'gen-conf.php');
		$initPdo = new PDO($conf['datasources'][_DATA_SRC]['connection']['dsn'], $conf['datasources'][_DATA_SRC]['connection']['user'], $conf['datasources'][_DATA_SRC]['connection']['password']);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
	if ($debug)
		echo "<br /> - $debug :".$sql."<br />";
	try{ 
		$con = $initPdo->prepare($sql);
	}catch(PDOException $e){
		print "Error!: " . $e->getMessage() . "<br/>";
	}
	$rs = $con->execute();
	if($rs){
		switch($return){
			case '1':
				return $con->fetch(PDO::FETCH_BOTH );
				//return mysql_fetch_array($rs);
			break;
			case '2':
				while($res[]=$con->fetch(PDO::FETCH_BOTH ));
				return $res;
			break;
			case '3':
				return $initPdo->lastInsertId();
			break;
			case '4':
				return $con->rowCount();
			break;
			case '5':
				while($res[]=$con->fetch(PDO::FETCH_NUM));
				return $res;
			break;
			case '6':
				return $con->rowCount();
			break;
			case '7':
				while($res[]=$con->fetch(PDO::FETCH_NUM));
				return $res;
			break;
			case '8':
				while($res[]=$con->fetch(PDO::FETCH_OBJ));
				return $res;
			break;
			
		}	
	}else{
		if ($debug){
			echo "Query error ";
			foreach($con->errorInfo() as $info){
				echo $info."<br >";
			}
		}
		return false;
	}
}


/*CREATE TABLE IF NOT EXISTS `authy_errors` (
  `id_authy_errors` int(11) NOT NULL AUTO_INCREMENT,
  `Msg` int(11) NOT NULL,
  `Info` int(11) NOT NULL,
  PRIMARY KEY (`id_authy_errors`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;*/
function log_error($error, $position=''){
	DB_Init();
	$sql = "INSERT INTO `authy_errors` (`Msg`, `Info`) VALUES ('".$error."', '".$position."')";
	$rs = mysql_query($sql);
	$lErrorHandler = array( 'HANDLER_1' => array(	'fr' => "Une erreur s'est produite",
													'en' => '')
			);
	if(_DEBUG == 'yes'){
		echo mysql_error();
		echo $error." ".$position;
	}	
	return $lErrorHandler['HANDLER_1'][$_SESSION[_AUTH_VAR]->lang];
}