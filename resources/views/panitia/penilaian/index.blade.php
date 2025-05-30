@extends('panitia.layouts.app')
@section('title', 'Participant Scoring')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Participant Scoring</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Events Table -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Events with Approved Participants</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Approved Participants</th>
                            <th>Scoring Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($acaras as $acara)
                        <tr>
                            <td>{{ $acara->id }}</td>
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
                                    $isPublished = $acara->pendaftaran->where('status', 'disetujui')
                                        ->filter(function($p) { return $p->penilaian && $p->penilaian->is_published; })
                                        ->count() > 0;
                                @endphp
                                
                                @if($approvedCount == 0)
                                    <span class="badge badge-secondary">No participants</span>
                                @elseif($scoredCount == 0)
                                    <span class="badge badge-warning">No scores yet</span>
                                @elseif($scoredCount < $approvedCount)
                                    <span class="badge badge-info">{{ $scoredCount }}/{{ $approvedCount }} Scored</span>
                                @elseif($isPublished)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-primary">Ready to Publish</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('panitia.penilaian.show', $acara->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-clipboard-list"></i> Score Participants
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($acaras->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No events with approved participants found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection