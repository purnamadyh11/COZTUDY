<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function index(){
        $data = Transaction::with('transactionDetail.place.placeDetails')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('frontend/cart', ['data' => $data]);
    }

    public function store(Request $request){
        $grand_total = 0;
        foreach ($request->price as $k => $v) {
            $grand_total += $v;
        }

        $transaction = Transaction::create([
            'code' => self::generateRandomString(5).date('His'), 
            'description' => "", 
            'grand_total' => $grand_total, 
            'status' => 0,
            'user_id' => Auth::user()->id,
        ]);

        foreach ($request->place_id as $key => $value) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'place_id' => $value,
                'qty' => 1,
                'sub_total' => $request->price[$key],
                'status' => 0,
            ]);
        }
        
        return redirect()->back();
    }

    public function cancel($id) {
        return Transaction::where('id', $id)->update(['status' => 4]);
    }

    public function generateRandomString($length = 10) {
        // Characters to be included in the random string
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Length of the characters string
        $charactersLength = strlen($characters);
        // Initialize the random string
        $randomString = '';
        // Loop through the desired length and append a random character from the characters string
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
