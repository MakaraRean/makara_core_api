<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function test(){
        $users = [];
        return view('test', ["users" => $users]);
    }
}
