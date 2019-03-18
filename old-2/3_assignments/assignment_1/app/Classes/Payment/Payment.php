<?php


class Payment
{
    protected $user;
    protected $product;
    protected $paymentMethod;

    public function __construct(User $user, Product $product, PaymentMethod $paymentMethod)
    {
        $this->user = $user;
        $this->product = $product;
        $this->paymentMethod = $paymentMethod;
    }

    public function getMethod()
    {
        return $this->paymentMethod;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function authorize()
    {
        return 'Doing some authorize things';
    }
}