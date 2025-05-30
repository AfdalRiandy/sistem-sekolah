@extends('panitia.layouts.app')
@section('title', 'Manage Participants')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Manage Event Participants</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Filter Registrations</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('panitia.peserta.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="acara">Event</label>
                            <select class="form-control" id="acara" name="acara">
                                <option value="">All Events</option>
                                @foreach($acaras as $acara)
                                    <option value="{{ $acara->id }}" {{ request('acara') == $acara->id ? 'selected' : '' }}>
                                        {{ $acara->nama_acara }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Waiting</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Approved</option>
                                <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Event Registrations</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Participant</th>
                            <th>Event</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftaran as $daftar)
                        <tr>
                            <td>{{ $daftar->id }}</td>
                            <td>{{ $daftar->user->name }}</td>
                            <td>{{ $daftar->acara->nama_acara }}</td>
                            <td>{{ $daftar->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($daftar->status == 'menunggu')
                                    <span class="badge badge-warning">Waiting</span>
                                @elseif($daftar->status == 'disetujui')
                                    <span class="badge badge-success">Approved</span>
                                @elseif($daftar->status == 'gagal')
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('panitia.peserta.show', $daftar->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                
                                @if($daftar->status == 'menunggu')
                                    <div class="mt-1 btn-group">
                                        <form action="{{ route('panitia.peserta.approve', $daftar->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="mr-1 btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $daftar->id }}">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </div>
                                    
                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $daftar->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('panitia.peserta.reject', $daftar->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel">Reject Registration</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="catatan">Rejection Reason</label>
                                                            <textarea class="form-control" id="catatan" name="catatan" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Reject Registration</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($pendaftaran->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No registrations found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $pendaftaran->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false, // Handled by Laravel pagination
            "ordering": true,
            "info": true
        });
    });
</script>
@endsection