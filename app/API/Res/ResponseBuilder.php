<?php

namespace App\API\Res;

class ResponseBuilder
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response;
    }

    public function withMessage(string $message)
    {
        $this->response->setMessage($message);

        return $this;
    }

    public function withStatus(int $status)
    {
        $this->response->setStatus($status);

        return $this;
    }

    public function withData(mixed $data)
    {
        $this->response->setData($data);

        return $this;
    }

    public function withAppends(mixed $appends)
    {
        $this->response->setAppends($appends);

        return $this;
    }

    public function send()
    {
        return $this->response->response();
    }
}
