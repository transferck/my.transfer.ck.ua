<?php

namespace App\Http\Controllers;

use App\Http\Requests\Costs\CostsCreateRequest;
use App\Http\Requests\Costs\CostsUpdateRequest;
use App\Models\Cost;

class CostsManagementController extends Controller
{
    public function index()
    {
        $costs = Cost::all();

        return view('costs-management.index', compact('costs'));
    }

    public function show(Cost $cost)
    {
        return view('costs-management.show', compact('cost'));
    }

    public function edit(Cost $cost)
    {
        return view('costs-management.update', compact('cost'));
    }

    public function update(Cost $cost, CostsUpdateRequest $request)
    {
        $cost->update($request->validated());

        return redirect()->route('costs.index')
            ->with('message', 'Cost updated successful');
    }

    public function create()
    {
        return view('costs-management');
    }

    public function store(CostsCreateRequest $request)
    {
        Cost::create($request->validated());

        return redirect()->route('costs.index')
            ->with('message', 'Cost created successful');
    }

    public function destroy(Cost $cost)
    {
        if (!$cost) {
            return redirect()->back()
                ->with('message', 'Cost not found');
        }

        $deleted = $cost->delete();

        if (!$deleted) {
            return redirect()->back()
                ->with('message', 'Errors with cost deletion');
        }

        return redirect()->route('costs.index')
            ->with('message', 'Cost is deleted successful');
    }
}
