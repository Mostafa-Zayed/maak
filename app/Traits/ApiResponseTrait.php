<?php

namespace App\Traits;

use Exception;

trait ApiResponseTrait
{

    public function apiResponse($data)
    {

    }
    protected function responseError($message,int $statusCode = 400, Exception $exception = null, int $errorCode = 1)
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $message ?? 'There was an internal error, Pls try again later',
                'exception' => $exception,
                'error_code' => $errorCode
            ], $statusCode
        );
    }

    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError($message, 403);
    }

    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, 404);
    }

    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->respondError($message, 500);
    }

    protected function respondValidationErrors(ValidationException $exception)
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ],
            422
        );
    }
}