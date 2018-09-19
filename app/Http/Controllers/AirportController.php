<?php

namespace App\Http\Controllers;

use App\AircraftType;
use App\Airport;
use App\Apron;
use App\ApronCapacity;
use App\City;
use App\NavFacility;
use App\Obstacle;
use App\ObstacleDetail;
use App\Province;
use App\RunwayDimension;
use App\RunwayDimensionDetail;
use App\Taxiway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

//    Domestic
    public function domestic()
    {
        $airports = Airport::all();
        $provinces = Province::orderBy('name')->get();

        return view('airport.domestic.index', compact('airports', 'provinces'));
    }

    public function findcity(Request $request)
    {
        $data = City::select('name')->where('province_id', $request->province_id)->orderBy('name')->get();

        return response()->json($data);
    }

    public function addairport(Request $request)
    {
        $province = Province::find($request->province);

        $validator = Validator::make($request->all(), [
            'airport_name' => 'required',
            'iata_code' => 'required',
            'icao_code' => 'required',
            'effective_date' => 'required',
            'province' => 'required',
            'city' => 'required',
            'type' => 'required',
        ]);


        if ($validator->passes()) {
            $airport = new Airport();
            $airport->name = $request->airport_name;
            $airport->icao_code = $request->icao_code;
            $airport->iata_code = $request->iata_code;
            $airport->effective_date = $request->effective_date;
            $airport->city = $request->city;
            $airport->province = $province->name;
            $airport->type = $request->type;
            $airport->save();

            return response()->json(['success' => 'Airport has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function deleteairport(Request $request)
    {
        $airport = Airport::find($request->id);

        $airport->delete();

        return ['success' => 'Airport has been deleted.'];
    }

//    General Data
    public function generaldata($id)
    {
        $airport = Airport::find($id);
        $runway_dimensions = RunwayDimension::where('airport_id', $id)->get();
        $aircraft_types = AircraftType::all();
        $apron_capacities = ApronCapacity::where('airport_id', $id)->get();

        $total_taxiway = count(Taxiway::where('airport_id', $id)->get());
        $total_apron = count(Apron::where('airport_id', $id)->get());
        $total_ap_capacity = ApronCapacity::where('airport_id', $id)->get()->sum('total_aircraft');

        return view('airport.domestic.generaldata', compact(
            'airport', 'total_taxiway', 'total_apron', 'apron_capacities', 'total_ap_capacity', 'aircraft_types', 'runway_dimensions'
            )
        );
    }

    public function updategeneraldata(Request $request){
        $airport = Airport::find($request->id);
        $airport->name = $request->name;
        $airport->icao_code = $request->icao_code;
        $airport->iata_code = $request->iata_code;
        $airport->city = $request->city;
        $airport->province = $request->province;
        $airport->effective_date = $request->effective_date;
        $airport->operation_time_start = $request->operation_time_start;
        $airport->operation_time_end = $request->operation_time_end;
        $airport->ground_handling_fac = $request->ground_handling_fac;
        $airport->refuel_fac = $request->refuel_fac;
        $airport->utc_zone = $request->utc_zone;
        $airport->owner = $request->owner;
        $airport->parimeter = $request->parimeter;
        $airport->remarks = $request->remarks;
        $airport->save();

        return ['success' => 'General Data has been updated.'];
    }

    public function addrwd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dimension' => 'required',
        ]);


        if ($validator->passes()) {
            $runway_dimension = New RunwayDimension();

            $runway_dimension->airport_id = $request->airport_id;
            $runway_dimension->dimension = $request->dimension;
            $runway_dimension->save();

            return response()->json(['success'=>'Runway Dimension has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function updaterwd(Request $request)
    {
        $array_rwd_id = $request->array_rwd_id;
        $array_rwd_dimension = $request->array_rwd_dimension;

        for($i = 0 ; $i < count($array_rwd_id) ; $i++){
            RunwayDimension::where('id', $array_rwd_id[$i])->update([
                'dimension' => $array_rwd_dimension[$i],
            ]);
        }

        return response()->json();
    }

    public function deleterwd(Request $request)
    {
        $runway_dimension = RunwayDimension::find($request->id);

        $runway_dimension->delete();

        return ['success' => 'Runway Dimension has been deleted.'];
    }

    public function updatetotalat(Request $request)
    {
        $array_at_id = $request->array_at_id;
        $array_at_total = $request->array_at_total;

        for($i = 0 ; $i < count($array_at_id) ; $i++){
            $check = ApronCapacity::where('airport_id', $request->airport_id)->where('at_id', $array_at_id[$i])->get();

            if(count($check) > 0){
                ApronCapacity::where('airport_id', $request->airport_id)->where('at_id', $array_at_id[$i])->update([
                    'total_aircraft' => $array_at_total[$i]
                ]);
            }
            else{
                $apron_capacity = new ApronCapacity();
                $apron_capacity->airport_id = $request->airport_id;
                $apron_capacity->at_id = $array_at_id[$i];
                $apron_capacity->total_aircraft = $array_at_total[$i];
                $apron_capacity->save();
            }
        }

        return response()->json();
    }

    public function printairportdata($id)
    {
        $airport = Airport::find($id);
        $runway_dimensions = RunwayDimension::where('airport_id', $id)->get();
        $taxiways = Taxiway::where('airport_id', $airport->id)->get();
        $aprons = Apron::where('airport_id', $airport->id)->get();
        $nav_facilities = NavFacility::where('airport_id', $airport->id)->get();
        $obstacles = Obstacle::where('airport_id', $airport->id)->get();
        $obstacle_details = ObstacleDetail::all();

        $runway_id = [];
        foreach ($runway_dimensions as $runway_dimension) {
            array_push($runway_id, $runway_dimension->id);
        }
        $runway_dimension_details = RunwayDimensionDetail::whereIn('rd_id', $runway_id)->get();

        return view('airport.domestic.dataprint', compact(
                'airport', 'taxiways', 'aprons', 'nav_facilities', 'obstacles', 'runway_dimension_details',
                'obstacle_details', 'runway_dimensions'
            )
        );
    }

//    Detail Data
    public function detaildata($id)
    {
        $airport = Airport::find($id);
        $runway_dimensions = RunwayDimension::where('airport_id', $id)->get();
        $taxiways = Taxiway::where('airport_id', $airport->id)->get();
        $aprons = Apron::where('airport_id', $airport->id)->get();
        $nav_facilities = NavFacility::where('airport_id', $airport->id)->get();
        $obstacles = Obstacle::where('airport_id', $airport->id)->get();
        $obstacle_details = ObstacleDetail::all();

        $runway_id = [];
        foreach ($runway_dimensions as $runway_dimension) {
            array_push($runway_id, $runway_dimension->id);
        }
        $runway_dimension_details = RunwayDimensionDetail::whereIn('rd_id', $runway_id)->get();

        return view('airport.domestic.detaildata', compact(
                'airport', 'taxiways', 'aprons', 'nav_facilities', 'obstacles', 'runway_dimension_details',
                'obstacle_details', 'runway_dimensions'
            )
        );
    }

    public function updatedetailairport(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->name = $request->name;
        $airport->effective_date = $request->effective_date;
        $airport->save();

        return ['success' => 'Airport Data has been updated.'];
    }

    public function updatedetailaerodrome(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->icao_code = $request->icao_code;
        $airport->iata_code = $request->iata_code;
        $airport->rp_latitude = $request->latitude;
        $airport->rp_longitude = $request->longitude;
        $airport->elevation = $request->elevation;
        $airport->ats = $request->ats;
        $airport->aerodrome_temp = $request->temp;
        $airport->airport_area = $request->area;
        $airport->pkpkk_categories = $request->pkpkk;
        $airport->magnetic_var = $request->mag_var;
        $airport->save();

        return ['success' => 'Aerodrome Data has been updated.'];
    }

    public function adddetailrwddetail(Request $request)
    {
        $rwd_detail = new RunwayDimensionDetail();
        $rwd_detail->rd_id = $request->rd_id;
        $rwd_detail->designator = $request->designator;
        $rwd_detail->heading = $request->heading;
        $rwd_detail->entry_pad = $request->entrypad;
        $rwd_detail->turning_area = $request->tarea;
        $rwd_detail->slope = $request->slope;
        $rwd_detail->threshold_elev = $request->telev;
        $rwd_detail->threshold_latlong = $request->tlatlong;
        $rwd_detail->tora = $request->tora;
        $rwd_detail->toda = $request->toda;
        $rwd_detail->stopway_dimens = $request->stop_dimens;
        $rwd_detail->stopway_slope = $request->stop_slope;
        $rwd_detail->resa = $request->resa;
        $rwd_detail->clearway = $request->clearway;
        $rwd_detail->surface = $request->surface;
        $rwd_detail->strength = $request->strength;
        $rwd_detail->asda = $request->asda;
        $rwd_detail->lda = $request->lda;
        $rwd_detail->save();

        return ['success' => 'Runway Designator has been added.'];
    }

    public function updatedetailrwd(Request $request)
    {
        $rwd = RunwayDimension::find($request->id);

        $rwd->dimension = $request->dimension;
        $rwd->save();

        return ['success' => 'Runway Dimension has been updated.'];
    }

    public function updatedetailrwddetail(Request $request)
    {
        $rwd_detail = RunwayDimensionDetail::find($request->id);

        $rwd_detail->designator = $request->designator;
        $rwd_detail->heading = $request->heading;
        $rwd_detail->entry_pad = $request->entrypad;
        $rwd_detail->turning_area = $request->tarea;
        $rwd_detail->slope = $request->slope;
        $rwd_detail->threshold_elev = $request->telev;
        $rwd_detail->threshold_latlong = $request->tlatlong;
        $rwd_detail->tora = $request->tora;
        $rwd_detail->toda = $request->toda;
        $rwd_detail->stopway_dimens = $request->stop_dimens;
        $rwd_detail->stopway_slope = $request->stop_slope;
        $rwd_detail->resa = $request->resa;
        $rwd_detail->clearway = $request->clearway;
        $rwd_detail->surface = $request->surface;
        $rwd_detail->strength = $request->strength;
        $rwd_detail->asda = $request->asda;
        $rwd_detail->lda = $request->lda;
        $rwd_detail->save();

        return ['success' => 'Runway Designator has been updated.'];
    }

    public function deletedetailrwd(Request $request)
    {
        $rwd = RunwayDimension::find($request->id);

        $rwd->delete();

        return ['success' => 'Runway Dimension has been deleted.'];
    }

    public function deletedetailrwddetail(Request $request)
    {
        $rwd_detail = RunwayDimensionDetail::find($request->id);

        $rwd_detail->delete();

        return ['success' => 'Runway Designator has been deleted.'];
    }

    public function adddetailtaxiway(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'taxiway_name' => 'required',
//            'dimension' => 'required',
//            'longitudinal_slope' => 'required',
//            'transverse_slope' => 'required',
//            'strength' => 'required',
//            'surface' => 'required',
        ]);


        if ($validator->passes()) {
            $taxiway = new Taxiway();
            $taxiway->airport_id = $request->airport_id;
            $taxiway->name = $request->taxiway_name;
            $taxiway->dimension = $request->dimension;
            $taxiway->longitudinal_slope = $request->longitudinal_slope;
            $taxiway->transverse_slope = $request->transverse_slope;
            $taxiway->strength = $request->strength;
            $taxiway->surface = $request->surface;
            $taxiway->save();

            return response()->json(['success' => 'Taxiway Data has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function updatedetailtaxiway(Request $request)
    {
        Taxiway::where('id', $request->id)->update([
            'name' => $request->name,
            'dimension' => $request->dimension,
            'longitudinal_slope' => $request->long_slope,
            'transverse_slope' => $request->trans_slope,
            'strength' => $request->strength,
            'surface' => $request->surface,
        ]);

        return ['success' => 'Taxiway Data has been updated.'];
    }

    public function deletedetailtaxiway(Request $request)
    {
        $taxiway = Taxiway::find($request->id);

        $taxiway->delete();

        return ['success' => 'Taxiway has been deleted.'];
    }

    public function adddetailapron(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'apron_name' => 'required',
//            'dimension' => 'required',
//            'slope' => 'required',
//            'apron_strength' => 'required',
//            'apron_surface' => 'required',
        ]);


        if ($validator->passes()) {
            $apron = new Apron();
            $apron->airport_id = $request->airport_id;
            $apron->name = $request->apron_name;
            $apron->dimension = $request->dimension;
            $apron->slope = $request->slope;
            $apron->surface = $request->apron_surface;
            $apron->strength = $request->apron_strength;
            $apron->save();

            return response()->json(['success' => 'Apron Data has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function updatedetailapron(Request $request)
    {
        Apron::where('id', $request->id)->update([
            'name' => $request->name,
            'dimension' => $request->dimension,
            'slope' => $request->slope,
            'surface' => $request->surface,
            'strength' => $request->strength,
        ]);

        return ['success' => 'Apron Data has been updated.'];
    }

    public function deletedetailapron(Request $request)
    {
        $apron = Apron::find($request->id);

        $apron->delete();

        return ['success' => 'Apron Data has been deleted.'];
    }

    public function updatedetailapm(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->ap_edge = $request->edge;
        $airport->ap_guidance = $request->guidance;
        $airport->ap_parking_stand = $request->park_stand;
        $airport->ap_aircraft_ns_pos = $request->ac_nsp;
        $airport->save();

        return ['success' => 'Apron Marking Data has been updated.'];
    }

    public function updatedetailrwm(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->rw_designation = $request->designation;
        $airport->rw_threshold = $request->threshold;
        $airport->rw_centerline = $request->centerline;
        $airport->rw_sidestrip = $request->sidestrip;
        $airport->rw_touchdown = $request->touchdown;
        $airport->rw_aim_point = $request->aimpoint;
        $airport->rw_nw_guidance = $request->nw_guidance;
        $airport->save();

        return ['success' => 'Runway Marking Data has been updated.'];
    }

    public function updatedetailtxm(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->taxi_centerline = $request->centerline;
        $airport->taxi_holdpos = $request->holdpos;
        $airport->taxi_edge = $request->edge;
        $airport->taxi_exit_guideline = $request->xguideline;
        $airport->save();

        return ['success' => 'Taxiway Marking Data has been updated.'];
    }

    public function updatedetaillightning(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->light_runway = $request->runway;
        $airport->light_approach = $request->approach;
        $airport->light_reil = $request->reil;
        $airport->light_threshold = $request->threshold;
        $airport->light_papi = $request->papi;
        $airport->light_taxiway = $request->taxiway;
        $airport->light_apron = $request->apron;
        $airport->light_flood = $request->flood;
        $airport->save();

        return ['success' => 'Lightning Data has been updated.'];
    }

    public function updatedetailfffac(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->ff_categories = $request->categories;
        $airport->ff_pkppk = $request->pkpkk;
        $airport->ff_ambulance = $request->ambulance;
        $airport->ff_command_car = $request->command;
        $airport->ff_rescue_car = $request->rescue;
        $airport->ff_personil = $request->personil;
        $airport->save();

        return ['success' => 'Fire Fighting Facilities has been updated.'];
    }

    public function updatedetailcomm(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->vhf = $request->vhf;
        $airport->ssb = $request->ssb;
        $airport->aftn = $request->aftn;
        $airport->direct_link = $request->direct;
        $airport->save();

        return ['success' => 'Communication has been updated.'];
    }

    public function updatedetailmeteoeq(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->anemometer = $request->anemometer;
        $airport->barometer = $request->barometer;
        $airport->barograph = $request->barograph;
        $airport->wb_db_therm = $request->wbdb_therm;
        $airport->therm_max = $request->therm_max;
        $airport->therm_min = $request->therm_min;
        $airport->fisicometer = $request->fisicometer;
        $airport->windshock = $request->windshock;
        $airport->weather_radar = $request->weather;
        $airport->rvr = $request->rvr;
        $airport->save();

        return ['success' => 'Meteorology Equipment updated.'];
    }

    public function adddetailnav(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'navaids' => 'required',
//            'category' => 'required',
//            'frequency' => 'required',
//            'course' => 'required',
//            'lat_long' => 'required',
//            'channel' => 'required',
        ]);


        if ($validator->passes()) {
            $nav = New NavFacility();

            $nav->airport_id = $request->airport_id;
            $nav->navaids = $request->navaids;
            $nav->category = $request->category;
            $nav->frequency = $request->frequency;
            $nav->course = $request->course;
            $nav->lat_long = $request->lat_long;
            $nav->channel = $request->channel;
            $nav->save();

            return response()->json(['success'=>'Navigation Facility has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function updatedetailnav(Request $request)
    {
        NavFacility::where('id', $request->id)->update([
            'navaids' => $request->navaids,
            'category' => $request->category,
            'frequency' => $request->freq,
            'course' => $request->course,
            'lat_long' => $request->latlong,
            'channel' => $request->channel
        ]);

        return ['success' => 'Navigation Facilities has been updated.'];
    }

    public function deletedetailnav(Request $request)
    {
        $nav = NavFacility::find($request->id);

        $nav->delete();

        return ['success' => 'Navigation Facility has been deleted.'];
    }

    public function adddetailobs(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'to' => 'required',
//            'app' => 'required',
        ]);


        if ($validator->passes()) {
            $obstacle = New Obstacle();

            $obstacle->airport_id = $request->airport_id;
            $obstacle->to_runway = $request->to;
            $obstacle->app_runway = $request->app;
            $obstacle->save();

            return response()->json(['success'=>'Obstacle Data has been created.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function adddetailobsdetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'obstacle' => 'required',
//            'latlong' => 'required',
//            'height' => 'required',
//            'dist_from' => 'required',
//            'dist_center' => 'required'
        ]);

        if ($validator->passes()) {
            $obs_detail = New ObstacleDetail();

            $obs_detail->obstacle_id = $request->obstacle_id;
            $obs_detail->obstacle = $request->obstacle;
            $obs_detail->lat_long = $request->latlong;
            $obs_detail->height = $request->height;
            $obs_detail->dist_from_rwy = $request->dist_from;
            $obs_detail->dist_centerline = $request->dist_center;
            $obs_detail->save();

            return response()->json(['success'=>'Obstacle Detail has been add.']);
        }

        return response()->json(['error'=>$validator->errors()->first()]);
    }

    public function updatedetailobs(Request $request)
    {
        $obstacle = Obstacle::find($request->obs_id);
        $obstacle->to_runway = $request->to;
        $obstacle->app_runway = $request->app;
        $obstacle->save();

        return response()->json();
    }

    public function updatedetailobsdetail(Request $request)
    {
        $array_id = $request->array_id;
        $array_obstacle = $request->array_obstacle;
        $array_latlong = $request->array_latlong;
        $array_height = $request->array_height;
        $array_distfrom = $request->array_distfrom;
        $array_distcenter = $request->array_distcenter;

        for($i = 0 ; $i < count($array_id) ; $i++){
            ObstacleDetail::where('id', $array_id[$i])->update([
                'obstacle' => $array_obstacle[$i],
                'lat_long' => $array_latlong[$i],
                'height' => $array_height[$i],
                'dist_from_rwy' => $array_distfrom[$i],
                'dist_centerline' => $array_distcenter[$i],
            ]);
        }

        return ['success' => 'Obstacle Data has been updated.'];
    }

    public function deletedetailobs(Request $request)
    {
        $obs = Obstacle::find($request->id);

        $obs->delete();

        return ['success' => 'Obstacle Data has been deleted.'];
    }

    public function deletedetailobsdetail(Request $request)
    {
        $obs = ObstacleDetail::find($request->id);

        $obs->delete();

        return ['success' => 'Obstacle Data has been deleted.'];
    }

    public function updatedetailiaproc(Request $request)
    {
        $airport = Airport::find($request->airport_id);
        $airport->iap_category = $request->iap;
        $airport->remarks_detail = $request->remarks;
        $airport->save();

        return ['success' => 'Instrument Approach Procedure has been updated.'];
    }

    public function document($id)
    {
        $airport = Airport::find($id);

        return view('airport.domestic.document', compact('airport'));
    }

    public function adl($id)
    {
        $airport = Airport::find($id);

        return view('airport.domestic.adl', compact('airport'));
    }

//    International
    public function international()
    {
        return view('airport.international.index');
    }
}
