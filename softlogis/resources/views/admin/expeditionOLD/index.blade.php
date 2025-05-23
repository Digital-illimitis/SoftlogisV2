@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">EXPORT</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ordre d'expedition</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mt-3 d-none">
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="font-30 text-primary"><i class='bx bxs-folder'></i>
                                        </div>
                                        <div class="user-groups ms-auto">
                                            <img src="{{ asset('assets/images/avatars/avatar-1.png') }}" width="35" height="35" class="rounded-circle" alt="" />
                                            <img src="assets/images/avatars/avatar-2.png" width="35" height="35" class="rounded-circle" alt="" />
                                        </div>
                                        <div class="user-plus">+</div>
                                    </div>
                                    <h6 class="mb-0 text-primary">En attente</h6>
                                    <small>15 files</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="font-30 text-primary"><i class='bx bxs-folder'></i>
                                        </div>
                                        <div class="user-groups ms-auto">
                                            <img src="assets/images/avatars/avatar-4.png" width="35" height="35" class="rounded-circle" alt="" />
                                        </div>
                                    </div>
                                    <h6 class="mb-0 text-primary">Livré</h6>
                                    <small>345 files</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="font-30 text-primary"><i class='bx bxs-folder'></i>
                                        </div>
                                        <div class="user-groups ms-auto">
                                            <img src="assets/images/avatars/avatar-7.png" width="35" height="35" class="rounded-circle" alt="" />
                                            <img src="assets/images/avatars/avatar-8.png" width="35" height="35" class="rounded-circle" alt="" />
                                        </div>
                                    </div>
                                    <h6 class="mb-0 text-primary">Valider</h6>
                                    <small>143 files</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                    <div class="d-flex align-items-center">
                        <div>
                            {{-- <h5 class="mb-0">Ordre d'expedition</h5> --}}
                        </div>
                        <div class="ms-auto">
                            @can('Create Expedition')
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#expeditionModal">Creer nouveau</button>
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Code <i class='bx bx-up-arrow-alt ms-2'></i></th>
                                    <th>N° Commande </th>
                                    <th>Client</th>
                                    <th>Statut</th>
                                    <th>Date livraison</th>
                                    <th>Date publication</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($expeditions as $expedition)
                                <tr>
                                    <td>{{ $expedition->code ?? 'N/A' }}</td>
                                    <td>{{ $expedition->num_order ?? 'N/A' }}</td>
                                    <td>
                                        <div class="font-weight-bold text-info">{{ $expedition->client->raison_sociale ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        @if ($expedition->statut == 'draft')
                                            <span class="badge bg-secondary text-secondary-light px-3 py-1">Brouillon</span>
                                        @endif
                                        @if ($expedition->statut == 'started')
                                            <span class="badge bg-warning text-warning-light px-3 py-1">Demarrage</span>
                                        @endif
                                        @if ($expedition->statut == 'startedDoc')
                                            <span class="badge bg-primary text-primary-light px-3 py-1">Demarrage Documennt</span>
                                        @endif
                                        @if ($expedition->statut == 'odTransit')
                                            <span class="badge bg-info text-info-light px-3 py-1">Ordre de transit</span>
                                        @endif
                                        @if ($expedition->statut == 'odTransport')
                                            <span class="badge bg-danger text-danger-light px-3 py-1">Ordre de transport</span>
                                        @endif
                                        @if ($expedition->statut == 'outStock')
                                            <span class="badge bg-info text-info-light px-3 py-1">Destockage</span>
                                        @endif
                                        @if ($expedition->statut == 'wait_exp')
                                            <span class="badge bg-success text-success-light px-3 py-1">En cours d'export</span>
                                        @endif
                                        @if ($expedition->statut == 'livered')
                                            <span class="badge bg-success text-success-light px-3 py-1">Livré</span>
                                        @endif
                                        @if ($expedition->statut == 'facturer')
                                            <span class="badge bg-success text-success-light px-3 py-1">Facturé</span>
                                        @endif
                                        @if ($expedition->statut == 'orderRecu')
                                            <span class="badge bg-success text-success-light px-3 py-1">Reçu/Client</span>
                                        @endif
                                    </td>

                                    <td>{{ $expedition->date_liv ?? 'N/A' }}</td>
                                    <td>{{ $expedition->created_at->diffForHumans() ?? 'N/A'}}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="{{ route('admin.odre_expedition.show', $expedition->uuid) }}" class="">
                                                <i class="lni lni-eye"></i>
                                            </a>

                                            @can('Edit Expedition')
                                            <a data-bs-toggle="modal" data-bs-target="#editExpeditionModal{{ $expedition->uuid }}"  class="" style="cursor: pointer"><i class='bx bxs-edit'></i></a>
                                            @endcan

                                            @can('Delette Expedition')
                                            <a class="deleteConfirmation"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-uuid="{{$expedition->uuid}}"
                                                data-type="confirmation_redirect" data-placement="top"
                                                data-token="{{ csrf_token() }}"
                                                data-url="{{route('admin.odre_expedition.destroy',$expedition->uuid)}}"
                                                data-title="Vous êtes sur le point de supprimer {{$expedition->code}}"
                                                data-id="{{$expedition->uuid}}" data-param="0"
                                                data-route="{{route('admin.odre_expedition.destroy',$expedition->uuid)}}">
                                                <i class='bx bxs-trash' style="cursor: pointer"></i>
                                            </a>

                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.expedition.editModal')
                                @empty
                                <tr class="text-center bold">Aucun ordre d'expedition</tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    @include('admin.expedition.addModal')
</div>
@endsection