<?php

namespace App\Http\Controllers;

use App\Logic\BaseLogic;
use App\Models\Debtor;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtorController extends Controller
{
    public function get_debtors(Request $request){
        if ($request->hasAny(['name', 'sex', 'address'])){
            $name = $request->input('name');
            $sex = $request->input('sex');
            $address = $request->input('address');
            $debtors = DB::table('debtors');
            if ($name)
                $debtors->where('name','LIKE', "%{$name}%");
            if ($sex)
                $debtors->where('sex','LIKE', "%{$sex}%");
            if ($address)
                $debtors->where('address','LIKE', "%{$address}%");
            $debtors = $debtors->where('is_active', '=', true)->get();
        }
        else{
            $debtors = Debtor::all();
            //$debtors = DB::table('debtors')->where('is_active', '=', true)->limit(10)->get();
        }

        if ($debtors->count() == 0){
            return BaseLogic::base_response("Debtor was not found!", status: 404);
        }
        return BaseLogic::get_response($debtors, $debtors->count());
    }

    public function add_debtor(Request $request){
        $name = $request->name;
        $sex = $request->sex;
        $address = $request->address;

        $debtor = new Debtor();
        $debtor->name = $name;
        $debtor->sex = $sex;
        $debtor->address = $address;
        $saved = $debtor->save();
        if (!$saved)
            return BaseLogic::base_response(message: "Debtor {$name} was not add, there are went wrong!", status: 422);
        return BaseLogic::base_response(message: "Debtor create successfully.", content: $request->json()->all(), status: 201);
    }

    public function update(Request $request){

    }
}
