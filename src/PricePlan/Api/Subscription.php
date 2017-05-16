<?php

namespace PricePlan\Api;

class Subscription
{
    private $guzzle;

    public function __construct($guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function cost($payload)
    {
        return $this->guzzle->post('subscribes/pre', $payload);
    }

    public function create($payload)
    {
        return $this->guzzle->post('subscribes/', $payload);
    }

    public function subscriptions($query)
    {
        return $this->guzzle->get('subscribes/', $query);
    }

    public function update($id, $payload)
    {
        return $this->guzzle->post('subscribes/'.$id, $payload);
    }
}
