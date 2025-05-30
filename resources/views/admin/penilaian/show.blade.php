@extends('admin.layouts.app')
@section('title', 'Score Participants')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Score Participants: {{ $acara->nama_acara }}</h1>
        <div>
            <a href="{{ route('admin.penilaian.index') }}" class="mr-2 shadow-sm d-none d-sm-inline-block btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Events
            </a>
            
            @php
                $allScored = true;
                $anyScored = false;
                $anyPublished = false;
                
                foreach($pendaftarans as $pendaftaran) {
                    if(!$pendaftaran->penilaian || $pendaftaran->penilaian->nilai === null) {
                        $allScored = false;
                    } else {
                        $anyScored = true;
                        if($pendaftaran->penilaian->is_published) {
                            $anyPublished = true;
                        }
                    }
                }
            @endphp
            
            @if($anyScored && !$anyPublished)
                <form action="{{ route('admin.penilaian.publish', $acara->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="shadow-sm btn btn-sm btn-success" onclick="return confirm('Are you sure you want to publish all scores? Participants will be able to see their results.')">
                        <i class="fas fa-globe fa-sm text-white-50"></i> Publish Results
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Event Information Card -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Event Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Event Name:</strong> {{ $acara->nama_acara }}</p>
                    <p><strong>Event Date:</strong> {{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Approved Participants:</strong> {{ $pendaftarans->count() }}</p>
                    <p><strong>Scoring Status:</strong> 
                        @if($allScored && $anyPublished)
                            <span class="badge badge-success">Published</span>
                        @elseif($allScored)
                            <span class="badge badge-primary">All Scored - Ready to Publish</span>
                        @elseif($anyScored)
                            <span class="badge badge-info">Partially Scored</span>
                        @else
                            <span class="badge badge-warning">No Scores Yet</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Approved Participants</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Score</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftarans as $pendaftaran)
                        <tr>
                            <td>{{ $pendaftaran->id }}</td>
                            <td>{{ $pendaftaran->user->name }}</td>
                            <td>{{ $pendaftaran->user->email }}</td>
                            <td>{{ $pendaftaran->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($pendaftaran->penilaian && $pendaftaran->penilaian->nilai !== null)
                                    <span class="font-weight-bold">{{ $pendaftaran->penilaian->nilai }}</span>/100
                                    @if($pendaftaran->penilaian->is_published)
                                        <span class="ml-2 badge badge-success">Published</span>
                                    @endif
                                @else
                                    <span class="text-warning">Not scored yet</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#scoreModal{{ $pendaftaran->id }}">
                                    <i class="fas fa-edit"></i> {{ $pendaftaran->penilaian ? 'Edit Score' : 'Add Score' }}
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Score Modal -->
                        <div class="modal fade" id="scoreModal{{ $pendaftaran->id }}" tabindex="-1" role="dialog" aria-labelledby="scoreModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.penilaian.store', $pendaftaran->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="scoreModalLabel">Score Participant: {{ $pendaftaran->user->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nilai">Score (0-100)</label>
                                                <input type="number" class="form-control" id="nilai" name="nilai" min="0" max="100" value="{{ $pendaftaran->penilaian ? $pendaftaran->penilaian->nilai : '' }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="catatan">Notes (Optional)</label>
                                                <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ $pendaftaran->penilaian ? $pendaftaran->penilaian->catatan : '' }}</textarea>
                                                <small class="form-text text-muted">These notes will be visible to the participant.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Score</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($pendaftarans->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No approved participants found for this event.</td>
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