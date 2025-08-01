<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Success response method.
     */
    public function sendResponse($result, $message = 'Success')
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Return error response.
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Return validation error response.
     */
    public function sendValidationError($errorMessages, $message = 'Validation Error')
    {
        return $this->sendError($message, $errorMessages, 422);
    }

    /**
     * Return paginated response.
     */
    public function sendPaginatedResponse($result, $message = 'Success')
    {
        $response = [
            'success' => true,
            'data' => [
                'items' => $result->items(),
                'pagination' => [
                    'current_page' => $result->currentPage(),
                    'last_page' => $result->lastPage(),
                    'per_page' => $result->perPage(),
                    'total' => $result->total(),
                    'from' => $result->firstItem(),
                    'to' => $result->lastItem(),
                ]
            ],
            'message' => $message,
        ];

        return response()->json($response, 200);
    }
}