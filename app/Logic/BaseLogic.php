<?php
    namespace App\Logic;
    use Illuminate\Http\Resources\Json\JsonResource;

class BaseLogic {
        public static function base_response($message, $content=null, $status = 200): \Illuminate\Http\JsonResponse
        {
            return response()->json(
                [
                    "status"=> $status,
                    "message" => $message,
                    "content" => $content
                ],
                $status
            );
        }
    }

class CustomeHttpResponse extends JsonResource{

}

