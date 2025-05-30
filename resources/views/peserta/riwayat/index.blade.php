@extends('peserta.layouts.app')
@section('title', 'Registration History')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">My Event Registration History</h1>
        <a href="{{ route('peserta.acara.index') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary">
            <i class="fas fa-search fa-sm text-white-50"></i> Browse Available Events
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

    <!-- Registration History Table -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">My Registrations</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftaran as $daftar)
                        <tr>
                            <td>{{ $daftar->acara->nama_acara }}</td>
                            <td>{{ \Carbon\Carbon::parse($daftar->acara->tanggal_acara)->format('d M Y') }}</td>
                            <td>{{ $daftar->created_at->format('d M Y') }}</td>
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
                                <a href="{{ route('peserta.acara.show', $daftar->acara_id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View Event
                                </a>
                                
                                @if($daftar->status == 'menunggu' && \Carbon\Carbon::now()->lt($daftar->acara->batas_pendaftaran))
                                    <form action="{{ route('peserta.acara.batalkan', $daftar->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this registration?')">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        @if($pendaftaran->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">You haven't registered for any events yet.</td>
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