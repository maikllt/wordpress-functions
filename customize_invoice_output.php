//===================================================================
// Documentation
//===================================================================

/*
 * all available action hooks list: 
 * https://docs.wpovernight.com/woocommerce-pdf-invoices-packing-slips/pdf-template-action-hooks/
 * how to use action hook:
 * https://docs.wpovernight.com/woocommerce-pdf-invoices-packing-slips/displaying-a-custom-field#with-a-template-action-hook
 * things to know about adding actions:
 * https://docs.wpovernight.com/general/how-to-use-filters/
 */ 

//===================================================================
// Use case description
//===================================================================

/*
 * to add buyer's email address, VAT number and company code, the folowing should be added at the 
 * end of the following file:
 * /wp-content/themes/{your-theme}/functions.php
 */


//===================================================================

// Add a custom action to modify the invoice output
add_action('wpo_wcpdf_after_billing_address', 'wpo_wcpdf_custom_buyer_information', 10, 2);
function wpo_wcpdf_custom_buyer_information($document_type, $order) {
	//Only apply this to invoices
	if ($document_type !== 'invoice') {
	return;
	}

	//Get the buyer's information from the order
	$buyer_email = $order->get_billing_email();
	$company_code = $order->get_meta('_billing_wooccm12');
	$vat_number = $order->get_meta('_billing_wooccm13');

	//Check if the information exists and output the additional details
	if (!empty($buyer_email) || !empty($vat_number) || !empty($company_code)) {
		echo '<tr>';
		echo '<td class="address billing-additional-info">';

		if (!empty($buyer_email)) {
		echo $buyer_email;
		}

		if (!empty($company_code)) {
		echo '<br>Į.k.: ' . $company_code;
		}

		if (!empty($vat_number)) {
		echo '<br>PVM kodas: ' . $vat_number;
		}

		echo '</td>';
		echo '</tr>';
	}
}