@extends('layouts.app')
@section('title', 'Cek Status Pendaftaran')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pendaftaran.index') }}">Pendaftaran</a></li>
                <li class="breadcrumb-item active">Cek Status</li>
            </ol>
        </nav>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center mb-4">
                    <h2 class="section-title">Cek Status Pendaftaran</h2>
                    <p class="section-subtitle">Masukkan NIM Anda untuk melihat status</p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('pendaftaran.cek') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM Anda" value="{{ request('nim') }}" required>
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search me-1"></i>Cek</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(request('nim'))
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4">
                        @if($registration)
                        <div class="text-center mb-3">
                            <i class="fas fa-{{ $registration->status === 'Diterima' ? 'check-circle text-success' : ($registration->status === 'Ditolak' ? 'times-circle text-danger' : 'clock text-warning') }} fa-3x mb-2"></i>
                            <h5 class="fw-bold">{{ $registration->name }}</h5>
                            <p class="text-muted">NIM: {{ $registration->nim }}</p>
                        </div>
                        <table class="table table-borderless">
                            <tr><td class="text-muted" style="width:40%">Email</td><td>{{ $registration->email }}</td></tr>
                            <tr><td class="text-muted">No. HP</td><td>{{ $registration->phone }}</td></tr>
                            <tr><td class="text-muted">Program Studi</td><td>{{ $registration->study_program }}</td></tr>
                            <tr><td class="text-muted">Semester</td><td>{{ $registration->semester }}</td></tr>
                            <tr><td class="text-muted">Status</td>
                                <td>
                                    @if($registration->status === 'Diterima')
                                    <span class="badge bg-success fs-6">Diterima</span>
                                    @elseif($registration->status === 'Ditolak')
                                    <span class="badge bg-danger fs-6">Ditolak</span>
                                    @else
                                    <span class="badge bg-warning text-dark fs-6">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            @if($registration->admin_notes)
                            <tr><td class="text-muted">Catatan</td><td>{{ $registration->admin_notes }}</td></tr>
                            @endif
                        </table>
                        @else
                        <div class="text-center py-3">
                            <i class="fas fa-exclamation-triangle text-warning fa-3x mb-2"></i>
                            <p class="mb-0">Data pendaftaran dengan NIM <strong>{{ request('nim') }}</strong> tidak ditemukan.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
