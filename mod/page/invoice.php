<?php
if($request['ot'] != 's')
	$request = $_REQUEST;

$pageTitle = _("Votre facture");

$IdSale = $request['cmd'];

$sale = AbonnementQuery::create()->where(" md5(concat(Abonnement.IdAbonnement,'CONCOURIA')) = '".$IdSale."'")->findOne();

if($sale) {
	$promoAmount = $sale->getAbonnementPrice() - $sale->getSubAmount();
	if($promoAmount > 0) {
		$promoDiscount = tr(td(_("Code Promo")).td('-'.number_format($promoAmount,2,'.',' ')."$"));
	}

	$taxes = SaleTaxeQuery::create()->filterByIdAbonnement($sale->getIdAbonnement())->find();
	if($taxes) {
		foreach($taxes as $taxe) {
			$listTaxes .= tr(td($taxe->getName()."(".number_format($taxe->getPourcent(),3,'.','')."%)").td($taxe->getMontant()."$"));
		}
	}
    
    $typeLabel = _("Annuel");
    if($sale->getType() == 'Mensuel') { 
        $typeLabel = _("Mensuel (12 mois)").strong(_("Prélèvement bancaire (Tous les").' '.date('j',strtotime($sale->getDatePaiement())).' '._("de chaque mois)"),'style="display: block;"'); 
    }

	$output['html'] =

	div(
		div(
			div(
				img(_SITE_URL.'css/img/logo.png',75,122)
				.h2(_("Facture"))
			,'','class="invoice-header"')

			.div(
				div(
					''/*$_SESSION['adresseInvoice']*/
				,'','class="left-info"')
				.div(
					table(
						tr(
							td(_("Facturation"))
							.td(
								p($sale->getSale()->getAccount()->getFirstname().' '.$sale->getSale()->getAccount()->getLastname(),'class="name"')
								.p($sale->getSale()->getAccount()->getAddress().' '.$sale->getSale()->getAccount()->getApp())
								.p($sale->getSale()->getAccount()->getVille()->getTranslation($lang_sql)->getName()." (".$sale->getSale()->getAccount()->getProvince()->getTranslation($lang_sql)->getName().") ".$sale->getSale()->getAccount()->getPays()->getTranslation($lang_sql)->getName()." ".$sale->getSale()->getAccount()->getPostalCode())

								.p($sale->getSale()->getAccount()->getHomePhone())
								.p($sale->getSale()->getAccount()->getEmail())
							)
						)
					)
				,'','class="right-info"')
			,'','class="info-top"')

			.div(
				div(
					table(
						tr(td(_("Facture #")).td($sale->getIdAbonnement()))
						.tr(td(_("Date")).td($sale->getDatePaiement()))
						.$comments
					)
				,'','class="left-info"')
			,'','class="info-bottom"')

			.table(
				thead(
					tr(
						td(_("Description"),'style="width: 150px;"')
						.td(_("Date d'expiration"))
						.td(_("Prix"))
					)
				)
				.tbody(
					td(_("Abonnement").' '.$typeLabel)
					.td(date('Y-m-d',strtotime('+1 year',strtotime($sale->getDatePaiement()))))
					.td($sale->getAbonnementPrice().'$')
				)
			,'class="cart-invoice"')

			.table(
				$promoDiscount
				.tr(td(_("Sous-total")).td($sale->getSubAmount()."$"))
				.$listTaxes
				.tr(td(_("Total")).td($sale->getAmount()."$"),'class="total"')
			,'class="total-invoice"')
		,'','class="paper-invoice"')
	,'','class="invoice-wrapper"');
}
