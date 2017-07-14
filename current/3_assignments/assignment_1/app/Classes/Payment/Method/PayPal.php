<?php


class PayPal extends PaymentMethod
{
    public function isApproved()
    {
        return true;
    }
}