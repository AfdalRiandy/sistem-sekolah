@extends('peserta.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Participant Dashboard</h1>
        <a href="{{ route('peserta.acara.index') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary">
            <i class="fas fa-calendar fa-sm text-white-50"></i> Browse Events
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Registrations Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-primary text-uppercase">
                                My Registrations</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ auth()->user()->pendaftaranAcara->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="p-2 text-center card-footer">
                    <a href="{{ route('peserta.riwayat.index') }}" class="text-primary">View All Registrations</a>
                </div>
            </div>
        </div>

        <!-- Approved Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-success text-uppercase">
                                Approved Events</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ auth()->user()->pendaftaranAcara->where('status', 'disetujui')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="p-2 text-center card-footer">
                    <a href="{{ route('peserta.riwayat.index') }}" class="text-success">View Approved Events</a>
                </div>
            </div>
        </div>

        <!-- Results Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-info text-uppercase">
                                Published Results</div>
                            @php
                                $publishedResults = auth()->user()->pendaftaranAcara()
                                    ->whereHas('penilaian', function($query) {
                                        $query->where('is_published', true);
                                    })
                                    ->count();
                            @endphp
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ $publishedResults }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-trophy fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="p-2 text-center card-footer">
                    <a href="{{ route('peserta.pengumuman.index') }}" class="text-info">View Results</a>
                </div>
            </div>
        </div>

        <!-- Pending Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-warning h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-warning text-uppercase">
                                Pending Approvals</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ auth()->user()->pendaftaranAcara->where('status', 'menunggu')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="p-2 text-center card-footer">
                    <a href="{{ route('peserta.riwayat.index') }}" class="text-warning">View Pending</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Upcoming Events -->
        <div class="col-lg-6">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Upcoming Events</h6>
                </div>
                <div class="card-body">
                    @php
                        $upcomingEvents = App\Models\Acara::where('tanggal_acara', '>', now())
                            ->where('batas_pendaftaran', '>', now())
                            ->latest('tanggal_acara')
                            ->take(5)
                            ->get();
                    @endphp

                    @if($upcomingEvents->count() > 0)
                        <div class="list-group">
                            @foreach($upcomingEvents as $event)
                                <a href="{{ route('peserta.acara.show', $event->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $event->nama_acara }}</h5>
                                        <small>{{ \Carbon\Carbon::parse($event->tanggal_acara)->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ Str::limit($event->deskripsi_acara, 100) }}</p>
                                    <small class="text-muted">
                                        Event Date: {{ \Carbon\Carbon::parse($event->tanggal_acara)->format('d M Y') }} | 
                                        Registration Deadline: {{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d M Y') }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('peserta.acara.index') }}" class="btn btn-primary btn-sm">View All Events</a>
                        </div>
                    @else
                        <p class="text-center">No upcoming events available.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- My Recent Registrations -->
        <div class="col-lg-6">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">My Recent Registrations</h6>
                </div>
                <div class="card-body">
                    @php
                        $recentRegistrations = auth()->user()->pendaftaranAcara()
                            ->with('acara')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($recentRegistrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRegistrations as $registration)
                                        <tr>
                                            <td>
                                                <a href="{{ route('peserta.acara.show', $registration->acara->id) }}">
                                                    {{ $registration->acara->nama_acara }}
                                                </a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($registration->acara->tanggal_acara)->format('d M Y') }}</td>
                                            <td>
                                                @if($registration->status == 'menunggu')
                                                    <span class="badge badge-warning">Waiting</span>
                                                @elseif($registration->status == 'disetujui')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif($registration->status == 'gagal')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('peserta.riwayat.index') }}" class="btn btn-primary btn-sm">View All Registrations</a>
                        </div>
                    @else
                        <p class="text-center">You haven't registered for any events yet.</p>
                        <div class="mt-3 text-center">
                            <a href="{{ route('peserta.acara.index') }}" class="btn btn-primary btn-sm">Browse Available Events</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Published Results -->
    <div class="row">
        <div class="col-12">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">My Latest Results</h6>
                </div>
                <div class="card-body">
                    @php
                        $publishedResults = auth()->user()->pendaftaranAcara()
                            ->with(['acara', 'penilaian'])
                            ->whereHas('penilaian', function($query) {
                                $query->where('is_published', true);
                            })
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp

                    @if($publishedResults->count() > 0)
                        <div class="row">
                            @foreach($publishedResults as $result)
                                <div class="mb-4 col-md-4">
                                    <div class="card h-100">
                                        <div class="text-white card-header bg-primary">
                                            {{ $result->acara->nama_acara }}
                                        </div>
                                        <div class="text-center card-body">
                                            <h1 class="display-4">{{ $result->penilaian->nilai }}</h1>
                                            <p class="lead">out of 100 points</p>
                                            
                                            @if($result->penilaian->nilai >= 80)
                                                <div class="p-2 mb-2 badge badge-success">Excellent</div>
                                            @elseif($result->penilaian->nilai >= 60)
                                                <div class="p-2 mb-2 badge badge-info">Good</div>
                                            @elseif($result->penilaian->nilai >= 40)
                                                <div class="p-2 mb-2 badge badge-warning">Average</div>
                                            @else
                                                <div class="p-2 mb-2 badge badge-danger">Needs Improvement</div>
                                            @endif
                                            
                                            <div class="mt-3">
                                                <a href="{{ route('peserta.pengumuman.show', $result->acara_id) }}" class="btn btn-sm btn-primary">View Full Results</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('peserta.pengumuman.index') }}" class="btn btn-primary btn-sm">View All Results</a>
                        </div>
                    @else
                        <p class="text-center">No published results available yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize any dashboard widgets here
    });
</script>
@endsection