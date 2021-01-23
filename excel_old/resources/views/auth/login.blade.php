@extends('layouts.auth')

@section('content')

    <div class="login-box">


        <div class="logo">

<a href="javascript:void(0);"><img class="application-logo" src=" {{ asset('/store/files/logo/logo.png') }}" /></a>
            
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_up" method="POST" action="{{ route('login') }}">



                    @if (isset($errorMessage))
                        <span class="help-block">
                                <strong>{{ $errorMessage }}</strong>
                        </span>
                    @endif

                    {{ csrf_field() }}

                    <div class="msg">
                        @lang('auth.login_title')
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line {{ $errors->has('email') ? ' error' : '' }}">
                            <input id="name" type="text" placeholder="@lang('auth.username')" value="" class="form-control" name="email" autofocus>
                        </div>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                             </span>
                        @endif

                    </div>

                    <div class="input-group {{ $errors->has('password') ? ' error' : '' }}">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="password" placeholder="@lang('auth.password')" value="" type="password" class="form-control" name="password">
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                             </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" id="rememberme" name="remember" {{ old('remember') ? 'checked' : '' }} class="filled-in chk-col-pink">
                            <label for="rememberme">@lang('auth.remember_me')</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">@lang('auth.sign_in')</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        @if(0)
                            <div class="col-xs-6">
                                <a href="{{ route('register') }}">@lang('auth.regiser')</a>
                            </div>
                            <div class="col-xs-6 align-right">
                                <a href="{{ route('password.request') }}">@lang('auth.forget_password')</a>
                            </div>
                        @else
                            <div class="col-xs-12 align-right">
                                <a href="{{ route('password.request') }}">@lang('auth.forget_password')</a>
                            </div>
                        @endif

                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
