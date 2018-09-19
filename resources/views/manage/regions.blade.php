@extends('layouts.app')

@section('page_heading', 'Region')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"></a>Manage Database</li>
        <li class="active">Region</li>
    </ol>
@endsection

@section('section')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Region Data</h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-link" data-toggle="modal" data-target="#region-modal"><i class="fa fa-plus"></i> New Region</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="region-table" class="table table-striped table-bordered" style="width:100%" hidden>
                            <thead>
                            <tr>
                                <th>Province</th>
                                <th>City</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($regions as $region)
                                <tr>
                                    <input type="hidden" class="id" value="{{$region->city_id}}">
                                    <td class="">{{$region->province_name}}</td>
                                    <td class="col-update city">{{$region->city_name}}</td>
                                    <td style="text-align: center" width="10%">
                                        <button class="btn btn-link update" data-toggle="tooltip" title="Update"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-link save" data-toggle="tooltip" title="Save" style="display: none"><i class="fa fa-save"></i></button>
                                        <button class="btn btn-link delete"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></button>
                                    </td>
                                </tr>
                            @endforeach
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

    <div class="modal fade" id="region-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Region</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="province-type" class="col-md-3 control-label">Province Type</label>

                            <div class="col-md-7">
                                <select id="province-type" class="form-control">
                                    <option value="" selected disabled>-Select Type-</option>
                                    <option value="new">New Province</option>
                                    <option value="exist">Existing Province</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group province" hidden>
                            <label for="province" class="col-md-3 control-label">Province</label>

                            <div class="col-md-7 province-exist" hidden>
                                <select name="province_exist" id="province-exist" class="form-control" style="width: 100%" disabled>
                                    <option value=""></option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}">{{$province->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-7 province-new" hidden>
                                <input type="text" name="province_new" class="form-control" id="province-new" placeholder="Province">
                            </div>
                        </div>
                        <div class="form-group city" hidden>
                            <label for="city" class="col-md-3 control-label">City</label>

                            <div class="col-md-7">
                                <input type="text" class="form-control" id="city" placeholder="City">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="submit btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#region-table');
            var overlay = $('.overlay');

            table.DataTable( {
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                "columnDefs": [
                    { "orderable": false, "targets": 2 }
                ]
            } );

            table.prop('hidden', false);
            overlay.prop('hidden', true);

            var province = $('#province-exist');

            province.prop('disabled', false);
            province.select2({
                placeholder: "-Select Province-"
            });

            $('#province-type').change(function () {
                if($(this).val() === 'new'){
                    $('.province').prop('hidden', false);
                    $('.province-new').prop('hidden', false);
                    $('.province-exist').prop('hidden', true);
                    $('.city').prop('hidden', false);
                }
                else{
                    $('.province').prop('hidden', false);
                    $('.province-new').prop('hidden', true);
                    $('.province-exist').prop('hidden', false);
                    $('.city').prop('hidden', false);
                }
            });

            $('.submit').click(function () {
                var div = $(this).closest('.form-horizontal');

                var province_type = div.find('#province-type').val();
                var province_exist = div.find('#province-exist').val();
                var province_new = div.find('#province-new').val();
                var city = div.find('#city').val();

                console.log(province_type, province_exist, province_new, city);

                $.ajax({
                    url : '{{url('manage-region-add')}}',
                    type : 'POST',
                    data : {
                        'province_type' : province_type,
                        'province_' : province_exist,
                        'province' : province_new,
                        'city' : city,
                        '_token' : '{{csrf_token()}}'
                    },

                    success: function(data){
                        if($.isEmptyObject(data.error)){
                            overlay.prop('hidden', false);
                            location.reload();

                            $('.close').click();

                            new PNotify({
                                title: "Success!",
                                text: data.success,
                                type: 'success',
                                delay: 2000
                            });

                        }else{
                            new PNotify({
                                title: "Error",
                                text: data.error,
                                type: 'error',
                                delay: 2000
                            });
                        }
                    }
                });
            });

            table.on('click', '.update', function () {
                var tr = $(this).closest('tr');

                tr.find('.col-update').prop('contenteditable', 'true').prop('style', 'border: 1px solid #78AAFD');
                tr.find('.update').prop('style', 'display: none');
                tr.find('.save').prop('style', 'display: inline');
            });

            table.on('click', '.save', function () {
                var tr = $(this).closest('tr');

                var id = tr.find('.id').val();
                var city = tr.find('.city').text();

                tr.find('.col-update').prop('contenteditable', 'false').prop('style', 'border: ');

                if(city === ""){
                    new PNotify({
                        title: "Error!",
                        text: 'Field required.',
                        type: 'error',
                        delay: 2000
                    });
                }
                else{
                    $.ajax({
                        url : '{{url('manage-region-update')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            'city' : city,
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            tr.find('.update').prop('style', 'display: inline');
                            tr.find('.save').prop('style', 'display: none');

                            overlay.prop('hidden', false);
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });
                        }
                    })
                }
            });

            table.on('click', '.delete', function () {
                var tr = $(this).closest('tr');
                var id = tr.find('.id').val();

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
                        url : '{{url('manage-region-delete')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            '_method' : 'DELETE',
                            '_token' : '{{csrf_token()}}'
                        },

                        success: function(response){
                            overlay.prop('hidden', false);
                            location.reload();

                            new PNotify({
                                title: "Success!",
                                text: response.success,
                                type: 'success',
                                delay: 2000
                            });
                        }
                    });
                }).on('pnotify.cancel', function() {});
            });
        } );

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop