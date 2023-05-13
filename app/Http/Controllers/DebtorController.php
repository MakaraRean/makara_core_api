<?php

namespace App\Http\Controllers;

use App\Logic\BaseLogic;
use App\Models\Debtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtorController extends Controller
{
    public function get_debtors(Request $request){
        if ($request->hasAny(['name', 'sex', 'address'])){
            $name = $request->input('name');
            $sex = $request->input('sex');
            $address = $request->input('address');
            $debtors = DB::table('debtors')->where('name','LIKE', "%{$name}%")
                ->orWhere('sex', 'LIKE', "%{$sex}%")
                ->orWhere('address', 'LIKE', "%{$address}%")
                ->where('is_active', '=', true)->get();
        }
        else{
            $debtors = Debtor::all();
            //$debtors = DB::table('debtors')->where('is_active', '=', true)->limit(10)->get();
        }

        if ($debtors->count() == 0){
            return BaseLogic::base_response("Debtor was not found!", status: 404);
        }
        return BaseLogic::base_response("Get debtors successfully", $debtors);
    }
}
