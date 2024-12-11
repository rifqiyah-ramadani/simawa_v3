
    <div class="row">
        @forelse($berita as $item)
            <div class="col-lg-4 col-md-6 col-12">
                <!-- Single Blog -->
                <div class="single-news">
                    <div class="news-head">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->judul }}">
                    </div>
                    <div class="news-body"> 
                        <div class="news-content">
                            <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> Diposting {{ \Carbon\Carbon::parse($item->publish_date)->format('d M, Y') }}</div>
                            <h2><a href="{{ route('berita.show', $item->id) }}">{{ $item->judul }}</a></h2>
                            <p class="text">{{ Str::limit($item->content, 100) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada berita.</p>
        @endforelse
        <!-- Tambahkan konten berita lainnya jika diperlukan -->
    </div>
    <!-- Pagination -->
    <div class="pagination-wrapper pagination-berita mt-1">
        {{ $berita->appends(['type' => 'berita'])->links('pagination::bootstrap-4') }}
    </div>
    
