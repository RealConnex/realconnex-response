<?php

declare(strict_types=1);

namespace Realconnex;

class HttpResponse
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function hello() : string
    {
        return 'Hello: ' . $this->name . '!';
    }
}
