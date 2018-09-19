<?php

namespace App\Http\Controllers;

use App\AircraftType;
use App\Airport;
use App\Obstacle;
use App\ObstacleDetail;
use App\RunwayDimension;
use App\RunwayDimensionDetail;
use App\RunwayStrength;
use App\RunwayStrengthDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Excel;

class ADLController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $airport = Airport::find($id);
        $runway_dimensions = RunwayDimension::where('airport_id', $id)->get();
        $obstacles = Obstacle::where('airport_id', $airport->id)->get();
        $runway_dimension_details = RunwayDimensionDetail::all();
        $obstacle_details = ObstacleDetail::all();
        $aircraft_types = AircraftType::all();
        $runway_strengths = RunwayStrength::where('airport_id', $id)->get();
        $runway_strength_details = RunwayStrengthDetail::all();

        return view('airport.domestic.adl', compact(
            'airport', 'obstacles', 'runway_dimension_details', 'obstacle_details', 'aircraft_types', 'runway_dimensions',
            'runway_strengths', 'runway_strength_details'
        ));
    }

    public function addadlrws(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'runway_code' => 'required',
        ]);

        if ($validator->passes()) {
            $rws = new RunwayStrength();
            $rws->airport_id = $request->airport_id;
            $rws->runway_code = $request->runway_code;
            $rws->save();

            return response()->json(['success' => 'Runway Strength has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function updateadlrws(Request $request)
    {
        RunwayStrength::where('id', $request->rs_id)->update([
            'runway_code' => $request->code
        ]);

        return response()->json();
    }

    public function deleteadlrws(Request $request)
    {
        $rws = RunwayStrength::find($request->id);
        $rws->delete();

        return ['success' => 'Runway Strength has been deleted'];
    }

    public function updateadlrwsdetail(Request $request)
    {
        $array_rws_detail_id = $request->array_rws_detail_id;
        $array_actype_id = $request->array_actype_id;
        $array_strength = $request->array_strength;
        $array_note = $request->array_note;

        for($i = 0 ; $i < count($array_rws_detail_id) ; $i++){
            if(isset($array_rws_detail_id[$i])){
                RunwayStrengthDetail::where('id', $array_rws_detail_id[$i])->update([
                    'rs_id' => $request->rs_id,
                    'aircraft_id' => $array_actype_id[$i],
                    'strength' => $array_strength[$i],
                    'note' => $array_note[$i],
                ]);
            }
            else{
                $rws_detail = new RunwayStrengthDetail();
                $rws_detail->rs_id = $request->rs_id;
                $rws_detail->aircraft_id = $array_actype_id[$i];
                $rws_detail->strength = $array_strength[$i];
                $rws_detail->note = $array_note[$i];
                $rws_detail->save();
            }
        }

        return ['success' => 'Runway Strength has been updated'];
    }

    public function download($id)
    {
        $data_strength = RunwayStrength::selectRaw('runway_code as Runway_Code, aty.type as Aircraft_Type, strength as Strength, note as Note')
            ->join('runway_strength_details as rsd', 'rsd.rs_id', '=', 'runway_strengths.id')
            ->join('airports as a', 'a.id', '=', 'runway_strengths.airport_id')
            ->join('aircraft_types as aty', 'aty.id', '=', 'rsd.aircraft_id')
            ->where('airport_id', $id)
            ->get();

        $data_adl = RunwayDimension::selectRaw('
                designator as Runway_Designator,
                IF(SUBSTR(tora, -1) = "m", SUBSTR(tora, 1, LENGTH(tora)-2), tora) as TORA_FULL,
                IF(
                    IF(
                        SUBSTR(stopway_dimens, -1) = "m", 
                        SUBSTR(stopway_dimens, 1, LENGTH(stopway_dimens)-2), 
                        stopway_dimens
                    )
                    +
                    IF(
                        SUBSTR(resa, -1) = "m", 
                        SUBSTR(resa, 1, LENGTH(resa)-2), 
                        resa
                    )
                    >= 90,
                    IF(
                        SUBSTR(tora, -1) = "m", 
                        SUBSTR(tora, 1, LENGTH(tora)-2), 
                        tora
                    )
                    ,
                    IF(
                        SUBSTR(tora, -1) = "m", 
                        SUBSTR(tora, 1, LENGTH(tora)-2), 
                        tora
                    )-90
                ) as TORA_RESA, 
                stopway_dimens as Stopway, clearway as Clearway, resa as RESA, IFNULL(height, "") as Height,
                IFNULL(IF(SUBSTR(dist_from_rwy, -1) = "m", SUBSTR(dist_from_rwy, 1, LENGTH(dist_from_rwy)-2), dist_from_rwy), "") as Distance_FULL,
                IF(
                    IF(
                        SUBSTR(stopway_dimens, -1) = "m", 
                        SUBSTR(stopway_dimens, 1, LENGTH(stopway_dimens)-2), 
                        stopway_dimens
                    )
                    +
                    IF(
                        SUBSTR(resa, -1) = "m", 
                        SUBSTR(resa, 1, LENGTH(resa)-2), 
                        resa
                    )
                    >= 90, 
                    IF(
                        SUBSTR(dist_from_rwy, -1) = "m", 
                        SUBSTR(dist_from_rwy, 1, LENGTH(dist_from_rwy)-2), 
                        dist_from_rwy
                    )
                    ,
                    IF(
                        SUBSTR(dist_from_rwy, -1) = "m", 
                        SUBSTR(dist_from_rwy, 1, LENGTH(dist_from_rwy)-2), 
                        dist_from_rwy
                    )-90
                ) as Distance_RESA')
            ->join('runway_dimension_details as r', 'r.rd_id', '=', 'runway_dimensions.id')
            ->leftJoin('obstacles as o', 'o.to_runway', '=', 'r.designator')
            ->leftJoin('obstacle_details as od', 'od.obstacle_id', '=', 'o.id')
            ->where('runway_dimensions.airport_id', $id)
            ->orderBy('Designator')
            ->get();

        $airport = Airport::find($id);
        $file_name = $airport->iata_code.'_'.$airport->icao_code.'_'.$airport->name;

        return Excel::create($file_name.' (ADL)', function($excel) use ($data_strength, $data_adl) {
            $excel->sheet('The Worst Strength', function($sheet) use ($data_strength)
            {
                $sheet->fromArray($data_strength, null, 'A1', true);
            });

            $excel->sheet('Airport Data Limitation', function($sheet) use ($data_adl)
            {
                $sheet->fromArray($data_adl, null, 'A1', true);
            });

        })->download('xlsx');
    }
}
