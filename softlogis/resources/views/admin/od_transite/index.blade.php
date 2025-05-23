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
                    <li class="breadcrumb-item active" aria-current="page">Ordre de transit</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative ">

                </div>
                <div class="ms-auto">
                    {{-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#CreateOdreTransite">
                        <i class="bx bxs-plus-square"></i>Creer Nouveau --}}
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead class="table-light text-uppercase">
                        <tr>
                            <th>Num#</th>
                            <th>Code#</th>
                            <th>N°Dossier</th>
                            <th>N°Declaration</th>
                            <th>Transitaire</th>
                            <th>Documents</th>
                            <th>Etat</th>
                            <th>Créé par</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px !important">
                        
                        @php $nombre = 1; @endphp
                        @forelse ($odretransites as $odretransite)
                        @php
                            $sourcing = App\Models\Sourcing::where('uuid', $odretransite->sourcing_uuid)->first()
                        @endphp
                            <tr id="sourcin_tr">
                                <td>{{ $nombre ?? '--'}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value=""
                                                aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">{{ $odretransite->code }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $sourcing->numDossier ?? '--'}}</td>
                                <td>{{ $sourcing->declarationNum ?? '--'}}</td>

                                <td class="">
                                    <span>{{ $odretransite->transitaire->raison_sociale ?? '--' }}</span>
                                </td>

                                <td>{{ $odretransite->files->where('etat', 'actif')->count() }}</td>
                                <td>{{ $odretransite->etat }}</td>
                                <td class="h-100">
                                    <span>{{ $odretransite->user_uuid }}</span>
                                </td>
                                <td style="max-width: 100px">
                                    <div class="d-flex order-actions text-end justify-content-between">
                                        <a href="{{ route('admin.od_transite.show', $odretransite->uuid) }}" class="bg-transparent col" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Plus d'info"><i class="lni lni-eye"></i></a>
                                        @can('Edit Transit')
                                        <button type="button" class="border-0 col text-primary mx-3 btn bg-transparent" data-bs-toggle="modal" data-bs-target="#EditOdreTransite{{ $odretransite->uuid }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>
                                        @endcan

                                        @can('Delette Transit')
                                        <a class="deleteConfirmation col bg-transparent text-decoration-none" data-uuid="{{ $odretransite->uuid }}"
                                            data-type="confirmation_redirect" data-placement="top"
                                            data-token="{{ csrf_token() }}"
                                            data-url="{{ route('admin.od_transite.destroy',$odretransite->uuid) }}"
                                            data-title="Vous êtes sur le point de supprimer {{ $odretransite->code }} "
                                            data-id="{{ $odretransite->uuid }}" data-param="0"
                                            data-route="{{ route('admin.od_transite.destroy',$odretransite->uuid) }}">
                                            <button class="text-danger border-0 bg-trasparent" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Supprimer">
                                                <i class='bx bxs-trash bg-transparent'></i>
                                            </button>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @include('admin.od_transite.editModal')
                            @php $nombre++; @endphp
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun ordre de transit</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- @include('admin.od_transite.addmodal') --}}
</div>
@endsection()