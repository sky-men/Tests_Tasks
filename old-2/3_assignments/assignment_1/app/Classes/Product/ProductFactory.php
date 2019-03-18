<?php

class ProductFactory implements Factory
{
    public static function create($type)
    {
        return new $type;
    }
}