<?php
namespace App\Http\Traits;

trait Api_Trait
{

    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($message,$status = 200)
    {
        return response()->json([
            'data' => null,
            'message' => $message,
            'status' => $status,
        ],200);
    }

    public function returnErrorValidation($message,$status = 200)
    {
        return response()->json([
            'data' => null,
            'message' => $message,
            'status' => $status,
        ],200);
    }

    public function returnErrorNotFound($message,$status = 200)
    {
        return response()->json([
            'data' => null,
            'message' => $message,
            'status' => $status,
        ],200);
    }



    public function returnDataPaginate( $data, $message, $last_page = null, $current_page = null, $total, $status=200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'last_page' => $last_page,
            'current_page' => $current_page,
            'total' => $total,
            'status' => $status,
        ],200);
    }

    public function returnData( $data, $message,$status=200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status,
        ],200);
    }


    public function returnSuccessMessage($message,$status=200){
        return response()->json([
            'data' => null,
            'message' => $message,
            'status' => $status,
        ],200);
    }


    public function returnSuccessDataMessage($message, $status = 200) {
        return response()->json([
            'data' => (object) [],
            'message' => [$message],
            'status' => $status,
        ], $status);
    }
    
    public function returnErrorDataNotFound($message, $status = 200) {
        return response()->json([
            'data' => (object) [],
            'message' => [$message],
            'status' => $status,
        ], $status);
    }
    public function returnInvalidData($message, $status = 200) {
        return response()->json([
            'data' => (object) [],
            'message' => [$message  . ' || Invalid Otp'],
            'status' => $status,
        ], $status);
    }
}
