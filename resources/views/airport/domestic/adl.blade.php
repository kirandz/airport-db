@extends('layouts.app')

@section('page_heading', 'Domestic')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Airport Data</li>
        <li><a href="{{url('airport-dom')}}">Domestic</a></li>
        <li class="active">ADL</li>
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
                        <li><a href="{{url('airport-dom/generaldata/'.$airport->id)}}">General Data</a></li>
                        <li><a href="{{url('airport-dom/detaildata/'.$airport->id)}}">Detail Data</a></li>
                        <li><a href="{{url('airport-dom/document/'.$airport->id)}}">Document</a></li>
                        <li class="active"><a href="#">Airport Data Limitation (ADL)</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="adl" style="display: none">
                            <h4 style="text-align: center">
                                <b>The Worst Strength</b>
                            </h4>
                            <button class="btn btn-link rwd-button" data-toggle="modal" data-target="#new-rws" style="float: left">
                                <i class="fa fa-plus"></i> New Runway Strength
                            </button>

                            @if(count($runway_strengths) > 0)
                                @foreach($runway_strengths as $runway_strength)
                                    <div class="rws">
                                        <input type="hidden" id="rws-id" value="{{$runway_strength->id}}">

                                        <button class="btn btn-link delete-rws" style="float: right;">
                                            <i class="fa fa-btn fa-trash"></i> Remove
                                        </button>
                                        <button class="btn btn-link save save-rws" style="float: right;display: none">
                                            <i class="fa fa-btn fa-save"></i> Save
                                        </button>
                                        <button class="btn btn-link update" style="float: right;">
                                            <i class="fa fa-btn fa-edit"></i> Update
                                        </button>

                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Runway</th>
                                                <td colspan="2">
                                                    <span class="txt-view" id="s-code">{{$runway_strength->runway_code}}</span>
                                                    <input type="hidden" id="code" value="{{$runway_strength->runway_code}}" class="form-control txt-fill" style="width: 41%">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Aircraft Type</th>
                                                <th>Strength</th>
                                                <th>Note</th>
                                            </tr>

                                            <?php $count_rws_detail = 0;?>
                                            @foreach($aircraft_types as $aircraft_type)
                                                <tr>
                                                    <td width="30%">{{$aircraft_type->type}}</td>

                                                    <?php $strength = ""; $note = ""; $rws_id = ""?>

                                                    @foreach($runway_strength_details as $runway_strength_detail)
                                                        @if($runway_strength_detail->rs_id == $runway_strength->id && $runway_strength_detail->aircraft_id == $aircraft_type->id)
                                                            <?php $strength = $runway_strength_detail->strength; $note = $runway_strength_detail->note; $rws_id = $runway_strength_detail->id?>
                                                            @break;
                                                        @endif
                                                    @endforeach

                                                    <td width="30%">
                                                        <span class="txt-view" id="s-strength-{{$count_rws_detail}}">{{$strength}}</span>
                                                        <input type="hidden" id="strength-{{$count_rws_detail}}" value="{{$strength}}" class="form-control txt-fill" style="width: 100%">
                                                    </td>
                                                    <td width="40%">
                                                        <span class="txt-view" id="s-note-{{$count_rws_detail}}">{{$note}}</span>
                                                        <input type="hidden" id="note-{{$count_rws_detail}}" value="{{$note}}" class="form-control txt-fill" style="width: 100%">
                                                    </td>
                                                </tr>

                                                <input type="hidden" id="rws-detail-id-{{$count_rws_detail}}" value="{{$rws_id}}">
                                                <input type="hidden" id="actype-id-{{$count_rws_detail}}" value="{{$aircraft_type->id}}">

                                                <?php $count_rws_detail++; ?>
                                            @endforeach

                                            <input type="hidden" id="count-rws-detail" value="{{$count_rws_detail}}">
                                        </table>
                                    </div>
                                @endforeach
                            @else
                                <table class="table table-bordered">
                                    <tr>
                                        <td style="text-align: center">No data avaible in table</td>
                                    </tr>
                                </table>
                            @endif
                            <br>

                            @foreach($runway_dimensions as $runway_dimension)
                                @foreach($runway_dimension_details as $runway_dimension_detail)
                                    @if($runway_dimension->id == $runway_dimension_detail->rd_id)
                                        <?php
                                        if(substr($runway_dimension_detail->stopway_dimens, 0, strpos($runway_dimension_detail->stopway_dimens, ' ')) == ''){
                                            $stopway = $runway_dimension_detail->stopway_dimens;
                                        }
                                        else{
                                            $stopway = substr($runway_dimension_detail->stopway_dimens, 0, strpos($runway_dimension_detail->stopway_dimens, ' '));
                                        }
                                        if(substr($runway_dimension_detail->clearway, 0, strpos($runway_dimension_detail->clearway, ' ')) == ''){
                                            $clearway = $runway_dimension_detail->clearway;
                                        }
                                        else{
                                            $clearway = substr($runway_dimension_detail->clearway, 0, strpos($runway_dimension_detail->clearway, ' '));
                                        }
                                        if(substr($runway_dimension_detail->resa, 0, strpos($runway_dimension_detail->resa, ' ')) == ''){
                                            $resa = $runway_dimension_detail->resa;
                                        }
                                        else{
                                            $resa = substr($runway_dimension_detail->resa, 0, strpos($runway_dimension_detail->resa, ' '));
                                        }
                                        if(substr($runway_dimension_detail->tora, 0, strpos($runway_dimension_detail->tora, ' ')) == ''){
                                            $tora = $runway_dimension_detail->tora;
                                        }
                                        else{
                                            $tora  = substr($runway_dimension_detail->tora, 0, strpos($runway_dimension_detail->tora, ' '));
                                        }
                                        if(((int)$stopway + (int)$resa) >= 90){
                                            $x = 0;
                                        }
                                        else{
                                            $x = 90;
                                        }
                                        $tora_resa = ((int)$tora - $x);
                                        ?>

                                        <h4 style="text-align: center">
                                            <b>Runway Designator {{$runway_dimension_detail->designator}}</b>
                                        </h4>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th colspan="2">TORA(FULL)</th>
                                                <th>TORA(RESA)</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{$tora}}</td>
                                                <td>{{$tora_resa}}</td>
                                            </tr>
                                            <tr>
                                                <th>Stopway</th>
                                                <th>Clearway</th>
                                                <th>RESA</th>
                                            </tr>
                                            <tr>
                                                <td>{{$stopway}}</td>
                                                <td>{{$clearway}}</td>
                                                <td>{{$resa}}</td>
                                            </tr>
                                        </table>

                                        <table class="table table-bordered">
                                            <tr>
                                                <th rowspan="2" style="vertical-align: middle;">Height(ft)</th>
                                                <th colspan="2">Distance</th>
                                            </tr>
                                            <tr>
                                                <th>FULL</th>
                                                <th>RESA</th>
                                            </tr>
                                            <?php $count_row = 0;?>
                                            @foreach($obstacles as $obstacle)
                                                @foreach($obstacle_details as $obstacle_detail)
                                                    @if($obstacle->to_runway == $runway_dimension_detail->designator && $obstacle->id == $obstacle_detail->obstacle_id)
                                                        <?php $count_row++;?>
                                                        <tr>
                                                            <?php
                                                            if(substr($obstacle_detail->dist_from_rwy, 0, strpos($obstacle_detail->dist_from_rwy, ' ')) == ''){
                                                                $dis_from = $obstacle_detail->dist_from_rwy;
                                                            }
                                                            else{
                                                                $dis_from = substr($obstacle_detail->dist_from_rwy, 0, strpos($obstacle_detail->dist_from_rwy, ' '));
                                                            }
                                                            $dist_from_resa = ((int)$dis_from - $x);
                                                            ?>
                                                            <td>{{$obstacle_detail->height}}</td>
                                                            <td>{{$dis_from}}</td>
                                                            <td>{{$dist_from_resa}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            @if($count_row == 0)
                                                <tr>
                                                    <td style="text-align: center" colspan="3">No data avaible in table</td>
                                                </tr>
                                            @endif
                                        </table>
                                            <br>
                                    @endif
                                @endforeach
                            @endforeach

                            <a href="{{url('download-adl/'.$airport->id)}}" class="btn btn-default download" target="_blank" style="float: right"><i class="fa fa-download"></i> Download ADL (.xlsx)</a>
                            <br><br>
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

    <div class="modal fade" id="new-rws" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="float: left">New Runway Strength</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code" class="col-md-4 control-label">Runway Code</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control" name="code" placeholder="Runway Code">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit-rws">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="airport-id" value="{{$airport->id}}">

    @if(Auth::user()->role_name == 'viewer')
        <input type="hidden" id="flag" value="1">
    @endif

    <script>
        var flag = $('#flag').val();

        if(flag === '1'){
            $('button').remove();
        }

        $(document).ready(function() {
            var div_adl = $('#adl');
            var id = $('#airport-id').val();

            div_adl.prop('style', '');

//            Update
            $('.update').click(function () {
                var div = $(this).closest('div');

                div.find('.update').prop('style', 'float: right;display: none');
                div.find('.save').prop('style', 'float: right;display: inline');
                div.find('.txt-view').prop('hidden', true);
                div.find('.txt-fill').prop('type', 'text');
                div.find('.txt-fill-date').prop('type', 'date');
                div.find('.field-upload').prop('type', 'file');
                div.find('.txt-fill-area').prop('readonly', false).prop('style', '');
            });

//            Save
            $('.save').click(function () {
                var div = $(this).closest('div');

                div.find('.update').prop('style', 'float: right;display: inline');
                div.find('.save').prop('style', 'float: right;display: none');
                div.find('.txt-view').prop('hidden', false);
                div.find('.txt-fill').prop('type', 'hidden');
                div.find('.field-upload').prop('type', 'hidden');
                div.find('.txt-fill-area').prop('readonly', true).prop('style', 'border: none');
                div_adl.addClass("disabledbox");
            });

//            The Wors Strength
            $('#submit-rws').click(function () {
                var div = $(this).closest('.form-horizontal');
                var code = div.find('#code').val();

                console.log(id, code);

                $.ajax({
                    url : '{{url('add-adl-rws')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'runway_code' : code,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            $('.close').click();

                            div_adl.addClass("disabledbox");
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

            $('.save-rws').click(function () {
                var div = $(this).closest('.rws');
                var rs_id = div.find('#rws-id').val();
                var code = div.find('#code').val();

                var count_rwsd = $('#count-rws-detail').val();
                var array_rws_detail_id = [];
                var array_actype_id = [];
                var array_strength = [];
                var array_note = [];


                for(var i = 0 ; i < count_rwsd ; i++){
                    var rws_detail_id = div.find('#rws-detail-id-'+i+'').val();
                    var actype_id = div.find('#actype-id-'+i+'').val();
                    var strength = div.find('#strength-'+i+'').val();
                    var note = div.find('#note-'+i+'').val();

                    array_rws_detail_id.push(rws_detail_id);
                    array_actype_id.push(actype_id);
                    array_strength.push(strength);
                    array_note.push(note);
                }

                $.ajax({
                    url : '{{url('update-adl-rws')}}',
                    type : 'POST',
                    data : {
                        'airport_id' : id,
                        'rs_id' : rs_id,
                        'code' : code,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){}
                });

                console.log(array_rws_detail_id, array_actype_id, array_strength,array_note) ;

                $.ajax({
                    url : '{{url('update-adl-rws-detail')}}',
                    type : 'POST',
                    data : {
                        'rs_id' : rs_id,
                        'array_rws_detail_id' : array_rws_detail_id,
                        'array_actype_id' : array_actype_id,
                        'array_strength' : array_strength,
                        'array_note' : array_note,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(response){
                        div_adl.addClass("disabledbox");

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

            $('.delete-rws').click(function () {
                var div = $(this).closest('.rws');
                var id = div.find('#rws-id').val();

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
                        url : '{{url('delete-adl-rws')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            div_adl.addClass("disabledbox");

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
        });
    </script>
@stop