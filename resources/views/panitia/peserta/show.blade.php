@extends('panitia.layouts.app')
@section('title', 'Participant Details')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Registration Details</h1>
        <a href="{{ route('panitia.peserta.index') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Participants
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

    <div class="row">
        <div class="col-lg-6">
            <!-- Participant Info -->
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Participant Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">Name</th>
                                <td>{{ $pendaftaran->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $pendaftaran->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Registration Date</th>
                                <td>{{ $pendaftaran->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($pendaftaran->status == 'menunggu')
                                        <span class="badge badge-warning">Waiting</span>
                                    @elseif($pendaftaran->status == 'disetujui')
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($pendaftaran->status == 'gagal')
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @if($pendaftaran->catatan)
                            <tr>
                                <th>Note</th>
                                <td>{{ $pendaftaran->catatan }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    @if($pendaftaran->status == 'menunggu')
                        <div class="mt-3">
                            <div class="btn-group">
                                <form action="{{ route('panitia.peserta.approve', $pendaftaran->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="mr-2 btn btn-success">
                                        <i class="fas fa-check"></i> Approve Registration
                                    </button>
                                </form>
                                
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                                    <i class="fas fa-times"></i> Reject Registration
                                </button>
                            </div>
                        </div>
                        
                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('panitia.peserta.reject', $pendaftaran->id) }}" method="POST">
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
                                                <small class="form-text text-muted">This reason will be visible to the participant.</small>
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

                    @if($pendaftaran->status != 'menunggu')
                        <div class="mt-3">
                            <form action="{{ route('panitia.peserta.reset', $pendaftaran->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to reset this registration to pending status?')">
                                    <i class="fas fa-undo"></i> Reset to Pending Status
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Event Info -->
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Event Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">Event Name</th>
                                <td>{{ $pendaftaran->acara->nama_acara }}</td>
                            </tr>
                            <tr>
                                <th>Event Date</th>
                                <td>{{ \Carbon\Carbon::parse($pendaftaran->acara->tanggal_acara)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Registration Deadline</th>
                                <td>{{ \Carbon\Carbon::parse($pendaftaran->acara->batas_pendaftaran)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Maximum Participants</th>
                                <td>{{ $pendaftaran->acara->maksimal_peserta }}</td>
                            </tr>
                            <tr>
                                <th>Registered Participants</th>
                                <td>
                                    {{ $pendaftaran->acara->pendaftaran->count() }} / {{ $pendaftaran->acara->maksimal_peserta }}
                                    ({{ $pendaftaran->acara->pendaftaran->where('status', 'disetujui')->count() }} approved)
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('panitia.peserta.index', ['acara' => $pendaftaran->acara_id]) }}" class="btn btn-info">
                            <i class="fas fa-users"></i> View All Participants for This Event
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection