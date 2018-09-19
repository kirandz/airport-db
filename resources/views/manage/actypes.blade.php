@extends('layouts.app')

@section('page_heading', 'Aircraft Type')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"></a>Manage Database</li>
        <li class="active">Aircraft Type</li>
    </ol>
@endsection

@section('section')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Aircraft Type Data</h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-link" data-toggle="modal" data-target="#actype-modal"><i class="fa fa-plus"></i> New Aircraft Type</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="actype-table" class="table table-striped table-bordered" style="width:100%" hidden>
                            <thead>
                            <tr>
                                <th>Aircraft Type</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ac_types as $ac_type)
                                <tr>
                                    <input type="hidden" class="id" value="{{$ac_type->id}}">
                                    <td class="col-update type">{{$ac_type->type}}</td>
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

    <div class="modal fade" id="actype-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Aircraft Type</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="type" class="col-md-3 control-label">Aircraft Type</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" id="type" placeholder="Aircraft Type">
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
            var table = $('#actype-table');
            var overlay = $('.overlay');

            table.DataTable( {
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                "columnDefs": [
                    { "orderable": false, "targets": 1 }
                ],
                fixedHeader: {
                    header: true
                }
            } );

            table.prop('hidden', false);
            overlay.prop('hidden', true);

            $('.submit').click(function () {
                var div = $(this).closest('.form-horizontal');

                var type = div.find('#type').val();

                $.ajax({
                    url : '{{url('manage-actype-add')}}',
                    type : 'POST',
                    data : {
                        'type' : type,
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
                var type = tr.find('.type').text();

                tr.find('.col-update').prop('contenteditable', 'false').prop('style', 'border: ');

                if(type === ""){
                    new PNotify({
                        title: "Error!",
                        text: 'Field required.',
                        type: 'error',
                        delay: 2000
                    });
                }
                else{
                    $.ajax({
                        url : '{{url('manage-actype-update')}}',
                        type : 'POST',
                        data : {
                            'id' : id,
                            'type' : type,
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
                        url : '{{url('manage-actype-delete')}}',
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