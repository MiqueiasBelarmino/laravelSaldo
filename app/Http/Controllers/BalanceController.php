<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;
use App\Http\Requests\MoneyValidationFormRequest;
use App\User;

class BalanceController extends Controller
{
    public function index()
    {

        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount:0;

        return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request, Balance $balance)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->deposit($request->value);

        if($response['success'])
            return redirect()->route('admin.balance')->with('success',$response['message']);
        
            return redirect()->back()->with('error',$response['message']);
    }

    public function withdraw()
    {
        return view('admin.balance.withdraw');
    }

    public function withdrawStore(MoneyValidationFormRequest $request, Balance $balance)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->withdraw($request->value);

        if($response['success'])
            return redirect()->route('admin.balance')->with('success',$response['message']);
        
            return redirect()->back()->with('error',$response['message']);
    }

    public function transfer()
    {
        return view('admin.balance.transfer');
    }

    public function confirmTransfer(Request $request, User $user)
    {
        if(!$receiver = $user->getReceiver($request->receiver))
        {
            return redirect()->back()->with('error', 'Usuário não encontrado');        
        }

        return view('admin.balance.transfer-confirm', compact('receiver'));

    }

}
