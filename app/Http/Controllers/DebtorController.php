<?php

namespace App\Http\Controllers;

use App\Logic\BaseLogic;
use App\Logic\CustomHttpResponse;
use App\Models\Debtor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtorController extends Controller
{
    public function get_debtors(Request $request){
            $name = $request->input('name');
            $sex = $request->input('sex');
            $address = $request->input('address');
            $debtors = DB::table('debtors')->where("is_active", true);
            if ($name) {
                $debtors->where('name', 'LIKE', "%{$name}%");
            }
            if ($sex) {
                $debtors->where('sex', '=', $sex);
            }

            if ($address) {
                $debtors->where('address', 'LIKE', "%{$address}%");
            }
            $debtors = $debtors->get();

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
}
