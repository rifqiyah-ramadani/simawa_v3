@if ($recentPosts->isEmpty())
    <p>No recent posts found.</p>
@else
    @foreach ($recentPosts as $post)
    <div class="single-post">
        <div class="image">
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->judul }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
        </div>
        <div class="content">
            <h5>
                <a href="{{ route('berita.show', $post->id) }}">{{ $post->judul }}</a>
            </h5>
            <ul class="meta">
                <li><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($post->publish_date)->format('M d, Y') }}</li>
            </ul>
        </div>
    </div>
    @endforeach
@endif
