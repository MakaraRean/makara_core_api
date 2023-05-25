<?php

namespace App\Http\Controllers;

use App\Logic\BaseLogic;
use App\Logic\CustomHttpResponse;
use App\Models\Debt;
use App\Models\Debtor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtorController extends Controller
{
    public function get_debtors(Request $request){
//            $debtors = DB::table('debtors')->where("is_active", true);
//            if ($name) {
//                $debtors->where('name', 'LIKE', "%{$name}%");
//            }
//            if ($sex) {
//                $debtors->where('sex', '=', $sex);
//            }
//
//            if ($address) {
//                $debtors->where('address', 'LIKE', "%{$address}%");
//            }
//            $debtors = $debtors->get();
        $filters = $request->only(['id', 'name', 'sex', 'address', 'd1', 'd2']);
        $debtors = BaseLogic::search('debtors', $filters);
        if ($debtors->isEmpty()){
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
            return CustomHttpResponse::save_unsuccess($debtor);
        return BaseLogic::base_response(message: "Debtor create successfully.", content: $request->json()->all(), status: 201);
    }

    public function update(Request $request){
        $debtor = Debtor::find($request->id);
        if (!$debtor){
            return CustomHttpResponse::notFoundResponse("Not found debtor with id {$request->id}!");
        }
        try {
            $debtor->name = $request->name;
            $debtor->sex = $request->sex;
            $debtor->address = $request->address;
            $saved = $debtor->save();
            if (!$saved)
                return CustomHttpResponse::update_unsuccess($debtor);

        }
        catch (Exception $exception){
            return CustomHttpResponse::update_unsuccess($exception);
        }
        return CustomHttpResponse::data_updated($debtor);
    }

    public function pay(Request $request){
        $debtor = Debtor::find($request->id);
        if (!$debtor){
            return CustomHttpResponse::notFoundResponse("Not found debtor with id {$request->id}!");
        }
        $debts = Debt::where('debtor_id', $request->id)->where('is_paid', false)->get();
        if ($debts->isEmpty()){
            return CustomHttpResponse::notFoundResponse("Debtor has no debt!");
        }
        try {
            $debts->each(function ($debt) {
                $debt->is_paid = true;
                $debt->save();
            });
            return CustomHttpResponse::custom_response("Debt was paid successfully!", data: $debts, status: 200);
        }
        catch (Exception $exception){
            return CustomHttpResponse::custom_response("Debt was not paid!",$exception, status: 400);
        }
    }
}
