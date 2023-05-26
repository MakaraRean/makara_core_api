<?php
    namespace App\Logic;
    use App\Interfaces\IDatabaseLogic;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;

    class BaseLogic implements IDatabaseLogic
    {
        public static function base_response($message, $content=null, $status = 200): JsonResponse
        {
            return response()->json(
                [
                    "status"=> $status,
                    "message" => $message,
                    "content" => $content
                ],
                $status
            );
        }


        public static function get_response($content, $total_record){
            return response()->json(
                [
                    "status"=> 200,
                    "message" => "Success",
                    "total_record"=> $total_record,
                    "content" => $content
                ],
                200
            );
        }

        public static function search($table, $filters = [])
        {
            $keys = array_keys($filters);
            $data = DB::table($table)->where('is_active', true)
                ->when($filters,
                    function ($query) use ($filters, $keys){
                        foreach (array_combine($filters, $keys) as $filter=>$key){
                            if ($key == 'sex'  || $key == 'is_paid' || $key == 'debtor_id' || $key == 'id')
                                $query->where($key, "=", $filter);
                            elseif ($key == 'd1' || $key == 'd2') {
                                continue;
                            }
                            else
                                $query->where($key, "LIKE", "%{$filter}%");
                        }
                        if (array_key_exists('d1', $filters) || array_key_exists('d2', $filters)){
                            if (!array_key_exists('d1', $filters)) {
                                $filters['d1'] = '1970-01-01';
                            }
                            if (!array_key_exists('d2', $filters)) {
                                $filters['d2'] = '2100-01-01';
                            }
                            $query->whereBetween('created_at',
                                [$filters['d1'], date('Y-m-d', strtotime($filters['d2'].'+ 1 day'))]);
                        }
                        return $query;
                    })
                ->get();
            return $data;
        }
    }
