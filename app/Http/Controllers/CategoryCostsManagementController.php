<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\CategoryCost;
use App\Models\Car;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class CategoryCostsManagementController extends Controller
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

        $categorycosts = CategoryCost::orderBy('id', 'asc')->get();

        return View('categorycostsmanagement.show-categorycosts', compact('categorycosts', 'cars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$cars = Car::all();
		
		return view('categorycostsmanagement.add-categorycost', [
          'categorycost'    => null,
		  'cars' => Car::all()
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
        $input = Input::only('name', 'img', 'position');

        $validator = Validator::make($input, CategoryCost::rules());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $categorycost = CategoryCost::create([
			'name'         		=> $request->input('name'),
			'img'         		=> $request->input('img'),
            'position'          => $request->input('position'),
        ]);

        $categorycost->save();

        return redirect('categorycosts/'.$categorycost->id)->with('success', trans('categorycosts.createSuccess'));
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
        $categorycost = CategoryCost::find($id);
        $costs = Cost::all();
        $categorycostCosts = [];

        foreach ($costs as $cost) {
            if ($cost && $cost->categorycost_id === $cost->id) {
                $categorycostCosts[] = $cost;
            }
        }

        $data = [
            'categorycost'      => $categorycost,
            'categorycostCosts' => $categorycostCosts,
        ];

        return view('categorycostsmanagement.show-categorycost')->with($data);
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
        $categorycost = CategoryCost::find($id);

        $data = [
            'categorycost'      => $categorycost,
        ];

        return view('categorycostsmanagement.edit-categorycost')->with($data);
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
        $categorycost = CategoryCost::find($id);

       $input = Input::only('name', 'img', 'position');

        $validator = Validator::make($input, CategoryCost::rules($id));

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $categorycost->fill($input)->save();

        return redirect('categorycosts/'.$categorycost->id)->with('success', trans('categorycosts.updateSuccess'));
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
        $default = CategoryCost::findOrFail(1);
        $categorycost = CategoryCost::findOrFail($id);

        if ($categorycost->id != $default->id) {
            $categorycost->delete();

            return redirect('categorycosts')->with('success', trans('categorycosts.deleteSuccess'));
        }

        return back()->with('error', trans('categorycosts.deleteSelfError'));
    }
}
