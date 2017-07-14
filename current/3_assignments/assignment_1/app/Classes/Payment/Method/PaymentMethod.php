<?php


abstract class PaymentMethod
{
    protected $paidPrice;

    public function setPaidPrice($paidPrice)
    {
        $this->paidPrice = $paidPrice;
    }

    public function paidPrice()
    {
        return $this->paidPrice;
    }

    public function isApproved()
    {
        return false;
    }
}