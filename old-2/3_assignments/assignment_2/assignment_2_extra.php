<?php
/**
 * Assignment #2 bonus
 * Extra tables (and reuse the tables from assignment #2)
 * - shoppingCart
 * - shoppingCartContent
 * - product
 * - method
 *
 * Output should be something like this:
 * <firstname> <lastname>       <paymentid>     <price>     <status>    <methodname>    <productname>
 */

require_once 'db.php';

$rows = query('SELECT
                  payment.*,
                  product.name AS product_name,
                  user.firstname, user.lastname,
                  method.name AS method_name
               FROM payment
               LEFT JOIN user ON user.id = payment.userID
               LEFT JOIN method ON method.id = payment.methodID

               LEFT JOIN shoppingcart ON shoppingcart.paymentID = payment.id
               LEFT JOIN shoppingcartcontent ON shoppingcartcontent.cartID = shoppingcart.id
               LEFT JOIN product ON product.id = shoppingcartcontent.productID

               LIMIT 100');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']))
{
    foreach ($rows as $value)
        echo "$value[firstname] $value[lastname] | $value[id] | $value[totalPrice] |  $value[status] |  $value[method_name] |  $value[product_name] <br><br>";
}
else
{
    header("Content-Type: application/json");

    $jsonArray = json_encode($rows);

    echo $jsonArray;
}