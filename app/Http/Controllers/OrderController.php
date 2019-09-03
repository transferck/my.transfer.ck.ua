<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Order;
use DB;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('pages.admin.home');
        }

        return view('pages.user.home');
    }

    public function changeStatus()
    {
        $now = Carbon::now();

            $orders = Order::where('status_order', '=', 'reservation')
            ->where(DB::raw("(DATE_FORMAT(datetime,'%Y-%m-%d'))"), $now->format('Y-m-d'))->get();

        //dd($orders);

        foreach ($orders as $order){
            $dt = strtotime($order->datetime);
            $dt2 = strtotime($now->format('Y-m-d H:i:s'));

            if($dt2 >= $dt){
                $order->status_order = 'success';
                $order->save();
            }
        }
    }
}
