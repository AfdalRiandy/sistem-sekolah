@extends('panitia.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Committee Dashboard</h1>
        <div>
            <a href="{{ route('panitia.peserta.index') }}" class="mr-2 shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary">
                <i class="fas fa-users fa-sm text-white-50"></i> View Registrations
            </a>
        </div>
    </div>

    <!-- Content Row - Statistics Cards -->
    <div class="row">
        <!-- Pending Registrations Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-warning h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-warning text-uppercase">
                                Pending Registrations</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\PendaftaranAcara::where('status', 'menunggu')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="p-2 text-center card-footer">
                    <a href="{{ route('panitia.peserta.index', ['status' => 'menunggu']) }}" class="text-warning">View Pending</a>
                </div>
            </div>
        </div>

        <!-- Approved Registrations Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-success text-uppercase">
                                Approved Participants</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\PendaftaranAcara::where('status', 'disetujui')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="p-2 text-center card-footer">
                    <a href="{{ route('panitia.peserta.index', ['status' => 'disetujui']) }}" class="text-success">View Approved</a>
                </div>
            </div>
        </div>

        <!-- Scored Participants Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-info text-uppercase">
                                Scored Participants</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                @php
                                    $scoredCount = App\Models\Penilaian::whereNotNull('nilai')->count();
                                @endphp
                                {{ $scoredCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="p-2 text-center card-footer">
                    <a href="{{ route('panitia.penilaian.index') }}" class="text-info">View Scoring</a>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-primary text-uppercase">
                                Upcoming Events</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\Acara::where('tanggal_acara', '>', now())->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Charts -->
    <div class="row">
        <!-- Registration Status Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Registration Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="registrationStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scoring Progress Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Scoring Progress</h6>
                </div>
                <div class="card-body">
                    <div class="pt-4 pb-2 chart-pie">
                        <canvas id="scoringProgressChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Scored
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Unscored
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Published
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Tables -->
    <div class="row">
        <!-- Pending Registrations Table -->
        <div class="mb-4 col-lg-6">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Pending Registrations</h6>
                </div>
                <div class="card-body">
                    @php
                        $pendingRegistrations = App\Models\PendaftaranAcara::where('status', 'menunggu')
                            ->with(['user', 'acara'])
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($pendingRegistrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Participant</th>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingRegistrations as $registration)
                                        <tr>
                                            <td>{{ $registration->user->name }}</td>
                                            <td>{{ $registration->acara->nama_acara }}</td>
                                            <td>{{ $registration->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('panitia.peserta.show', $registration->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('panitia.peserta.index', ['status' => 'menunggu']) }}" class="btn btn-warning btn-sm">View All Pending</a>
                        </div>
                    @else
                        <p class="text-center">No pending registrations found.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Events Table -->
        <div class="mb-4 col-lg-6">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Upcoming Events</h6>
                </div>
                <div class="card-body">
                    @php
                        $upcomingEvents = App\Models\Acara::where('tanggal_acara', '>', now())
                            ->orderBy('tanggal_acara')
                            ->take(5)
                            ->get();
                    @endphp

                    @if($upcomingEvents->count() > 0)
                        <div class="list-group">
                            @foreach($upcomingEvents as $event)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $event->nama_acara }}</h5>
                                        <small>{{ \Carbon\Carbon::parse($event->tanggal_acara)->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ Str::limit($event->deskripsi_acara, 80) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-day"></i> {{ \Carbon\Carbon::parse($event->tanggal_acara)->format('d M Y') }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-users"></i> {{ $event->pendaftaran->count() }} Registered /
                                            {{ $event->maksimal_peserta }} Max
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">No upcoming events found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Events Needing Scoring Row -->
    <div class="row">
        <div class="col-12">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Events Needing Scoring</h6>
                </div>
                <div class="card-body">
                    @php
                        $eventsNeedingScoring = App\Models\Acara::whereHas('pendaftaran', function($query) {
                                $query->where('status', 'disetujui');
                            })
                            ->where('tanggal_acara', '<', now()) // Past events
                            ->whereDoesntHave('pendaftaran.penilaian', function($query) {
                                $query->where('is_published', true);
                            })
                            ->take(5)
                            ->get();
                    @endphp

                    @if($eventsNeedingScoring->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Event Date</th>
                                        <th>Approved Participants</th>
                                        <th>Scoring Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eventsNeedingScoring as $acara)
                                    <tr>
                                        <td>{{ $acara->nama_acara }}</td>
                                        <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}</td>
                                        <td>{{ $acara->pendaftaran->where('status', 'disetujui')->count() }}</td>
                                        <td>
                                            @php
                                                $approvedCount = $acara->pendaftaran->where('status', 'disetujui')->count();
                                                $scoredCount = 0;
                                                foreach($acara->pendaftaran->where('status', 'disetujui') as $pendaftaran) {
                                                    if($pendaftaran->penilaian && $pendaftaran->penilaian->nilai !== null) {
                                                        $scoredCount++;
                                                    }
                                                }
                                                $percentage = $approvedCount > 0 ? round(($scoredCount / $approvedCount) * 100) : 0;
                                            @endphp
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%" 
                                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ $percentage }}%
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $scoredCount }} of {{ $approvedCount }} scored</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('panitia.penilaian.show', $acara->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-clipboard-list"></i> Score
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('panitia.penilaian.index') }}" class="btn btn-primary btn-sm">View All Scoring</a>
                        </div>
                    @else
                        <p class="text-center">No events need scoring at this time.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
