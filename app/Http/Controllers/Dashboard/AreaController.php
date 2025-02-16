<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AreaRequest;
use App\Models\Admin;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::get();

        return view('dashboard.areas.index' , compact('areas'));
    }


    public function create()
    {
        return view('dashboard.areas.create');
    }

    public function store(AreaRequest $request)
    {
        $areaData = $request->validated();
        Area::create($areaData);
        return to_route('dashboard.areas.index')->with(['success'=>__('added_successfully')]);
    }

    public function edit(Area $area)
    {
        return view('dashboard.areas.edit' , compact('area'));
    }


    public function update(AreaRequest $request, Area $area)
    {
        $areaData = $request->validated();
        $area->update($areaData);

        return to_route('dashboard.areas.index')->with(['success'=>__('updated_successfully')]);
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return to_route('dashboard.areas.index')->with(['success'=>__('deleted_successfully')]);
    }

}
