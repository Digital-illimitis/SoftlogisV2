@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">IMPORT</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:history.back();"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Sourcing</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">

                {{-- <div class="position-relative">
                    <div class="gap-3">
                        <div class="ms-2 col">
                            <select id="statusFilter" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="draft">Brouillon</option>
                                <option value="started">Démarrage</option>
                                <option value="validateDoc">Validation Documentaire</option>
                                <option value="odTransit">En cours de transit</option>
                                <option value="odlivraison">En cours de livraison</option>
                                <option value="stocked">Reçu/Stocké</option>

                            </select>
                        </div>
                    </div>
                </div> --}}

                <div class="ms-auto">
                    @can('Create Sourcing')
                    <a type="button" class="btn btn-outline-primary" href="{{ route('admin.sourcing.create') }}">
                        <i class="bx bxs-plus-square"></i> Nouveau sourcing
                    </a>
                    @endcan
                </div>
            </div>
            @php $bl = DB::table('sourcings')->groupBy('num_bl')->count(); $num_dossier = DB::table('sourcings')->groupBy('numDossier')->count(); @endphp
            <div class="table-responsive">
                <div class="card-body pb-0 mb-0">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
                        <div class="col">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center cursor-pointer justify-content-between"
                                        onclick="redirectToInFabrication()">
                                        <div>
                                            <p class="mb-0 text-secondary text-uppercase size_12">Nombre de BL</p>
                                            <h4 class="my-1" style="color: blue;">{{$bl}}</h4>
                                        </div>
                                        <div class="text-danger ms-auto font-30">
                                                        <i class='bx bx-file'></i>
                                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center cursor-pointer justify-content-between"
                                        onclick="redirectToInFabrication()">
                                        <div>
                                            <p class="mb-0 text-secondary text-uppercase size_12">Nombre de dossiers</p>
                                            <h4 class="my-1" style="color: orange;">{{$num_dossier}}</h4>
                                        </div>
                                        <div class="widgets-icons bg-light-success text-success ms-auto"><i
                                                class="bx bxs-wallet"></i>
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table  class="table table-striped table-bordered mb-0" id="example2">
                    <thead class="table-light text-uppercase">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>N° Bl</th>
                            <th>N° Dossier</th>
                            <th>N° Declaration</th>
                            <th>Date declaration</th>
                            <th>Produits</th>
                            <th>Date estimative A</th>
                            <th>Date Réelle A</th>
                            <th>ID du navire</th>
                            <th>Documents</th>
                            <th>Statut</th>
                            <th>Publié le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px !important">
                            @forelse($sourcings as $sourcing)
                                <tr>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $loop->iteration ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->code ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->num_bl ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->numDossier ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->declarationNum ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->declarationDate ?? '--' }}</h6>
                                    </td>
                                    
                                    <td class="">
                                        <span>{{ $sourcing->products->count() }}</span>
                                    </td>

                                    <td>{{ $sourcing->date_arriver ?? '--'}}</td>

                                    <td class="text-center">{{ $sourcing->date_reel_arriver ?? "N/D"}}</td>

                                    <td>{{ $sourcing->id_navire ?? '--'}}</td>
                                    <td class="h-100">
                                        <span>{{ $sourcing->files->count() }}</span>
                                    </td>

                                    <td>
                                        @if ($sourcing->statut == "draft")
                                        <div class="badge rounded-pill text-light bg-secondary p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Brouillon
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "started")
                                        <div class="badge rounded-pill text-light bg-secondary p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Demarrage
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "validateDoc")
                                        <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Demarrage document
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "odTransit")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>En cour de transit import
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "odlivraison")
                                        <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>en cours de livraison
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "received")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Reçu ||
                                            <span>{{   $sourcing->products->where('is_received', true)->count()  }}</span> /
                                            <span>{{ $sourcing->products->count() }}</span>
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "stocked")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Stocké
                                        </div>
                                        @endif

                                    </td>
                                    <td>{{ $sourcing->created_at->diffForHumans() }}</td>
                                    <td style="max-width: 100px">
                                        <div class="d-flex order-actions text-end justify-content-between">

                                            <a href="{{ route('admin.sourcing.show', $sourcing->uuid) }}" class="bg-transparent col" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Voir"><i class="lni lni-eye"></i>
                                            </a>

                                            @if ($sourcing->statut === "stocked")
                                            <a type="button" class="border-0 text-success col mx-2 btn">
                                                <i class='bx bxs-package'></i>
                                            </a>
                                            @else
                                            @can('Edit Sourcing')
                                            <a type="button" class="border-0 col mx-2 btn" data-bs-toggle="modal" data-bs-target="#EditSourcing{{ $sourcing->uuid }}">
                                                <i class='bx bxs-edit'></i>
                                            </a>
                                            @endcan
                                            @endif

                                            @can('Delette Sourcing')
                                            <a class="deleteConfirmation col text-decoration-none" data-uuid="{{$sourcing->uuid}}"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-type="confirmation_redirect" data-placement="top"
                                                data-token="{{ csrf_token() }}"
                                                data-url="{{route('admin.sourcing.destroy',$sourcing->uuid)}}"
                                                data-title="Vous êtes sur le point de supprimer {{$sourcing->code}} "
                                                data-id="{{$sourcing->uuid}}" data-param="0"
                                                data-route="{{route('admin.sourcing.destroy',$sourcing->uuid)}}">
                                                <i class='bx bxs-trash '></i>
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                {{-- @include('admin.sourcing.productListModal') --}}
                                @include('admin.sourcing.fileListModal')
                                @include('admin.sourcing.editModal')
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun sourcing</td>
                            </tr>
                            @endforelse
                        {{-- @endforeach --}}

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection