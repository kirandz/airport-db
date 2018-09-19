@extends('layouts.app')

@section('page_heading', 'Document')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"></a>Manage Database</li>
        <li class="active">Document</li>
    </ol>
@endsection

@section('section')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" id="document">
                    <div class="box-header with-border">
                        <h3 class="box-title">Airport Document</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="airport-table" class="table table-striped table-bordered" style="width:100%" hidden>
                            <thead>
                            <tr>
                                <th>ICAO Code</th>
                                <th>IATA Code</th>
                                <th>City</th>
                                <th style="text-align: center">Chart</th>
                                <th style="text-align: center">ARPI</th>
                                <th style="text-align: center">ARMI</th>
                                <th style="text-align: center">Berita Acara</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($airports as $airport)
                                <tr>
                                    <td>{{$airport->icao_code}}</td>
                                    <td>{{$airport->iata_code}}</td>
                                    <td>{{$airport->city}}</td>
                                    <td style="text-align: center">
                                        <button class="trigger-chart btn btn-link" data-toggle="tooltip" title="Upload"><i class="fa fa-upload"></i></button>
                                        {{--Upload Chart--}}
                                        <form action="{{url('upload-chart/'.$airport->id)}}" method="POST" enctype="multipart/form-data" style="display: none">
                                            {{csrf_field()}}
                                            <input class="upload-chart" name="chart" type="file" style="display: none" accept="application/pdf">
                                            <button type="submit" class="upload-chart-submit" style="display: none"></button>
                                        </form>
                                        <a class="btn btn-link" href="{{ asset("files/chart/$airport->chart") }}" target="_blank" data-toggle="tooltip" title="Preview"><i class="fa fa-external-link"></i></a>
                                    </td>
                                    <td style="text-align: center">
                                        <button class="trigger-arpi btn btn-link" data-toggle="tooltip" title="Upload"><i class="fa fa-upload"></i></button>
                                        {{--Upload ARPI--}}
                                        <form action="{{url('upload-arpi/'.$airport->id)}}" method="POST" enctype="multipart/form-data" style="display: none">
                                            {{csrf_field()}}
                                            <input class="upload-arpi" name="arpi" type="file" style="display: none" accept="application/pdf">
                                            <button type="submit" class="upload-arpi-submit" style="display: none"></button>
                                        </form>
                                        <a class="btn btn-link" href="{{ asset("files/arpi/$airport->arpi") }}" target="_blank" data-toggle="tooltip" title="Preview"><i class="fa fa-external-link"></i></a>
                                    </td>
                                    <td style="text-align: center">
                                        <button class="trigger-armi btn btn-link" data-toggle="tooltip" title="Upload"><i class="fa fa-upload"></i></button>
                                        {{--Upload ARMI--}}
                                        <form action="{{url('upload-armi/'.$airport->id)}}" method="POST" enctype="multipart/form-data" style="display: none">
                                            {{csrf_field()}}
                                            <input class="upload-armi" name="armi" type="file" style="display: none" accept="application/pdf">
                                            <button type="submit" class="upload-armi-submit" style="display: none"></button>
                                        </form>
                                        <a class="btn btn-link" href="{{ asset("files/armi/$airport->armi") }}" target="_blank" data-toggle="tooltip" title="Preview"><i class="fa fa-external-link"></i></a>
                                    </td>
                                    <td style="text-align: center">
                                        <button class="trigger-berita btn btn-link" data-toggle="tooltip" title="Upload"><i class="fa fa-upload"></i></button>
                                        {{--Upload Berita Acara--}}
                                        <form action="{{url('upload-berita/'.$airport->id)}}" method="POST" enctype="multipart/form-data" style="display: none">
                                            {{csrf_field()}}
                                            <input class="upload-berita" name="berita_acara" type="file" style="display: none" accept="application/pdf">
                                            <button type="submit" class="upload-berita-submit" style="display: none"></button>
                                        </form>
                                        <a class="btn btn-link" href="{{ asset("files/beritaacara/$airport->berita_acara") }}" target="_blank" data-toggle="tooltip" title="Preview"><i class="fa fa-external-link"></i></a>
                                    </td>
                                </tr>
                            @endforeach
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

    <?php $flag = 0?>
    @if ($message = Session::get('message'))
        <?php $flag = 1?>
        <span id="message" hidden>{{ Session::get('message') }}</span>
    @endif

    <script>
        var flag =  <?php echo $flag?>

        $(document).ready(function() {
            var msg = $('#message').text();

            if(flag === 1){
                new PNotify({
                    title: "Success!",
                    text: msg,
                    type: 'success',
                    delay: 2000
                });
            }

            var table = $('#airport-table');
            var overlay = $('.overlay');
            var div = $('#document');

            table.DataTable( {
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3,4,5,6] }
                ]
            } );

            table.prop('hidden', false);
            overlay.prop('hidden', true);

            $('.trigger-chart').click(function () {
                var row = $(this).closest('tr');
                var chart = row.find('.upload-chart');

                chart.click();
                chart.change(function () {
                    div.addClass("disabledbox");
                    row.find('.upload-chart-submit').click();
                });
            });

            $('.trigger-arpi').click(function () {
                var row = $(this).closest('tr');
                var arpi = row.find('.upload-arpi');

                arpi.click();
                arpi.change(function () {
                    div.addClass("disabledbox");
                    row.find('.upload-arpi-submit').click();
                });
            });

            $('.trigger-armi').click(function () {
                var row = $(this).closest('tr');
                var armi = row.find('.upload-armi');

                armi.click();
                armi.change(function () {
                    div.addClass("disabledbox");
                    row.find('.upload-armi-submit').click();
                });
            });

            $('.trigger-berita').click(function () {
                var row = $(this).closest('tr');
                var berita = row.find('.upload-berita');

                berita.click();
                berita.change(function () {
                    div.addClass("disabledbox");
                    row.find('.upload-berita-submit').click();
                });
            });
        } );

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop