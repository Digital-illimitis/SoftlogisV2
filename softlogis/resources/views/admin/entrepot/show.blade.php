@extends('admin.layouts.admin')
@section('section')
<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $entrepot->nom ?? 'N/A' }}</div>
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

        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card radius-10">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3">
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3"><i class='bx bxl-dropbox'></i>
                                </div>
                                <h4 class="my-1">{{ $totalDistinctProductsInEntrepot }}</h4>
                                <p class="mb-0 text-secondary">Produit distinct</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="widgets-icons rounded-circle mx-auto bg-light-danger text-danger mb-3"><i class='bx bx-line-chart-down'></i>
                                </div>
                                <h4 class="my-1">{{ $totalFamiliesInEntrepot}}</h4>
                                <p class="mb-0 text-secondary">Famille de produit</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="widgets-icons rounded-circle mx-auto bg-light-info text-info mb-3"><i class='bx bx-wallet font-30'></i>
                                </div>
                                <h4 class="my-1">{{ number_format($totalAmountInEntrepot, 0, ',', ' ') }} Fcfa</h4>
                                <p class="mb-0 text-secondary">Valeur totale</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i class='bx bxl-youtube'></i>
                                </div>
                                <h4 class="my-1">38M</h4>
                                <p class="mb-0 text-secondary">YouTube Subscribers</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="widgets-icons rounded-circle mx-auto bg-light-warning text-warning mb-3"><i class='bx bxl-dropbox'></i>
                                </div>
                                <h4 class="my-1">28K</h4>
                                <p class="mb-0 text-secondary">Dropbox Users</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!--end row-->

    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Marchandises de l'entrepot</h6>
                </div>
                <div class="dropdown ms-auto">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                            class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                    </a>
                    <ul class="dropdown-menu">

                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Famille</th>
                            <th>Image</th>
                            <th>N* Serie</th>
                            <th>Statut</th>
                            <th>Date Reception</th>
                            <th>Date stockage</th>
                            <th>Conformité</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productsInEntrepot as $product)
                            <tr>
                                <td>{{ $product->familly->libelle ?? ''}}</td>
                                <td><img src="{{ asset('files/' . $product->image) }}" height="50"></td>
                                <td>{{ $product->numero_serie ?? ''}}</td>

                                <td>
                                    @if ($product->status == 'stocked')
                                        <span class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">Reçu/Stocké</span>
                                    @endif
                                </td>
                                <td>{{ Carbon\Carbon::parse($product->date_reception)->format('d/m/Y') ?? ''}}</td>
                                <td>{{ Carbon\Carbon::parse($product->date_stockage)->format('d/m/Y') ?? ''}}</td>
                                <td>
                                    @php
                                        $productConformity =  App\Models\stockUpdate::where('product_id', $product->id)->first();
                                    @endphp
                                   @if (!empty($productConformity))
                                        @if ($productConformity->conformity == 'on')
                                        <span class="badge badge-success p-2 bg-success">
                                            Conforme
                                        </span>
                                        @else
                                        <span class="badge badge-danger p-2 bg-danger">
                                            Non Conforme
                                        </span>
                                        @endif
                                   @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
