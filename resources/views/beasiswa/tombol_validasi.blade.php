<a href="{{ route('beasiswa.detail', $data['id']) }}" class="btn btn-success">
    <i class="bi bi-pencil-square"></i> Lihat Detail
</a>
{{-- ini kemungkinan muncul setelah pencet detail --}}
{{-- @if($data['status'] == 'diproses')
   <a href="{{ route('beasiswa.lanjutkan_validasi', $data['id']) }}" class="btn btn-success">
       Lanjutkan Validasi
   </a>
@endif  --}}