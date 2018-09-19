<?php

namespace App\Http\Controllers;

use App\Airport;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $airports = Airport::all();

        return view('manage.files', compact('airports'));
    }

//    Aerodrome
    public function uploadaerodrome(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        if ($request->file('aerodrome') != null)
        {
            if(!is_null($airport->aerodrome)){
                unlink('files/aerodrome/' . $airport->aerodrome);
            }

            $file = $request->file('aerodrome');
            $file->move(public_path('/files/aerodrome'), $file->getClientOriginalName());
            $airport->aerodrome = $file->getClientOriginalName();
            $airport->save();
        }

        return redirect()->back();
    }

    public function uploadchart($id, Request $request){
        $airport = Airport::find($id);
        if ($request->file('chart') != null)
        {
            if(!is_null($airport->chart)){
                unlink('files/chart/' . $airport->chart);
            }

            $file = $request->file('chart');
            $file->move(public_path('/files/chart'), $file->getClientOriginalName());
            $airport->chart = $file->getClientOriginalName();
            $airport->save();
        }

        return redirect()->back()->with('message', 'Upload success.');
    }

    public function uploadarpi($id, Request $request){
        $airport = Airport::find($id);
        if ($request->file('arpi') != null)
        {
            if(!is_null($airport->arpi)){
                unlink('files/arpi/' . $airport->arpi);
            }

            $file = $request->file('arpi');
            $file->move(public_path('/files/arpi'), $file->getClientOriginalName());
            $airport->arpi = $file->getClientOriginalName();
            $airport->save();
        }

        return redirect()->back()->with('message', 'Upload success.');
    }

    public function uploadarmi($id, Request $request){
        $airport = Airport::find($id);
        if ($request->file('armi') != null)
        {
            if(!is_null($airport->armi)){
                unlink('files/armi/' . $airport->armi);
            }

            $file = $request->file('armi');
            $file->move(public_path('/files/armi'), $file->getClientOriginalName());
            $airport->armi = $file->getClientOriginalName();
            $airport->save();
        }

        return redirect()->back()->with('message', 'Upload success.');
    }

    public function uploadberita($id, Request $request){
        $airport = Airport::find($id);
        if ($request->file('berita_acara') != null)
        {
            if(!is_null($airport->berita_acara)){
                unlink('files/beritaacara/' . $airport->berita_acara);
            }

            $file = $request->file('berita_acara');
            $file->move(public_path('/files/beritaacara'), $file->getClientOriginalName());
            $airport->berita_acara = $file->getClientOriginalName();
            $airport->save();
        }

        return redirect()->back()->with('message', 'Upload success.');
    }
}
