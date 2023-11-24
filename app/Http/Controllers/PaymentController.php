<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $pay = Payment::all();
        if($pay->isEmpty()) {
            return $this->notFoundResponse(null);
        } else if ($pay) {
            return $this->getSuccessResponse($pay);
        } else {
            return $this->failedResponse('Error in getting payment', null , 500);
        }
    }

    public function getUserPayment(Request $request) {
        $user = $request->user();
        $pay = Payment::where('user_id', $user->id)->get();
        if($pay->isEmpty()) {
            return $this->notFoundResponse(null);
        } else if ($pay) {
            return $this->getSuccessResponse($pay);
        } else {
            return $this->failedResponse('Error in getting payment', null , 500);
        }
    }
}
