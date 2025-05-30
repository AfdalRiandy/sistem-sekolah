@extends('admin.layouts.app')
@section('title', 'Manage Participants')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Event Participants</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Events with Participants Table -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Events and Participants</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Registration Deadline</th>
                            <th>Participants</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($acaras as $acara)
                        <tr>
                            <td>{{ $acara->id }}</td>
                            <td>{{ $acara->nama_acara }}</td>
                            <td>{{ \Carbon\Carbon::parse($acara->tanggal_acara)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d M Y') }}</td>
                            <td>
                                <span class="badge badge-success">{{ $acara->pendaftaran->where('status', 'disetujui')->count() }} Approved</span>
                                <span class="badge badge-warning">{{ $acara->pendaftaran->where('status', 'menunggu')->count() }} Waiting</span>
                                <span class="badge badge-danger">{{ $acara->pendaftaran->where('status', 'gagal')->count() }} Rejected</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.peserta.show', $acara->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-users"></i> View Participants
                                </a>
                            </td>
                        </tr>
                        @endforeach
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