@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3 text-uppercase">EXport</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Ordre de transit</li>
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
           
            <div class="ms-auto">
                {{-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#CreateOdreTransite">
                    <i class="bx bxs-plus-square"></i>Creer Nouveau
                </button> --}}
            </div>
        </div>
        <div class="table-responsive text-center">
            <table class="table table-bordered mb-0" id="example2">
                <thead class="table-light text-uppercase">
                    <tr>
                        <th>Code#</th>
                        <th>Transitaire</th>
                        <th>Documents</th>
                        <th>Date de creation</th>
                        <th>Créé par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody style="font-size: 12px !important">

                    @forelse ($transits as $transit)
                        <tr id="sourcin_tr">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value=""
                                            aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14">{{ $transit->code ?? '--' }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="">
                                <span>{{ $transit->transitaire->raison_sociale ?? '--' }}</span>
                            </td>

                            <td>{{ $transit->files->count() }}</td>
                            <td>{{ $transit->created_at->diffForHumans()  ?? '--'}}</td>
                            <td class="h-100">
                                <span>{{ $transit->user_uuid ?? '--'}}</span>
                            </td>
                            <td style="max-width: 100px">
                                <div class="d-flex order-actions text-end justify-content-between">
                                    <a href="{{ route('admin.transit.to_expedition.show',$transit->uuid) }}" class="bg-transparent col" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Plus d'info"><i class="lni lni-eye"></i></a>

                                    @can('Edit Transit')
                                    <a class="col bg-transparent text-decoration-none mx-2" data-bs-toggle="modal" data-bs-target="#EditOdreTransite{{ $transit->uuid }}">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    @endcan

                                    @can('Delette Transit')
                                    <a class="deleteConfirmation col bg-transparent text-decoration-none" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-uuid="{{ $transit->uuid }}"
                                        data-type="confirmation_redirect" data-placement="top"
                                        data-token="{{ csrf_token() }}"
                                        data-url="{{ route('admin.transit.to_expedition.destroy',$transit->uuid) }}"
                                        data-title="Vous êtes sur le point de supprimer {{ $transit->code }} "
                                        data-id="{{ $transit->uuid }}" data-param="0"
                                        data-route="{{ route('admin.transit.to_expedition.destroy',$transit->uuid) }}">
                                        <i class='bx bxs-trash bg-transparent'></i>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @include('admin.expTransit.editModal')
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucun ordre de transite</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection