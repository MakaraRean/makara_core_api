<?php
    namespace App\Logic;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\JsonResource;

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

class CustomHttpResponse extends JsonResponse{
    public static function not_found(){
        return BaseLogic::base_response("Data not found!", status: 404);
    }

    public static function save_unsuccess($data){
        return BaseLogic::base_response("Data save unsuccessfully! please check data entry.", $data, 422);
    }

    public static function update_unsuccess($data){
        return BaseLogic::base_response("Data update is not success! there are went wrong", $data, 422);
    }

    public static function data_updated($data)
    {
        return BaseLogic::base_response("Data was updated.", $data);
    }
}

