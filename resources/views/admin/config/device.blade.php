@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Configuration</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Taux d'échange</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
              valeur de l'euro

            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Valeur</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($devices as $item)
                        <tr>
                            <td>{{ $item->code ?? '001'}}</td>
                            <td>{{ $item->valeur ?? '--'}}</td>
                            <td>
                                <a href="" data-bs-target="#editDeviceModal" data-bs-toggle="modal"> Modifier</a>
                            </td>
                        </tr>

                        <div class="modal fade" id="editDeviceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifier taux</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.devise.update',$item->uuid) }}" method="post" class="submitForm">
                                        <div class="modal-body my-4">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Valeur <span><span class="text-danger">*</span></span></label>
                                                <input class="form-control" type="text" name="valeur" value="{{ $item->valeur }}" required>
                                                @error('valeur')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                    
                                            <div class="modal-footer mt-2">
                                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-outline-success">Ajouter</button>
                                            </div>
                                        </div>
                                    </form>
                    
                                </div>
                            </div>
                        </div>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">Aucun element</td>
                            </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- Modal add new category --}}

    <!-- Modal -->
    
    {{-- <div class="modal fade" id="addDeviceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouveau taux</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.devise.store') }}" method="post" class="submitForm">
                    <div class="modal-body my-4">
                        @csrf
                        <div class="form-group">
                            <label for="">Valeur <span><span class="text-danger">*</span></span></label>
                            <input class="form-control" type="text" name="valeur" autocomplete="off" required>
                            @error('valeur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer mt-2">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-outline-success">Ajouter</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div> --}}

    <hr>


    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                Valeur du dollar
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Valeur</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dollar as $item)
                        <tr>
                            <td>{{ $item->code ?? '002'}}</td>
                            <td>{{ $item->value ?? '--'}}</td>
                            <td>
                                <a href="" data-bs-target="#editDollarModal" data-bs-toggle="modal"> Modifier</a>
                            </td>
                        </tr>

                        <div class="modal fade" id="editDollarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifier Valeur du Dollar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.dollar.update',$item->uuid) }}" method="post" class="submitForm">
                                        <div class="modal-body my-4">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Valeur <span><span class="text-danger">*</span></span></label>
                                                <input class="form-control" type="text" name="value" value="{{ $item->value }}" required>
                                                @error('valeur')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                    
                                            <div class="modal-footer mt-2">
                                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-outline-success">Ajouter</button>
                                            </div>
                                        </div>
                                    </form>
                    
                                </div>
                            </div>
                        </div>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">Aucun element</td>
                            </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

@endsection
