<!DOCTYPE html>
<html>
<head>
    <title>Airport Database</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset("bower_components/bootstrap/dist/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("bower_components/font-awesome/css/font-awesome.min.css")}}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")}}">
</head>
<body onload="window.print();">
<!-- Airport Data -->
<div id="airportdata">
    <h4 style="text-align: center">
        <b>Airport Data</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">Airport Name</th>
            <td>
                <span class="txt-view" id="s-name">{{$airport->name}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Effective Date</th>
            <?php $date = date('d F Y', strtotime($airport->effective_date));?>
            <td>
                <span class="txt-view" id="s-effective-date">{{$date}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Aerodrome File</th>
            <td>
                {{$airport->aerodrome}}
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Aerodrome Data -->
<div id="aerodromedata">
    <h4 style="text-align: center">
        <b>Aerodrome Data</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">IATA / ICAO Code</th>
            <td>
                <span class="txt-view" id="s-icao-code">{{$airport->iata_code}}</span>/
                <span class="txt-view" id="s-iata-code">{{$airport->icao_code}}</span>
            </td>
        </tr>
        <tr>
            <th colspan="2">References Point</th>
        </tr>
        <tr>
            <th width="30%">&bull; Latitude</th>
            <td>
                <span class="txt-view" id="s-latitude">{{$airport->rp_latitude}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">&bull; Longitude</th>
            <td>
                <span class="txt-view" id="s-longitude">{{$airport->rp_longitude}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Aerodrome Elevation</th>
            <td>
                <span class="txt-view" id="s-elevation">{{$airport->elevation}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Jenis pelayanan keselamatan penerbangan (ATS)</th>
            <td>
                <span class="txt-view" id="s-ats">{{$airport->ats}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Aerodrome temperature reference	</th>
            <td>
                <span class="txt-view" id="s-temp">{{$airport->aerodrome_temp}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Luas Bandara (Ha)</th>
            <td>
                <span class="txt-view" id="s-area">{{$airport->airport_area}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">PK-PKK (Fire fighting) Categories</th>
            <td>
                <span class="txt-view" id="s-pkpkk">{{$airport->pkpkk_categories}}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Magnetic Variation</th>
            <td>
                <span class="txt-view" id="s-mag-var">{{$airport->magnetic_var}}</span>
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Runway Data -->
<div class="runwaydata">
    <h4 style="text-align: center">
        <b>Runway Data</b>
    </h4>
    @if(count($runway_dimensions ) > 0)
        @foreach($runway_dimensions as $runway_dimension)
            <div class="rwd">
                <input type="hidden" id="id" value="{{$runway_dimension->id}}">

                <table class="table table-bordered">
                    <tr>
                        <th width="25%">Runway Dimension</th>
                        <td colspan="3">
                            <span class="txt-view" id="s-dimension">{{$runway_dimension->dimension}}</span>
                            <input type="hidden" id="dimension" value="{{$runway_dimension->dimension}}" class="form-control txt-fill" style="width: 32%">
                        </td>
                    </tr>
                </table>
            </div>

            @foreach($runway_dimension_details as $runway_dimension_detail)
                @if($runway_dimension->id == $runway_dimension_detail->rd_id)
                    <div class="rwd-detail">
                        <input type="hidden" id="id" value="{{$runway_dimension_detail->id}}">

                        <table class="table table-bordered ">
                            <tr>
                                <th>Runway Designator</th>
                                <td colspan="3">
                                    <span class="txt-view" id="s-designator">{{$runway_dimension_detail->designator}}</span>
                                    <input type="hidden" id="designator" value="{{$runway_dimension_detail->designator}}" class="form-control txt-fill" style="width: 32%">
                                </td>
                            </tr>
                            <tr>
                                <th width="25%">Heading</th>
                                <th width="25%">Entry Angle</th>
                                <th width="25%">Turning Area</th>
                                <th width="25%">Slope</th>
                            </tr>
                            <tr>
                                <td>
                                    <span class="txt-view" id="s-heading">{{$runway_dimension_detail->heading}}</span>
                                    <input type="hidden" id="heading" value="{{$runway_dimension_detail->heading}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-entrypad">{{$runway_dimension_detail->entry_pad}}</span>
                                    <input type="hidden" id="entrypad" value="{{$runway_dimension_detail->entry_pad}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-tarea">{{$runway_dimension_detail->turning_area}}</span>
                                    <input type="hidden" id="tarea" value="{{$runway_dimension_detail->turning_area}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-slope">{{$runway_dimension_detail->slope}}</span>
                                    <input type="hidden" id="slope" value="{{$runway_dimension_detail->slope}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                            </tr>
                            <tr>
                                <th>Threshold elevation</th>
                                <th>Threshold Lat/Long</th>
                                <th>TORA</th>
                                <th>TODA</th>
                            </tr>
                            <tr>
                                <td>
                                    <span class="txt-view" id="s-telev">{{$runway_dimension_detail->threshold_elev}}</span>
                                    <input type="hidden" id="telev" value="{{$runway_dimension_detail->threshold_elev}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-tlatlong">{{$runway_dimension_detail->threshold_latlong}}</span>
                                    <input type="hidden" id="tlatlong" value="{{$runway_dimension_detail->threshold_latlong}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-tora">{{$runway_dimension_detail->tora}}</span>
                                    <input type="hidden" id="tora" value="{{$runway_dimension_detail->tora}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-toda">{{$runway_dimension_detail->toda}}</span>
                                    <input type="hidden" id="toda" value="{{$runway_dimension_detail->toda}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                            </tr>
                            <tr>
                                <th>Stopway dimension</th>
                                <th>Stopway slope</th>
                                <th>RESA</th>
                                <th>Clearway</th>
                            </tr>
                            <tr>
                                <td>
                                    <span class="txt-view" id="s-stop-dimens">{{$runway_dimension_detail->stopway_dimens}}</span>
                                    <input type="hidden" id="stop-dimens" value="{{$runway_dimension_detail->stopway_dimens}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-stop-slope">{{$runway_dimension_detail->stopway_slope}}</span>
                                    <input type="hidden" id="stop-slope" value="{{$runway_dimension_detail->stopway_slope}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-resa">{{$runway_dimension_detail->resa}}</span>
                                    <input type="hidden" id="resa" value="{{$runway_dimension_detail->resa}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-clearway">{{$runway_dimension_detail->clearway}}</span>
                                    <input type="hidden" id="clearway" value="{{$runway_dimension_detail->clearway}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                            </tr>
                            <tr>
                                <th>Surface</th>
                                <th>Strength</th>
                                <th>ASDA</th>
                                <th>LDA</th>
                            </tr>
                            <tr>
                                <td>
                                    <span class="txt-view" id="s-surface">{{$runway_dimension_detail->surface}}</span>
                                    <input type="hidden" id="surface" value="{{$runway_dimension_detail->surface}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-strength">{{$runway_dimension_detail->strength}}</span>
                                    <input type="hidden" id="strength" value="{{$runway_dimension_detail->strength}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-asda">{{$runway_dimension_detail->asda}}</span>
                                    <input type="hidden" id="asda" value="{{$runway_dimension_detail->asda}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-lda">{{$runway_dimension_detail->lda}}</span>
                                    <input type="hidden" id="lda" value="{{$runway_dimension_detail->lda}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            @endforeach
        @endforeach
    @else
        <table class="table table-bordered">
            <tr>
                <td style="text-align: center">No data avaible in table</td>
            </tr>
        </table>
    @endif
</div>
<br>

<!-- Taxiway Data -->
<div id="taxiwaydata">
    <h4 style="text-align: center">
        <b>Taxiway Data</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th>Taxiway Name</th>
            <th>Dimension</th>
            <th>Longitudinal Slope</th>
            <th>Transverse Slope</th>
            <th>Taxiway Strength</th>
            <th>Taxiway Surface</th>
        </tr>

        @if(count($taxiways) > 0)
            @foreach($taxiways as $taxiway)
                <tr class="taxiway-row">
                    <input type="hidden" id="id" value="{{$taxiway->id}}">
                    <td>
                        <span class="txt-view" id="s-name">{{$taxiway->name}}</span>
                        <input type="hidden" id="name" value="{{$taxiway->name}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-dimension">{{$taxiway->dimension}}</span>
                        <input type="hidden" id="dimension" value="{{$taxiway->dimension}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-long-slope">{{$taxiway->longitudinal_slope}}</span>
                        <input type="hidden" id="long-slope" value="{{$taxiway->longitudinal_slope}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-trans-slope">{{$taxiway->transverse_slope}}</span>
                        <input type="hidden" id="trans-slope" value="{{$taxiway->transverse_slope}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-strength">{{$taxiway->strength}}</span>
                        <input type="hidden" id="strength" value="{{$taxiway->strength}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-surface">{{$taxiway->surface}}</span>
                        <input type="hidden" id="surface" value="{{$taxiway->surface}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" style="text-align: center">No data avaible in table</td>
            </tr>
        @endif
    </table>
</div>
<br>

<!-- Apron Data -->
<div id="aprondata">
    <h4 style="text-align: center">
        <b>Apron Data</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th>Apron Name</th>
            <th>Dimension</th>
            <th>Slope</th>
            <th>Apron Strength</th>
            <th>Apron Surface</th>
        </tr>

        @if(count($aprons) > 0)
            @foreach($aprons as $apron)
                <tr class="taxiway-row">
                    <input type="hidden" id="id" value="{{$apron->id}}">
                    <td>
                        <span class="txt-view" id="s-name">{{$apron->name}}</span>
                        <input type="hidden" id="name" value="{{$apron->name}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-dimension">{{$apron->dimension}}</span>
                        <input type="hidden" id="dimension" value="{{$apron->dimension}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-slope">{{$apron->slope}}</span>
                        <input type="hidden" id="slope" value="{{$apron->slope}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-strength">{{$apron->strength}}</span>
                        <input type="hidden" id="strength" value="{{$apron->strength}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-surface">{{$apron->surface}}</span>
                        <input type="hidden" id="surface" value="{{$apron->surface}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" style="text-align: center">No data avaible in table</td>
            </tr>
        @endif
    </table>
</div>
<br>

<!-- Apron Marking Data -->
<div id="apronmarkingdata">
    <h4 style="text-align: center">
        <b>Aprom Marking Data</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">Apron edge marking</th>
            <td>
                <span class="txt-view" id="s-edge">{{$airport->ap_edge}}</span>
                <input type="hidden" id="edge" value="{{$airport->ap_edge}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Apron guidance name</th>
            <td>
                <span class="txt-view" id="s-guidance">{{$airport->ap_guidance}}</span>
                <input type="hidden" id="guidance" value="{{$airport->ap_guidance}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Parking stand number marking</th>
            <td>
                <span class="txt-view" id="s-park-stand">{{$airport->ap_parking_stand}}</span>
                <input type="hidden" id="park-stand" value="{{$airport->ap_parking_stand}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Aircraft nosewheel stopping position marking</th>
            <td>
                <span class="txt-view" id="s-ac-nsp">{{$airport->ap_aircraft_ns_pos}}</span>
                <input type="hidden" id="ac-nsp" value="{{$airport->ap_aircraft_ns_pos}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Runway Marking Data -->
<div id="runwaymarkingdata">
    <h4 style="text-align: center">
        <b>Runway Marking Data</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">Runway designation marking</th>
            <td>
                <span class="txt-view" id="s-designation">{{$airport->rw_designation}}</span>
                <input type="hidden" id="designation" value="{{$airport->rw_designation}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Threshold marking</th>
            <td>
                <span class="txt-view" id="s-threshold">{{$airport->rw_threshold}}</span>
                <input type="hidden" id="threshold" value="{{$airport->rw_threshold}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Runway centerline marking</th>
            <td>
                <span class="txt-view" id="s-centerline">{{$airport->rw_centerline}}</span>
                <input type="hidden" id="centerline" value="{{$airport->rw_centerline}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Runway side strip marking</th>
            <td>
                <span class="txt-view" id="s-sidestrip">{{$airport->rw_sidestrip}}</span>
                <input type="hidden" id="sidestrip" value="{{$airport->rw_sidestrip}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Touchdown marking</th>
            <td>
                <span class="txt-view" id="s-touchdown">{{$airport->rw_touchdown}}</span>
                <input type="hidden" id="touchdown" value="{{$airport->rw_touchdown}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Aiming point marking</th>
            <td>
                <span class="txt-view" id="s-aimpoint">{{$airport->rw_aim_point}}</span>
                <input type="hidden" id="aimpoint" value="{{$airport->rw_aim_point}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Nose wheel guidance marking</th>
            <td>
                <span class="txt-view" id="s-guidance">{{$airport->rw_nw_guidance}}</span>
                <input type="hidden" id="nw-guidance" value="{{$airport->rw_nw_guidance}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Taxiway Marking Data -->
<div id="taxiwaymarkingdata">
    <h4 style="text-align: center">
        <b>Taxiway Marking Data</b>
    </h4>
    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">Taxiway centerline marking</th>
            <td>
                <span class="txt-view" id="s-centerline">{{$airport->taxi_centerline}}</span>
                <input type="hidden" id="centerline" value="{{$airport->taxi_centerline}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Taxiway holding position marking</th>
            <td>
                <span class="txt-view" id="s-holdpos">{{$airport->taxi_holdpos}}</span>
                <input type="hidden" id="holdpos" value="{{$airport->taxi_holdpos}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Taxiway edge marking</th>
            <td>
                <span class="txt-view" id="s-edge">{{$airport->taxi_edge}}</span>
                <input type="hidden" id="edge" value="{{$airport->taxi_edge}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Exit guideline marking</th>
            <td>
                <span class="txt-view" id="s-xguidline">{{$airport->taxi_exit_guideline}}</span>
                <input type="hidden" id="xguideline" value="{{$airport->taxi_exit_guideline}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Lightning Data -->
<div id="lightningdata">
    <h4 style="text-align: center">
        <b>Lightning Data</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">Runway lights</th>
            <td>
                <span class="txt-view" id="s-runway">{{$airport->light_runway}}</span>
                <input type="hidden" id="runway" value="{{$airport->light_runway}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Approach lights</th>
            <td>
                <span class="txt-view" id="s-approach">{{$airport->light_approach}}</span>
                <input type="hidden" id="approach" value="{{$airport->light_approach}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">REIL</th>
            <td>
                <span class="txt-view" id="s-reil">{{$airport->light_reil}}</span>
                <input type="hidden" id="reil" value="{{$airport->light_reil}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Threshold/Runway lights</th>
            <td>
                <span class="txt-view" id="s-threshold">{{$airport->light_threshold}}</span>
                <input type="hidden" id="threshold" value="{{$airport->light_threshold}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">PAPI</th>
            <td>
                <span class="txt-view" id="s-papi">{{$airport->light_papi}}</span>
                <input type="hidden" id="papi" value="{{$airport->light_papi}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Taxiway edge lights</th>
            <td>
                <span class="txt-view" id="s-taxiway">{{$airport->light_taxiway}}</span>
                <input type="hidden" id="taxiway" value="{{$airport->light_taxiway}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Apron edge lights</th>
            <td>
                <span class="txt-view" id="s-apron">{{$airport->light_apron}}</span>
                <input type="hidden" id="apron" value="{{$airport->light_apron}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Flood lights</th>
            <td>
                <span class="txt-view" id="s-flood">{{$airport->light_flood}}</span>
                <input type="hidden" id="flood" value="{{$airport->light_flood}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Fire Fighting Facility -->
<div id="firefightingfac">
    <h4 style="text-align: center">
        <b>Fire Fighting Facility</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">Category</th>
            <td>
                <span class="txt-view" id="s-categories">{{$airport->ff_categories}}</span>
                <input type="hidden" id="categories" value="{{$airport->ff_categories}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">PK-PKK</th>
            <td>
                <textarea id="pkpkk" class="txt-fill-area" cols="100" rows="7" readonly style="border: none">{{$airport->ff_pkppk}}</textarea>
            </td>
        </tr>
        <tr>
            <th width="30%">Ambulance</th>
            <td>
                <span class="txt-view" id="s-ambulance">{{$airport->ff_ambulance}}</span>
                <input type="hidden" id="ambulance" value="{{$airport->ff_ambulance}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Commando Car</th>
            <td>
                <span class="txt-view" id="s-command">{{$airport->ff_command_car}}</span>
                <input type="hidden" id="command" value="{{$airport->ff_command_car}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Rescue Car</th>
            <td>
                <span class="txt-view" id="s-rescue">{{$airport->ff_rescue_car}}</span>
                <input type="hidden" id="rescue" value="{{$airport->ff_rescue_car}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Personil</th>
            <td>
                <span class="txt-view" id="s-personil">{{$airport->ff_personil}}</span>
                <input type="hidden" id="personil" value="{{$airport->ff_personil}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Communication -->
<div id="communication">
    <h4 style="text-align: center">
        <b>Communication</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">VHF Communication</th>
            <td>
                <span class="txt-view" id="s-vhf">{{$airport->vhf}}</span>
                <input type="hidden" id="vhf" value="{{$airport->vhf}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">SSB</th>
            <td>
                <span class="txt-view" id="s-ssb">{{$airport->ssb}}</span>
                <input type="hidden" id="ssb" value="{{$airport->ssb}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">AFTN</th>
            <td>
                <span class="txt-view" id="s-aftn">{{$airport->aftn}}</span>
                <input type="hidden" id="aftn" value="{{$airport->aftn}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Direct Link</th>
            <td>
                <span class="txt-view" id="s-direct">{{$airport->direct_link}}</span>
                <input type="hidden" id="direct" value="{{$airport->direct_link}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Meteorology Equipment -->
<div id="meteorlogyeq">
    <h4 style="text-align: center">
        <b>Meteorology Equipment</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">Anemometer</th>
            <td>
                <span class="txt-view" id="s-anemometer">{{$airport->anemometer}}</span>
                <input type="hidden" id="anemometer" value="{{$airport->anemometer}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Barometer</th>
            <td>
                <span class="txt-view" id="s-barometer">{{$airport->barometer}}</span>
                <input type="hidden" id="barometer" value="{{$airport->barometer}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Barograph</th>
            <td>
                <span class="txt-view" id="s-barograph">{{$airport->barograph}}</span>
                <input type="hidden" id="barograph" value="{{$airport->barograph}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Wet ball and dry ball thermometer</th>
            <td>
                <span class="txt-view" id="s-wbdb-therm">{{$airport->wb_db_therm}}</span>
                <input type="hidden" id="wbdb-therm" value="{{$airport->wb_db_therm}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Thermometer max</th>
            <td>
                <span class="txt-view" id="s-therm-max">{{$airport->therm_max}}</span>
                <input type="hidden" id="therm-max" value="{{$airport->therm_max}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Thermometer min</th>
            <td>
                <span class="txt-view" id="s-therm-min">{{$airport->therm_min}}</span>
                <input type="hidden" id="therm-min" value="{{$airport->therm_min}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Fisicometer</th>
            <td>
                <span class="txt-view" id="s-fisicometer">{{$airport->fisicometer}}</span>
                <input type="hidden" id="fisicometer" value="{{$airport->fisicometer}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Windshock</th>
            <td>
                <span class="txt-view" id="s-windshock">{{$airport->windshock}}</span>
                <input type="hidden" id="windshock" value="{{$airport->windshock}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">Weather radar/satelite</th>
            <td>
                <span class="txt-view" id="s-weather">{{$airport->weather_radar}}</span>
                <input type="hidden" id="weather" value="{{$airport->weather_radar}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
        <tr>
            <th width="30%">RVR</th>
            <td>
                <span class="txt-view" id="s-rvr">{{$airport->rvr}}</span>
                <input type="hidden" id="rvr" value="{{$airport->rvr}}" class="form-control txt-fill" style="width: 30%">
            </td>
        </tr>
    </table>
</div>
<br>

<!-- Obstacle Data -->
<div id="obstacledata">
    <h4 style="text-align: center">
        <b>Obstacle Data</b>
    </h4>
    @if(count($obstacles) > 0)
        @foreach($obstacles as $obstacle)
            <div class="obstacle-detail">
                <input type="hidden" id="id" value="{{$obstacle->id}}">

                <table class="table table-bordered">
                    <tr>
                        <th>T/O RWY</th>
                        <td colspan="7">
                            <span class="txt-view" id="s-to">{{$obstacle->to_runway}}</span>
                            <input type="hidden" id="to" value="{{$obstacle->to_runway}}" class="form-control txt-fill" style="width: 20%">
                        </td>
                    </tr>
                    <tr>
                        <th>APP RWY</th>
                        <td colspan="7">
                            <span class="txt-view" id="s-app">{{$obstacle->app_runway}}</span>
                            <input type="hidden" id="app" value="{{$obstacle->app_runway}}" class="form-control txt-fill" style="width: 20%">
                        </td>
                    </tr>
                    <tr>
                        <th width="18%">Obstacle</th>
                        <th width="18%">Lat/Long</th>
                        <th width="18%">Height (ft)</th>
                        <th width="18%">Distance from RWY</th>
                        <th width="18%">Distance centerline (leteral)</th>
                    </tr>

                    <?php $count_obstacle = 0?>
                    @foreach($obstacle_details as $obstacle_detail)
                        @if($obstacle->id == $obstacle_detail->obstacle_id)

                            <?php $count_obstacle++?>

                            <tr>
                                <input type="hidden" id="id-{{$count_obstacle}}" value="{{$obstacle_detail->id}}">
                                <input type="hidden" id="id" value="{{$obstacle_detail->id}}">
                                <td>
                                    <span class="txt-view" id="s-obstacle">{{$obstacle_detail->obstacle}}</span>
                                    <input type="hidden" id="obstacle-{{$count_obstacle}}" value="{{$obstacle_detail->obstacle}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-latlong">{{$obstacle_detail->lat_long}}</span>
                                    <input type="hidden" id="latlong-{{$count_obstacle}}" value="{{$obstacle_detail->lat_long}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-height">{{$obstacle_detail->height}}</span>
                                    <input type="hidden" id="height-{{$count_obstacle}}" value="{{$obstacle_detail->height}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-distfrom">{{$obstacle_detail->dist_from_rwy}}</span>
                                    <input type="hidden" id="distfrom-{{$count_obstacle}}" value="{{$obstacle_detail->dist_from_rwy}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                                <td>
                                    <span class="txt-view" id="s-distcenter">{{$obstacle_detail->dist_centerline}}</span>
                                    <input type="hidden" id="distcenter-{{$count_obstacle}}" value="{{$obstacle_detail->dist_centerline}}" class="form-control txt-fill" style="width: 100%">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>

                <input type="hidden" id="count-obstacle" value="{{$count_obstacle}}">

            </div>
        @endforeach
    @else
        <table class="table table-bordered">
            <tr>
                <td style="text-align: center">No data avaible in table</td>
            </tr>
        </table>
    @endif
</div>
<br>

<!-- Navigation Facility -->
<div id="navigationfac">
    <h4 style="text-align: center">
        <b>Navigation Facility</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th>Navaids</th>
            <th>Category</th>
            <th>Frequency</th>
            <th>Course</th>
            <th>Lat/Long</th>
            <th>Channel</th>
        </tr>

        @if(count($nav_facilities) > 0)
            @foreach($nav_facilities as $nav_facility)
                <tr class="taxiway-row">
                    <input type="hidden" id="id" value="{{$nav_facility->id}}">
                    <td>
                        <span class="txt-view" id="s-navaids">{{$nav_facility->navaids}}</span>
                        <input type="hidden" id="navaids" value="{{$nav_facility->navaids}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-category">{{$nav_facility->category}}</span>
                        <input type="hidden" id="category" value="{{$nav_facility->category}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-freq">{{$nav_facility->frequency}}</span>
                        <input type="hidden" id="freq" value="{{$nav_facility->frequency}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-course">{{$nav_facility->course}}</span>
                        <input type="hidden" id="course" value="{{$nav_facility->course}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-latlong">{{$nav_facility->lat_long}}</span>
                        <input type="hidden" id="latlong" value="{{$nav_facility->lat_long}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                    <td>
                        <span class="txt-view" id="s-channel">{{$nav_facility->channel}}</span>
                        <input type="hidden" id="channel" value="{{$nav_facility->channel}}" class="form-control txt-fill" style="width: 100%">
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" style="text-align: center">No data avaible in table</td>
            </tr>
        @endif
    </table>
</div>
<br>

<!-- Instrument Approach Procedure -->
<div id="instrumentappproc">
    <h4 style="text-align: center">
        <b>Instrument Approach Procedure</b>
    </h4>

    <table class="table  table-bordered" id="airport-table" style="width: 100%">
        <tr>
            <th width="30%">IAP Category (Produk)</th>
            <td>
                <textarea id="iap" class="txt-fill-area" cols="100" rows="7" readonly style="border: none">{{$airport->iap_category}}</textarea>
            </td>
        </tr>
        <tr>
            <th width="30%">Remarks</th>
            <td>
                <textarea id="remarks" class="txt-fill-area" cols="100" rows="7" readonly style="border: none">{{$airport->remarks}}</textarea>
            </td>
        </tr>
    </table>
</div>

</body>
</html>