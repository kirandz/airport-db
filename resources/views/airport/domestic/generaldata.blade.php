@extends('layouts.app')

@section('page_heading', 'Domestic')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Airport Data</li>
        <li><a href="{{url('airport-dom')}}">Domestic</a></li>
        <li class="active">General Data</li>
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
    </style>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#">General Data</a></li>
                        <li><a href="{{url('airport-dom/detaildata/'.$airport->id)}}">Detail Data</a></li>
                        <li><a href="{{url('airport-dom/document/'.$airport->id)}}">Document</a></li>
                        <li><a href="{{url('airport-dom/adl/'.$airport->id)}}">Airport Data Limitation (ADL)</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="generaldata" style="display: none">
                            <h4 style="text-align: center">
                                <b>Airport Data</b>
                            </h4>
                            <button class="btn btn-link save" style="float: right;display: none"><i class="fa fa-save"></i> Save</button>
                            <button class="btn btn-link update" style="float: right"><i class="fa fa-edit"></i> Update</button>
                            {{--<a href="{{url('print-airportdata/'.$airport->id)}}" class="btn btn-link print" target="_blank" style="float: right; display: none"><i class="fa fa-print"></i> Print</a>--}}
                            <table class="table  table-bordered" id="airport-table" style="width: 100%" hidden>
                                <tr>
                                    <th width="30%">Airport Name</th>
                                    <td>
                                        <span class="txt-view" id="s-name">{{$airport->name}}</span>
                                        <input type="hidden" id="name" value="{{$airport->name}}" class="form-control txt-fill" style="width: 30%">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">Effective Date</th>
                                    <td>
                                        <?php $date = date('d F Y', strtotime($airport->effective_date));?>
                                        <span class="txt-view" id="s-effective-date">
                                            @if($airport->effective_date != null && $airport->effective_date != '')
                                                {{$date}}
                                            @endif
                                        </span>
                                        <input type="hidden" id="effective-date" value="{{$airport->effective_date}}" class="form-control txt-fill-date" style="width: 30%">
                                    </td>
                                </tr>
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
                                    <th width="30%">City / Province</th>
                                    <td>
                                        <span class="txt-view" id="s-city">{{$airport->city}}</span>
                                        <input type="hidden" id="city" value="{{$airport->city}}" class="form-control txt-fill" style="width: 30%">/
                                        <span class="txt-view" id="s-province">{{$airport->province}}</span>
                                        <input type="hidden" id="province" value="{{$airport->province}}" class="form-control txt-fill" style="width: 30%">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">Runway Dimension</th>
                                    <td>
                                    <?php $check = 0; $count = 0;?>
                                    @foreach($runway_dimensions as $runway_dimension)
                                        <div id="runway-dimens">
                                            <?php $check++; $count++?>
                                            <table width="100%" style="margin-bottom: 10px">
                                                <tr>
                                                    <td width="50%">
                                                        <span class="txt-view s-rwd">{{$runway_dimension->dimension}}</span>
                                                        <input type="hidden" id="rwd-id" value="{{$runway_dimension->id}}">
                                                        <button class="btn-link rw-button delete" data-toggle="tooltip" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                    <td width="50%">
                                                        @if($check <= 1)
                                                            <button class="btn btn-link rw-button" data-toggle="modal" data-target="#new-rwd" style="float: right"><i class="fa fa-plus"></i> New Runway Dimension</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>

                                            <input type="hidden" id="rwd-{{$count}}" value="{{$runway_dimension->dimension}}" class="form-control txt-fill rw-dimension" style="width: 30%">
                                        </div>
                                    @endforeach

                                    @if($check == 0)
                                        <button class="btn btn-link rw-button" data-toggle="modal" data-target="#new-rwd" style="float: right"><i class="fa fa-plus"></i> New Runway Dimension</button>
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Taxiway</th>
                                    <td>{{$total_taxiway}}</td>
                                </tr>
                                <tr>
                                    <th>Total Apron</th>
                                    <td>{{$total_apron}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Operation Time</th>
                                    <td>
                                        <span class="txt-view" id="s-operation-ts">{{$airport->operation_time_start}}</span>
                                        <input type="hidden" id="operation-ts" value="{{$airport->operation_time_start}}" class="form-control txt-fill" style="width: 30%">-
                                        <span class="txt-view">{{$airport->operation_time_end}}</span>
                                        <input type="hidden" id="operation-te" value="{{$airport->operation_time_end}}" class="form-control txt-fill" style="width: 30%">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">Total Parking Stand</th>
                                    <td>{{$total_ap_capacity}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Comply to Aircraft Type</th>
                                    <td>
                                        <?php $count = 1;?>
                                        @foreach($aircraft_types as $aircraft_type)

                                            <?php $total = ""; ?>
                                            @foreach($apron_capacities as $apron_capacity)
                                                @if($apron_capacity->at_id == $aircraft_type->id)
                                                    <?php $total = $apron_capacity->total_aircraft; ?>
                                                    @break;
                                                @else
                                                    <?php $total = ""; ?>
                                                @endif
                                            @endforeach

                                            <div>
                                                <input type="hidden" id="at-id" value="{{$aircraft_type->id}}">
                                                <label for="at-{{$count-1}}" class="col-md-1" style="width: 15%">{{$aircraft_type->type}}</label>
                                                <input type="text" class="apc col-md-1" id="at-{{$count-1}}" style="text-align: center; width: 10%; margin-right: 10px" readonly value="{{$total}}">
                                            </div>

                                            @if($count%2 == 0)
                                                <br><br>
                                            @endif
                                            <?php $count++; ?>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">Ground Handling Facility</th>
                                    <td>
                                        <span class="txt-view" id="s-ground-hf">{{$airport->ground_handling_fac}}</span>
                                        <input type="hidden" id="ground-hf" value="{{$airport->ground_handling_fac}}" class="form-control txt-fill" style="width: 30%">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">Refueling Facility</th>
                                    <td>
                                        <span class="txt-view" id="s-refuel-fac">{{$airport->refuel_fac}}</span>
                                        <input type="hidden" id="refuel-fac" value="{{$airport->refuel_fac}}" class="form-control txt-fill" style="width: 30%">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">UTC Zone</th>
                                    <td>
                                        <span class="txt-view" id="s-utc">{{$airport->utc_zone}}</span>
                                        <input type="hidden" id="utc" value="{{$airport->utc_zone}}" class="form-control txt-fill" style="width: 30%">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">Owner / Manager</th>
                                    <td>
                                        <span class="txt-view" id="s-owner">{{$airport->owner}}</span>
                                        <input type="hidden" id="owner" value="{{$airport->owner}}" class="form-control txt-fill" style="width: 30%">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">Perimeter</th>
                                    <td>
                                        <span class="txt-view" id="s-parimeter">{{$airport->parimeter}}</span>
                                        <input type="hidden" id="parimeter" value="{{$airport->parimeter}}" class="form-control txt-fill" style="width: 30%">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Apron</th>
                                    <td>
                                        <?php $count = 1;?>
                                        @foreach($aircraft_types as $aircraft_type)

                                            @foreach($apron_capacities as $apron_capacity)
                                                @if($apron_capacity->at_id == $aircraft_type->id)
                                                    <?php $total = $apron_capacity->total_aircraft; ?>
                                                    @break;
                                                @else
                                                    <?php $total = 0; ?>
                                                @endif
                                            @endforeach

                                            @if($total > 0)
                                                <input type="checkbox" id="aircraft-type" class="col-md-1" checked onclick="return false;">
                                                <label class="col-md-2" for="aircraft-type">{{$aircraft_type->type}}</label>
                                            @else
                                                <input type="checkbox" id="aircraft-type" class="col-md-1" onclick="return false;">
                                                <label class="col-md-2" for="aircraft-type">{{$aircraft_type->type}}</label>
                                            @endif

                                            @if($count%2 == 0)
                                                <br><br>
                                            @endif
                                            <?php $count++; ?>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Remarks</th>
                                    <td>
                                        <textarea id="remarks" class="txt-fill-area" cols="100" rows="7" readonly style="border: none">{{$airport->remarks}}</textarea>
                                    </td>
                                </tr>
                            </table>
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

    <div class="modal fade" id="new-rwd" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="float: left">New Runway Dimension</h4>
                        <br>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('dimension') ? ' has-error' : '' }}">
                            <label for="dimension" class="col-md-4 control-label">Runway Dimension</label>

                            <div class="col-md-6">
                                <input id="m-dimension" type="text" class="form-control" name="dimension" placeholder="Runway Dimension">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{$airport->id}}" id="airport-id">

    @if(Auth::user()->role_name == 'viewer')
        <input type="hidden" id="flag" value="1">
    @endif

    <script>
        var flag = $('#flag').val();

        if(flag === '1'){
            $('button').remove();
        }

        $(document).ready(function() {
            var table = $('#airport-table');
            var remarks = $('#remarks');
            var div_generaldata = $('#generaldata');
            var id = $('#airport-id').val();

            table.prop('hidden', false);
            div_generaldata.prop('style', '');

//            Update
            $('.update').click(function () {
                $('.update').prop('style', 'float: right;display: none');
                $('.save').prop('style', 'float: right;display: inline');
                $('.txt-view').prop('hidden', true);
                $('.txt-fill').prop('type', 'text');
                $('.txt-fill-date').prop('type', 'date');
                $('.rw-button').hide();
                $('.apc').prop('readonly', false);
                $('.txt-fill-area').prop('readonly', false).prop('style', '');
            });

//            Save
            $('.save').click(function () {
                var total_at = "<?php echo count($aircraft_types); ?>";
                var total_rd = "<?php echo count($runway_dimensions); ?>";

                var name = $('#name').val();
                var icao_code = $('#icao-code').val();
                var iata_code = $('#iata-code').val();
                var city = $('#city').val();
                var province = $('#province').val();
                var effective_date = $('#effective-date').val();
                var operation_time_start = $('#operation-ts').val();
                var operation_time_end = $('#operation-te').val();
                var ground_handling_fac = $('#ground-hf').val();
                var refuel_fac = $('#refuel-fac').val();
                var utc_zone = $('#utc').val();
                var owner = $('#owner').val();
                var parimeter = $('#parimeter').val();
                var remarks = $('#remarks').val();
                var array_rwd_id = [];
                var array_rwd_dimension = [];
                var array_at_id = [];
                var array_at_total = [];

                $('.update').prop('style', 'float: right;display: inline');
                $('.save').prop('style', 'float: right;display: none');
                $('.txt-view').prop('hidden', false);
                $('.txt-fill').prop('type', 'hidden');
                $('.txt-fill-date').prop('type', 'hidden');
                $('.rw-button').show();
                $('.apc').prop('readonly', true);
                $('.txt-fill-area').prop('readonly', true).prop('style', 'border: none');
                div_generaldata.addClass("disabledbox");

                for(var i=0 ; i<total_at ; i++){
                    var at = $('#at-'+i+'');
                    var div_apc = at.closest('div');
                    var at_id = div_apc.find('#at-id').val();
                    var at_total = at.val();

                    array_at_id.push(at_id);
                    array_at_total.push(at_total);
                }

                for(var j=1 ; j<=total_rd ; j++){
                    var rwd = $('#rwd-'+j+'');
                    var div_rwd = rwd.closest('div');
                    var rd_id = div_rwd.find('#rwd-id').val();
                    var dimension = rwd.val();

                    array_rwd_id.push(rd_id);
                    array_rwd_dimension.push(dimension);
                }

                $.ajax({
                    url : '{{url('update-totalat')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'array_at_id' : array_at_id,
                        'array_at_total' : array_at_total,
                        '_token' : '{{csrf_token()}}'
                    },
                    success: function(response){}
                });

                $.ajax({
                    url : '{{url('update-rwd')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'array_rwd_id' : array_rwd_id,
                        'array_rwd_dimension' : array_rwd_dimension,
                        '_token' : '{{csrf_token()}}'
                    },
                    success: function(response){}
                });

                $.ajax({
                    url : '{{url('update-generaldata')}}',
                    type : 'POST',
                    data : {
                        'id' : id,
                        'name' : name,
                        'icao_code' : icao_code,
                        'iata_code' : iata_code,
                        'city' : city,
                        'province' : province,
                        'effective_date' : effective_date,
                        'operation_time_start' : operation_time_start,
                        'operation_time_end' : operation_time_end,
                        'ground_handling_fac' : ground_handling_fac,
                        'refuel_fac' : refuel_fac,
                        'utc_zone' : utc_zone,
                        'owner' : owner,
                        'parimeter' : parimeter,
                        'remarks' : remarks,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
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

//            Delete Runway Dimension
            $('.delete').click(function () {
                var div_rwd = $(this).closest('div');
                var rwd_id = div_rwd.find('#rwd-id').val();

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
                        url : '{{url('delete-rwd')}}',
                        type : 'POST',
                        data : {
                            'id' : rwd_id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_generaldata.addClass("disabledbox");

                            new PNotify({
                                title: "Delete",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });

                            location.reload();
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });

//            Submit Runway Dimension
            $('.submit').click(function () {
                var div_rwd = $(this).closest('.form-horizontal');
                var dimension = div_rwd.find('#m-dimension').val();

                var submit = $(this);
                submit.prop('disabled', true);

                $.ajax({
                    url : '{{url('add-rwd')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'dimension' : dimension,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            location.reload();

                            div_generaldata.addClass("disabledbox");
                            $('.close').click();

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
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop