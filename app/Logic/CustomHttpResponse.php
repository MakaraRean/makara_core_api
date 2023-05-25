<?php

namespace App\Logic;

use App\Interfaces\ICustomHttpResponse;
use Faker\Provider\Base;

class CustomHttpResponse implements ICustomHttpResponse
{
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

    public static function custom_response($message, $data, $status){
        return BaseLogic::base_response($message, $data, $status);
    }

    public static function successResponse($data, $message, $status = 200)
    {
        return BaseLogic::base_response($message, $data, $status);
    }

    public static function errorResponse($message, $status)
    {
        return BaseLogic::base_response($message, status: $status);
    }

    public static function notFoundResponse($message = 'Data not found! please check your data.')
    {
        return BaseLogic::base_response($message, status: 404);
    }

    public static function getResponse($message, $totalRecords)
    {
        return BaseLogic::get_response($message, $totalRecords);
    }
}
