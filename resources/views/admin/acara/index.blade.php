@extends('admin.layouts.app')
@section('title', 'Manage Events')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Manage Events</h1>
        <a href="{{ route('admin.acara.create') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Event
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

    <!-- Events Table -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">All Events</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Event Date</th>
                            <th>Registration Deadline</th>
                            <th>Max Participants</th>
                            <th>Created At</th>
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
                            <td>{{ $acara->maksimal_peserta }}</td>
                            <td>{{ $acara->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.acara.edit', $acara->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.acara.destroy', $acara->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
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