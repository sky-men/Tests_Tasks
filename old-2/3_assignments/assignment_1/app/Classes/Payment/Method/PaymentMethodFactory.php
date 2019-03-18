<?php

class PaymentMethodFactory implements Factory
{
    public static function create($type)
    {
        return new $type;
    }
}