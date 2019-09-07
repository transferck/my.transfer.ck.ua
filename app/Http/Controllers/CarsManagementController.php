<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cars\CarsCreateRequest;
use App\Http\Requests\Cars\CarsUpdateRequest;
use App\Models\Car;

class CarsManagementController extends Controller
{
    public function index()
    {
        $cars = Car::all();

        return view('cars-management.index', compact('cars'));
    }

    public function show(Car $car)
    {
        return view('cars-management.show', compact('car'));
    }

    public function edit(Car $car)
    {
        return view('cars-management.update', compact('car'));
    }

    public function update(Car $car, CarsUpdateRequest $request)
    {
        $car->update($request->validated());

        return redirect()->route('cars.index')
            ->with('message', 'Car updated successful');
    }

    public function create()
    {
        return view('cars-management');
    }

    public function store(CarsCreateRequest $request)
    {
        Car::create($request->validated());

        return redirect()->route('cars.index')
            ->with('message', 'Car created successful');
    }

    public function destroy(Car $car)
    {
        if (!$car) {
            return redirect()->back()
                ->with('message', 'Car not found');
        }

        $deleted = $car->delete();

        if (!$deleted) {
            return redirect()->back()
                ->with('message', 'Errors with car deletion');
        }

        return redirect()->route('cars.index')
            ->with('message', 'Car is deleted successful');
    }
}
