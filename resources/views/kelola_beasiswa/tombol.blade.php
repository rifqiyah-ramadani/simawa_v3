
@if(auth()->user()->hasRole('Operator Kemahasiswaan'))
    <a href="#" data-id="{{$data->id}}" class="btn btn-success tombol-detail"><i class="bi bi-pencil-square"></i> </a>
    <a href="#" data-id="{{$data->id}}" class="btn btn-warning tombol-edit"><i class="bi bi-pencil-square"></i> </a>
    <a href="#" data-id="{{$data->id}}" class="btn btn-danger tombol-delete"><i class="bi bi-trash"></i> </a>
@endif 

@if(auth()->user()->hasRole('Operator Fakultas'))
    <a href="#" data-id="{{$data->id}}" class="btn btn-success tombol-detail"><i class="bi bi-eye"></i> Detail</a>
@endif