<script>
    // Registration Status Chart
    var ctx = document.getElementById("registrationStatusChart");
    var registrationStatusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["This Week", "Last Week", "Two Weeks Ago", "Three Weeks Ago"],
            datasets: [
                {
                    label: "Approved",
                    backgroundColor: "#1cc88a",
                    data: [
                        {{ App\Models\PendaftaranAcara::where('status', 'disetujui')->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(7))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'disetujui')->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(14))->where('updated_at', '<', \Carbon\Carbon::now()->subDays(7))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'disetujui')->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(21))->where('updated_at', '<', \Carbon\Carbon::now()->subDays(14))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'disetujui')->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(28))->where('updated_at', '<', \Carbon\Carbon::now()->subDays(21))->count() }}
                    ],
                },
                {
                    label: "Rejected",
                    backgroundColor: "#e74a3b",
                    data: [
                        {{ App\Models\PendaftaranAcara::where('status', 'gagal')->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(7))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'gagal')->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(14))->where('updated_at', '<', \Carbon\Carbon::now()->subDays(7))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'gagal')->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(21))->where('updated_at', '<', \Carbon\Carbon::now()->subDays(14))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'gagal')->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(28))->where('updated_at', '<', \Carbon\Carbon::now()->subDays(21))->count() }}
                    ],
                },
                {
                    label: "Pending",
                    backgroundColor: "#f6c23e",
                    data: [
                        {{ App\Models\PendaftaranAcara::where('status', 'menunggu')->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'menunggu')->where('created_at', '>=', \Carbon\Carbon::now()->subDays(14))->where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'menunggu')->where('created_at', '>=', \Carbon\Carbon::now()->subDays(21))->where('created_at', '<', \Carbon\Carbon::now()->subDays(14))->count() }},
                        {{ App\Models\PendaftaranAcara::where('status', 'menunggu')->where('created_at', '>=', \Carbon\Carbon::now()->subDays(28))->where('created_at', '<', \Carbon\Carbon::now()->subDays(21))->count() }}
                    ],
                }
            ],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    time: {
                        unit: 'week'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        min: 0,
                        maxTicksLimit: 5,
                        padding: 10,
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: true
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
        }
    });

    // Scoring Progress Doughnut Chart
    var ctx2 = document.getElementById("scoringProgressChart");
    var scoringProgressChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Scored", "Unscored", "Published"],
            datasets: [{
                data: [
                    {{ App\Models\Penilaian::whereNotNull('nilai')->where('is_published', false)->count() }},
                    {{ App\Models\PendaftaranAcara::where('status', 'disetujui')->count() - App\Models\Penilaian::whereNotNull('nilai')->count() }},
                    {{ App\Models\Penilaian::where('is_published', true)->count() }}
                ],
                backgroundColor: ['#1cc88a', '#e74a3b', '#36b9cc'],
                hoverBackgroundColor: ['#17a673', '#c23321', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 70,
        },
    });
</script>
@endsection