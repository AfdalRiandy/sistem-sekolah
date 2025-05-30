@extends('peserta.layouts.app')
@section('title', 'Available Events')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Available Events</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        @foreach($acaras as $acara)
            <div class="mb-4 col-xl-4 col-md-6">
                <div class="shadow card border-left-primary h-100">
                    <div class="py-3 card-header">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $acara->nama_acara }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-uppercase">
                                    Event Date: {{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}
                                </div>
                                <div class="mb-1 text-xs font-weight-bold text-danger text-uppercase">
                                    Registration Deadline: {{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d M Y') }}
                                </div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                    {{ Str::limit($acara->deskripsi_acara, 100) }}
                                </div>
                                <div class="mt-2 text-xs">
                                    <span class="badge badge-info">Max Participants: {{ $acara->maksimal_peserta }}</span>
                                    <span class="badge badge-secondary">Registered: {{ $acara->pendaftaran->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('peserta.acara.show', $acara->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-info-circle"></i> View Details
                        </a>
                        
                        @php
                            $pendaftaran = $acara->pendaftaran->where('user_id', auth()->id())->first();
                        @endphp
                        
                        @if($pendaftaran)
                            <button class="btn btn-secondary btn-sm" disabled>
                                @if($pendaftaran->status == 'menunggu')
                                    <i class="fas fa-clock"></i> Waiting for Approval
                                @elseif($pendaftaran->status == 'disetujui')
                                    <i class="fas fa-check"></i> Approved
                                @elseif($pendaftaran->status == 'gagal')
                                    <i class="fas fa-times"></i> Rejected
                                @endif
                            </button>
                        @elseif(\Carbon\Carbon::now()->gt($acara->batas_pendaftaran))
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-ban"></i> Registration Closed
                            </button>
                        @elseif($acara->pendaftaran->count() >= $acara->maksimal_peserta)
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-users"></i> Event Full
                            </button>
                        @else
                            <form action="{{ route('peserta.acara.daftar', $acara->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-paper-plane"></i> Register Now
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        @if($acaras->isEmpty())
            <div class="col-12">
                <div class="mb-4 shadow card">
                    <div class="card-body">
                        <p class="text-center">No events available at the moment.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection