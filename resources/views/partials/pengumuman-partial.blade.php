<ul class="list-group">
    @forelse($pengumuman as $item)
        <li class="list-group-item">
            <div class="pengumuman-content">
                <a href="{{ asset('storage/' . $item->file) }}" target="_blank">
                    <i class="fa fa-file-alt text-warning"></i> {{ $item->judul }}
                </a>
                <div class="pengumuman-date">
                    <span class="badge">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        Diposting {{ \Carbon\Carbon::parse($item->publish_date)->format('d M, Y') }}
                    </span>
                </div>
            </div>
        </li>
    @empty
        <li class="list-group-item text-center text-muted">
            Belum ada pengumuman.
        </li>
    @endforelse
</ul>

<!-- Tombol Pagination -->
<div class="pagination-wrap mt-3 d-flex justify-content-between">
    @if($pengumuman->onFirstPage())
        <button class="btn btn-secondary" disabled>Previous</button>
    @else
        <button class="btn btn-warning" id="prev-pengumuman" data-url="{{ $pengumuman->previousPageUrl() }}">Previous</button>
    @endif

    @if($pengumuman->hasMorePages())
        <button class="btn btn-warning" id="next-pengumuman" data-url="{{ $pengumuman->nextPageUrl() }}">Next</button>
    @else
        <button class="btn btn-secondary" disabled>Next</button>
    @endif
</div>
