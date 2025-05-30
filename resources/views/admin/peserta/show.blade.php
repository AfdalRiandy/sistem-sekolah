@extends('admin.layouts.app')
@section('title', 'View Event Participants')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Participants for: {{ $acara->nama_acara }}</h1>
        <a href="{{ route('admin.peserta.index') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Events
        </a>
    </div>

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
                    <p><strong>Registration Deadline:</strong> {{ \Carbon\Carbon::parse($acara->batas_pendaftaran)->format('d M Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Maximum Participants:</strong> {{ $acara->maksimal_peserta }}</p>
                    <p><strong>Approved Participants:</strong> {{ $pendaftarans->count() }} / {{ $acara->maksimal_peserta }}</p>
                    <p><strong>Total Registrations:</strong> {{ $acara->pendaftaran->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="mb-4 shadow card">
        <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Approved Participants</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="text-gray-400 fas fa-ellipsis-v fa-sm fa-fw"></i>
                </a>
                <div class="shadow dropdown-menu dropdown-menu-right animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Export Options:</div>
                    <a class="dropdown-item" href="{{ route('admin.peserta.export', $acara->id) }}">
                        <i class="mr-2 text-gray-400 fas fa-file-excel fa-sm fa-fw"></i>Export to Excel
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.peserta.pdf', $acara->id) }}">
                        <i class="mr-2 text-gray-400 fas fa-file-pdf fa-sm fa-fw"></i>Export to PDF
                    </a>
                </div>
            </div>
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
                            <th>Status</th>
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
                                <span class="badge badge-success">Approved</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#userDetailsModal{{ $pendaftaran->user_id }}">
                                    <i class="fas fa-eye"></i> View Details
                                </button>
                            </td>
                        </tr>
                        
                        <!-- User Details Modal -->
                        <div class="modal fade" id="userDetailsModal{{ $pendaftaran->user_id }}" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="userDetailsModalLabel">Participant Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="font-weight-bold">Personal Information</h6>
                                                <p><strong>Name:</strong> {{ $pendaftaran->user->name }}</p>
                                                <p><strong>Email:</strong> {{ $pendaftaran->user->email }}</p>
                                                <p><strong>Joined:</strong> {{ $pendaftaran->user->created_at->format('d M Y') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="font-weight-bold">Registration Information</h6>
                                                <p><strong>Registration Date:</strong> {{ $pendaftaran->created_at->format('d M Y H:i') }}</p>
                                                <p><strong>Status:</strong> <span class="badge badge-success">Approved</span></p>
                                                <p><strong>Approved By:</strong> Committee</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
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