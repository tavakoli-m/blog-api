<?php

namespace App\API\Res;

class Response
{
    private string $message = "The operation was successful";

    private mixed $data = [];

    private int $status = 200;

    private mixed $appends = [];

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function setData(mixed $data)
    {
        $this->data = $data;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function setAppends(mixed $appends)
    {
        $this->appends = $appends;
    }

    public function response(){
        $body = [];
        $body['message'] = $this->message;
        !is_null($this->data) && $body['data'] = $this->data;
        $body = $body + $this->appends;
        
        return response()->json($body,$this->status);
    }
}
