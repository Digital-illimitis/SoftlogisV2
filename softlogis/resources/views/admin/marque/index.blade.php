@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Variation</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Marques</li>
                </ol>
            </nav>
        </div>
        {{-- <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
            </div>
        </div> --}}
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">


              <div class="ms-auto">
                <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#addMarqueModal"><i class="bx bxs-plus-square"></i>Nouvelle Marque</button>
              </div>

               <!-- Button trigger modal -->

            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>code</th>
                            <th>Libelle</th>
                            <th>Couleur</th>
                            <th>Etat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($marques as $marque)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14">#{{ $marque->code }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $marque->libelle }}</td>

                            <td><div class="badge rounded-pill p-2 text-uppercase px-3" style="background: {{ $marque->color }}"> {{ $marque->color }}
                            </div></td>
                            <td>
                                <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"> {{ $marque->etat }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a data-bs-toggle="modal" data-bs-target="#editMarqueModal{{ $marque->uuid }}"  class="" style="cursor: pointer"><i class='bx bxs-edit'></i></a>

                                    {{-- <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a> --}}

                                    <a class="ms-3 deleteConfirmation" data-uuid="{{$marque->uuid}}"
                                        data-type="confirmation_redirect" data-placement="top"
                                        data-token="{{ csrf_token() }}"
                                        data-url="{{route('admin.marque.destroy',$marque->uuid)}}"
                                        data-title="Vous êtes sur le point de supprimer {{$marque->libelle}} "
                                        data-id="{{$marque->uuid}}" data-param="0"
                                        data-route="{{route('admin.marque.destroy',$marque->uuid)}}"><i
                                            class='bx bxs-trash' style="cursor: pointer"></i></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal edit Marque --}}
                        <!-- Modal -->
                        <div class="modal fade" id="editMarqueModal{{ $marque->uuid }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifier marque</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.marque.update', $marque->uuid) }}" method="post" class="submitForm">
                                        <div class="modal-body my-4">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="">Libelle</label>
                                                    <input class="form-control" type="text" name="libelle" value="{{ $marque->libelle }}">
                                                </div>
                                                <div class="form-group col">
                                                    <label for="">Couleur</label>
                                                    <input class="form-control" type="color" name="color" value="{{ $marque->color }}">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="description">Description <span class="text-muted">(facultatif)</span></label>
                                                <textarea class="form-control" name="description"  cols="30" rows="2" value="{{ $marque->description }}">{{ $marque->description }}</textarea>
                                            </div>
                                            <hr>

                                            <div class="modal-footer mt-2">
                                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-outline-info">Modifier</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @empty

                            <center><span>Aucune marque</span></center>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- Modal add new category --}}

    <!-- Modal -->
    <div class="modal fade" id="addMarqueModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouvelle marque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.marque.store') }}" method="post" class="submitForm">
                    <div class="modal-body my-4">
                        @csrf
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Libelle <span><span class="text-danger">*</span></span></label>
                                <input class="form-control" type="text" name="libelle" autocomplete="off" required>
                                @error('libelle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col">
                                <label for="">Couleur <span class="text-muted">(facultatif)</span></label>
                                <input class="form-control" type="color" name="color" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="description">Description <span class="text-muted">(facultatif)</span></label>
                            <textarea class="form-control" name="description" cols="30" rows="2" autocomplete="off"></textarea>
                        </div>
                        <hr>

                        <div class="modal-footer mt-2">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-success">Ajouter</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>



</div>


@endsection
