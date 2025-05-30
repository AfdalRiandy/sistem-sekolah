@extends('peserta.layouts.app')
@section('title', 'Event Results')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Event Results: {{ $myPendaftaran->acara->nama_acara }}</h1>
        <a href="{{ route('peserta.pengumuman.index') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Results
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Rankings Table -->
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Participant Rankings</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allScores as $index => $pendaftaran)
                                <tr class="{{ $pendaftaran->id == $myPendaftaran->id ? 'table-primary' : '' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $pendaftaran->user->name }}
                                        @if($pendaftaran->id == $myPendaftaran->id)
                                            <span class="ml-2 badge badge-primary">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $pendaftaran->penilaian->nilai }}/100</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Your Result Card -->
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Your Results</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <h1 class="display-4 font-weight-bold">{{ $myPendaftaran->penilaian->nilai }}</h1>
                        <p class="lead">out of 100 points</p>
                        
                        @if($myPendaftaran->penilaian->nilai >= 80)
                            <div class="mb-2">
                                <i class="fas fa-trophy fa-3x text-warning"></i>
                            </div>
                            <div class="mb-3 text-success">Excellent Performance!</div>
                        @elseif($myPendaftaran->penilaian->nilai >= 60)
                            <div class="mb-2">
                                <i class="fas fa-medal fa-3x text-info"></i>
                            </div>
                            <div class="mb-3 text-info">Good Job!</div>
                        @elseif($myPendaftaran->penilaian->nilai >= 40)
                            <div class="mb-2">
                                <i class="fas fa-thumbs-up fa-3x text-warning"></i>
                            </div>
                            <div class="mb-3 text-warning">Average Performance</div>
                        @else
                            <div class="mb-2">
                                <i class="fas fa-thumbs-down fa-3x text-danger"></i>
                            </div>
                            <div class="mb-3 text-danger">Needs Improvement</div>
                        @endif
                    </div>

                    <hr>

                    <div class="mb-3 text-center">
                        <h4>Your Rank</h4>
                        <div class="display-4 font-weight-bold">{{ $rank }}</div>
                        <p>out of {{ $allScores->count() }} participants</p>
                    </div>

                    @if($myPendaftaran->penilaian->catatan)
                        <hr>
                        <div class="mb-3">
                            <h5 class="font-weight-bold">Notes from Evaluator:</h5>
                            <p class="card-text">{{ $myPendaftaran->penilaian->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Event Info Card -->
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Event Information</h6>
                </div>
                <div class="card-body">
                    <p><strong>Event Name:</strong> {{ $myPendaftaran->acara->nama_acara }}</p>
                    <p><strong>Event Date:</strong> {{ \Carbon\Carbon::parse($myPendaftaran->acara->tanggal_acara)->format('d M Y') }}</p>
                    <p><strong>Total Participants:</strong> {{ $allScores->count() }}</p>
                    <p><strong>Average Score:</strong> {{ round($allScores->avg('penilaian.nilai'), 1) }}/100</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false
        });
    });
</script>
@endsection