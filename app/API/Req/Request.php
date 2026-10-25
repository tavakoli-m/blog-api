<?php

namespace App\API\Req;

use App\Exceptions\RequestException;
use Closure;

class Request{
        public function __invoke(Closure $action,Closure $rejectAction = null) : RequestResult
    {
        try {
            $result = $action();
        } catch (\Throwable $th) {
            report($th);
            !is_null($rejectAction) && $rejectAction();
            throw new RequestException($th->getMessage());
        }

        return new RequestResult(true, $result);
    }
}