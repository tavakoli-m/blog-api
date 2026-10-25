<?php

namespace App\API\Req;

class RequestResult
{
    public function __construct(public bool $ok, public mixed $data) {}
}
