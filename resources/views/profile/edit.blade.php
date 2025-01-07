@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Edit Profil</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="{{ $user->username }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ $user->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="usertype" class="form-label">User Type</label>
                            <input type="text" class="form-control" id="usertype" name="usertype" 
                                   value="{{ $user->usertype }}" readonly>
                        </div>

                        @if ($user->usertype === 'mahasiswa')
                            <div class="mb-3">
                                <label for="program_reguler" class="form-label">Program Reguler</label>
                                <select class="form-control" id="program_reguler" name="program_reguler">
                                    <option value="">-- Pilih Program --</option>
                                    <option value="D3 - Diploma 3" 
                                        {{ old('program_reguler', $detail->program_reguler) == 'D3 - Diploma 3' ? 'selected' : '' }}>
                                        D3 - Diploma 3
                                    </option>
                                    <option value="D4 - Diploma 4" 
                                        {{ old('program_reguler', $detail->program_reguler) == 'D4 - Diploma 4' ? 'selected' : '' }}>
                                        D4 - Diploma 4
                                    </option>
                                    <option value="S1 - Sarjana" 
                                        {{ old('program_reguler', $detail->program_reguler) == 'S1 - Sarjana' ? 'selected' : '' }}>
                                        S1 - Sarjana
                                    </option>
                                    <option value="S2 - Magister" 
                                        {{ old('program_reguler', $detail->program_reguler) == 'S2 - Magister' ? 'selected' : '' }}>
                                        S2 - Magister
                                    </option>
                                    <option value="Prof - Profesi" 
                                        {{ old('program_reguler', $detail->program_reguler) == 'Prof - Profesi' ? 'selected' : '' }}>
                                        Prof - Profesi
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-control" id="semester" name="semester">
                                    <option value="">-- Pilih Semester --</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="Semester {{ $i }}" 
                                            {{ old('semester', $detail->semester) == "Semester $i" ? 'selected' : '' }}>
                                            Semester {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>                        

                            <div class="mb-3">
                                <label for="IPK" class="form-label">IPK</label>
                                <input type="number" step="0.01" class="form-control" id="IPK" name="IPK" 
                                       value="{{ old('IPK', $detail->IPK) }}">
                            </div>

                            <div class="mb-3">
                                <label for="Umur" class="form-label">Umur</label>
                                <input type="number" class="form-control" id="Umur" name="Umur" 
                                       value="{{ old('Umur', $detail->Umur) }}">
                            </div>

                            <div class="mb-3">
                                <label for="status_beasiswa" class="form-label">Status Beasiswa</label>
                                <select class="form-control" id="status_beasiswa" name="status_beasiswa">
                                    <option value="">-- Pilih Status Beasiswa --</option>
                                    <option value="Sedang menerima beasiswa lain" 
                                        {{ old('status_beasiswa', $detail->status_beasiswa) == 'Sedang menerima beasiswa lain' ? 'selected' : '' }}>
                                        Sedang menerima beasiswa lain
                                    </option>
                                    <option value="Tidak Sedang menerima beasiswa lain" 
                                        {{ old('status_beasiswa', $detail->status_beasiswa) == 'Tidak Sedang menerima beasiswa lain' ? 'selected' : '' }}>
                                        Tidak Sedang menerima beasiswa lain
                                    </option>
                                </select>
                            </div>                            

                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan" name="jurusan" 
                                       value="{{ old('jurusan', $detail->jurusan) }}">
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
