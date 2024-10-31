<div class="row">
    @forelse($buatPendaftaran as $item)
    <div class="col-md-6">
        <div class="card-scholarship">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Beasiswa">
            <div class="card-body">
                <span class="badge-status {{ $item->status == 'dibuka' ? 'bg-success' : 'bg-danger' }}">
                    {{ $item->status }}
                </span>
                <h5 class="card-title">Beasiswa {{ $item->beasiswa->nama_beasiswa }}</h5>
                <p class="card-subtitle">{{ $item->tahun }}</p>
                <div class="info-icons">
                    <span>
                        <i class="bi bi-calendar2-week"></i> 
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') }}
                    </span>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary tombol-daftar" 
                        data-id="{{ $item->id }}" 
                        data-status="{{ $item->status }}">Lihat Detail</button>
            </div>
        </div>
    </div>
    @empty
    <p>Tidak ada pendaftaran beasiswa ditemukan.</p>
    @endforelse
</div>
