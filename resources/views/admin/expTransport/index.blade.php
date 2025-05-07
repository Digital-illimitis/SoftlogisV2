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
                    <li class="breadcrumb-item active" aria-current="page">Ordre de Transport</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">

            <div class="table-responsive text-center">
                <table class="table table-bordered mb-0">
                    <thead class="table-light text-uppercase">

                        <tr class="">
                            <th>Code#</th>
                            <th>Transporteur</th>
                            <th>Voie d'expedition</th>
                            <th>Date d'expedition</th>
                            <th>Date de publication</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px !important">
                        @forelse ($ordreTransports as $ordreTransport)
                        <tr id="sourcin_tr">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14">#{{ $ordreTransport->code }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $ordreTransport->transporteur->raison_sociale ?? 'N/A' }}</td>
                            <td class="text-center text-capitalize">
                                {{ $ordreTransport->voie_exp ?? 'N/A' }}
                            </td>
                            <td>{{ $ordreTransport->date_transport }}</td>
                            <td>{{ $ordreTransport->created_at->diffForHumans() }}</td>

                            <td style="max-width: 100px">
                                <div class="d-flex order-actions text-end justify-content-between">
                                    <a href="{{ route('admin.expTransport.show', $ordreTransport->uuid) }}" class="bg-transparent col" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Plus d'info"><i class="lni lni-eye"></i></a>

                                    @can('Edit Transport')
                                    <a class="col bg-transparent text-decoration-none mx-2" data-bs-toggle="modal" data-bs-target="#editOrdreTransport{{ $ordreTransport->uuid }}">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    @endcan

                                    @can('Delette Transport')
                                    <a class="deleteConfirmation col bg-transparent text-decoration-none" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-uuid="{{ $ordreTransport->uuid }}"
                                        data-type="confirmation_redirect" data-placement="top"
                                        data-token="{{ csrf_token() }}"
                                        data-url="{{ route('admin.transport.destroy',$ordreTransport->uuid) }}"
                                        data-title="Vous êtes sur le point de supprimer {{ $ordreTransport->code }} "
                                        data-id="{{ $ordreTransport->uuid }}" data-param="0"
                                        data-route="{{ route('admin.transport.destroy',$ordreTransport->uuid) }}">
                                        <i class='bx bxs-trash bg-transparent'></i>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @include('admin.expTransport.editModal')
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucun ordre de transport</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection