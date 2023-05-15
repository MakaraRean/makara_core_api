<?php

namespace App\Interfaces;

interface ICustomHttpResponse {
    public static function errorResponse($message, $status);
    public static function successResponse($data, $message, $status = 200);
    public static function notFoundResponse($message);
}
