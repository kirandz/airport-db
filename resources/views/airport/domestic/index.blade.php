@extends('layouts.app')

@section('page_heading', 'Domestic')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Airport Data</li>
        <li class="active">Domestic</li>
    </ol>
@endsection

@section('section')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Airport Data</h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-link" data-toggle="modal" data-target="#new-airport"><i class="fa fa-plus"></i> New Airport</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-hover" id="airport-table" style="width: 100%" hidden>
                            <thead>
                            <tr>
                                <th>ICAO Code</th>
                                <th>IATA Code</th>
                                <th>Airport Name</th>
                                <th>City</th>
                                <th>Type</th>
                                <th class="action-col" style="text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($airports) > 0)
                                @foreach($airports as $airport)
                                    <tr>
                                        <input type="hidden" id="id" value="{{$airport->id}}">
                                        <td>{{$airport->icao_code}}</td>
                                        <td>{{$airport->iata_code}}</td>
                                        <td><a href="{{url('airport-dom/generaldata/'.$airport->id)}}">{{$airport->name}}</a></td>
                                        <td>{{$airport->city}}</td>
                                        <td>{{$airport->type}}</td>
                                        <td class="action-col" style="text-align: center">
                                            <button class="btn-link delete" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="new-airport" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Airport</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('airport_name') ? ' has-error' : '' }}">
                            <label for="airport_name" class="col-md-4 control-label">Airport Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="airport_name" value="{{ old('airport_name') }}" placeholder="Airport Name">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('iata_code') ? ' has-error' : '' }}">
                            <label for="iata-code" class="col-md-4 control-label">IATA Code</label>

                            <div class="col-md-6">
                                <input id="iata-code" type="text" class="form-control" name="iata_code" value="{{ old('iata_code') }}" placeholder="IATA Code">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('icao_code') ? ' has-error' : '' }}">
                            <label for="icao-code" class="col-md-4 control-label">ICAO Code</label>

                            <div class="col-md-6">
                                <input id="icao-code" type="text" class="form-control" name="icao_code" value="{{ old('icao_code') }}" placeholder="ICAO Code">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('effective_date') ? ' has-error' : '' }}">
                            <label for="effective-date" class="col-md-4 control-label">Effective Date</label>

                            <div class="col-md-6">
                                <input id="effective-date" type="date" class="form-control" name="effective_date" value="{{ old('effective_date') }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                            <label for="province" class="col-md-4 control-label">Province</label>

                            <div class="col-md-6">
                                <select name="province_id" id="province" class="form-control" style="width: 100%" disabled>
                                    <option value=""></option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}">{{$province->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="col-md-4 control-label">City</label>

                            <div class="col-md-6">
                                <select name="city" id="city" class="form-control" style="width: 100%" disabled>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">Type</label>

                            <div class="col-md-6">
                                <select name="type" id="type" class="selectpicker form-control" title="Choose Airport Type">
                                    <option value="DOM">Domestic</option>
                                    <option value="INT" disabled>International</option>
                                </select>
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

    @if(Auth::user()->role_name == 'viewer')
        <input type="hidden" id="flag" value="1">
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#airport-table');
            var overlay = $('.overlay');
            var province = $('#province');
            var city = $('#city');

            province.prop('disabled', false);
            province.select2({
                placeholder: "-Select Province-"
            });
            city.select2({
                placeholder: "-Select City-"
            });

            var flag = $('#flag').val();

            if(flag === '1'){
                $('.action-col').remove();

                table.DataTable( {
                    "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
                } );
            }
            else{
                table.DataTable( {
                    "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                    "columnDefs": [
                        { "orderable": false, "targets": 5 }
                    ]
                } );
            }

            table.prop('hidden', false);
            overlay.prop('hidden', true);

            province.change(function () {
                var id = $(this).val();
                var op = '';

                $.ajax({
                    type : 'get',
                    url : '{{url('find-city')}}',
                    data : {
                        'province_id' : id
                    },

                    success : function (data) {
                        op = '<option value=""></option>';

                        console.log(data);

                        for(var i=0;i<data.length;i++){
                            op+='<option value="'+data[i].name+'">'+data[i].name+'</option>';
                        }

                        city.prop('disabled', false);
                        city.html(" ");
                        city.append(op);
                    }
                });
            });

//            Submit
            $('.submit').click(function () {
                var div = $(this).closest('.form-horizontal');
                var name = div.find('#name').val();
                var iata_code = div.find('#iata-code').val();
                var icao_code = div.find('#icao-code').val();
                var effective_date = div.find('#effective-date').val();
                var province_id = div.find('#province').val();
                var city = div.find('#city').val();
                var type = div.find('#type').val();

                $.ajax({
                    url : '{{url('add-airport')}}',
                    type : 'POST',
                    data : {
                        'airport_name' : name,
                        'iata_code' : iata_code,
                        'icao_code' : icao_code,
                        'effective_date' : effective_date,
                        'province' : province_id,
                        'city' : city,
                        'type' : type,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            $('.close').click();

                            overlay.prop('hidden', false);
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

//            Delete
            $('.delete').click(function () {
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
                        url : '{{url('delete-airport')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            overlay.prop('hidden', false);

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

        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop