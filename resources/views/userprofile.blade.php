@extends('layouts.app')

@section('page_heading', 'User Profile')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User Profile</li>
    </ol>
@endsection

@section('section')
    <style>
        .container {
            position: relative;
            width: 50%;
        }

        .image {
            opacity: 1;
            display: block;
            width: 75%;
            height: auto;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .container:hover .image {
            opacity: 0.3;
        }

        .container:hover .middle {
            opacity: 1;
        }

        .text {
            color: white;
            font-size: 15px;
        }
    </style>

    <section class="content">
        <div class="row">
            <div class="col-md-5">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <div class="container">
                            @if(Auth::user()->profile_picture == null)
                                <img class="profile-user-img img-responsive img-circle image" src="{{asset('images/user.png')}}" alt="User profile picture">
                            @else
                                <img class="profile-user-img img-responsive img-circle image" src="{{asset('images/profile/'.Auth::user()->profile_picture)}}" alt="User profile picture">
                            @endif

                            <form action="{{url('user-update-picture')}}" method="POST" enctype="multipart/form-data" style="display: none">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                <input type="file" name="profile_picture" id="upload-profile" accept="image/*">

                                <button type="submit" id="submit-profile-picture"></button>
                            </form>

                            <div class="middle">
                                <button id="trigger" class="btn btn-primary text"><i class="fa fa-edit"></i></button>

                                @if(Auth::user()->profile_picture != null)
                                    <a href="{{url('user-remove-picture/'.Auth::user()->id)}}" id="remove-profile-picture" class="btn btn-danger text"><i class="fa fa-trash"></i></a>
                                @endif

                            </div>
                        </div>

                        <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>

                        <form role="form" action="{{url('user-update')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">

                            <div class="box-body">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{Auth::user()->name}}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{Auth::user()->email}}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">New password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary" id="submit-profile" style="width: 100%"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $flag = 0;?>

    @if ($message = Session::get('success'))
        <?php $flag = 1?>
        <i id="msg" hidden>{{ Session::get('success') }}</i>
    @elseif ($message = Session::get('update_pp'))
        <?php $flag = 2?>
        <i id="msg" hidden>{{ Session::get('update_pp') }}</i>
    @elseif ($message = Session::get('remove_pp'))
        <?php $flag = 3?>
        <i id="msg" hidden>{{ Session::get('remove_pp') }}</i>
    @endif

    <script>
        var flag = <?php echo $flag?>

        $(document).ready(function () {
            var msg = "";

            if(flag === 1) {
                msg = $('#msg').html();

                new PNotify({
                    title: 'Success!',
                    text: msg,
                    type: 'success',
                    delay: 2000
                });
            }
            else if(flag === 2)
            {
                msg = $('#msg').html();

                new PNotify({
                    title: 'Success!',
                    text: msg,
                    type: 'success',
                    delay: 2000
                });
            }
            else if(flag === 3){
                msg = $('#msg').html();

                new PNotify({
                    title: 'Success!',
                    text: msg,
                    type: 'success',
                    delay: 2000
                });
            }

            var div = $('.box-profile');

            $('#trigger').click(function () {
                var profile = $('#upload-profile');

                profile.click();
                profile.change(function () {
                    $('#submit-profile-picture').click();

                    div.addClass("disabledbox");
                });
            });

            $('#submit-profile').click(function () {
                div.addClass("disabledbox");
            });
        });
    </script>
@stop