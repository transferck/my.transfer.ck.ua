<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class OrdersStatsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index()
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

		$orders = Order::where('user_id', '=', auth()->user()->id)->get();
        [$passangers_orders, $totalSuma, $success_order] = $this->getOrdersStatsByQuery($orders);

        $orders_month = Order::where('user_id', '=', auth()->user()->id)
            ->whereYear('datetime', '=', Carbon::now()->format('Y'))
            ->whereMonth('datetime', '=', Carbon::now()->format('m'))
            ->get();
        [$passangers_month, $totalSumaMonth, $success_month] = $this->getOrdersStatsByQuery($orders_month);

        $orders_last_month = Order::where('user_id', '=', auth()->user()->id)
            ->whereYear('datetime', '=', Carbon::now()->format('Y'))
            ->whereMonth('datetime', '=', Carbon::now()->subMonth()->format('m'))
            ->get();
        [$passangers_last_month, $totalSumaLastMonth, $success_last_month] = $this->getOrdersStatsByQuery($orders_last_month);

        $charts = $this->getChartsData();

		return view('orders-stats.index', compact(
		    'orders', 'success_order',
            'passangers_orders', 'totalSuma',
            'orders_month', 'success_month',
            'passangers_month', 'totalSumaMonth',
            'passangers_last_month', 'totalSumaLastMonth',
            'success_last_month', 'orders_last_month',
            'charts'
        ));
		
    }

    protected function getSum($order)
    {
		
		if($order > 0 && $order < 7){
            return 50 * $order;
        }elseif ($order >= 8 && $order <= 19){
            return $order * 50;
        }elseif ($order >= 20) {
            return $order * 50;
        }else{
            return 0;
        }
    }

    public function getChartsData()
    {
        $data = [];

        $data['orders_week'] = Order::orders_week('reservation');
        $data['orders_week_success'] = Order::orders_week('success');

        $data['orders_month'] = Order::orders_month('sent');
        $data['orders_month_success'] = Order::orders_month('success');

        $data['orders_year'] =  Order::orders_year('sent');

        return $data;
    }

    private function getOrdersStatsByQuery(Collection $q)
    {
        $notPaid = $q
            ->where('status_order', 'success')
            ->where('status_pay', 'not-paid')

            ->sum(function ($row) {
                return $row->tickets + $row->ticket_child;
            });

        $customerpaidB = $q
            ->where('status_order', 'success')
            ->where('status_pay', 'paid')
            ->where('ticketfree_reason', 'customerpaid')
            ->where('airport_ukraine', 'Б')

            ->sum(function ($row) {
                return $row->tickets + $row->ticket_child;
            });

        $customerpaidZH = $q
            ->where('status_order', 'success')
            ->where('status_pay', 'paid')
            ->where('ticketfree_reason', 'customerpaid')
            ->where('airport_ukraine', 'Ж')

            ->sum(function ($row) {
                return $row->tickets + $row->ticket_child;
            });

        $halfB = $q
            ->where('status_order', 'success')
            ->where('status_pay', 'paid')
            ->where('ticketfree_reason', 'discounthalf')
            ->where('airport_ukraine', 'Б')

            ->sum(function ($row) {
                return $row->tickets + $row->ticket_child;
            });

        $halfZH = $q
            ->where('status_order', 'success')
            ->where('status_pay', 'paid')
            ->where('ticketfree_reason', 'discounthalf')
            ->where('airport_ukraine', 'Ж')

            ->sum(function ($row) {
                return $row->tickets + $row->ticket_child;
            });

        $sumCustomerpaidB = $customerpaidB * 300;
        $sumCustomerpaidZH = $customerpaidZH * 350;

        $sumHalfB = $halfB * 150;
        $sumHalfZH = $halfZH * 175;

        $passangers_orders = $notPaid + $customerpaidB + $customerpaidZH + $halfB + $halfZH;

        $totalSuma = $this->getSum($passangers_orders);
        $totalSuma -= $sumCustomerpaidB + $sumCustomerpaidZH + $sumHalfB + $sumHalfZH;

        $success_order = $q->where('status_order', '=', 'success')->count();

        return [$passangers_orders, $totalSuma, $success_order];
    }
}
