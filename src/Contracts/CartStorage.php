<?php

namespace FauziDhuhuri\SimpleCart\Contracts;

interface CartStorage
{
    public function get(string $identifier, string $instance = 'default');
    public function store(string $identifier, string $instance, array $content);
    public function forget(string $identifier, string $instance);
}