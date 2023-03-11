@extends('layouts.main',['title' => 'User'])
@section('content')
    <x-content :title="[
        'name'=>'User',
        'icon'=>'fas fa-users',
    ]">
    @if (session('message') == 'success store')
        <x-alert-success/>
    @endif
    @if (session('message') == 'success update')
        <x-alert-success type="update"/>
    @endif
    @if (session('message') == 'success delete')
        <x-alert-success type="delete"/>
    @endif

    <div class="card card-outline card-info">
        <div class="card-header form-inline">
            <x-btn-add href="{{ route('user.create') }}" />
            <x-search />
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <td><b>Foto</b></td>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Outlet</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $users->firstItem();
                    ?>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                <img src="{{ $user->foto }}" class="img-fluid mr-2 rounded" width="120">
                            </td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->outlet }}</td>
                            <td>
                                <x-edit href="{{ route('user.edit', ['user'=>$user->id]) }}" />
                                <x-delete data-name="{{ $user->nama }}" data-url="{{ route('user.destroy', ['user'=>$user->id]) }}" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links('page') }}
        </div>
    </div>
    </x-content>
@endsection
@push('modal')
    <x-modal-delete />
@endpush
