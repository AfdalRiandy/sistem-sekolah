@extends('admin.layouts.app')
@section('title', 'Edit Event')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Edit Event</h1>
        <a href="{{ route('admin.acara.index') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Events
        </a>
    </div>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Event Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.acara.update', $acara->id) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nama_acara">Event Name</label>
                    <input type="text" class="form-control @error('nama_acara') is-invalid @enderror" id="nama_acara" name="nama_acara" value="{{ old('nama_acara', $acara->nama_acara) }}" required>
                    @error('nama_acara')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="tanggal_acara">Event Date</label>
                    <input type="date" class="form-control @error('tanggal_acara') is-invalid @enderror" id="tanggal_acara" name="tanggal_acara" value="{{ old('tanggal_acara', $acara->tanggal_acara->format('Y-m-d')) }}" required>
                    @error('tanggal_acara')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="batas_pendaftaran">Registration Deadline</label>
                    <input type="date" class="form-control @error('batas_pendaftaran') is-invalid @enderror" id="batas_pendaftaran" name="batas_pendaftaran" value="{{ old('batas_pendaftaran', $acara->batas_pendaftaran->format('Y-m-d')) }}" required>
                    @error('batas_pendaftaran')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="maksimal_peserta">Maximum Participants</label>
                    <input type="number" class="form-control @error('maksimal_peserta') is-invalid @enderror" id="maksimal_peserta" name="maksimal_peserta" value="{{ old('maksimal_peserta', $acara->maksimal_peserta) }}" required min="1">
                    @error('maksimal_peserta')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="deskripsi_acara">Event Description</label>
                    <textarea class="form-control @error('deskripsi_acara') is-invalid @enderror" id="deskripsi_acara" name="deskripsi_acara" rows="5" required>{{ old('deskripsi_acara', $acara->deskripsi_acara) }}</textarea>
                    @error('deskripsi_acara')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Update Event</button>
            </form>
        </div>
    </div>
</div>
@endsection