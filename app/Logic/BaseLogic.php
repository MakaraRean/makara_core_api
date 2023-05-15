<?php
    namespace App\Logic;
    use Illuminate\Http\JsonResponse;

class BaseLogic {
        public static function base_response($message, $content=null, $status = 200): JsonResponse
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


        public static function get_response($content, $total_record){
            return response()->json(
                [
                    "status"=> 200,
                    "message" => "Success",
                    "total_record"=> $total_record,
                    "content" => $content
                ],
                200
            );
        }
    }
