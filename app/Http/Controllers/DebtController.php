<?php

namespace App\Http\Controllers;

use App\Logic\BaseLogic;
use App\Logic\CustomHttpResponse;
use App\Models\Debt;
use App\Models\Debtor;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function get(Request $request){
        $params = $request->only(['id', 'd1', 'd2', 'is_paid']);
        $debts = BaseLogic::search('debts', $params);
        if ($debts->isEmpty()){
            return CustomHttpResponse::notFoundResponse();
        }
        return CustomHttpResponse::getResponse($debts, $debts->count());
    }

    public function add(Request $request){
        $debt = new Debt();
        $debtorId = Debtor::find($request->debtor_id);
        if (!$debtorId){
            return CustomHttpResponse::notFoundResponse("Debtor {$request->debtor_id} not found!");
        }
        $debt->debtor_id = $request->debtor_id;
        $debt->amount = $request->amount;
        $saved = $debt->save();
        if (!$saved){
            return CustomHttpResponse::save_unsuccess($debt);
        }
        return CustomHttpResponse::successResponse($debt, 'A new debt  has been added',  201);
    }

    // Create a function to update debt
    public function update(Request $request){
        $debt = Debt::find($request->id);
        if (!$debt){
            return CustomHttpResponse::notFoundResponse("Debt {$request->id} not found!");
        }
        $debt->debtor_id = $request->debtor_id;
        $debt->amount = $request->amount;
        $saved = $debt->save();
        if (!$saved){
            return CustomHttpResponse::save_unsuccess($debt);
        }
        return CustomHttpResponse::successResponse($debt, 'Debt has been updated',  200);
    }

    // Create a function to pay debt
    public function pay(Request $request){
        $debt = Debt::find($request->id);
        if (!$debt){
            return CustomHttpResponse::notFoundResponse("Debt {$request->id} not found!");
        }
        $debt->is_paid = true;
        $saved = $debt->save();
        if (!$saved){
            return CustomHttpResponse::save_unsuccess($debt);
        }
        return CustomHttpResponse::successResponse($debt, 'Debt has been paid',  200);
    }
}
