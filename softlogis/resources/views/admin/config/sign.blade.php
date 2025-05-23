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
                    <li class="breadcrumb-item active" aria-current="page">Signature/ Caché</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="ms-auto">
                <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#addSignModal"><i class="bx bxs-plus-square"></i>Nouvelle Signature</button>
              </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
              Signature

            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>image <sup>png</sup></th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($signs as $item)
                        <tr>
                            <td>001</td>
                            <td>
                                <img src="{{ asset('documents/files/' . $item->sign) }}" alt="" class="img-fluid" width="50" height="50">
                            </td>
                            <td class="text-end">
                                <a type="button" class="border-0 col mx-2 btn" data-bs-toggle="modal" data-bs-target="#editSignModal{{ $item->uuid }}">
                                    <i class='bx bxs-edit'></i>
                                </a>
                                <a class="deleteConfirmation col text-decoration-none" data-uuid="{{$item->uuid}}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-type="confirmation_redirect" data-placement="top"
                                    data-token="{{ csrf_token() }}"
                                    data-url="{{route('admin.signature.destroySign',$item->uuid)}}"
                                    data-title="Vous êtes sur le point de le supprimer"
                                    data-id="{{$item->uuid}}" data-param="0"
                                    data-route="{{route('admin.signature.destroySign',$item->uuid)}}">
                                    <i class='bx bxs-trash '></i>
                                </a>
                            </td>
                        </tr>

                        <div class="modal fade" id="editSignModal{{ $item->uuid }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifié la signature</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.signature.edit', $item->uuid) }}" method="post" class="submitForm">
                                        <div class="modal-body my-4">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Signature <span><span class="text-danger">*</span></span></label>
                                                <input class="form-control" type="file" name="sign" value="{{ $item->sign }}" required>
                                                @error('sign')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                        
                                            <div class="modal-footer mt-2">
                                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-outline-success">Modifier</button>
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

<div class="modal fade" id="addSignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter la signature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.signature.store') }}" method="post" class="submitForm">
                <div class="modal-body my-4">
                    @csrf
                    <div class="form-group">
                        <label for="">Signature <span><span class="text-danger">*</span></span></label>
                        <input class="form-control" type="file" name="sign" required>
                        @error('sign')
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

@endsection
