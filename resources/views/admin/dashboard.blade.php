@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Admin Dashboard</h1>
        <a href="{{ route('admin.acara.create') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Event
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Events Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-primary text-uppercase">
                                Total Events</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\Acara::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-success text-uppercase">
                                Total Users</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\User::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
            </div>
        </div>

        <!-- Approved Registrations Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-info text-uppercase">
                                Approved Registrations</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                {{ App\Models\PendaftaranAcara::where('status', 'disetujui')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- User Distribution -->
        <div class="col-xl-8 col-lg-7">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">User Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Status -->
        <div class="col-xl-4 col-lg-5">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Registration Status</h6>
                </div>
                <div class="card-body">
                    <div class="pt-4 pb-2 chart-pie">
                        <canvas id="registrationStatusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Pending
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Approved
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Rejected
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Events -->
        <div class="mb-4 col-lg-6">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Events</h6>
                </div>
                <div class="card-body">
                    @php
                        $recentEvents = App\Models\Acara::latest()->take(5)->get();
                    @endphp

                    @if($recentEvents->count() > 0)
                        <div class="list-group">
                            @foreach($recentEvents as $event)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $event->nama_acara }}</h5>
                                        <small>{{ $event->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ Str::limit($event->deskripsi_acara, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Event Date: {{ \Carbon\Carbon::parse($event->tanggal_acara)->format('d M Y') }}
                                        </small>
                                        <a href="{{ route('admin.acara.edit', $event->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('admin.acara.index') }}" class="btn btn-primary btn-sm">View All Events</a>
                        </div>
                    @else
                        <p class="text-center">No events created yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest Registrations -->
        <div class="mb-4 col-lg-6">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Latest Registrations</h6>
                </div>
                <div class="card-body">
                    @php
                        $latestRegistrations = App\Models\PendaftaranAcara::with(['user', 'acara'])
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($latestRegistrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Participant</th>
                                        <th>Event</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestRegistrations as $registration)
                                        <tr>
                                            <td>{{ $registration->user->name }}</td>
                                            <td>{{ $registration->acara->nama_acara }}</td>
                                            <td>
                                                @if($registration->status == 'menunggu')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($registration->status == 'disetujui')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif($registration->status == 'gagal')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $registration->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">No registrations found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row">
        <div class="mb-4 col-lg-12">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-block btn-primary">
                                <i class="mr-1 fas fa-users"></i> Manage Users
                            </a>
                        </div>
                        <div class="mb-3 col-md-3">
                            <a href="{{ route('admin.acara.create') }}" class="btn btn-block btn-success">
                                <i class="mr-1 fas fa-calendar-plus"></i> Create Event
                            </a>
                        </div>
                        <div class="mb-3 col-md-3">
                            <a href="{{ route('admin.peserta.index') }}" class="btn btn-block btn-info">
                                <i class="mr-1 fas fa-user-check"></i> View Participants
                            </a>
                        </div>
                        <div class="mb-3 col-md-3">
                            <a href="{{ route('admin.penilaian.index') }}" class="btn btn-block btn-warning">
                                <i class="mr-1 fas fa-clipboard-list"></i> Score Participants
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
<script>
    // User Distribution Chart
    var ctx = document.getElementById("userDistributionChart");
    var userDistributionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Admin", "Committee", "Participant"],
            datasets: [{
                label: "Users",
                backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
                hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
                borderColor: "#4e73df",
                data: [
                    {{ App\Models\User::where('role', 'admin')->count() }},
                    {{ App\Models\User::where('role', 'panitia')->count() }},
                    {{ App\Models\User::where('role', 'peserta')->count() }}
                ],
            }],
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
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    },
                    maxBarThickness: 80,
                }],
                yAxes: [{
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
                display: false
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
        }
    });

    // Registration Status Chart
    var ctx2 = document.getElementById("registrationStatusChart");
    var registrationStatusChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Pending", "Approved", "Rejected"],
            datasets: [{
                data: [
                    {{ App\Models\PendaftaranAcara::where('status', 'menunggu')->count() }},
                    {{ App\Models\PendaftaranAcara::where('status', 'disetujui')->count() }},
                    {{ App\Models\PendaftaranAcara::where('status', 'gagal')->count() }}
                ],
                backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b'],
                hoverBackgroundColor: ['#dda20a', '#17a673', '#c23321'],
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