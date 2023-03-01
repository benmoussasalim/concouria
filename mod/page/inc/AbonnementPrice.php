<?php

if($_SESSION['Promo']) {
    $promoClass = 'active-promo';
    $promoAmount = p(span($_SESSION['Promo']['Amount']));
    $disableInput = 'disabled';
}

if($_SESSION['payment_method'] == 'month') { $monthDisplay = '/'._("mois"); }

if(!$listTaxe) {
    if($_SESSION['payment_method'] == 'month') { 
        $basePrice = _PRIX_ABONNEMENT_MOIS; } else { $basePrice = $_SESSION['Price']; 
    }
    
    if(!$account) {
        $account = AccountQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->findOne();
    }

	$taxes = TaxeQuery::create()->useGrpTaxeQuery()->useProvinceQuery()->filterByIdProvince($account->getIdProvince())->endUse()->endUse()->find();
	if($taxes) {        
		foreach($taxes as $taxe) {
			$amount = number_format(($basePrice * $taxe->getPourcent()) / 100,2,'.',' ');

            $basePrice += $amount;

			$listTaxe .=
			div(
				h3($taxe->getCode()."(".number_format($taxe->getPourcent(),3,'.',' ')."%)")
				.p($amount."$")
			,'','class="tax-wrapper"');
		}
	}

	$_SESSION['FinalPrice'] = $basePrice;
}

$paymentLabel = p(span(number_format($_SESSION['Price'],2,'.','')."$ / "._("année")),'class="price"');
if($_SESSION['payment_method'] == 'month') {
    unset($_SESSION['Promo']);
    
    $paymentLabel = 
        //p(span(_PRIX_FIXE_ABONNEMENT."$"),'class="price fix"')
        p(span(_PRIX_ABONNEMENT_MOIS."$ / "._("mois")),'class="price"')
    ;
} else {
    $contentPromo =
        h3(_("Code promotionnel"))
        .div(
            div(
                input('text','promo-code',$_SESSION['Promo']['Code'],$disableInput.' placeholder="'._("Code promo").'"')
            ,'','class="input-wrapper"')
            .$promoAmount
        ,'','class="input-block promo-code '.$promoClass.'"')
    ;
}

$return['AbonnementPrice'] =
div(
    div(
        div(
            h3(_("Coût de l'abonnement"))
            .$paymentLabel
        ,'','class="price-wrapper"')

        .$listTaxe

        .div(
            h3(_("Total"))
            .p(number_format($_SESSION['FinalPrice'],2,'.','').'$<sup>'.$monthDisplay.' ('._("Taxes incl.").')</sup>')
        ,'','class="total-wrapper"')
    ,'','class="block-price"')

    .$contentPromo
,'','data-section="AbonnementPrice"')
;

