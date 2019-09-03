<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use App\Rules\NotEqualsOrder;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use DB;

class OrdersManagementController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index()
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

        $pagintaionEnabled = config('ordersmanagement.enablePagination');
        if ($pagintaionEnabled) {
            $orders = Order::paginate(config('ordersmanagement.paginateListSize'));
        } else {
            $orders = Order::all();
        }
        $roles = Role::all();

		$orders_vl = Order::where([
			['type', '=', 'vl'],
			//['status_order', '!=', 'cancel'],
			['user_id', '=', auth()->user()->id],
		])
		->orWhere([
			['status_order', '=', 'sent'],
			['status_order', '=', 'reservation'],
			['status_order', '=', 'moved'],
			['status_order', '=', 'update'],
		])->orderBy('updated_at', 'desc');

		$ordersVlCount = $orders_vl->count();

		$orders_vl = $orders_vl->get();

		$orders_pr = Order::where([
			['type', '=', 'pr'],
            //['status_order', '!=', 'cancel'],
			['user_id', '=', auth()->user()->id],
		])->orWhere([
			['status_order', '=', 'sent'],
			['status_order', '=', 'reservation'],
			['status_order', '=', 'moved'],
			['status_order', '=', 'update'],
		])->orderBy('updated_at', 'desc')
		  ->get();

		$orders_pr_cancel = Order::where([
			['type', '=', 'pr'],
			['status_order', '=', 'cancel'],
			['user_id', '=', auth()->user()->id],
		])->orderBy('updated_at', 'desc')
          ->orderBy('id', 'desc')
		->get();

		$orders_vl_cancel = Order::where([
			['type', '=', 'vl'],
			['status_order', '=', 'cancel'],
			['user_id', '=', auth()->user()->id],
		])->orderBy('updated_at', 'desc')
          ->orderBy('id', 'desc')
		->get();

        $ownOrdersIds = Auth::user()->orders
            ->pluck('id');

        return View('ordersmanagement.show-orders', compact('orders',
            'orders_pr',
            'orders_vl',
            'orders_pr_cancel',
            'orders_vl_cancel',
            'roles',
            'ownOrdersIds',
            'ordersVlCount'
        ));
    }

    public function ordersApi(Request $request)
    {
        $user = Auth::user();

        if ($user->isRole('user'))
            throw new AuthorizationException('Forbidden');

        $filters = $request->filters;
        $orderBy = $request->get('order-by');

        $ordersQuery = Order::where([
            ['type', $filters['type']],
            //['status_order', '!=', 'cancel'],
            ['user_id', $user->id],
        ]);

        if (isset($filters['from']))
            $ordersQuery = $ordersQuery->whereDate('datetime', '>=', date($filters['from']));
        if (isset($filters['to']))
            $ordersQuery = $ordersQuery->whereDate('datetime', '<=', date($filters['to']));

        if (isset($filters['id']))
            $ordersQuery = $ordersQuery->where('id', '=', $filters['id']);

        if (isset($filters['name']))
            $ordersQuery = $ordersQuery->where('fio', 'like', '%' . $filters['name'] . '%');

        if (isset($filters['phone']))
            $ordersQuery = $ordersQuery->where('phone', 'like', '%' . $filters['phone'] . '%');

        if (isset($filters['status']))
            $ordersQuery = $ordersQuery->where('status_order', $filters['status']);

        $totalCount = $ordersQuery->count();

        $orders = $ordersQuery->orderBy($orderBy['col'], $orderBy['order'])
            ->get();

        $ownOrdersIds = Auth::user()->orders
            ->pluck('id');

        return new JsonResponse([
            'items' => $orders,
            'totalCount' => $totalCount,
            'ownItemsIds' => $ownOrdersIds
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function orders_all(Request $request)
    {
        if (Auth::user()->isRole(['user', 'agent']))
            throw new AuthorizationException('Forbidden');

        $orders = Order::with('user');

        if($request->has('from') && !empty($request->get('from'))){
            $orders = $orders->where('created_at', '>=', $request->get('from'));
        }

        if($request->has('to') && !empty($request->get('to'))){
            $orders = $orders->where('created_at', '<', $request->get('to'));
        }

        //$orders = $orders->orderBy('updated_at', 'desc')->orderBy('id', 'desc')->get();

		$orders = Order::with('User')
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
		    ->get();

        $tempOrders = $orders->slice(0, 10);

        $agents = [];

        $tempAgents = $orders->unique('user_id');

        foreach ($tempAgents as $agent) {
            array_push($agents, ['id' => $agent->user->id, 'name' => $agent->user->name]);
        }

        $ordersCount = Order::count();

		$orders_cancel = Order::where([
			['status_order', '=', 'cancel'],
		])->orderBy('updated_at', 'desc')
          ->orderBy('id', 'desc')
		->get();

        $pagintaionEnabled = config('usersmanagement.enablePagination');
        if ($pagintaionEnabled) {
            $users = User::whereHas('roles', function($q){
                $q->where('name', 'Agent');
            })->with(['orders' => function($q){
                  $q->where('status_order', '=', 'success');
            }])
                ->paginate(config('usersmanagement.paginateListSize'));
        } else {
            $users = User::all();
        }

        $ownOrdersIds = Auth::user()->orders
            ->pluck('id');

        return View('ordersmanagement.show-orders-all', compact('users',
            'orders_cancel',
            'orders',
            'ordersCount',
            'tempOrders',
            'agents',
            'ownOrdersIds'
        ));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function allOrdersApi(Request $request)
    {
        if (Auth::user()->isRole(['user', 'agent']))
            throw new AuthorizationException('Forbidden');

        $filters = $request->get('filters');
        $orderBy = $request->get('order-by');

        $orders = Order::with('User');

        if (is_array($filters)) {
            if ( isset($filters['from']) )
                $orders->whereDate('datetime', '>=', date($filters['from']));
            if ( isset($filters['to']) )
                $orders->whereDate('datetime', '<=', date($filters['to']));

            if ( isset($filters['id']) )
                $orders->where('id', '=', $filters['id']);

            if ( isset($filters['name']) )
                $orders->where('fio', 'like', '%' . $filters['name'] . '%');

            if ( isset($filters['phone']) )
                $orders->where('phone', 'like', '%' . $filters['phone'] . '%');

            if ( isset($filters['user_id']) )
                $orders->where('user_id', '=', $filters['user_id']);

            if ( isset($filters['status']) ) {
                $orders->where('status_order', '=', $filters['status']);
            }
        }

        $totalCount = $orders->count();

        $orders = $orders->orderBy($orderBy['col'], $orderBy['order'])
            ->get();

        $ownOrdersIds = Auth::user()->orders
            ->pluck('id');

        return new JsonResponse([
            'items' => $orders,
            'ownItemsIds' => $ownOrdersIds,
            'totalCount' => $totalCount
        ]);
    }

    public function allSearchRange(Request $request)
    {
        $orders = Order::with('user')
            ->where('created_at', '>=', $request->get('from'))
            ->orderBy('updated_at', 'desc')->orderBy('id', 'desc')->get();
        return datatables()->of($orders)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

        $roles = Role::all();

        [$showCardGold, $showDiscountHalf] = $this->isShowBonuses();

        return view('ordersmanagement.create-order')->with(
            compact('roles', 'showCardGold', 'showDiscountHalf')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

        [$showCardGold, $showDiscountHalf] = $this->isShowBonuses();
        $ticketFreeReasonDiff = [];

        if (!$showCardGold) {
            $ticketFreeReasonDiff[] = 'cardgold';
        }
        if (!$showDiscountHalf) {
            $ticketFreeReasonDiff[] = 'discounthalf';
        }

        $validatorArr = [
            'fio'                  				=> 'required|max:255',
            'phone'                  			=> 'required',
            'datetime'                  		=> 'required',
            'airport_ukraine'             		=> 'required',
            'address'                			=> 'required',
            'tickets'                			=> 'required',
            'transfer'                			=> 'required',

        ];

        $validatorArr['ticketfree_reason'] = new NotEqualsOrder($ticketFreeReasonDiff);

        $validator = Validator::make($request->all(),
            $validatorArr,
            [
                'fio.required'        				=> trans('ordersmanagement.messages.fio'),
				'phone.required'        		  	=> trans('ordersmanagement.messages.phone'),
				'datetime.required'        		  	=> trans('ordersmanagement.messages.datetime'),
				'airport_ukraine.required'        	=> trans('ordersmanagement.messages.airport_ukraine'),
				'airport_world.required'       	  	=> trans('ordersmanagement.messages.airport_world'),
				'address.required'       	  		=> trans('ordersmanagement.messages.address'),
				'tickets.required'       	  		=> trans('ordersmanagement.messages.tickets'),
				'transfer.required'       	  		=> trans('ordersmanagement.messages.transfer'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // Create Order
		$order = new Order;
		$order->fio = $request->input('fio');
		$order->phone = $request->input('phone');
        $order->fio2 = $request->input('fio2');
        $order->phone2 = $request->input('phone2');
		$order->type = 'vl';
		$order->datetime = $request->input('datetime');
		$order->airport_ukraine = $request->input('airport_ukraine');
		$order->airport_world = $request->input('airport_world');
		$order->terminal = $request->input('terminal');
		$order->registration = $request->input('registration');
		$order->flight = $request->input('flight');
		$order->address = $request->input('address');
		$order->address2 = $request->input('address2');
		$order->tickets = $request->input('tickets');
		$order->ticket_full = $request->input('ticket_full');
		$order->ticket_child = $request->input('ticket_child');
		$order->ticketfree_reason = $request->input('ticketfree_reason');
		$order->children = $request->input('children');
		$order->children_place = $request->input('children_place');
		$order->transfer = $request->input('transfer');
		$order->suburb = $request->input('suburb');
		$order->info = $request->input('info');
		$order->status_order = 'sent';
		$order->status_pay = $request->input('status_pay');
		$order->option_nameplate = $request->input('option_nameplate');
		$order->option_babyk = $request->input('option_babyk');
		$order->option_babyl = $request->input('option_babyl');
		$order->user_id = auth()->user()->id;

        $order->save();

        return redirect('orders')->with('success', trans('ordersmanagement.createSuccess'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store_pr(Request $request)
    {
        [$showCardGold, $showDiscountHalf] = $this->isShowBonuses();
        $ticketFreeReasonDiff = [];

        if (!$showCardGold) {
            $ticketFreeReasonDiff[] = 'cardgold';
        }
        if (!$showDiscountHalf) {
            $ticketFreeReasonDiff[] = 'discounthalf';
        }

        $validatorArr = [
            'fio'                  				=> 'required|max:255',
            'phone'                  			=> 'required',
            'datetime'                  		=> 'required',
            'airport_ukraine'             		=> 'required',
            'address'                			=> 'required',
            'tickets'                			=> 'required',
            'transfer'                			=> 'required',

        ];

        $validatorArr['ticketfree_reason'] = new NotEqualsOrder($ticketFreeReasonDiff);

        $validator = Validator::make($request->all(),
            $validatorArr,
            [
                'fio.required'        				=> trans('ordersmanagement.messages.fio'),
				'phone.required'        		  	=> trans('ordersmanagement.messages.phone'),
				'datetime.required'        		  	=> trans('ordersmanagement.messages.datetime'),
				'airport_ukraine.required'        	=> trans('ordersmanagement.messages.airport_ukraine'),
				'airport_world.required'       	  	=> trans('ordersmanagement.messages.airport_world'),
				'address.required'       	  		=> trans('ordersmanagement.messages.address'),
				'tickets.required'       	  		=> trans('ordersmanagement.messages.tickets'),
				'transfer.required'       	  		=> trans('ordersmanagement.messages.transfer'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // Create Order
		$order = new Order;
		$order->fio = $request->input('fio');
		$order->phone = $request->input('phone');
        $order->fio2 = $request->input('fio2');
        $order->phone2 = $request->input('phone2');
		$order->type = 'pr';
		$order->datetime = $request->input('datetime');
		$order->airport_ukraine = $request->input('airport_ukraine');
		$order->airport_world = $request->input('airport_world');
		$order->terminal = $request->input('terminal');
		$order->registration = $request->input('registration');
		$order->flight = $request->input('flight');
		$order->address = $request->input('address');
		$order->address2 = $request->input('address2');
		$order->tickets = $request->input('tickets');
		$order->ticket_full = $request->input('ticket_full');
		$order->ticket_child = $request->input('ticket_child');
		$order->ticketfree_reason = $request->input('ticketfree_reason');
		$order->children = $request->input('children');
		$order->children_place = $request->input('children_place');
		$order->transfer = $request->input('transfer');
		$order->suburb = $request->input('suburb');
		$order->info = $request->input('info');
		$order->status_order = 'sent';
		$order->status_pay = $request->input('status_pay');
		$order->option_nameplate = $request->input('option_nameplate');
		$order->option_babyk = $request->input('option_babyk');
		$order->option_babyl = $request->input('option_babyl');
		$order->user_id = auth()->user()->id;

        $order->save();

        return redirect('orders')->with('success', trans('ordersmanagement.createSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function show($id)
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

        $order = Order::find($id);

        if (Auth::user()->isRole('agent') &&
            $order->user->id !== Auth::user()->id)
            throw new AuthorizationException('Forbidden');

        return view('ordersmanagement.show-order')->withOrder($order);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

        $order = Order::findOrFail($id);

        [$showCardGold, $showDiscountHalf] = $this->isShowBonuses($order);

        if (Auth::user()->isRole('agent') &&
            $order->user->id !== Auth::user()->id)
            throw new AuthorizationException('Forbidden');

        return view('ordersmanagement.edit-order')->with(
            compact('order', 'showCardGold', 'showDiscountHalf')
        );
    }

    /**
     * Обновления данных заказа
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

        [$showCardGold, $showDiscountHalf] = $this->isShowBonuses();
        $ticketFreeReasonDiff = [];

        if (!$showCardGold) {
            $ticketFreeReasonDiff[] = 'cardgold';
        }
        if (!$showDiscountHalf) {
            $ticketFreeReasonDiff[] = 'discounthalf';
        }

        $validatorArr = [
            'fio'                  => 'required|max:255',
            'phone'                => 'required|max:32',
            'airport_ukraine'      => 'required|max:255',
            'datetime'             => 'required',
            //'registration'         => 'required',
            'address'              => 'required',
            'tickets'              => 'required',
            'transfer'              => 'required',

        ];

        $order = Order::findOrFail($id);

        $validatorArr['ticketfree_reason'] = new NotEqualsOrder($ticketFreeReasonDiff, $order);


        $validator = Validator::make($request->all(),
            $validatorArr,
            [
                'fio.required'        => trans('auth.userNameRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::user()->isRole('agent') &&
            $order->user->id !== Auth::user()->id)
            throw new AuthorizationException('Forbidden');

        $order->fio = $request->input('fio');
        $order->phone = $request->input('phone');
        $order->fio2 = $request->input('fio2');
        $order->phone2 = $request->input('phone2');
        $order->type = 'vl';
        $order->status_order = 'update';
        $order->airport_ukraine = $request->input('airport_ukraine');
        $order->terminal = $request->input('terminal');
		$order->datetime = $request->input('datetime');
        $order->registration = $request->input('registration');
        $order->flight = $request->input('flight');
        $order->address = $request->input('address');
		$order->address2 = $request->input('address2');
        $order->tickets = $request->input('tickets');
		$order->ticket_full = $request->input('ticket_full');
		$order->ticket_child = $request->input('ticket_child');
		$order->ticketfree_reason = $request->input('ticketfree_reason');
		$order->children = $request->input('children');
		$order->children_place = $request->input('children_place');
        $order->transfer = $request->input('transfer');
        $order->suburb = $request->input('suburb');
        $order->info = $request->input('info');
        $order->option_nameplate = $request->input('option_nameplate');
		$order->option_babyk = $request->input('option_babyk');
		$order->option_babyl = $request->input('option_babyl');
		$order->status_pay = $request->input('status_pay');
        //$order->user_id = auth()->user()->id;
        $order->save();

        return redirect('orders')->with('success', trans('ordersmanagement.updateSuccess'));
    }


    /**
     * Обновления данных заказа Прилета
     *
     * @param Request $request
     * @param $id
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function updateArrival(Request $request, $id)
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

        [$showCardGold, $showDiscountHalf] = $this->isShowBonuses();
        $ticketFreeReasonDiff = [];

        if (!$showCardGold) {
            $ticketFreeReasonDiff[] = 'cardgold';
        }
        if (!$showDiscountHalf) {
            $ticketFreeReasonDiff[] = 'discounthalf';
        }

        $validatorArr = [
            'fio'                  => 'required|max:255',
            'phone'                => 'required|max:32',
            'airport_ukraine'      => 'required|max:255',
            'datetime'             => 'required',
            //'registration'         => 'required',
            'address'              => 'required',
            'tickets'              => 'required',
            'transfer'              => 'required',

        ];

        $order = Order::findOrFail($id);

        $validatorArr['ticketfree_reason'] = new NotEqualsOrder($ticketFreeReasonDiff, $order);

        $validator = Validator::make($request->all(),
            $validatorArr,
            [
                'fio.required'        => trans('auth.userNameRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::user()->isRole('agent') &&
            $order->user->id !== Auth::user()->id)
            throw new AuthorizationException('Forbidden');

        $order->fio = $request->input('fio');
        $order->phone = $request->input('phone');
        $order->fio2 = $request->input('fio2');
        $order->phone2 = $request->input('phone2');
        $order->type = 'pr';
        $order->status_order = 'update';
        $order->airport_ukraine = $request->input('airport_ukraine');
        $order->airport_world = $request->input('airport_world');
        $order->terminal = $request->input('terminal');
        $order->datetime = $request->input('datetime');
        $order->registration = $request->input('registration');
        $order->flight = $request->input('flight');
        $order->address = $request->input('address');
		$order->address2 = $request->input('address2');
        $order->tickets = $request->input('tickets');
		$order->ticket_full = $request->input('ticket_full');
		$order->ticket_child = $request->input('ticket_child');
		$order->ticketfree_reason = $request->input('ticketfree_reason');
		$order->children = $request->input('children');
		$order->children_place = $request->input('children_place');
        $order->transfer = $request->input('transfer');
        $order->suburb = $request->input('suburb');
        $order->info = $request->input('info');
        $order->option_nameplate = $request->input('option_nameplate');
		$order->option_babyk = $request->input('option_babyk');
		$order->option_babyl = $request->input('option_babyl');
		$order->status_pay = $request->input('status_pay');
        //$order->user_id = auth()->user()->id;
        $order->save();


        return redirect('orders')->with('success', trans('ordersmanagement.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        if (Auth::user()->isRole(['user', 'agent']))
            throw new AuthorizationException('Forbidden');
        $order = Order::findOrFail($id);

        if ($order->id) {
            $order->delete();
            return redirect('orders')->with('success', trans('usersmanagement.deleteSuccess'));
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }

    /**
     * Method to search the orders.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('order_search_box');
        $searchRules = [
            'order_search_box' => 'required|string|max:255',
        ];
        $searchMessages = [
            'order_search_box.required' => 'Search term is required',
            'order_search_box.string'   => 'Search term has invalid characters',
            'order_search_box.max'      => 'Search term has too many characters - 255 allowed',
        ];

        $validator = Validator::make($request->all(), $searchRules, $searchMessages);

        if ($validator->fails()) {
            return response()->json([
                json_encode($validator),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $results = Order::where('id', 'like', $searchTerm.'%')
                            ->orWhere('fio', 'like', $searchTerm.'%')
                            ->orWhere('phone', 'like', $searchTerm.'%')->get();


        return response()->json([
            json_encode($results),
        ], Response::HTTP_OK);
    }

    /**
     * Удаленные заказы
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deletedList()
    {
        $orders = Order::withTrashed()->get();

        return view('ordersmanagement.show-deleted-orders', ['orders' => $orders]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function reservation($id)
    {
        if (Auth::user()->isRole(['user', 'agent']))
            throw new AuthorizationException('Forbidden');

        $order = Order::find($id);

        if($order->id){
            $order->status_order = 'reservation';
            $order->save();
        }else{
            return back()->with('error', trans('ordersmanagement.notFoundOrder'));
        }

        return redirect()->back()->with('success', trans('ordersmanagement.reservationSuccess'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function cancelOrder(Request $request, $id)
    {
        if (Auth::user()->isRole('user'))
            throw new AuthorizationException('Forbidden');

        $order = Order::find($id);

        if($order){
            $order->status_order = 'cancel';
            if ($request->cancel_info)
                $order->cancel_info = $request->cancel_info;
            $order->save();
        }else{
            return back()->with('error', trans('ordersmanagement.notFoundOrder'));
        }

        return redirect()->back()->with('success', trans('ordersmanagement.cancelSuccess'));
    }

    private function isShowBonuses(Order $order = null)
    {
        $currentMonth = date('m');

        $itemCardGold = Order::whereRaw('MONTH(ticketfree_reason_date) = ?', [$currentMonth])
            ->where('status_order', '!=', 'cancel')
            ->where('ticketfree_reason', 'cardgold')
            ->first('id');

        $itemDiscountHalf = Order::whereRaw('MONTH(ticketfree_reason_date) = ?', [$currentMonth])
            ->where('status_order', '!=', 'cancel')
            ->where('ticketfree_reason', 'discounthalf')
            ->first('id');

        $showCardGold = false;
        $showDiscountHalf = false;

        if ($itemCardGold) {
            if ($order && $itemCardGold->id == $order->id) {
                $showCardGold = true;
            }
        } else {
            $showCardGold = true;
        }

        if ($itemDiscountHalf) {
            if ($order && $itemDiscountHalf->id == $order->id) {
                $showDiscountHalf = true;
            }
        } else {
            $showDiscountHalf = true;
        }

        if ($order) {
            if ($order->ticketfree_reason == 'cardgold') {
                $showCardGold = true;
            }

            if ($order->ticketfree_reason == 'discounthalf') {
                $showDiscountHalf = true;
            }
        }

        
        return [
            $showCardGold,
            $showDiscountHalf
        ];
    }
}
