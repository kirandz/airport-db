@extends('layouts.app')

@section('page_heading', 'Domestic')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Airport Data</li>
        <li><a href="{{url('airport-dom')}}">Domestic</a></li>
        <li class="active">Document</li>
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
                        <li class="active"><a href="#">Document</a></li>
                        <li><a href="{{url('airport-dom/adl/'.$airport->id)}}">Airport Data Limitation (ADL)</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="document" style="display: none">
                            <div class="box-group" id="accordion">
                                <div class="panel box" style="border-radius: 0px; border: 1px solid #8aa4af; border-top: 1px solid #8aa4af; margin-bottom: 5px">
                                    <div class="box-header">
                                        <h4 class="box-title" style="font-size: 15px;">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#chart">
                                                <b>Chart</b>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="chart" class="collapse">
                                        <div class="box-body">
                                            @if($airport->chart != '' || $airport->chart != null)
                                                <embed src="{{url('/files/chart/'.$airport->chart)}}#page=1&zoom=75" type="application/pdf" width="100%" height="600px" id="embed">
                                                    @else
                                                        No data available
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="panel box" style="border-radius: 0px; border: 1px solid #8aa4af; border-top: none; margin-bottom: 5px">
                                    <div class="box-header">
                                        <h4 class="box-title" style="font-size: 15px;">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#arpi">
                                                <b>ARPI</b>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="arpi" class="collapse">
                                        <div class="box-body">
                                            @if($airport->arpi != '' || $airport->arpi != null)
                                                <embed src="{{url('/files/arpi/'.$airport->arpi)}}#page=1&zoom=75" type="application/pdf" width="100%" height="600px" id="embed">
                                                    @else
                                                        No data available
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="panel box" style="border-radius: 0px; border: 1px solid #8aa4af; border-top: none; margin-bottom: 5px">
                                    <div class="box-header">
                                        <h4 class="box-title" style="font-size: 15px;">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#armi">
                                                <b>ARMI</b>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="armi" class="collapse">
                                        <div class="box-body">
                                            @if($airport->armi != '' || $airport->armi != null)
                                                <embed src="{{url('/files/armi/'.$airport->armi)}}#page=1&zoom=75" type="application/pdf" width="100%" height="600px" id="embed">
                                                    @else
                                                        No data available
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="panel box" style="border-radius: 0px; border: 1px solid #8aa4af; border-top: none; margin-bottom: 5px">
                                    <div class="box-header">
                                        <h4 class="box-title" style="font-size: 15px;">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#beritaacara">
                                                <b>Berita Acara</b>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="beritaacara" class="collapse">
                                        <div class="box-body">
                                            @if($airport->berita_acara != '' || $airport->berita_acara != null)
                                                <embed src="{{url('/files/beritaacara/'.$airport->berita_acara)}}#page=1&zoom=75" type="application/pdf" width="100%" height="600px" id="embed">
                                                    @else
                                                        No data available
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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

    <script>
        $(document).ready(function() {
            var div_document = $('#document');

            div_document.prop('style', '');

            $('.doc-name').click(function () {
                var table = $(this).closest('table');

                $('.doc-preview').prop('hidden', true);
                table.find('.doc-preview').prop('hidden', false);
            });

            $('.close').click(function () {
                var table = $(this).closest('table');

                table.find('.doc-preview').prop('hidden', true);
            });
        });
    </script>
@stop