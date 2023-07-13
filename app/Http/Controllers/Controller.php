<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addVisiter(){
        $ipAddress = $_SERVER['REMOTE_ADDR']; // Retrieve the user's IP address
        DB::table('viewer')->insert([
            'ip_address' => $ipAddress || "0.0.0.0.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
