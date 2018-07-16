<?php

namespace App\Modules\Finance\Model;

use App\Modules\Order\Model\OrderModel;
use App\Modules\User\Model\UserDetailModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashoutModel extends Model
{
    
    protected $table = 'cashout';

    protected $primaryKey = 'id';

    protected $fillable = [
        'uid', 'pay_type', 'pay_account', 'pay_code', 'cash', 'fees', 'real_cash',
        'admin_uid', 'cashout_type', 'cashout_account', 'status', 'note'
    ];


    public $transactionData;

    public function createCashout($data)
    {
        $cashout = array(
            'uid' => $data['uid'],
            'cashout_account' => $data['cashout_account'],
            'cash' => $data['cash']
        );
        $order = array(
            'code' => $data['code'],
            'title' => $data['title'],
            'uid' => $data['uid'],
            'cash' => $data['cash'],
            'created_at'=>date('Y-m-d H:i:s',time())
        );
        $this->transactionData['cashout'] = $cashout;
        $this->transactionData['order'] = $order;

        $status = DB::transaction(function(){
            $this->transactionData['cashout'] = CashoutModel::create($this->transactionData['cashout']);
            OrderModel::create($this->transactionData['order']);
        });

        return is_null($status) ? $this->transactionData['cashout']->id : false;


    }

    
    static function addCashout($data)
    {
        $status = DB::transaction(function() use ($data) {
            $user = Auth::User();
            CashoutModel::create($data);
            $finance = array(
                'action' => 4,
                'pay_account' => $data['cashout_account'],
                'cash' => $data['cash'],
                'uid' => $user->id,
                'created_at'=>date('Y-m-d H:i:s',time())
            );
            if ($data['cashout_type'] == 1){
                $finance['pay_type'] = 2;
            } elseif ($data['cashout_type'] == 2){
                $finance['pay_type'] = 4;
            }
            FinancialModel::create($finance);
            UserDetailModel::where('uid', $user->id)->decrement('balance', $data['cash']);
        });
        return is_null($status) ? true : false;
    }

    
    static function cashoutRefund($cashId)
    {
        $cashoutInfo = CashoutModel::find($cashId);
        if (!empty($cashoutInfo)){
            $status = DB::transaction(function() use ($cashoutInfo){
                UserDetailModel::where('uid', $cashoutInfo->uid)->increment('balance', $cashoutInfo->cash);
                $cashoutInfo->status = 2;
                $cashoutInfo->save();
                $data = [
                    'action' => 8,
                    'pay_type' => 1,
                    'cash' => $cashoutInfo->cash,
                    'uid' => $cashoutInfo->uid
                ];
                FinancialModel::create($data);
            });
            return is_null($status) ? true : false;
        }
    }

}
