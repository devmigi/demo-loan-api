<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message = '')
    {
        $response = [
            'code' => 200,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendSuccess($message = '')
    {
        $response = [
            'code' => 200,
            'data'    => null,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($message, $errors = [], $code = 404)
    {
        $response = [
            'message' => $message,
            'code' => $code
        ];


        if(!empty($errors)){
            $response['data'] = $errors;
        }

        Log::error(json_encode($response));

        return response()->json($response, $code);
    }

}