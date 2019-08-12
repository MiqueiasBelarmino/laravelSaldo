<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;
use App\Models\Historic;
use App\Http\Requests\MoneyValidationFormRequest;
use App\User;

class BalanceController extends Controller
{
    private $totalPage = 10;
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

        if($receiver->id == auth()->user()->id)
        {
            return redirect()->back()->with('error', 'Não é possivel transferir para sí');        
        }

        $balance = auth()->user()->balance;

        return view('admin.balance.transfer-confirm', compact('receiver', 'balance'));

    }

    public function transferStore(MoneyValidationFormRequest $request, User $user)
    {
        if(!$receiver = $user->find($request->receiver_id))
            return redirect()->route('balance.transfer')
            ->with('error', 'Recebedor não encontrado');
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->transfer($request->value, $receiver);

        if($response['success'])
            return redirect()->route('admin.balance')->with('success',$response['message']);
        
            return redirect()->route('balance.transfer')->with('error',$response['message']);
    }

    public function historic(Historic $historic)
    {
        $historics = auth()->user()->historics()->with(['userReceiver'])->paginate($this->totalPage);
        
        $types = $historic->type();

        return view('admin.balance.historics', compact('historics', 'types'));
    }

    public function searchHistoric(Request $request, Historic $historic)
    {
        $dataForm = $request->except('_token');
        $historics = $historic->search($dataForm,$this->totalPage);
        $types = $historic->type();

        //passar dataForm para não perder filtro na paginação
        return view('admin.balance.historics', compact('historics', 'types','dataForm'));

    }

}