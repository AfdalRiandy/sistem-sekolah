@extends('peserta.layouts.app')
@section('title', 'Event Details')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Event Details</h1>
        <a href="{{ route('peserta.acara.index') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Events
        </a>
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
        <div class="col-lg-8">
            <!-- Event Details -->
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $acara->nama_acara }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Description:</h5>
                        <p>{{ $acara->deskripsi_acara }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Event Date:</strong> {{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}</p>
                            <p><strong>Registration Deadline:</strong> {{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Maximum Participants:</strong> {{ $acara->maksimal_peserta }}</p>
                            <p><strong>Current Registrations:</strong> {{ $acara->pendaftaran->count() }}</p>
                        </div>
                    </div>

                    @php
                        $pendaftaran = $acara->pendaftaran->where('user_id', auth()->id())->first();
                    @endphp

                    <div class="mt-4">
                        @if($pendaftaran)
                            <div class="alert alert-info">
                                <h5 class="font-weight-bold">Registration Status: 
                                    @if($pendaftaran->status == 'menunggu')
                                        <span class="badge badge-warning">Waiting for Approval</span>
                                    @elseif($pendaftaran->status == 'disetujui')
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($pendaftaran->status == 'gagal')
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </h5>
                                
                                @if($pendaftaran->catatan)
                                    <p><strong>Note:</strong> {{ $pendaftaran->catatan }}</p>
                                @endif
                                
                                <p>Registered on: {{ $pendaftaran->created_at->format('d M Y H:i') }}</p>
                            </div>
                        @elseif(\Carbon\Carbon::now()->gt($acara->batas_pendaftaran))
                            <div class="alert alert-warning">
                                <h5 class="font-weight-bold">Registration Closed</h5>
                                <p>The registration deadline for this event has passed.</p>
                            </div>
                        @elseif($acara->pendaftaran->count() >= $acara->maksimal_peserta)
                            <div class="alert alert-warning">
                                <h5 class="font-weight-bold">Event Full</h5>
                                <p>This event has reached its maximum number of participants.</p>
                            </div>
                        @else
                            <form action="{{ route('peserta.acara.daftar', $acara->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="mr-1 fas fa-paper-plane"></i> Register for this Event
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Registration Status -->
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Registration Info</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="mb-4 progress">
                            @php
                                $percentage = $acara->maksimal_peserta > 0 
                                    ? min(100, ($acara->pendaftaran->count() / $acara->maksimal_peserta) * 100) 
                                    : 0;
                            @endphp
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%"
                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ round($percentage) }}%
                            </div>
                        </div>
                        <p><strong>Slots:</strong> {{ $acara->pendaftaran->count() }} / {{ $acara->maksimal_peserta }}</p>
                    </div>
                    
                    <div class="mb-2">
                        <p>
                            <strong>Time Remaining:</strong><br>
                            @if(\Carbon\Carbon::now()->gt($acara->batas_pendaftaran))
                                <span class="text-danger">Registration Closed</span>
                            @else
                                <span class="text-success">{{ \Carbon\Carbon::now()->diffForHumans($acara->batas_pendaftaran, ['parts' => 2]) }}</span>
                            @endif
                        </p>
                    </div>
                    
                    <a href="{{ route('peserta.riwayat.index') }}" class="btn btn-info btn-sm btn-block">
                        <i class="mr-1 fas fa-history"></i> View My Registration History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection