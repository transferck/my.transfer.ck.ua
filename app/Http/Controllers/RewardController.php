<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Traits\CaptureIpTrait;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class RewardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $currDate = Carbon::now()->format('Y-m-d');
        $orders = Order::whereDate('datetime', '=', $currDate)
            ->where('status_order', '=', 'success')
            ->get();
    }

}