<?php
define('DRUPAL_ROOT', dirname(__FILE__).'/../../../../');
chdir(DRUPAL_ROOT);
require './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


if (isset($_POST['SIGN'])) {
				$sign = strtoupper(md5(md5($_POST['SHOP_ID']).'&'.md5($_POST["ORDER_ID"]).'&'.md5($_POST['STATE'])));
				if ($_POST['SIGN'] == $sign) {
					switch ($_POST['STATE']) {
						case 'paid':
						  $order = commerce_order_load($_POST["ORDER_ID"]);
						  $order_wrapper = entity_metadata_wrapper('commerce_order', $order);
						  $transaction = commerce_payment_transaction_new('ubrir', $order->order_id);
						  $transaction->instance_id = $order->data['payment_method'];
						  $transaction->amount = $order_wrapper->commerce_order_total->amount->value();
						  $transaction->currency_code = $order_wrapper->commerce_order_total->currency_code->value();
						  $transaction->status = COMMERCE_PAYMENT_STATUS_SUCCESS;
						  $transaction->message = t('Оплата успешно совершена.');
						  commerce_payment_transaction_save($transaction);		
	 					  break;
					  }
			    }
			} 


?>