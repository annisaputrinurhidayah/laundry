@extends('layouts.main',['title'=>'My Profile'])
@section('content')
<x-content :title="[
    'name' => 'My Profile',
    'icon' => 'fas fa-user'
]">
<div class="row">
    <div class="col-md-6 col-lg-4">
        @if (session('message') == 'success update')
        <x-alert-success type="update" />
        @endif
        <form action="{{  route('profile') }}" class="card card-info" method="POST">
            <div class="card-header">
                <h3 class="card-title">My Profile</h3>
            </div>
            <div class="card-body">
                @csrf
                <x-input label="Nama" name="nama" :value="$user->nama"/>
                <x-input label="Username" name="username" :value="$user->username" disabled/>
                    <p class="text-muted mt-5" >
                       Kosongkan password jika tidak mengganti password
                    </p>
                    <x-input label="Password" name="password" type="password"/>
                    <x-input label="Password Confirmation" name="password_confirmation" type="password"/>
            </div>
            <div class="card-footer">
                <x-btn-update />
            </div>
        </form>
    </div>
</div>
</x-content>
@endsection
{{-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">

                    @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            @if($user->photo)
                                <img src="/images/nisa.jpg" class="img-thumbnail rounded mx-auto d-block">
                            @else
                                <img src="/images/nisa.jpg" class="img-thumbnail rounded mx-auto d-block">
                            @endif

                        </div>
                        <div class="col-md-8">
                            <form method="POST" action="" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="old_password" class="col-md-4 col-form-label text-md-end">Old Password</label>

                                    <div class="col-md-6">
                                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" autocomplete="old-password">

                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Change Profile Photo</label>

                                    <div class="col-md-6">
                                        <input id="photo" type="file" class="form-control" name="photo">
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Update Profile
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

