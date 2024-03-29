<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit(float $value) : Array
    {

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format($value, 2,'.','');
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'I',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);

        if($deposit && $historic)
        {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Recarga efetuada'
            ];
        }else
        {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao recarregar'
            ];
        }
    }

    public function withdraw(float $value) : Array
    {
        if($this->amount < $value)
            return [
                'success' => false,
                'message' => 'Saldo insuficiente',
            ];

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2,'.','');
        $withdraw = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'O',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);

        if($withdraw && $historic)
        {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Saque realizado'
            ];
        }else
        {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha no saque'
            ];
        }
    }

    public function transfer(float $value, User $receiver) : Array
    {
        if($this->amount < $value)
        return [
            'success' => false,
            'message' => 'Saldo insuficiente',
        ];

        DB::beginTransaction();

        //atualizar o próprio saldo
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2,'.','');
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'                => 'T',
            'amount'              => $value,
            'total_before'        => $totalBefore,
            'total_after'         => $this->amount,
            'date'                => date('Ymd'),
            'user_id_transaction' => $receiver->id
        ]);

        //atualizar o saldo do recebedor
        $receiverBalance = $receiver->balance()->firstOrCreate([]);
        //$receiverTotalBefore = $receiverBalance->amount ? $this->senderBalance : 0;
        $receiverTotalBefore = $receiverBalance->amount ? $receiverBalance->amount : 0;
        $receiverBalance->amount += number_format($value, 2,'.','');
        $receiverTransfer = $receiverBalance->save();

        $receiverHistoric = $receiver->historics()->create([
            'type'                => 'I',
            'amount'              => $value,
            'total_before'        => $receiverTotalBefore,
            'total_after'         => $receiverBalance->amount,
            'date'                => date('Ymd'),
            'user_id_transaction' => auth()->user()->id
        ]);

        if($receiverTransfer && $receiverHistoric)
        {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Tranferência realizada'
            ];
        }else
        {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha na transferência'
            ];
        }
    }

}
