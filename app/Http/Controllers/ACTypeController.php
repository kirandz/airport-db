<?php

namespace App\Http\Controllers;

use App\ACType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ACTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ac_types = ACType::all();

        return view('manage.actypes', compact('ac_types'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);


        if ($validator->passes()) {
            $ac_type = New ACType();

            $ac_type->type = $request->type;
            $ac_type->save();

            return response()->json(['success'=>'Aircraft Type has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function update(Request $request)
    {
        $ac_type = ACType::find($request->id);

        $ac_type->type = $request->type;
        $ac_type->save();

        return response()->json(['success'=>'Aircraft Type has been updated.']);
    }

    public function delete(Request $request)
    {
        $ac_type = ACType::find($request->id);

        $ac_type->delete();

        return response()->json(['success'=>'Aircraft Type has been deleted.']);
    }
}
