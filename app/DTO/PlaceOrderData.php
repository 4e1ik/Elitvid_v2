<?php

namespace App\DTO;

class PlaceOrderData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public ?string $corporationName,
        public ?string $comment,
    ) {}
}
