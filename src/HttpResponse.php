<?php

declare(strict_types=1);

namespace Realconnex;

class HttpResponse
{
    private $response;

    public function __construct(string $request)
    {
        $this->response = $request;
    }

    public function hello() : string
    {
        return 'Response: ' . $this->response . '!';
    }
}
