@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3 text-uppercase size_16">Stockage</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active size_14" aria-current="page">Mouvement de stock</li>
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
                
                <div class="ms-auto">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editStock">
                        <i class="bx bxs-plus-square"></i> Deplacer produit
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>N° Serie</th>
                            <th>Famille</th>
                            <th>Mouvement</th>
                            <th>Entrepots</th>
                            <th>Modifié par</th>
                            <th>Date de stockage</th>
                            <th>Date de sortie</th>
                            <th>Fiche d'inspection</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mvtUpdates as $mvtUpdate)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14">{{ $mvtUpdate->product->numero_serie ?? '' }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $mvtUpdate->product->familly->libelle ?? '--'}}</td>
                            @if ($mvtUpdate->mouvement == 'In' )
                            <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">In</div></td>
                            @else
                            <td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">Out</div></td>
                            @endif

                            <td>{{ $mvtUpdate->entrepot->nom ?? 'Vrack' }}</td>
                            <td>{{ $mvtUpdate->user->name.' '.$mvtUpdate->user->lastname }}</td>
                            {{-- <td>{{ $mvtUpdate->created_at->diffForHumans() }}</td> --}}
                            <td>{{ $mvtUpdate->product->date_reception ?? '' }}</td>
                            <td>{{ $mvtUpdate->product->date_outStock ?? '' }}</td>

                            <td>
                                @if (!empty($mvtUpdate->file))
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pdfModal{{$mvtUpdate->id}}" class=""><i class="lni lni-eye"></i></a>
                                    </div>
                                @else()
                                    <div>
                                        Acucune fiche chargée
                                    </div>
                                @endif
                            </td>
                        </tr>

                        @include('admin.stock.viewFicheModal')
                        @empty
                            <tr>Aucun mouvement de stock</tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @include('admin.stock.editStock')
</div>



@endsection