<?php

namespace App\Http\Controllers;

use App\Http\Requests\Costs\CostsCreateRequest;
use App\Http\Requests\Costs\CostsUpdateRequest;
use App\Models\Cost;
use App\Models\CategoryCost;
use App\Models\Car;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class CostsManagementController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();
		$categorycosts = categorycost::all();

        $costs = Cost::orderBy('id', 'asc')->get();

        return View('costsmanagement.show-costs', compact('costs', 'cars', 'categorycosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$cars = Car::all();
		$categorycosts = CategoryCost::all();
        //return view('costsmanagement.add-cost');
		return view('costsmanagement.add-cost', [
          'cost'    => null,
		  'cars' => Car::all(),
		  'categorycosts' => CategoryCost::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::only('car_id', 'category_consumption', 'purchase_cost', 'count', 'work_price', 'mileage', 'consumption_title', 'notes');

        $validator = Validator::make($input, Cost::rules());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $cost = Cost::create([
			'car_id'         				=> $request->input('car_id'),
            //'side_number'          			=> $request->input('side_number'),
            'category_consumption'          => $request->input('category_consumption'),
			//'subcategory_consumption'       => $request->input('subcategory_consumption'),
			'purchase_cost'          		=> $request->input('purchase_cost'),
			'count'          				=> $request->input('count'),
			'work_price'          			=> $request->input('work_price'),
			'mileage'          				=> $request->input('mileage'),
			//'consumption_title'          	=> $request->input('consumption_title'),
            'notes'         				=> $request->input('notes'),
            //'status'        				=> $request->input('status'),
            'taggable_id'   				=> 0,
            'taggable_type' 				=> 'cost',
        ]);

        $cost->taggable_id = $cost->id;
        $cost->save();

        //return redirect('costs/'.$cost->id)->with('success', trans('costs.createSuccess'));
		return redirect('costs')->with('success', trans('costs.createSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cost = Cost::find($id);
        $cars = Car::all();
        $costUsers = [];

        foreach ($cars as $car) {
            if ($car && $car->cost_id === $cost->id) {
                $costUsers[] = $user;
            }
        }

        $data = [
            'cost'      => $cost,
            'costUsers' => $costUsers,
        ];

        return view('costsmanagement.show-cost')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cost = Cost::find($id);
		$categorycosts = CategoryCost::all();
		$cars = Car::all();
        $users = User::all();
        $costUsers = [];

        foreach ($users as $user) {
            if ($user->profile && $user->profile->cost_id === $cost->id) {
                $costUsers[] = $user;
            }
        }

        $data = [
            'cost'      		 => $cost,
			'cars'      		 => $cars,
			'categorycosts'      => $categorycosts,
            'costUsers' 		 => $costUsers,
        ];

        return view('costsmanagement.edit-cost')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cost = Cost::find($id);

		$input = Input::only('car_id', 'category_consumption', 'purchase_cost', 'count', 'work_price', 'mileage', 'consumption_title', 'notes');

        $validator = Validator::make($input, Cost::rules($id));

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $cost->fill($input)->save();

        return redirect('costs/'.$cost->id)->with('success', trans('costs.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $default = Cost::findOrFail(1);
        $cost = Cost::findOrFail($id);

        if ($cost->id != $default->id) {
            $cost->delete();

            return redirect('costs')->with('success', trans('costs.deleteSuccess'));
        }

        return back()->with('error', trans('costs.deleteSelfError'));
    }
}
