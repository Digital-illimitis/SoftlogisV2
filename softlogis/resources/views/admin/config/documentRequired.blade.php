@extends('admin.layouts.admin')

@section('section')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3 text-uppercase">configuration</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Document requis</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Corbeille</button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
      
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="ms-auto">
                        <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#addNewDocModal"><i class="bx bxs-plus-square"></i>Nouveaux Document</button>
                      </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0" id="example2">
                        <thead class="table-light">
                            <tr>
                                <th>Code#</th>
                                <th>Libelle</th>
                                <th>Etat</th>
                                <th>Description courte</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documentRequises as $item )
                                <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">{{ $item->code ?? '--'}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->libelle ?? '--'}}</td>
                                <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{ $item->etat ?? '--' }}</div></td>
                                <td>{{ $item->description ?? '--' }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a data-bs-toggle="modal" data-bs-target="#EditDocModal{{ $item->uuid }}" class=""><i class='bx bxs-edit'></i></a>
                                        
                                        <a class="ms-3 deleteConfirmation" data-uuid="{{$item->uuid}}"
                                            data-type="confirmation_redirect" data-placement="top"
                                            data-token="{{ csrf_token() }}"
                                            data-url="{{route('admin.document_destroy',$item->uuid)}}"
                                            data-title="Vous êtes sur le point de supprimer {{$item->libelle}} "
                                            data-id="{{$item->uuid}}" data-param="0"
                                            data-route="{{route('admin.document_destroy',$item->uuid)}}"><i
                                                class='bx bxs-trash' style="cursor: pointer"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <td colspan="5">DOCUEMTN VIDE</td>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Add new Document Modal --}}
        <div class="modal fade" id="addNewDocModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajout D'un Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.document_store') }}" method="post" class="submitForm">
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
                                <div class="form-group mt-3">
                                    <label for="description">Description <span class="text-muted">(facultatif)</span></label>
                                    <textarea class="form-control" name="description" id="" cols="30" rows="2" autocomplete="off"></textarea>
                                </div>
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


        {{-- Edit update Document Modal --}}
        
        @if (!empty($item))
            <div class="modal fade" id="EditDocModal{{ $item->uuid }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modifier Document</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.document_update', $item->uuid) }}" method="post" class="submitForm">
                            <div class="modal-body my-4">
                                @csrf
            
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="">Libelle <span><span class="text-danger">*</span></span></label>
                                        <input class="form-control" type="text" value="{{ $item->libelle }}" name="libelle" autocomplete="off" required placeholder="{{ $item->libelle ?? 'NA' }}">
                                        @error('libelle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="description">Description <span class="text-muted">(facultatif)</span></label>
                                        <textarea class="form-control" value="{{ old('description') }}" name="description" id="" cols="30" rows="2" autocomplete="off">{{ $item->description ?? 'NA' }}</textarea>
                                    </div>
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
        @endif
        


    </div>

@endsection