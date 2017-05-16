<?php

namespace PricePlan\Api;

class Product
{
    private $guzzle;

    public function __construct($guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function create($payload)
    {
        return false;
    }

    public function product($id)
    {
        return $this->guzzle->get('products/'.$id);
    }

    public function products()
    {
        return $this->guzzle->get('products/');
    }

    public function statuses()
    {
        return $this->guzzle->get('productstatuses/');
    }
}
