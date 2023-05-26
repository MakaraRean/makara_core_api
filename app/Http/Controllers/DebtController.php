<?php

namespace App\Http\Controllers;

use App\Logic\BaseLogic;
use App\Logic\CustomHttpResponse;
use App\Models\Debt;
use App\Models\Debtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function get(Request $request){
        $params = $request->only(['id', 'd1', 'd2', 'is_paid', 'debtor_id']);
        $debts = BaseLogic::search('debts', $params);

        $debtorIds = $debts->pluck('debtor_id')->toArray();
        $debtors = Debtor::whereIn('id', $debtorIds)->get()->keyBy('id');
        $debtsRes = $debts->map(function ($debt) use ($debtors) {
            return [
                'id' => $debt->id,
                'amount' => $debt->amount,
                'is_paid' => $debt->is_paid,
                'debtor' => $debtors->get($debt->debtor_id),
            ];
        });
//        foreach ($debts as $debt){
//            $debtModel->amount = $debt->amount;
//            $debtModel->is_paid = $debt->is_paid;
//            $debtModel->debtor =  Debtor::find($debt->debtor_id);
//            $debtsRes[] = $debtModel;
//        }
        if ($debts->isEmpty()){
            return CustomHttpResponse::notFoundResponse();
        }
        return CustomHttpResponse::getResponse($debtsRes, $debts->count());
    }


    public function getByDebtor($id){
        $debtor = DB::table('debts')->select('debtor_id', DB::raw('SUM(amount) as total_amount, COUNT(debtor_id) as debt_count'))
            ->groupBy('debtor_id')
            ->where('debtor_id', $id)->where('is_active', true)->first();
        if (!$debtor){
            return CustomHttpResponse::notFoundResponse("Debtor {$id} not found!");
        }
        $debtor->debtor = Debtor::find($id);

        //$debtorResponse = new Debtor;
        $debtorResponse = $debtor->debtor;
        $debtorResponse->total_amount = $debtor->total_amount;
        $debtorResponse->debt_count = $debtor->debt_count;
        return CustomHttpResponse::custom_response("Debt of {$debtorResponse->name} found successfully", $debtorResponse, 200);
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
