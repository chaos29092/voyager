<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Mail;
use App\Models\Order;

class MailController extends Controller
{

    public function submit(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
        ]);

        $order = new Order();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone =$request->phone;
        $order->subject =$request->subject;
        $order->message =$request->message;
        $order->url =$request->url;
        $order->clientId =$request->clientId;

        $order->save();

        Mail::to(env('MAIL_TO','chaos29092@gmail.com'))->cc(env('MAIL_CC','chaos29092@gmail.com'))->send(new OrderShipped($order));
//      use queue
//        Mail::to('chaos29092@gmail.com')->queue(new OrderShipped($order));
    }

    public function submit_ok()
    {
        return view('submit_ok');
    }

}
