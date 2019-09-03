<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Order;
use App\Traits\CaptureIpTrait;
use Carbon\Carbon;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class OrderAgentController extends Controller
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


    public function agents()
    {
        return view('pages.agents');
    }

    /**
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function agentAll(Request $request)
    {
        if (Auth::user()->isRole(['user', 'agent']))
            throw new AuthorizationException('Forbidden');

        $usersQuery = User::whereHas('roles', function ($q) {
            $q->where('name', 'Agent');
        })->with('orders')
            ->orderBy('id', 'DESC');

        $agentsCount = $usersQuery->count();
        $users = $usersQuery->get();

        foreach ($users as $user) {
            [$reward, $tickets, $successCount] = $this->getOrdersStatsByQuery($user->orders);
            $user->reward = $reward;
            $user->tickets = $tickets;
            $user->successCount = $successCount;
            $user->ordersCount = $user->orders->count();
        }

        $users = $users->sortBy('reward', SORT_REGULAR, true);

        return view('pages.agentsAll', compact('users', 'agentsCount'));
    }

    public static function getSum($order, $k = 1)
    {
        if($k == 0) return 0;
        
        if($order >= 0 && $order <= 7){
            return 50 * $order;
        }elseif ($order >= 8 && $order <= 19){
            return $order * 50;
        }elseif ($order >= 20) {
            return $order * 50;
        }else{
            return 0;
        }

		/*
        if($order > 0 && $order < 7){
            return 30 * $order;
        }elseif ($order > 6 && $order < 16){
            return $order * 33;
        }elseif ($order > 15 && $order < 25){
            return $order * 36;
        }elseif ($order > 24 && $order < 36){
            return $order * 40;
        }elseif ($order > 35 && $order < 44){
            return $order * 43;
        }elseif ($order > 44 && $order < 59){
            return $order * 45;
        }elseif ($order > 59) {
            return $order * 50;
        }else{
            return 0;
        }
		*/
    }

    public function allAgentsApi(Request $request)
    {
        if (Auth::user()->isRole(['user', 'agent']))
            throw new AuthorizationException('Forbidden');

        $filters = $request->filters;
        $orderBy = $request->get('order-by');

        $usersQuery = User::whereHas('roles', function ($q) {
            $q->where('name', 'Agent');
        });


        $usersQuery = $usersQuery->with(['orders' => function ($q) use ($filters) {
            if (is_array($filters)) {
                if ( isset($filters['from']) )
                    $q->whereDate('datetime', '>=', date($filters['from']));
                if ( isset($filters['to']) )
                    $q->whereDate('datetime', '<=', date($filters['to']));
            }
        }]);

        if ( isset($filters['name']) )
            $usersQuery = $usersQuery->where('name', 'like', '%' . $filters['name'] . '%');

        $totalCount = $usersQuery->count();

        $sortableValues = [
            'reward', 'tickets', 'successCount', 'ordersCount'
        ];

        $colIsSortable = in_array($orderBy['col'], $sortableValues);

        if (!$colIsSortable)
            $usersQuery = $usersQuery->orderBy($orderBy['col'], $orderBy['order']);

        $users = $usersQuery->get();

        foreach ($users as $user) {
            [$reward, $tickets, $successCount] = $this->getOrdersStatsByQuery($user->orders);
            $user->reward = $reward;
            $user->tickets = $tickets;
            $user->successCount = $successCount;
            $user->ordersCount = $user->orders->count();
        }

        if ($colIsSortable) {
            $users = $users->sortBy($orderBy['col'], SORT_REGULAR, $orderBy['order'] == 'DESC');
            $users = array_values($users->toArray());
        }

        return new JsonResponse([
            'items' => $users,
            'totalCount' => $totalCount
        ]);
    }

    private function getOrdersStatsByQuery($q)
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

        $successCount = $q->where('status_order', '=', 'success')->count();

        $ticketsQuery = $q->where('status_order', 'success')
            ->where('ticketfree_reason', '!=', 'cardpersonal')
            ->where('ticketfree_reason', '!=', 'cardgold');

        $tickets = $ticketsQuery->sum('tickets');

        $tickets += $ticketsQuery->sum('ticket_child');

        return [$totalSuma, $tickets, $successCount];
    }

}