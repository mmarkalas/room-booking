<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ApiException extends HttpResponseException
{
    public function __construct($message = null, $code = 500, array $details = [])
    {
        // build response object
        $response = new Response();

        $responseBody = [
            'success' => false,
            'message' => $message,
            'error_code' => $code ?: Response::HTTP_INTERNAL_SERVER_ERROR
        ];

        if (!empty($details)) {
            $responseBody['data'] = $details;
        }

        $response->setContent($responseBody)->setStatusCode($code);

        parent::__construct($response);
    }
}
