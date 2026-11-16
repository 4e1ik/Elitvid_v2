<?php

namespace App\Repositories;

class CartRepository
{
    private const KEY = 'cart';

    public function all(): array
    {
        return session(self::KEY, []);
    }

    public function save(array $items): void
    {
        session([self::KEY => $items]);
    }
}
