<?php


die();
ini_set("display_errors",'1');
include '../inc/init.php'; 




$conn = Propel::getConnection(_DATA_SRC);
$stmt = $conn->prepare(' SET foreign_key_checks = 0;');
$stmt->execute();

$stmt = $conn->prepare(" 
    SELECT  `id_authy`, `couple`, `status`, `export_ready`, `export_status`, `sexe`, `birth_date`, `firstname`, `lastname`, `email`, `date_expire`, `home_phone`, `other_phone`, `cellphone`, `ext_phone`, `reference`, `address`, `app`, `postal_code`, `proprietaire`, `id_ville`, `id_region`, `id_province`, `id_pays`, `note`, `workplace`, `work`, `username_contest`, `email_contest`, `password_email_contest`, `password_contest`, `air_miles`, `cinoche_username`, `hershey_username`, `hershey_password`, `canton_username`, `presse_username`, `hbc_card`, `milliplein_card`, `metro_card`, `cinoche_password`, `hotmail_password`, `facebook_username`, `facebook_password`, `casa_username`, `date_creation`, `date_modification`, `id_group_creation`, `id_creation`, `id_modification` FROM concouri_prod_bk.`account` WHERE `id_account` in ('2453','2466','2467','2464','2459','2461','2448','2452')
");
$stmt->execute();  
while($accounts[]=$stmt->fetch(PDO::FETCH_ASSOC));  
if($accounts){
    foreach( $accounts as $account ) {

	
	
		$stmt = $conn->prepare(" 
			SELECT  `id_group_creation`, `validation_key`, `username`, `passwd_hash`, `email`, `is_root`, `group`, `expire`, `deactivate`, `date_requested`, `language`, `last_poke`, `last_poke_ip`, `rights`, `wbs_public`, `wbs_private`, `onglet`, `passwd_hash_temp`, `date_creation`, `date_modification`, `id_creation`, `id_modification` 
			FROM concouri_prod_bk.`authy`
			WHERE  `id_authy` = '".$account['id_authy']."' limit 1
		");
		$account['id_authy']=NULL;
		$stmt->execute();  
		$authy=$stmt->fetch(PDO::FETCH_ASSOC);  
		if($authy){
			$valtAuthy="";
			foreach($authy as $key  => $val){
				if($valtAuthy){
					$valtAuthy .= ",'".addslashes($val)."'";
				}else{
					$valtAuthy = "'".addslashes($val)."'";
				}
			}
			echo $sql = "
			
				INSERT INTO concouri_prod.`authy`( `id_group_creation`, `validation_key`, `username`, `passwd_hash`, `email`, `is_root`, `group`, `expire`, `deactivate`, `date_requested`, `language`, `last_poke`, `last_poke_ip`, `rights`, `wbs_public`, `wbs_private`, `onglet`, `passwd_hash_temp`, `date_creation`, `date_modification`, `id_creation`, `id_modification`) 
				VALUES (".$valtAuthy.")";
			echo "<br>";
		//die();
			$stmt = $conn->prepare($sql);
			$stmt->execute();  
			$account['id_authy'] = $conn->lastInsertId();
		}
		 
		//$IdAuthy
		$valt="";
		foreach($account as $key  => $val){
			if($valt){
				$valt .= ",'".addslashes($val)."'";
			}else{
				$valt = "'".addslashes($val)."'";
			}
		}
		
		echo $sql = "
		
		INSERT INTO concouri_prod.`account`( `id_authy`, `couple`, `status`, `export_ready`, `export_status`, `sexe`, `birth_date`, `firstname`, `lastname`, `email`, `date_expire`, `home_phone`, `other_phone`, `cellphone`, `ext_phone`, `reference`, `address`, `app`, `postal_code`, `proprietaire`, `id_ville`, `id_region`, `id_province`, `id_pays`, `note`, `workplace`, `work`, `username_contest`, `email_contest`, `password_email_contest`, `password_contest`, `air_miles`, `cinoche_username`, `hershey_username`, `hershey_password`, `canton_username`, `presse_username`, `hbc_card`, `milliplein_card`, `metro_card`, `cinoche_password`, `hotmail_password`, `facebook_username`, `facebook_password`, `casa_username`, `date_creation`, `date_modification`, `id_group_creation`, `id_creation`, `id_modification`) VALUES 
		
		(".$valt.")";
		
		echo "<br>";
		$stmt = $conn->prepare($sql);
		$stmt->execute();  
		
	}
}



