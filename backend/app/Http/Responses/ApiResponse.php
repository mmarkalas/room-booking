<?php

namespace App\Http\Responses;

class ApiResponse
{
    protected $data;
    protected $code;

    public function setData($data, $code = null)
    {
        $this->data = $data;
        $this->code = $code;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCode()
    {
        return $this->code;
    }
}
