@extends('layouts.app')

@section('page_heading', 'Domestic')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Airport Data</li>
        <li><a href="{{url('airport-dom')}}">Domestic</a></li>
        <li class="active">Detail Data</li>
    </ol>
@endsection

@section('section')
    <style>
        th{
            background-color: #f4f4f4;
        }

        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 1px solid #8aa4af;
        }
        .fixed-button
        {
            position: fixed;
            bottom: 10px;
            right: 30px;
            opacity: 0.8;
        }
    </style>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li><a href="{{url('airport-dom/generaldata/'.$airport->id)}}">General Data</a></li>
                        <li class="active"><a href="#">Detail Data</a></li>
                            <li><a href="{{url('airport-dom/document/'.$airport->id)}}">Document</a></li>
                        <li><a href="{{url('airport-dom/adl/'.$airport->id)}}">Airport Data Limitation (ADL)</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="detaildata" style="display: none">

                            <!-- Airport Data -->
                            <div id="airportdata">
                                <h4 style="text-align: center">
                                    <b>Airport Data</b>
                                </h4>

                                <button class="btn btn-link save" id="save-airportdata" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

                                <table class="table  table-bordered" id="airport-table" style="width: 100%">
                                    <tr>
                                        <th width="30%">Airport Name</th>
                                        <td>
                                            <span class="txt-view" id="s-name">{{$airport->name}}</span>
                                            <input type="hidden" id="name" value="{{$airport->name}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Effective Date</th>
                                        <?php $date = date('d F Y', strtotime($airport->effective_date));?>
                                        <td>
                                           <span class="txt-view" id="s-effective-date">
                                            @if($airport->effective_date != null && $airport->effective_date != '')
                                                   {{$date}}
                                               @endif
                                        </span>
                                            <input type="hidden" id="effective-date" value="{{$airport->effective_date}}" class="form-control txt-fill-date" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">AIP File</th>
                                        <td>
                                            <a href="{{ asset("files/aerodrome/$airport->aerodrome") }}" target="_blank" class="txt-view" id="s-aerodrome">{{$airport->aerodrome}}</a>
                                            <form action="{{url('upload-aerodrome')}}" method="POST" enctype="multipart/form-data">
                                                {{csrf_field()}}
                                                <input type="hidden" name="airport_id" value="{{$airport->id}}">
                                                <input type="file" name="aerodrome" class="form-control field-upload" style="width: 30%; display: none;">

                                                <button type="submit" id="upload-aerodrome" hidden></button>
                                            </form>
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

                                <button class="btn btn-link save" id="save-aerodrome" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

                                <table class="table  table-bordered" id="airport-table" style="width: 100%">
                                    <tr>
                                        <th width="30%">ICAO / IATA Code</th>
                                        <td>
                                            <span class="txt-view" id="s-icao-code">{{$airport->icao_code}}</span>
                                            <input type="hidden" id="icao-code" value="{{$airport->icao_code}}" class="form-control txt-fill" style="width: 30%">/
                                            <span class="txt-view" id="s-iata-code">{{$airport->iata_code}}</span>
                                            <input type="hidden" id="iata-code" value="{{$airport->iata_code}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">References Point</th>
                                    </tr>
                                    <tr>
                                        <th width="30%">&bull; Latitude</th>
                                        <td>
                                            <span class="txt-view" id="s-latitude">{{$airport->rp_latitude}}</span>
                                            <input type="hidden" id="latitude" value="{{$airport->rp_latitude}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">&bull; Longitude</th>
                                        <td>
                                            <span class="txt-view" id="s-longitude">{{$airport->rp_longitude}}</span>
                                            <input type="hidden" id="longitude" value="{{$airport->rp_longitude}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Aerodrome Elevation</th>
                                        <td>
                                            <span class="txt-view" id="s-elevation">{{$airport->elevation}}</span>
                                            <input type="hidden" id="elevation" value="{{$airport->elevation}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Jenis pelayanan keselamatan penerbangan (ATS)</th>
                                        <td>
                                            <span class="txt-view" id="s-ats">{{$airport->ats}}</span>
                                            <input type="hidden" id="ats" value="{{$airport->ats}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Aerodrome temperature reference	</th>
                                        <td>
                                            <span class="txt-view" id="s-temp">{{$airport->aerodrome_temp}}</span>
                                            <input type="hidden" id="temp" value="{{$airport->aerodrome_temp}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Luas Bandara (Ha)</th>
                                        <td>
                                            <span class="txt-view" id="s-area">{{$airport->airport_area}}</span>
                                            <input type="hidden" id="area" value="{{$airport->airport_area}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">PK-PKK (Fire fighting) Categories</th>
                                        <td>
                                            <span class="txt-view" id="s-pkpkk">{{$airport->pkpkk_categories}}</span>
                                            <input type="hidden" id="pkpkk" value="{{$airport->pkpkk_categories}}" class="form-control txt-fill" style="width: 30%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Magnetic Variation</th>
                                        <td>
                                            <span class="txt-view" id="s-mag-var">{{$airport->magnetic_var}}</span>
                                            <input type="hidden" id="mag-var" value="{{$airport->magnetic_var}}" class="form-control txt-fill" style="width: 30%">
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

                                            <button class="btn btn-link delete-rwd" style="float: right">
                                                <i class="fa fa-btn fa-trash"></i> Remove
                                            </button>
                                            <button class="btn btn-link save save-rwd" style="float: right; display: none">
                                                <i class="fa fa-btn fa-save"></i> Save
                                            </button>
                                            <button class="btn btn-link update" style="float: right;">
                                                <i class="fa fa-btn fa-edit"></i> Update
                                            </button>
                                            <button class="btn btn-link rwd-button" data-toggle="modal" data-target="#new-rwd-detail" style="float: left">
                                                <input type="hidden" id="id" value="{{$runway_dimension->id}}">
                                                <i class="fa fa-plus"></i> New Designator
                                            </button>

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

                                                    <button class="btn btn-link delete-rwd-detail" style="float: right">
                                                        <i class="fa fa-btn fa-trash"></i> Remove
                                                    </button>
                                                    <button class="btn btn-link save save-rwd-detail" style="float: right; display: none">
                                                        <i class="fa fa-btn fa-save"></i> Save
                                                    </button>
                                                    <button class="btn btn-link update" style="float: right;">
                                                        <i class="fa fa-btn fa-edit"></i> Update
                                                    </button>

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

                                <button class="btn btn-link" data-toggle="modal" data-target="#new-taxiway" style="float: right"><i class="fa fa-plus"></i> New Taxiway</button>

                                <table class="table  table-bordered" id="airport-table" style="width: 100%">
                                    <tr>
                                        <th>Taxiway Name</th>
                                        <th>Dimension</th>
                                        <th>Longitudinal Slope</th>
                                        <th>Transverse Slope</th>
                                        <th>Taxiway Strength</th>
                                        <th>Taxiway Surface</th>
                                        <th width="13%" style="text-align: center" class="action-col">Action</th>
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
                                                <td style="text-align: center" class="action-col">
                                                    <button class="update-row btn-link" data-toggle="tooltip" title="Update"><i class="fa fa-btn fa-edit"></i></button>
                                                    <button class="save-row btn-link save-taxiway" data-toggle="tooltip" title="Save" hidden><i class="fa fa-btn fa-save"></i></button>
                                                    <button class="delete-row btn-link delete-taxiway" data-toggle="tooltip" title="Delete"><i class="fa fa-btn fa-trash"></i></button>
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

                                <button class="btn btn-link" data-toggle="modal" data-target="#new-apron" style="float: right"><i class="fa fa-plus"></i> New Apron</button>

                                <table class="table  table-bordered" id="airport-table" style="width: 100%">
                                    <tr>
                                        <th>Apron Name</th>
                                        <th>Dimension</th>
                                        <th>Slope</th>
                                        <th>Apron Surface</th>
                                        <th>Apron Strength</th>
                                        <th width="13%" style="text-align: center" class="action-col">Action</th>
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
                                                    <span class="txt-view" id="s-surface">{{$apron->surface}}</span>
                                                    <input type="hidden" id="surface" value="{{$apron->surface}}" class="form-control txt-fill" style="width: 100%">
                                                </td>
                                                <td>
                                                    <span class="txt-view" id="s-strength">{{$apron->strength}}</span>
                                                    <input type="hidden" id="strength" value="{{$apron->strength}}" class="form-control txt-fill" style="width: 100%">
                                                </td>
                                                <td style="text-align: center" class="action-col">
                                                    <button class="update-row btn-link" data-toggle="tooltip" title="Update"><i class="fa fa-btn fa-edit"></i></button>
                                                    <button class="save-row btn-link save-apron" data-toggle="tooltip" title="Save" hidden><i class="fa fa-btn fa-save"></i></button>
                                                    <button class="delete-row btn-link delete-apron" data-toggle="tooltip" title="Delete"><i class="fa fa-btn fa-trash"></i></button>
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
                                    <b>Apron Marking Data</b>
                                </h4>

                                <button class="btn btn-link save" id="save-apm" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

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

                                <button class="btn btn-link save" id="save-rwm" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

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

                                <button class="btn btn-link save" id="save-txm" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

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

                                <button class="btn btn-link save" id="save-lightning" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

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

                                <button class="btn btn-link save" id="save-fffac" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

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

                                <button class="btn btn-link save" id="save-comm" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

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

                                <button class="btn btn-link save" id="save-meteoeq" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

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
                                <button class="btn btn-link obs" data-toggle="modal" data-target="#new-obstacle" style="float: left">
                                    <i class="fa fa-plus"></i> New Obstacle
                                </button>
                                @if(count($obstacles) > 0)
                                    @foreach($obstacles as $obstacle)
                                        <div class="obstacle-detail">
                                            <input type="hidden" id="id" value="{{$obstacle->id}}">

                                            <button class="btn btn-link delete-obstacle" style="float: right">
                                                <i class="fa fa-btn fa-trash"></i> Remove
                                            </button>
                                            <button class="btn btn-link save save-obstacle" style="float: right;display: none">
                                                <i class="fa fa-btn fa-save"></i> Save
                                            </button>
                                            <button class="btn btn-link update" style="float: right;">
                                                <i class="fa fa-btn fa-edit"></i> Update
                                            </button>

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
                                                    <th width="10%" style="text-align: center;" class="action-col">Action</th>
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
                                                            <td style="text-align: center" class="action-col">
                                                                <button class="delete-obstacle-detail btn-link"  data-toggle="tooltip" title="Delete">
                                                                    <i class="fa fa-btn fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <td>
                                                        <button class="btn-link obs-button" data-toggle="modal" data-target="#new-obstacle-detail">
                                                            <input type="hidden" id="id" value="{{$obstacle->id}}">
                                                            <i class="fa fa-plus"></i> Add
                                                        </button>
                                                    </td>
                                                </tr>
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

                                <button class="btn btn-link" data-toggle="modal" data-target="#new-nav" style="float: right"><i class="fa fa-plus"></i> New Navigation Facility</button>

                                <table class="table  table-bordered" id="airport-table" style="width: 100%">
                                    <tr>
                                        <th>Navaids</th>
                                        <th>Category</th>
                                        <th>Frequency</th>
                                        <th>Course</th>
                                        <th>Lat/Long</th>
                                        <th>Channel</th>
                                        <th width="13%" style="text-align: center" class="action-col">Action</th>
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
                                                <td style="text-align: center" class="action-col">
                                                    <button class="update-row btn-link" data-toggle="tooltip" title="Update"><i class="fa fa-btn fa-edit"></i></button>
                                                    <button class="save-row btn-link save-nav" data-toggle="tooltip" title="Save" hidden><i class="fa fa-btn fa-save"></i></button>
                                                    <button class="delete-row btn-link delete-nav" data-toggle="tooltip" title="Delete"><i class="fa fa-btn fa-trash"></i></button>
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

                                <button class="btn btn-link save" id="save-iaproc" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>

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
                                            <textarea id="remarks" class="txt-fill-area" cols="100" rows="7" readonly style="border: none">{{$airport->remarks_detail}}</textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <a href="{{url('print-airportdata/'.$airport->id)}}" class="btn btn-default print" target="_blank" style="float: right"><i class="fa fa-print"></i> Print Detail Data</a>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="new-rwd-detail" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="form-horizontal">
                    <input type="hidden" id="rd-id" name="rd_id">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Runway Dimension Detail</h4>
                    </div>
                    <div class="modal-body">
                        <table style="width: 100%;">
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Runway Designator</label>

                                        <div class="col-md-5">
                                            <input id="designator" type="text" class="form-control" name="designator" value="{{ old('designator') }}" placeholder="Runway Designator">
                                        </div>
                                    </div>
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td width="45%">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">Heading</label>

                                        <div class="col-md-7">
                                            <input id="heading" type="text" class="form-control" name="heading" value="{{ old('heading') }}" placeholder="Heading">
                                        </div>
                                    </div>
                                </td>
                                <td width="55%">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Entry Angle</label>

                                        <div class="col-md-6">
                                            <input id="entrypad" type="text" class="form-control" name="entry_pad" value="{{ old('entry_pad') }}" placeholder="Entry Angle">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="45%">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">Turning</label>

                                        <div class="col-md-7">
                                            <input id="tarea" type="text" class="form-control" name="turning_area" value="{{ old('turning_area') }}" placeholder="Turning">
                                        </div>
                                    </div>
                                </td>
                                <td width="55%">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Slope</label>

                                        <div class="col-md-6">
                                            <input id="slope" type="text" class="form-control" name="slope" value="{{ old('slope') }}" placeholder="Slope">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="45%">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">Threshold Elevation</label>

                                        <div class="col-md-7">
                                            <input id="telev" type="text" class="form-control" name="threshold_elev" value="{{ old('threshold_elev') }}" placeholder="Threshold Elevation">
                                        </div>
                                    </div>
                                </td>
                                <td width="55%">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Threshold Lat</label>

                                        <div class="col-md-6">
                                            <input id="tlatlong" type="text" class="form-control" name="threshold_latlong" value="{{ old('threshold_latlong') }}" placeholder="Threshold Lat/Long">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="45%">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">TORA</label>

                                        <div class="col-md-7">
                                            <input id="tora" type="text" class="form-control" name="tora" value="{{ old('tora') }}" placeholder="TORA">
                                        </div>
                                    </div>
                                </td>
                                <td width="55%">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">TODA</label>

                                        <div class="col-md-6">
                                            <input id="toda" type="text" class="form-control" name="toda" value="{{ old('toda') }}" placeholder="TODA">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="45%">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">Stopway Dimension</label>

                                        <div class="col-md-7">
                                            <input id="stop-dimens" type="text" class="form-control" name="stopway_dimens" value="{{ old('stopway_dimens') }}" placeholder="Stopway Dimension">
                                        </div>
                                    </div>
                                </td>
                                <td width="55%">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Stopway Slope</label>

                                        <div class="col-md-6">
                                            <input id="stop-slope" type="text" class="form-control" name="stopway_slope" value="{{ old('stopway_slope') }}" placeholder="Stopway Slope">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="45%">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">RESA</label>

                                        <div class="col-md-7">
                                            <input id="resa" type="text" class="form-control" name="resa" value="{{ old('resa') }}" placeholder="RESA">
                                        </div>
                                    </div>
                                </td>
                                <td width="55%">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Clearway</label>

                                        <div class="col-md-6">
                                            <input id="clearway" type="text" class="form-control" name="clearway" value="{{ old('clearway') }}" placeholder="Clearway">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="45%">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">Surface</label>

                                        <div class="col-md-7">
                                            <input id="surface" type="text" class="form-control" name="surface" value="{{ old('surface') }}" placeholder="Surface">
                                        </div>
                                    </div>
                                </td>
                                <td width="55%">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Strength</label>

                                        <div class="col-md-6">
                                            <input id="strength" type="text" class="form-control" name="strength" value="{{ old('strength') }}" placeholder="Strength">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="45%">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">ASDA</label>

                                        <div class="col-md-7">
                                            <input id="asda" type="text" class="form-control" name="asda" value="{{ old('asda') }}" placeholder="ASDA">
                                        </div>
                                    </div>
                                </td>
                                <td width="55%">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">LDA</label>

                                        <div class="col-md-6">
                                            <input id="lda" type="text" class="form-control" name="lda" value="{{ old('lda') }}" placeholder="LDA">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit-rwd-detail" >Submit</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-taxiway" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Taxiway</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Taxiway Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Taxiway Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dimension" class="col-md-4 control-label">Dimension</label>

                            <div class="col-md-6">
                                <input id="dimension" type="text" class="form-control" name="dimension" value="{{ old('dimension') }}" placeholder="Dimension">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="long-slope" class="col-md-4 control-label">Longitudinal Slope</label>

                            <div class="col-md-6">
                                <input id="long-slope" type="text" class="form-control" name="longitudinal_slope" value="{{ old('longitudinal_slope') }}" placeholder="Longitudinal Slope">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="trans-slope" class="col-md-4 control-label">Transverse Slope</label>

                            <div class="col-md-6">
                                <input id="trans-slope" type="text" class="form-control" name="transverse_slope" value="{{ old('transverse_slope') }}" placeholder="Transverse Slope">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="strength" class="col-md-4 control-label">Strength</label>

                            <div class="col-md-6">
                                <input id="strength" type="text" class="form-control" name="strength" value="{{ old('strength') }}" placeholder="Strength">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="surface" class="col-md-4 control-label">Surface</label>

                            <div class="col-md-6">
                                <input id="surface" type="text" class="form-control" name="surface" value="{{ old('surface') }}" placeholder="Surface">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit-taxiway">Submit</button>
                        <button class="dismiss-modal btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-apron" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Apron</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Apron Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Apron Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dimension" class="col-md-4 control-label">Dimension</label>

                            <div class="col-md-6">
                                <input id="dimension" type="text" class="form-control" name="dimension" placeholder="Dimension">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slope" class="col-md-4 control-label">Slope</label>

                            <div class="col-md-6">
                                <input id="slope" type="text" class="form-control" name="slope" placeholder="Slope">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="surface" class="col-md-4 control-label">Surface</label>

                            <div class="col-md-6">
                                <input id="surface" type="text" class="form-control" name="surface" placeholder="Surface">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="strength" class="col-md-4 control-label">Strength</label>

                            <div class="col-md-6">
                                <input id="strength" type="text" class="form-control" name="strength" placeholder="Strength">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit-apron">Submit</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-obstacle" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Obstacle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="to" class="col-md-4 control-label">T/O RWY</label>

                            <div class="col-md-6">
                                <input id="to" type="text" class="form-control" name="to_runway" placeholder="T/O Runway">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="app" class="col-md-4 control-label">APP RWY</label>

                            <div class="col-md-6">
                                <input id="app" type="text" class="form-control" name="app_runway" placeholder="APP Runway">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit-obstacle">Submit</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-obstacle-detail" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Obstacle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="obstacle" class="col-md-4 control-label">Obstacle</label>

                            <div class="col-md-6">
                                <input id="obstacle" type="text" class="form-control" name="obstacle" placeholder="Obstacle">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="latlong" class="col-md-4 control-label">Lat/Long</label>

                            <div class="col-md-6">
                                <input id="latlong" type="text" class="form-control" name="lat_long" placeholder="Lat/Long">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="height" class="col-md-4 control-label">Height</label>

                            <div class="col-md-6">
                                <input id="height" type="text" class="form-control" name="height" placeholder="Height">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dist-from" class="col-md-4 control-label">Distance From RWY</label>

                            <div class="col-md-6">
                                <input id="dist-from" type="text" class="form-control" name="dist_from_rwy" placeholder="Distance From RWY">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dist-center" class="col-md-4 control-label">Distance Centerline</label>

                            <div class="col-md-6">
                                <input id="dist-center" type="text" class="form-control" name="dist_centerline" placeholder="Distance Centerline">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit-obstacle-detail">Submit</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-nav" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Navigation Facility</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="navaids" class="col-md-4 control-label">Navaids</label>

                            <div class="col-md-6">
                                <input id="navaids" type="text" class="form-control" name="navaids" placeholder="Navaids">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nav-category" class="col-md-4 control-label">Category</label>

                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control" name="category" placeholder="Category">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="frequency" class="col-md-4 control-label">Frequency</label>

                            <div class="col-md-6">
                                <input id="freq" type="text" class="form-control" name="frequency" placeholder="Frequency">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="course" class="col-md-4 control-label">Course</label>

                            <div class="col-md-6">
                                <input id="course" type="text" class="form-control" name="course" placeholder="Course">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lat_long" class="col-md-4 control-label">Lat/Long</label>

                            <div class="col-md-6">
                                <input id="latlong" type="text" class="form-control" name="lat_long" placeholder="Lat//Long">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="channel" class="col-md-4 control-label">Strength</label>

                            <div class="col-md-6">
                                <input id="channel" type="text" class="form-control" name="channel" placeholder="Channel">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit-nav">Submit</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{$airport->id}}" id="airport-id">

    @if(Auth::user()->role_name == 'viewer')
        <input type="hidden" id="flag" value="1">
    @endif

    <button class="btn btn-primary fixed-button" style="display: none"><i class="glyphicon glyphicon-chevron-up"></i></button>

    <script>
        var flag = $('#flag').val();

        if(flag === '1'){
            $('.action-col').remove();
            $('button').remove();
        }

        $(document).ready(function() {
            var id = $('#airport-id').val();
            var div_detaildata = $('#detaildata');

            div_detaildata.prop('style', '');

//            Update
            $('.update').click(function () {
                var div = $(this).closest('div');

                div.find('.update').prop('style', 'float: right;display: none');
                div.find('.save').prop('style', 'float: right;display: inline');
                div.find('.txt-view').prop('hidden', true);
                div.find('.txt-fill').prop('type', 'text');
                div.find('.txt-fill-date').prop('type', 'date');
                div.find('.field-upload').prop('style', 'width: 30%; display: inline;');
                div.find('.txt-fill-area').prop('readonly', false).prop('style', '');
            });

            $('.update-row').click(function () {
                var tr = $(this).closest('tr');

                tr.find('.txt-view').prop('hidden', true);
                tr.find('.txt-fill').prop('type', 'text');
                tr.find('.update-row').prop('hidden', true);
                tr.find('.save-row').prop('hidden', false);
            });

//            Save
            $('.save').click(function () {
                var div = $(this).closest('div');

                div.find('.update').prop('style', 'float: right;display: inline');
                div.find('.save').prop('style', 'float: right;display: none');
                div.find('.txt-view').prop('hidden', false);
                div.find('.txt-fill').prop('type', 'hidden');
                div.find('.txt-fill-date').prop('type', 'hidden');
                div.find('.field-upload').prop('style', 'width: 30%; display: none;');
                div.find('.txt-fill-area').prop('readonly', true).prop('style', 'border: none');
                div_detaildata.addClass("disabledbox");
            });

            $('.save-row').click(function () {
                var tr = $(this).closest('tr');

                tr.find('.txt-view').prop('hidden', false);
                tr.find('.txt-fill').prop('type', 'hidden');
                tr.find('.update-row').prop('hidden', false);
                tr.find('.save-row').prop('hidden', true);
                div_detaildata.addClass("disabledbox");
            });

//            Airport Data
            $('#save-airportdata').click(function () {
                var div_airportdata = $(this).closest('#airportdata');
                var name = div_airportdata.find('#name').val();
                var effective_date = div_airportdata.find('#effective-date').val();

                $.ajax({
                    url : '{{url('update-detail-airport')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'name' : name,
                        'effective_date' : effective_date,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        $('#upload-aerodrome').click();
                    }
                });
            });

//            Aerodrome Data
            $('#save-aerodrome').click(function () {
                var div_aerodrome = $(this).closest('#aerodromedata');
                var icao_code = div_aerodrome.find('#icao-code').val();
                var iata_code = div_aerodrome.find('#iata-code').val();
                var latitude = div_aerodrome.find('#latitude').val();
                var longitude = div_aerodrome.find('#longitude').val();
                var elevation = div_aerodrome.find('#elevation').val();
                var ats = div_aerodrome.find('#ats').val();
                var temp = div_aerodrome.find('#temp').val();
                var area = div_aerodrome.find('#area').val();
                var pkpkk = div_aerodrome.find('#pkpkk').val();
                var mag_var = div_aerodrome.find('#mag-var').val();

                $.ajax({
                    url : '{{url('update-detail-aerodrome')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'icao_code' : icao_code,
                        'iata_code' : iata_code,
                        'latitude' : latitude,
                        'longitude' : longitude,
                        'elevation' : elevation,
                        'ats' : ats,
                        'temp' : temp,
                        'area' : area,
                        'pkpkk' : pkpkk,
                        'mag_var' : mag_var,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

//            Runway Data
            var rd_id = '';

            $('.rwd-button').click(function () {
                rd_id = $(this).closest('button').find('#id').val();
            });

            $('.save-rwd').click(function () {
                var div = $(this).closest('.rwd');

                var id = div.find('#id').val();
                var dimension = div.find('#dimension').val();

                $.ajax({
                    url : '{{url('update-detail-rwd')}}',
                    type : 'POST',
                    data : {
                        'id' : id,
                        'dimension' : dimension,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            div_detaildata.addClass("disabledbox");
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            new PNotify({
                                title: "Error!",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            $('.delete-rwd').click(function () {
                var div = $(this).closest('.rwd');
                var id = div.find('#id').val();

                (new PNotify({
                    title: 'Confirmation Needed',
                    text: 'Are you sure want to delete?',
                    icon: 'glyphicon glyphicon-question-sign',
                    type: 'error',
                    hide: false,
                    confirm: {
                        confirm: true
                    },
                    buttons: {
                        closer: false,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                })).get().on('pnotify.confirm', function() {
                    $.ajax({
                        url : '{{url('delete-detail-rwd')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_detaildata.addClass("disabledbox");

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });

                            location.reload();
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });

            $('#submit-rwd-detail').click(function () {
                var div = $(this).closest('.form-horizontal');

                var designator = div.find('#designator').val();
                var heading = div.find('#heading').val();
                var entrypad = div.find('#entrypad').val();
                var tarea = div.find('#tarea').val();
                var slope = div.find('#slope').val();
                var telev = div.find('#telev').val();
                var tlatlong = div.find('#tlatlong').val();
                var tora = div.find('#tora').val();
                var toda = div.find('#toda').val();
                var stop_dimens = div.find('#stop-dimens').val();
                var stop_slope = div.find('#stop-slope').val();
                var resa = div.find('#resa').val();
                var clearway = div.find('#clearway').val();
                var surface = div.find('#surface').val();
                var strength = div.find('#strength').val();
                var asda = div.find('#asda').val();
                var lda = div.find('#lda').val();

                var submit = $(this);
                submit.prop('disabled', true);

                $.ajax({
                    url : '{{url('add-detail-rwd-detail')}}',
                    type : 'POST',
                    data : {
                        'rd_id' : rd_id,
                        'designator' : designator,
                        'heading' : heading,
                        'entrypad' : entrypad,
                        'tarea' : tarea,
                        'slope' : slope,
                        'telev' : telev,
                        'tlatlong' : tlatlong,
                        'tora' : tora,
                        'toda' : toda,
                        'stop_dimens' : stop_dimens,
                        'stop_slope' : stop_slope,
                        'resa' : resa,
                        'clearway' : clearway,
                        'surface' : surface,
                        'strength' : strength,
                        'asda' : asda,
                        'lda' : lda,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            $('.close').click();

                            div_detaildata.addClass("disabledbox");
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            submit.prop('disabled', false);

                            new PNotify({
                                title: "Error!",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            $('.save-rwd-detail').click(function () {
                var div = $(this).closest('.rwd-detail');

                var id = div.find('#id').val();
                var designator = div.find('#designator').val();
                var heading = div.find('#heading').val();
                var entrypad = div.find('#entrypad').val();
                var tarea = div.find('#tarea').val();
                var slope = div.find('#slope').val();
                var telev = div.find('#telev').val();
                var tlatlong = div.find('#tlatlong').val();
                var tora = div.find('#tora').val();
                var toda = div.find('#toda').val();
                var stop_dimens = div.find('#stop-dimens').val();
                var stop_slope = div.find('#stop-slope').val();
                var resa = div.find('#resa').val();
                var clearway = div.find('#clearway').val();
                var surface = div.find('#surface').val();
                var strength = div.find('#strength').val();
                var asda = div.find('#asda').val();
                var lda = div.find('#lda').val();

                $.ajax({
                    url : '{{url('update-detail-rwd-detail')}}',
                    type : 'POST',
                    data : {
                        'id' : id,
                        'designator' : designator,
                        'heading' : heading,
                        'entrypad' : entrypad,
                        'tarea' : tarea,
                        'slope' : slope,
                        'telev' : telev,
                        'tlatlong' : tlatlong,
                        'tora' : tora,
                        'toda' : toda,
                        'stop_dimens' : stop_dimens,
                        'stop_slope' : stop_slope,
                        'resa' : resa,
                        'clearway' : clearway,
                        'surface' : surface,
                        'strength' : strength,
                        'asda' : asda,
                        'lda' : lda,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            div_detaildata.addClass("disabledbox");
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            new PNotify({
                                title: "Error!",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            $('.delete-rwd-detail').click(function () {
                var div = $(this).closest('.rwd-detail');
                var id = div.find('#id').val();

                (new PNotify({
                    title: 'Confirmation Needed',
                    text: 'Are you sure want to delete?',
                    icon: 'glyphicon glyphicon-question-sign',
                    type: 'error',
                    hide: false,
                    confirm: {
                        confirm: true
                    },
                    buttons: {
                        closer: false,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                })).get().on('pnotify.confirm', function() {
                    $.ajax({
                        url : '{{url('delete-detail-rwd-detail')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_detaildata.addClass("disabledbox");

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });

                            location.reload();
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });

//            Taxiway Data
            $('.submit-taxiway').click(function () {
                var div = $(this).closest('.form-horizontal');
                var name = div.find('#name').val();
                var dimension = div.find('#dimension').val();
                var long_slope = div.find('#long-slope').val();
                var trans_slope = div.find('#trans-slope').val();
                var strength = div.find('#strength').val();
                var surface = div.find('#surface').val();

                var submit = $(this);
                submit.prop('disabled', true);

                $.ajax({
                    url : '{{url('add-detail-taxiway')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'taxiway_name' : name,
                        'dimension' : dimension,
                        'longitudinal_slope' : long_slope,
                        'transverse_slope' : trans_slope,
                        'strength' : strength,
                        'surface' : surface,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            $('.close').click();

                            div_detaildata.addClass("disabledbox");
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            submit.prop('disabled', false);

                            new PNotify({
                                title: "Error!",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            $('.save-taxiway').click(function () {
                var tr = $(this).closest('tr');

                var id = tr.find('#id').val();
                var name = tr.find('#name').val();
                var dimension = tr.find('#dimension').val();
                var long_slope = tr.find('#long-slope').val();
                var trans_slope = tr.find('#trans-slope').val();
                var strength = tr.find('#strength').val();
                var surface = tr.find('#surface').val();

                $.ajax({
                    url : '{{url('update-detail-taxiway')}}',
                    type : 'POST',
                    data : {
                        'id' : id,
                        'name' : name,
                        'dimension' : dimension,
                        'long_slope' : long_slope,
                        'trans_slope' : trans_slope,
                        'strength' : strength,
                        'surface' : surface,
                        '_token' : '{{csrf_token()}}'
                    },
                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

            $('.delete-taxiway').click(function () {
                var tr = $(this).closest('tr');
                var id = tr.find('#id').val();

                (new PNotify({
                    title: 'Confirmation Needed',
                    text: 'Are you sure want to delete?',
                    icon: 'glyphicon glyphicon-question-sign',
                    type: 'error',
                    hide: false,
                    confirm: {
                        confirm: true
                    },
                    buttons: {
                        closer: false,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                })).get().on('pnotify.confirm', function() {
                    $.ajax({
                        url : '{{url('delete-detail-taxiway')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_detaildata.addClass("disabledbox");

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });

                            location.reload();
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });

//            Apron Data
            $('.submit-apron').click(function () {
                var div = $(this).closest('.form-horizontal');
                var name = div.find('#name').val();
                var dimension = div.find('#dimension').val();
                var slope = div.find('#slope').val();
                var strength = div.find('#strength').val();
                var surface = div.find('#surface').val();

                var submit = $(this);
                submit.prop('disabled', true);

                $.ajax({
                    url : '{{url('add-detail-apron')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'apron_name' : name,
                        'dimension' : dimension,
                        'slope' : slope,
                        'apron_strength' : strength,
                        'apron_surface' : surface,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            $('.close').click();

                            div_detaildata.addClass("disabledbox");
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            submit.prop('disabled', false);

                            new PNotify({
                                title: "Error!",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            $('.save-apron').click(function () {
                var tr = $(this).closest('tr');

                var id = tr.find('#id').val();
                var name = tr.find('#name').val();
                var dimension = tr.find('#dimension').val();
                var slope = tr.find('#slope').val();
                var strength = tr.find('#strength').val();
                var surface = tr.find('#surface').val();

                $.ajax({
                    url : '{{url('update-detail-apron')}}',
                    type : 'POST',
                    data : {
                        'id' : id,
                        'name' : name,
                        'dimension' : dimension,
                        'slope' : slope,
                        'strength' : strength,
                        'surface' : surface,
                        '_token' : '{{csrf_token()}}'
                    },
                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

            $('.delete-apron').click(function () {
                var tr = $(this).closest('tr');
                var id = tr.find('#id').val();

                (new PNotify({
                    title: 'Confirmation Needed',
                    text: 'Are you sure want to delete?',
                    icon: 'glyphicon glyphicon-question-sign',
                    type: 'error',
                    hide: false,
                    confirm: {
                        confirm: true
                    },
                    buttons: {
                        closer: false,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                })).get().on('pnotify.confirm', function() {
                    $.ajax({
                        url : '{{url('delete-detail-apron')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_detaildata.addClass("disabledbox");

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });

                            location.reload();
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });

//            Apron Marking Data
            $('#save-apm').click(function () {
                var div_apm = $(this).closest('#apronmarkingdata');
                var edge = div_apm.find('#edge').val();
                var guidance = div_apm.find('#guidance').val();
                var park_stand = div_apm.find('#park-stand').val();
                var ac_nsp = div_apm.find('#ac-nsp').val();

                $.ajax({
                    url : '{{url('update-detail-apm')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'edge' : edge,
                        'guidance' : guidance,
                        'park_stand' : park_stand,
                        'ac_nsp' : ac_nsp,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

//            Runway Marking Data
            $('#save-rwm').click(function () {
                var div_rwm = $(this).closest('#runwaymarkingdata');
                var designation = div_rwm.find('#designation').val();
                var threshold = div_rwm.find('#threshold').val();
                var centerline = div_rwm.find('#centerline').val();
                var sidestrip = div_rwm.find('#sidestrip').val();
                var touchdown = div_rwm.find('#touchdown').val();
                var aimpoint = div_rwm.find('#aimpoint').val();
                var nw_guidance = div_rwm.find('#nw-guidance').val();

                $.ajax({
                    url : '{{url('update-detail-rwm')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'designation' : designation,
                        'threshold' : threshold,
                        'centerline' : centerline,
                        'sidestrip' : sidestrip,
                        'touchdown' : touchdown,
                        'aimpoint' : aimpoint,
                        'nw_guidance' : nw_guidance,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

//            Taxiway Marking Data
            $('#save-txm').click(function () {
                var div_txm = $(this).closest('#taxiwaymarkingdata');
                var centerline = div_txm.find('#centerline').val();
                var holdpos = div_txm.find('#holdpos').val();
                var edge = div_txm.find('#edge').val();
                var xguideline = div_txm.find('#xguideline').val();

                $.ajax({
                    url : '{{url('update-detail-txm')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'centerline' : centerline,
                        'holdpos' : holdpos,
                        'edge' : edge,
                        'xguideline' : xguideline,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

//            Lightning Data
            $('#save-lightning').click(function () {
                var div_lightning = $(this).closest('#lightningdata');
                var runway = div_lightning.find('#runway').val();
                var approach = div_lightning.find('#approach').val();
                var reil = div_lightning.find('#reil').val();
                var threshold = div_lightning.find('#threshold').val();
                var papi = div_lightning.find('#papi').val();
                var taxiway = div_lightning.find('#taxiway').val();
                var apron = div_lightning.find('#apron').val();
                var flood = div_lightning.find('#flood').val();

                $.ajax({
                    url : '{{url('update-detail-lightning')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'runway' : runway,
                        'approach' : approach,
                        'reil' : reil,
                        'threshold' : threshold,
                        'papi' : papi,
                        'taxiway' : taxiway,
                        'apron' : apron,
                        'flood' : flood,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

//            Fire Fighting Facility
            $('#save-fffac').click(function () {
                var div_fffac = $(this).closest('#firefightingfac');
                var categories = div_fffac.find('#categories').val();
                var pkpkk = div_fffac.find('#pkpkk').val();
                var ambulance = div_fffac.find('#ambulance').val();
                var command = div_fffac.find('#command').val();
                var rescue = div_fffac.find('#rescue').val();
                var personil = div_fffac.find('#personil').val();

                $.ajax({
                    url : '{{url('update-detail-fffac')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'categories' : categories,
                        'pkpkk' : pkpkk,
                        'ambulance' : ambulance,
                        'command' : command,
                        'rescue' : rescue,
                        'personil' : personil,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

//            Communication
            $('#save-comm').click(function () {
                var div_comm = $(this).closest('#communication');
                var vhf = div_comm.find('#vhf').val();
                var ssb = div_comm.find('#ssb').val();
                var aftn = div_comm.find('#aftn').val();
                var direct = div_comm.find('#direct').val();

                $.ajax({
                    url : '{{url('update-detail-comm')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'vhf' : vhf,
                        'ssb' : ssb,
                        'aftn' : aftn,
                        'direct' : direct,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

//            Meteorology Equipment
            $('#save-meteoeq').click(function () {
                var div_meteoeq = $(this).closest('#meteorlogyeq');
                var anemometer = div_meteoeq.find('#anemometer').val();
                var barometer = div_meteoeq.find('#barometer').val();
                var barograph = div_meteoeq.find('#barograph').val();
                var wbdb_therm = div_meteoeq.find('#wbdb-therm').val();
                var therm_max = div_meteoeq.find('#therm-max').val();
                var therm_min = div_meteoeq.find('#therm-min').val();
                var fisicometer = div_meteoeq.find('#fisicometer').val();
                var windshock = div_meteoeq.find('#windshock').val();
                var weather = div_meteoeq.find('#weather').val();
                var rvr = div_meteoeq.find('#rvr').val();

                $.ajax({
                    url : '{{url('update-detail-meteoeq')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'anemometer' : anemometer,
                        'barometer' : barometer,
                        'barograph' : barograph,
                        'wbdb_therm' : wbdb_therm,
                        'therm_max' : therm_max,
                        'therm_min' : therm_min,
                        'fisicometer' : fisicometer,
                        'windshock' : windshock,
                        'weather' : weather,
                        'rvr' : rvr,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });


//            Obstacle Data
            var obstacle_id = '';

            $('.obs-button').click(function () {
                obstacle_id = $(this).closest('button').find('#id').val();
            });

            $('#submit-obstacle').click(function () {
                var div = $(this).closest('.form-horizontal');
                var to = div.find('#to').val();
                var app = div.find('#app').val();

                var submit = $(this);
                submit.prop('disabled', true);

                $.ajax({
                    url : '{{url('add-detail-obs')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'to' : to,
                        'app' : app,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            $('.close').click();

                            div_detaildata.addClass("disabledbox");
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            submit.prop('disabled', false);

                            new PNotify({
                                title: "Error!",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            $('.save-obstacle').click(function () {
                var div = $(this).closest('.obstacle-detail');

                var obs_id = div.find('#id').val();
                var to = div.find('#to').val();
                var app = div.find('#app').val();

                var count_obstacle = div.find('#count-obstacle').val();
                var array_id = [];
                var array_obstacle = [];
                var array_latlong = [];
                var array_height = [];
                var array_distfrom = [];
                var array_distcenter = [];

                for(var i = 1 ; i <= count_obstacle ; i++){
                    var id = div.find('#id-'+i+'').val();
                    var obstacle = div.find('#obstacle-'+i+'').val();
                    var latlong = div.find('#latlong-'+i+'').val();
                    var height = div.find('#height-'+i+'').val();
                    var distfrom = div.find('#distfrom-'+i+'').val();
                    var distcenter = div.find('#distcenter-'+i+'').val();

                    array_id.push(id);
                    array_obstacle.push(obstacle);
                    array_latlong.push(latlong);
                    array_height.push(height);
                    array_distfrom.push(distfrom);
                    array_distcenter.push(distcenter);
                }

                $.ajax({
                    url : '{{url('update-detail-obs')}}',
                    type : 'POST',
                    data : {
                        'obs_id' : obs_id,
                        'to' : to,
                        'app' : app,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){}
                });

                $.ajax({
                    url : '{{url('update-detail-obs-detail')}}',
                    type : 'POST',
                    data : {
                        'array_id' : array_id,
                        'array_obstacle' : array_obstacle,
                        'array_latlong' : array_latlong,
                        'array_height' : array_height,
                        'array_distfrom' : array_distfrom,
                        'array_distcenter' : array_distcenter,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

            $('.delete-obstacle').click(function () {
                var div = $(this).closest('.obstacle-detail');
                var id = div.find('#id').val();

                (new PNotify({
                    title: 'Confirmation Needed',
                    text: 'Are you sure want to delete?',
                    icon: 'glyphicon glyphicon-question-sign',
                    type: 'error',
                    hide: false,
                    confirm: {
                        confirm: true
                    },
                    buttons: {
                        closer: false,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                })).get().on('pnotify.confirm', function() {
                    $.ajax({
                        url : '{{url('delete-detail-obs')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_detaildata.addClass("disabledbox");

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });

                            location.reload();
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });

            $('.submit-obstacle-detail').click(function () {
                var div = $(this).closest('.form-horizontal');

                var obstacle = div.find('#obstacle').val();
                var latlong = div.find('#latlong').val();
                var height = div.find('#height').val();
                var dist_from = div.find('#dist-from').val();
                var dist_center = div.find('#dist-center').val();

                var submit = $(this);
                submit.prop('disabled', true);

                $.ajax({
                    url : '{{url('add-detail-obs-detail')}}',
                    type : 'POST',
                    data : {
                        'obstacle_id' : obstacle_id,
                        'obstacle' : obstacle,
                        'latlong' : latlong,
                        'height' : height,
                        'dist_from' : dist_from,
                        'dist_center' : dist_center,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            $('.close').click();

                            div_detaildata.addClass("disabledbox");
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            submit.prop('disabled', false);

                            new PNotify({
                                title: "Error!",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            $('.delete-obstacle-detail').click(function () {
                var tr = $(this).closest('tr');
                var id = tr.find('#id').val();

                (new PNotify({
                    title: 'Confirmation Needed',
                    text: 'Are you sure want to delete?',
                    icon: 'glyphicon glyphicon-question-sign',
                    type: 'error',
                    hide: false,
                    confirm: {
                        confirm: true
                    },
                    buttons: {
                        closer: false,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                })).get().on('pnotify.confirm', function() {
                    $.ajax({
                        url : '{{url('delete-detail-obs-detail')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_detaildata.addClass("disabledbox");

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });

                            location.reload();
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });

//            Navigation Facility
            $('.submit-nav').click(function () {
                var div = $(this).closest('.form-horizontal');
                var navaids = div.find('#navaids').val();
                var category = div.find('#category').val();
                var freq = div.find('#freq').val();
                var course = div.find('#course').val();
                var latlong = div.find('#latlong').val();
                var channel = div.find('#channel').val();

                var submit = $(this);
                submit.prop('disabled', true);

                $.ajax({
                    url : '{{url('add-detail-nav')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'navaids' : navaids,
                        'category' : category,
                        'frequency' : freq,
                        'course' : course,
                        'lat_long' : latlong,
                        'channel' : channel,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            $('.close').click();

                            div_detaildata.addClass("disabledbox");
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            submit.prop('disabled', false);

                            new PNotify({
                                title: "Error!",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            $('.save-nav').click(function () {
                var tr = $(this).closest('tr');

                var id = tr.find('#id').val();
                var navaids = tr.find('#navaids').val();
                var category = tr.find('#category').val();
                var freq = tr.find('#freq').val();
                var course = tr.find('#course').val();
                var latlong = tr.find('#latlong').val();
                var channel = tr.find('#channel').val();

                $.ajax({
                    url : '{{url('update-detail-nav')}}',
                    type : 'POST',
                    data : {
                        'id' : id,
                        'navaids' : navaids,
                        'category' : category,
                        'freq' : freq,
                        'course' : course,
                        'latlong' : latlong,
                        'channel' : channel,
                        '_token' : '{{csrf_token()}}'
                    },
                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

            $('.delete-nav').click(function () {
                var tr = $(this).closest('tr');
                var id = tr.find('#id').val();

                (new PNotify({
                    title: 'Confirmation Needed',
                    text: 'Are you sure want to delete?',
                    icon: 'glyphicon glyphicon-question-sign',
                    type: 'error',
                    hide: false,
                    confirm: {
                        confirm: true
                    },
                    buttons: {
                        closer: false,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                })).get().on('pnotify.confirm', function() {
                    $.ajax({
                        url : '{{url('delete-detail-nav')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_detaildata.addClass("disabledbox");

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });

                            location.reload();
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });

//            Instrument Approach Procedure
            $('#save-iaproc').click(function () {
                var div_iaproc = $(this).closest('#instrumentappproc');
                var iap = div_iaproc.find('#iap').val();
                var remarks = div_iaproc.find('#remarks').val();

                $.ajax({
                    url : '{{url('update-detail-iaproc')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'iap' : iap,
                        'remarks' : remarks,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_detaildata.addClass("disabledbox");

                        new PNotify({
                            title: "Success!",
                            text: response.success,
                            type: 'success',
                            delay: 2000
                        });

                        location.reload();
                    }
                });
            });

            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('.fixed-button').fadeIn();
                } else {
                    $('.fixed-button').fadeOut();
                }
            });
            $('.fixed-button').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 500);
                return false;
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
