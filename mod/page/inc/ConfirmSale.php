<?php

$return['message'] = _("Erreur lors du traitement de la requête.");
$return['class'] = 'payment-error';
$return['error'] = true;

/*
$saleCheck = SaleQuery::create()->filterByIdAccount($account->getIdAccount())->findOne();
if(count($saleCheck) > 0) { $primaryKey = $saleCheck->getIdSale(); }
else {
    $sale = new Sale();
    $saleData['IdAccount'] = $account->getIdAccount();
    $sale->fromArray($saleData);
    $sale->save();

    $primaryKey = $sale->getPrimaryKey();
}
*/
$sale = new Sale();
$saleData['IdAccount'] = $account->getIdAccount();
$sale->fromArray($saleData);
$sale->save();

$primaryKey = $sale->getPrimaryKey();

if($primaryKey) {
    
    if($account->getDateExpire()) { $dateAdd = date($account->getDateExpire(), strtotime('+1 year')); } else { $dateAdd = date('Y-m-d H:i:s', strtotime('+1 year')); }

    $account->setDateExpire(date('Y-m-d H:i:s',strtotime($dateAdd)));
    $account->save();

    $abonnement = new Abonnement();
    $abonnementData['IdSale'] = $primaryKey;
    $abonnementData['DatePaiement'] = date('Y-m-d H:i:s');
    $abonnementData['SubAmount'] = $_SESSION['Price'];
    $abonnementData['Amount'] = $_SESSION['FinalPrice'];
    $abonnementData['AbonnementPrice'] = (_PRIX_ABONNEMENT/100);

    $abonnement->fromArray($abonnementData);
    $abonnement->save();

    $abonnementKey = $abonnement->getPrimaryKey();

    if($abonnementKey) {
        $taxes = TaxeQuery::create()->useGrpTaxeQuery()->filterByIdGroupTaxeSup($account->getProvince()->getIdGrpTaxe())->endUse()->find();
        if($taxes) {
            foreach($taxes as $taxe) {
                $taxeSave = new SaleTaxe();
                $dataTaxe['IdAbonnement'] = $abonnementKey;
                $dataTaxe['IdTaxe'] = $taxe->getIdTaxe();
                $dataTaxe['Name'] = $taxe->getCode();
                $dataTaxe['Pourcent'] = $taxe->getPourcent();
                $dataTaxe['Montant'] = number_format(($_SESSION['Price'] * $taxe->getPourcent()) / 100,2,'.',' ');

                $taxeSave->fromArray($dataTaxe);
                $taxeSave->save();
            }
        }

        $mail = MailQuery::create()->findPk(4);
        if($mail) {
            $title = $mail->getTranslation($lang_sql)->getTitle();
            $body = $mail->getTranslation($lang_sql)->getText();

            $body = str_replace('%%Firstname%%',$account->getFirstname(),$body);
            $body = str_replace('%%Lastname%%',$account->getLastname(),$body);
            $body = str_replace('%%DateExpire%%',date('Y-m-d', strtotime('+1 year')),$body);
            $body = str_replace('%%IdSale%%',$primaryKey,$body);
            $body = str_replace('%%DateCreation%%',date('Y-m-d H:i:s'),$body);
            $body = str_replace('%%Amount%%',$_SESSION['FinalPrice'],$body);

            $body = str_replace('%%Adresse%%',$account->getAddress(),$body);
            $body = str_replace('%%App%%',$account->getApp(),$body);
            $body = str_replace('%%Ville%%',$account->getVille()->getTranslation($lang_sql)->getName(),$body);
            $body = str_replace('%%Province%%',($account->getProvince()->getTranslation($lang_sql)->getName()) ? "(".$account->getProvince()->getTranslation($lang_sql)->getName().")" : '',$body);
            $body = str_replace('%%CodePostal%%',$account->getPostalCode(),$body);
            $body = str_replace('%%Telephone%%',$account->getHomePhone(),$body);

            $body = str_replace('%%lien_website%%',_SITE_URL,$body);
            $body = str_replace('%%lien_com%%',_SITE_URL.'invoice?cmd='.md5($abonnementKey.'CONCOURIA'),$body);

            sendHTMLemail($body,_FROM,_SALE_EMAIL,$title,_FROM);
            sendHTMLemail($body,_FROM,$account->getEmail(),$title,_FROM);
            
            unset($_SESSION['Price']);
			unset($_SESSION['FinalPrice']);
			unset($_SESSION['Promo']);
            
            $return['message'] = _("Compte activé avec succès.");
            $return['class'] = 'payment-success';
            $return['error'] = false;
        }
    }
}

