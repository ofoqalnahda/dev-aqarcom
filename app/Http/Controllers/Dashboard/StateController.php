<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StateRequest;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $states = State::get();
        return view('dashboard.states.index' , compact('states'));
    }


    public function create()
    {
        return view('dashboard.states.create');
    }

    public function store(StateRequest $request)
    {
        $stateData = $request->validated();
        $stateData['real_lng'] = $request->lng;
        $stateData['real_lat'] = $request->lat;
        State::create($stateData);
        return to_route('dashboard.states.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(State $state)
    {
        return view('dashboard.states.edit' , compact('state'));
    }

    public function updateLocationForm(State $state)
    {
        return view('dashboard.states.updateLocation' , compact('state'));
    }


    public function updateLocation(Request $request , State $state)
    {
        $newData = $request->validate([
            'real_lat' => 'required',
            'real_lng' => 'required'
        ]);

        $state->update($newData);

        return to_route('dashboard.states.index')->with(['success'=>__('updated_successfully')]);
    }


    public function update(StateRequest $request, State $state)
    {
        $stateData = $request->validated();
        $state->update($stateData);

        return to_route('dashboard.states.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(State $state)
    {
        $state->delete();
        return to_route('dashboard.states.index')->with(['success'=>__('deleted_successfully')]);
    }
}
