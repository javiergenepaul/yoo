<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentInbox;
Use \Carbon\Carbon;

class PaymentInboxController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('management')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'msg_reciever' => 'required',
            'msg_sender' => 'required',
            'amount' => 'required|numeric',
            'ref' => 'required',
            'sender_acc_name' => 'required',
            'sender_acc_no' => 'required',
            'date_sent' => 'required|date_format:Y-m-d',
            'message' => 'required',
        ]);

        $payment_inbox = new PaymentInbox;
        $payment_inbox->msg_reciever = $request->msg_reciever;
        $payment_inbox->msg_sender = $request->msg_sender;
        $payment_inbox->amount = $request->amount;
        $payment_inbox->ref = $request->ref;
        $payment_inbox->sender_acc_name = $request->sender_acc_name;
        $payment_inbox->sender_acc_no = $request->sender_acc_no;
        $payment_inbox->date_sent = $request->date_sent;
        $payment_inbox->date_recieved = Carbon::now();
        $payment_inbox->message = $request->message;
        $payment_inbox->save();

        $resposnse = [
            'message' => 'Payment Inbox added',
            'payment_inbox' => $payment_inbox
        ];

        return response($response, 200);
    }
}
