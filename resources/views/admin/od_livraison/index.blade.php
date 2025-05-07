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
                    <li class="breadcrumb-item active" aria-current="page">Ordre de livraison</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>

    {{-- @include('admin.od_livraison.addLivraison') --}}

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Num#</th>
                            <th>Code#</th>
                            <th>Transporteur</th>
                            <th>Date de livraison</th>
                            <th>Lieu de livraison</th>
                            <th>Créé par</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px !important">
                        @php $nombre = 1; @endphp
                        @forelse ($oDLivraisons as $oDLivraison)
                            <tr id="sourcin_tr">
                                <td>{{ $nombre }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value=""
                                                aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">{{ $oDLivraison->code }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <span>{{ $oDLivraison->transporteur->raison_sociale ?? '--' }}</span>
                                </td>

                                <td>{{ $oDLivraison->date_livraison }}</td>
                                <td>{{ $oDLivraison->lieu_livraison }}</td>
                                <td class="h-100">
                                    <span>{{ $oDLivraison->created_by }}</span>
                                </td>
                                <td style="max-width: 100px">
                                    <div class="d-flex order-actions text-end justify-content-between">
                                        <a href="{{ route('admin.od_livraisons.show', $oDLivraison->uuid) }}" class="bg-transparent col" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Plus d'info"><i class="lni lni-eye"></i>
                                        </a>
                                        @can('Edit Transport')
                                        <button type="button" class="border-0 col mx-3 btn bg-transparent" data-bs-toggle="modal" data-bs-target="#EditOdrelivraison{{ $oDLivraison->uuid }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>
                                        @endcan
                                        @can('Delette Transport')
                                        <a class="deleteConfirmation col bg-transparent text-decoration-none" data-uuid="{{ $oDLivraison->uuid }}"
                                            data-type="confirmation_redirect" data-placement="top"
                                            data-token="{{ csrf_token() }}"
                                            data-url="{{ route('admin.od_livraisons.destroy', $oDLivraison->uuid) }}"
                                            data-title="Vous êtes sur le point de supprimer {{ $oDLivraison->code }} "
                                            data-id="{{ $oDLivraison->uuid }}" data-param="0"
                                            data-route="{{ route('admin.od_livraisons.destroy', $oDLivraison->uuid) }}">
                                            <button class="border-0 bg-trasparent" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Supprimer">
                                                <i class='bx bxs-trash bg-transparent'></i>
                                            </button>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            @include('admin.od_livraison.editlivraison')
                            @php $nombre++; @endphp
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun ordre de livraison</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <!--<tfoot>
                        <tr>
                            <th>Code#</th>
                            <th>Transporteur</th>
                            <th>Date de livraison</th>
                            <th>Lieu de livraison</th>
                            <th>Creer par</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>-->
                </table>
            </div>
        </div>
    </div>
</div>

@endsection()