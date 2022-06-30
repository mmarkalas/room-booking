<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Responses\ApiResponse;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected $response;

    public function __construct()
    {
        $this->response = new ApiResponse();
    }

    /**
     * Handling response and exceptions
     *
     * @param $callback
     * @return \Illuminate\Http\JsonResponse
     */
    public function runWithExceptionHandling($callback)
    {
        try {
            $callback();
            $data = $this->response->getData();

            $response = [
                'success' => $data['success'] ?? true,
                'message' => $data['message'] ?? __('responses.success'),
                'data' => $data['data'] ?? $data
            ];

            if ($this->response->getCode()) {
                return response()
                    ->json(
                        $response,
                        $this->response->getCode()
                    );
            }

            return response()->json($response);
        } catch (ApiException $e) {
            throw $e;
        } catch (ValidationException $e) {
            throw new ApiException(
                $e->getMessage(),
                $e->getResponse() ? $e->getResponse()->getStatusCode() : Response::HTTP_UNPROCESSABLE_ENTITY,
                $e->errors()
            );
        } catch (QueryException $e) {
            throw new ApiException(
                "Invalid Request.",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (Exception $e) {
            Log::critical($e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            throw new ApiException($e->getMessage(), $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
