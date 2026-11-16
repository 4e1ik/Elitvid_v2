<?php

namespace App\DTO;

class OrderFilterData
{
    public function __construct(
        public ?string $from,
        public ?string $to,
    ) {}
}
