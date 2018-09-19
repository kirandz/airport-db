<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $regions = Province::selectRaw('provinces.id as province_id, provinces.name as province_name, c.id as city_id, c.name as city_name')
            ->join('cities as c', 'c.province_id', '=', 'provinces.id')->get();
        $provinces = Province::all();

        return view('manage.regions', compact('regions', 'provinces'));
    }

    public function add(Request $request)
    {
        if($request->province_type == 'new'){
            $validator = Validator::make($request->all(), [
                'province_type' => 'required',
                'province' => 'required',
                'city' => 'required'
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'province_type' => 'required',
                'province_' => 'required',
                'city' => 'required'
            ]);
        }

        if ($validator->passes()) {
            if($request->province_type == 'new'){
                $province = New Province();
                $province->name = strtoupper($request->province);
                $province->save();

                $temp = Province::where('name', $request->province)->first();

                $city = New City();
                $city->province_id = $temp->id;
                $city->name = strtoupper($request->city);
                $city->save();
            }
            else{
                $city = New City();
                $city->province_id = $request->province_;
                $city->name = strtoupper($request->city);
                $city->save();
            }

            return response()->json(['success'=>'Region has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function update(Request $request)
    {
        $city = City::find($request->id);
        $city->name = $request->city;
        $city->save();

        return response()->json(['success'=>'Region has been updated.']);
    }

    public function delete(Request $request)
    {
        $city = City::find($request->id);

        $city->delete();

        return response()->json(['success'=>'Region has been deleted.']);
    }
}
