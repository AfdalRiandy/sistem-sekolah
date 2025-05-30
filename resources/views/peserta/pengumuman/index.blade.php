@extends('peserta.layouts.app')
@section('title', 'Announcements')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Event Results</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        @forelse($pendaftarans as $pendaftaran)
            <div class="mb-4 col-xl-4 col-md-6">
                <div class="shadow card border-left-primary h-100">
                    <div class="py-3 card-header">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $pendaftaran->acara->nama_acara }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 text-xs font-weight-bold text-uppercase">
                                    Event Date: {{ \Carbon\Carbon::parse($pendaftaran->acara->tanggal_acara)->format('d M Y') }}
                                </div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                    Your Score: {{ $pendaftaran->penilaian->nilai }}/100
                                </div>
                                <div class="mt-2">
                                    @if($pendaftaran->penilaian->nilai >= 80)
                                        <span class="badge badge-success">Excellent</span>
                                    @elseif($pendaftaran->penilaian->nilai >= 60)
                                        <span class="badge badge-info">Good</span>
                                    @elseif($pendaftaran->penilaian->nilai >= 40)
                                        <span class="badge badge-warning">Average</span>
                                    @else
                                        <span class="badge badge-danger">Needs Improvement</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('peserta.pengumuman.show', $pendaftaran->acara_id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-trophy"></i> View Full Results
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="mb-4 shadow card">
                    <div class="card-body">
                        <p class="text-center">No event results available yet. Please check back later.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection