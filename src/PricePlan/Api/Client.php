<?php

namespace PricePlan\Api;

/**
 * @todo Запрос новой ссылки на авторизацию клиента в личном кабинете
 * @todo Запрос ссылки на авторизацию клиента в личном кабинете
 */
class Client
{
    private $guzzle;

    public function __construct($guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function blocking($id)
    {
        return $this->guzzle->get('blocking/client/'.$id);
    }

    public function client($id)
    {
        return $this->guzzle->get('clients/'.$id);
    }

    public function clients()
    {
        return $this->guzzle->get('clients/');
    }

    public function create($payload)
    {
        return $this->guzzle->post('clients/', $payload);
    }

    public function decrease($id, $payload)
    {
        return $this->guzzle->post('clients/'.$id.'/decrease', $payload);
    }

    public function delete($id)
    {
        return $this->guzzle->delete('clients/'.$id);
    }

    public function getAuthKey($id)
    {
        return $this->guzzle->get('clients/'.$id.'/auth-key');
    }

    public function increase($id, $payload)
    {
        return $this->guzzle->post('clients/'.$id.'/increase', $payload);
    }

    public function update($id, $payload)
    {
        return $this->guzzle->post('clients/'.$id, $payload);
    }

    public function updateAuthKey($id)
    {
        return $this->guzzle->post('clients/'.$id.'/auth-key');
    }

}