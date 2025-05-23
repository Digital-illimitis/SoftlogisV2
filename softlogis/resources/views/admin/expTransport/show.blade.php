@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3 text-uppercase">Ordre de transport</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#destockageModal">Destockage</button> --}}
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('files/' . $extransport->transporteur->logo) }}" alt="Company  logo" class="rounded-circle p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4 class="text-uppercase">{{ $extransport->transporteur->raison_sociale ?? 'N/A' }}</h4>
                                    <p class="text-secondary mb-1 text-uppercase size_12">{{ $extransport->transporteur->type ?? 'N/A' }}</p>
                                    <p class="text-muted font-size-sm my-2 text-capitalize size_14">{{ $extransport->transporteur->voie_transport ?? 'N/A' }}</p>

                                    <button class="btn btn-outline-primary">Plus d'info</button>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Site Web</h6>
                                    <span class="text-secondary">https://coderventByJm.com</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Email</h6>
                                    <span class="text-secondary">{{ $extransport->transporteur->email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Phone</h6>
                                    <span class="text-secondary">{{ $extransport->transporteur->phone }}</span>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body row">
                            <div class="col-sm-12 col-md-6">
                                <div class="row mb-3">
                                    <div class="col-sm-7">
                                        <h6 class="mb-0">Code :</h6>
                                    </div>
                                    <div class="col-sm-5 text-secondary">
                                        {{ $extransport->code }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-7">
                                        <h6 class="mb-0">Lieu d'expedition :</h6>
                                    </div>
                                    <div class="col-sm-5 text-secondary">
                                        {{ $extransport->destination }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-7">Créé par :</div>
                                    <div class="col-sm-5 text-secondary">
                                        {{ $extransport->user_uuid }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row mb-3">
                                    <div class="col-sm-7">
                                        <h6 class="mb-0">Date d'expedition :</h6>
                                    </div>
                                    <div class="col-sm-5 text-secondary">
                                        {{ Carbon\Carbon::parse($extransport->date_transport)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-7">
                                        <h6 class="mb-0">Voie d'Expedition :</h6>
                                    </div>
                                    <div class="col-sm-5 text-secondary text-capitalize">
                                        {{ $extransport->voie_exp }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-7">Date de creation :</div>
                                    <div class="col-sm-5 text-secondary">
                                        {{ $extransport->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="row my-4 col-12">
                                <div class="col-sm-12 col-md-12">
                                    <h6 class="mb-0">Note :</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 text-secondary bg-light p-4">
                                    <p>
                                        {{ $extransport->note }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h5 class="mb-0">Documents associés</h5>
                                        </div>
                                        <div class="ms-auto">
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped table-hover table-sm mb-0">
                                            <thead>
                                                <tr>

                                                    <th>Libellé <i class='bx bx-up-arrow-alt ms-2'></i></th>
                                                    <th>Ajouté par</th>
                                                    <th>Date d'ajout</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($ordreTransportFile as $fileDoc)

                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div><i class='bx bxs-file-pdf me-2 font-24 text-info'></i>
                                                            </div>
                                                            <div class="font-weight-bold text-danger">{{ $fileDoc->name }}</div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $fileDoc->user_uuid }}</td>
                                                    <td>{{ $fileDoc->created_at->diffForHumans() }}</td>
                                                    <td>
                                                        <i data-bs-toggle="modal" data-bs-target="#pdfModal{{$fileDoc->id}}" class='lni lni-eye font-24 pointer' style="font-size: 30px; cursor: pointer;"></i>
                                                    </td>
                                                </tr>
                                                @include('admin.expTransport.showFile')
                                                @empty

                                                <tr>
                                                    <span>Aucun document associé</span>
                                                </tr>

                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @include('admin.expTransport.destockageModal') --}}
@endsection