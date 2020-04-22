<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Payment\PagSeguro\CreditCard;

class CheckoutController extends Controller
{
    public function index() {
        session()->forget('pagseguro_session_code');

        if(!auth()->check()){
            return redirect()->route('login');
        }

        $this->makePagSeguroSession();

        $cartItens = array_map(function($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));

        $total = array_sum($cartItens);

        return view('checkout', compact('total'));
    }

    public function proccess(Request $request){
        try{
            $dataPost = $request->all();
            $cartItens = session()->get('cart');
            $stores = array_unique(array_column($cartItens, 'store_id'));
            $user = auth()->user();
            $reference = "XPTO";

            $creditCardPayment = new CreditCard($cartItens, $user, $dataPost, $reference);
            $result = $creditCardPayment->doPayment();

            $userOrders = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cartItens),
                'store_id' => 1
            ];

            $userOrders = $user->orders()->create($userOrders);
            $userOrders->stores()->sync($stores);

            session()->forget('cart');
            session()->forget('pagseguro_session_code');

            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Pedido realizado com sucesso',
                    'order' => $reference
                ]
            ]);
        }catch(Exception $e){
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => 'Erro ao processar pedido'
                ]
                ], 401);
        }
    }

    public function thanks(){
        return view('thanks');
    }

    private function makePagSeguroSession() {
        if(!session()->has('pagseguro_session_code')){
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            
            session()->put('pagseguro_session_code', $sessionCode->getResult());
        }
    }
}
