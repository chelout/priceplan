<?php

namespace PricePlan\Api;

class Document
{
    private $guzzle;

    public function __construct($guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function create(array $payload)
    {
        return $this->guzzle->post('invoices/', $payload);
    }

    public function documents(array $query)
    {
        return $this->guzzle->get('documents/', $query);
    }

    public function invoice(int $id)
    {
        return $this->guzzle->get('invoices/'.$id);
    }

    public function invoices()
    {
        return $this->guzzle->get('invoices/');
    }

    public function downloadInvoice(int $id, string $path, bool $stamp = true)
    {
        return $this->guzzle->download('invoices/'.$id.'/download'.($stamp ? '/stamp' : null), $path);
    }

    public function downloadInvoiceFact(int $id, string $path, bool $stamp = true)
    {
        return $this->guzzle->download('invoicefacts/'.$id.'/download'.($stamp ? '/stamp' : null), $path);
    }

    public function downloadRevenue(int $id, string $path, bool $stamp = true)
    {
        return $this->guzzle->download('revenues/'.$id.'/download'.($stamp ? '/stamp' : null), $path);
    }
}
