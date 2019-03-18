<?php
/**
 * Assignment #1
 * Build all needed classes to run this code succesfully
 * Keep in mind:
 * - It should be possible to pay with CreditCardMethod
 * - It should be possible to buy coins as a product
 */

require_once 'app/autoload.php';

$user = User::getInstanceById(1234);

$product = ProductFactory::create('vip');
$product->setPrice(100); // in cents

$paymentMethod = PaymentMethodFactory::create('paypal');

$payment = new Payment($user, $product, $paymentMethod);

$paymentMethod->setPaidPrice(100);

if($payment->getMethod()->isApproved() && $payment->getProduct()->getPrice() == $payment->getMethod()->paidPrice()) {
    var_dump($payment->authorize());
}
