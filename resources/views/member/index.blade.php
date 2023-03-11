@extends('layouts.main', ['title' => 'Member'])
@section('content')
    <x-content :title="[
        'name' => 'Member',
        'icon' => 'fas fa-users',
    ]">
        @if (session('message') == 'success store')
            <x-alert-success />
        @endif
        @if (session('message') == 'success update')
            <x-alert-success type="update" />
        @endif
        @if (session('message') == 'success delete')
            <x-alert-success type="delete" />
        @endif

        <div class="card card-outline card-info">
            <div class="card-header form-inline">
                <x-btn-add href="{{ route('member.create') }}" />
                <x-search />
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <td><b>Foto</b></td>
                        <th>Nama</th>
                        <th>P/L</th>
                        <th>Telephon</th>
                        <th>Alamat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $members->firstItem();
                    ?>
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                <img src="{{ $member->foto }}" class="img-fluid mr-2 rounded" width="120">
                            </td>
                            <td>{{ $member->nama }}</td>
                            <td>{{ $member->jenis_kelamin }}</td>
                            <td>{{ $member->tlp }}</td>
                            <td>{{ $member->alamat }}</td>
                            <td class="text-right">
                                <x-edit href="{{ route('member.edit', ['member'=>$member->id]) }}" />
                                <x-delete data-name="{{ $member->nama }}" data-url="{{ route('member.destroy', ['member'=>$member->id]) }}" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

                {{-- <div class="row pt-4 pb-4 pl-4 pr-4">
                    @foreach ($members as $member)
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-body pt-0">

                                <div class="row">

                                        <div class="col-7">
                                            <h2 class="lead"><b>{{ $member->nama }}</b></h2>
                                            <p class="text-muted text-sm">{{ $member->jenis_kelamin }}</p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-building"></i></span> Address: {{ $member->alamat }}</li><br>
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-phone"></i></span> Phone {{ $member->tlp }}</li>
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            <img src="{{ $member->foto }}" alt="user-avatar"
                                                class="rounded-circle img-fluid">
                                        </div>

                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <x-edit href="{{ route('member.edit', ['member'=>$member->id]) }}" />
                                        <x-delete data-url="{{ route('member.destroy', ['member'=>$member->id]) }}" />
                                </div>
                                </div>

                        </div>
                    </div>
                    @endforeach
                </div> --}}
            </div>
            <div class="card-footer">
                {{ $members->links('page') }}
            </div>
        </div>
    </x-content>
@endsection
@push('modal')
    <x-modal-delete />
@endpush
