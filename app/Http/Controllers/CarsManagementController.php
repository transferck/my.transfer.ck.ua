<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cars\CarsCreateRequest;
use App\Http\Requests\Cars\CarsUpdateRequest;
use App\Models\Car;
use App\Models\User;
use App\Models\Cost;
use App\Models\CategoryCost;
use App\Traits\UploadTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Validator;

class CarsManagementController extends Controller
{
    use UploadTrait;
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
        $cars = Car::all();

        $cars = $cars->sortBy(function ($car) {
            return $car->getAllCostsSum();
        });

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
        $input = Input::only('manufacturer', 'registration_number', 'side_number', 'purchase_date', 'purchase_price', 'mileage', 'release_date', 'condition', 'color', 'img', 'notes', 'car_status', 'status');

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
			'purchase_price'        => $request->input('purchase_price'),
			'mileage'               => $request->input('mileage'),
			'release_date'          => $request->input('release_date'),
			'condition'             => $request->input('condition'),
			'img'                 	=> $request->input('img'),			
			'color'                 => $request->input('color'),
			'notes'                 => $request->input('notes'),
            'car_status'            => $request->input('car_status'),
            'status'             	=> $request->input('status'),
            'taggable_id'   		=> 0,
            'taggable_type' 		=> 'car',
        ]);

        if ($image = $request->file('image')) {
            $name = Str::slug($request->input('side_number')) . $request->input('registration_number') . '_' . time();
            $folder = 'images/cars/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();

            $this->uploadOne($image, $folder, 'public', $name);

            if ($car->image) {
                unlink($car->image);
            }

            $car->image = 'storage/' . $filePath;
        }

        $car->taggable_id = $car->id;
        $car->save();

        return redirect('cars/'.$car->registration_number)->with('success', trans('cars.createSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($registration_number)
    {
        $car = Car::where(['registration_number' => $registration_number])->first();
        $categorycosts = CategoryCost::getInGroups();

        $carCosts = Cost::query()
            ->where('car_id', $car->id)
            ->get();

        return view('carsmanagement.show-car', compact('car', 'categorycosts', 'carCosts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($registration_number)
    {
        $car = Car::where(['registration_number' => $registration_number])->first();
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
    public function update(Request $request, $registration_number)
    {
        $car = Car::where(['registration_number' => $registration_number])->first();

        $input = Input::only('manufacturer', 'registration_number', 'side_number', 'purchase_date', 'purchase_price', 'mileage', 'release_date', 'condition', 'color', 'img', 'notes', 'car_status', 'status');

        $validator = Validator::make($input, Car::rules($car->id));

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($image = $request->file('image')) {
            $name = Str::slug($request->input('side_number')) . $request->input('registration_number') . '_' . time();
            $folder = 'images/cars/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();

            $this->uploadOne($image, $folder, 'public', $name);

            if ($car->image) {
                unlink($car->image);
            }

            $car->image = 'storage/' . $filePath;
        }

        $car->fill($input)->save();

        return redirect('cars/'.$car->registration_number)->with('success', trans('cars.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($registration_number)
    {
        $default = Car::findOrFail(1);
        $car = Car::where(['registration_number' => $registration_number])->first();

        if ($car->id != $default->id) {
            $car->delete();

            return redirect('cars')->with('success', trans('cars.deleteSuccess'));
        }

        return back()->with('error', trans('cars.deleteSelfError'));
    }

    public function costsByCategory($registration_number, $costcategoryId)
    {
        $car = Car::where(['registration_number' => $registration_number])->first();

        if (!$car) {
            throw new \Exception('Car not found');
        }

        $costs = Cost::query()
            ->where('category_consumption', $costcategoryId)
            ->where('car_id', $car->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('carsmanagement.costs-by-category', compact('costs', 'car'));
    }
}
