<?php

namespace App\Logic;

use App\Interfaces\ICustomHttpResponse;

class CustomHttpResponse implements ICustomHttpResponse
{
    public static function not_found()
    {
        return BaseLogic::base_response("Data not found!", status: 404);
    }

    public static function save_unsuccess($data)
    {
        return BaseLogic::base_response("Data save unsuccessfully! please check data entry.", $data, 422);
    }

    public static function update_unsuccess($data)
    {
        return BaseLogic::base_response("Data update is not success! there are went wrong", $data, 422);
    }

    public static function data_updated($data)
    {
        return BaseLogic::base_response("Data was updated.", $data);
    }

    public static function successResponse($data, $message, $status = 200)
    {
        return BaseLogic::base_response($message, $data, $status);
    }

    public static function errorResponse($message, $status)
    {
        return BaseLogic::base_response($message, status: $status);
    }

    public static function notFoundResponse($message)
    {
        return BaseLogic::base_response($message, status: 404);
    }
}
