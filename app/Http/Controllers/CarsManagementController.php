<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cars\CarsCreateRequest;
use App\Http\Requests\Cars\CarsUpdateRequest;
use App\Models\Car;
use App\Models\User;
use App\Models\Cost;
use App\Models\CategoryCost;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class CarsManagementController extends Controller
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
        $costs = Cost::all();

        $cars = Car::orderBy('side_number', 'asc')->get();

        return View('carsmanagement.show-cars', compact('cars', 'costs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('carsmanagement.add-car');
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
        $input = Input::only('manufacturer', 'registration_number', 'side_number', 'purchase_date', 'mileage', 'release_date', 'condition', 'color', 'notes', 'status');

        $validator = Validator::make($input, Car::rules());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $car = Car::create([
            'manufacturer'          => $request->input('manufacturer'),
            //'model'         		=> $request->input('model'),			
            'registration_number'   => $request->input('registration_number'),
            'side_number'           => $request->input('side_number'),
			'purchase_date'         => $request->input('purchase_date'),
			'mileage'               => $request->input('mileage'),
			'release_date'          => $request->input('release_date'),
			'condition'             => $request->input('condition'),
			'color'                 => $request->input('color'),
			'notes'                 => $request->input('notes'),
            'status'             	=> $request->input('status'),
            'taggable_id'   		=> 0,
            'taggable_type' 		=> 'car',
        ]);

        $car->taggable_id = $car->id;
        $car->save();

        return redirect('cars/'.$car->id)->with('success', trans('cars.createSuccess'));
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
        $car = Car::find($id);
        $categorycosts = CategoryCost::orderBy('position', 'asc')->get();				
		//$categorycosts = CategoryCost::all();
        $cars = Car::all();		
        $costs = Cost::all();
        $carCosts = [];

        foreach ($costs as $cost) {
            if ($cost && $cost->car_id === $car->id) {
                $carCosts[] = $cost;
            }
        }

        $data = [
            'car'       	=> $car,
            'carCosts'  	=> $carCosts,
			'costs'  		=> $costs,
			'categorycosts' => $categorycosts,
			//'costs' 		=> Cost::all(),
			//'categorycosts' => CategoryCost::all()
        ];

        return view('carsmanagement.show-car')->with($data);
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
        $car = Car::find($id);
        $users = User::all();
        $themeUsers = [];

        foreach ($users as $user) {
            if ($user->profile && $user->profile->theme_id === $car->id) {
                $themeUsers[] = $user;
            }
        }

        $data = [
            'car'      => $car,
            'themeUsers' => $themeUsers,
        ];

        return view('carsmanagement.edit-car')->with($data);
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
        $car = Car::find($id);

        $input = Input::only('manufacturer', 'registration_number', 'side_number', 'purchase_date', 'mileage', 'release_date', 'condition', 'color', 'notes', 'status');

        $validator = Validator::make($input, Car::rules($id));

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $car->fill($input)->save();

        return redirect('cars/'.$car->id)->with('success', trans('cars.updateSuccess'));
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
        $default = Car::findOrFail(1);
        $car = Car::findOrFail($id);

        if ($car->id != $default->id) {
            $car->delete();

            return redirect('cars')->with('success', trans('cars.deleteSuccess'));
        }

        return back()->with('error', trans('cars.deleteSelfError'));
    }
}
