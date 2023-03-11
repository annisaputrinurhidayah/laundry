@extends('layouts.main',['title'=>'Sign In','login'=>true])

@section('content')
<div class="login-logo">
    <img src="/images/logo.png" alt="" class="rounded-circle" width="40%"> <br>
    <a href=""><b>Login</b>{{ config('app.name') }}</a>
</div>
{{-- <div class="card " style="background: transparent;">
    <div class="card-body login-card-body rounded">

    </div>
</div> --}}
{{-- <p class="login-box-msg">Sign in to start your session</p> --}}
        <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="input-group ">
            <input name="username" class="form-control rounded-pill border border-info @error('username') is-invalid @enderror" placeholder="Username">
            {{-- <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div> --}}
        </div>
        @error('username')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div class="input-group mt-3">
            <input name="password" type="password" class="form-control rounded-pill border border-info @error('password') is-invalid @enderror" placeholder="Password">
            {{-- <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div> --}}
        </div>
        @error('password')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div class="row mt-3">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
            </div>
            <div class="col-4">
            </div>
            <div class="input-group mt-3">
                <button type="submit" class="btn btn-info btn-block rounded-pill ">Sign In</button>
            </div>
        </div>
        </form>
@endsection
