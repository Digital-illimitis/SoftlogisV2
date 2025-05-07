@extends('admin.layouts.admin')
@section('section')
   <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Client</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Commandes</li>
                    </ol>
                </nav>
            </div>
           
        </div>
        <!--end breadcrumb-->
        <div class="container-fluid px-0">
            <div class="card" style="">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-success" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#successhome" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Niveau de Stock</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#successprofile" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Suivi des Commandes</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="successhome" role="tabpanel">                
                            <div class="">
                                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
                                  
                                    <div class="col">
                                        <div class="card radius-10">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center cursor-pointer" onclick="redirectToStocked()">
                                                    <div>
                                                        <p class="mb-0 text-secondary text-uppercase size_12">Reçu/Stocké</p>
                                                        <h4 class="my-1">{{ $receivStock->count() }} </h4>
                                                        <p class="mb-0 font-13 text-danger"><i
                                                                class='bx bxs-down-arrow align-middle'></i>{{ number_format($receivStock->sum('price_unitaire')), 0, ',', ' ' }}
                                                            <span>Fcfa</span></p>
                                                    </div>
                                                    <div class="widgets-icons bg-light-warning text-warning ms-auto">
                                                        <span class="size_12">{{ $percentagereceivStock }} %</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card radius-10">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center cursor-pointer"
                                                    onclick="redirectToExpEnCours()">
                                                    <div>
                                                        <p class="mb-0 text-secondary text-uppercase size_12">Cours de Route export
                                                        </p>
                                                        <h4 class="my-1">{{ $inWaitExpediteExport->count() }} </h4>
                                                        <p class="mb-0 font-13 text-danger"><i
                                                                class='bx bxs-down-arrow align-middle'></i>{{ number_format($inWaitExpediteExport->sum('price_unitaire')), 0, ',', ' ' }}
                                                            <span>Fcfa</span></p>
                                                    </div>
                                                    <div class="widgets-icons bg-light-warning text-warning ms-auto">
                                                        <strong class="size_12">{{ $percentageinWaitExpediteExport }} %</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card radius-10 ">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center cursor-pointer"
                                                    onclick="redirectTodelivered()">
                                                    <div>
                                                        <p class="mb-0 text-secondary text-uppercase size_12">Livré</p>
                                                        <h4 class="my-1">{{ $liverExpedite->count() }} </h4>
                                                        <p class="mb-0 font-13 text-success"><i
                                                                class="bx bxs-up-arrow align-middle"></i>{{ number_format($liverExpedite->sum('price_unitaire')), 0, ',', ' ' }}
                                                            <span>Fcfa</span></p>
                                                    </div>
                                                    <div class="widgets-icons bg-light-success text-success ms-auto">
                                                        <strong class="size_12">{{ $percentageliverExpedite }} %</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 g-0 row-group text-center border-top">
                                <div class="col">
                                    <div class="p-3 " style="position: relative;">
                                        <div class="col-12 row">
                                            <div class="col-4"></div>
                                            <div class="col-4">
                                                <h6 class="mb-0 size_14">{{ $stockGlobals->count() }}</h5>
                                            </div>
                                            <div class="col-4 text-end mt-0 m-0 px-0">
                                                <a href="{{ route('admin.allProduction') }}">
                                                    <img src="{{ asset('icone/voir.png') }}" alt="" style="max-width: 20px">
                                                </a>
                                            </div>
                                        </div>
            
                                        <small class="mb-0 size_12">Quantité sur chaine de production</small>
                                        <p>
                                            <i class="bx bx-up-arrow-alt align-middle"></i>
                                            {{ number_format($stockGlobals->sum('price_unitaire')) }} <span>Fcfa</span>
                                        </p>
                                    </div>
                                </div>
                               
                                <div class="col">
                                    <div class="p-3">
                                        <small>Prochaine arrivée de marchandise</small>
                                        @if ($firstNextArrivage !== null)
                                        <h6
                                            class="mb-0 {{ Carbon\Carbon::parse($firstNextArrivage->date_arriver)->isPast() ? 'text-danger' : '' }}">
                                            {{ Carbon\Carbon::parse($firstNextArrivage->date_arriver)->format('d/m/Y') }}
                                        </h6>
                                        @else
                                        <h6 class="mb-0">Aucun</h6>
                                        @endif
                                        <small class="mb-0">
                                            <button type="button" class=" btn btn-sm bg-transparent" data-bs-toggle="modal"
                                                data-bs-target="#nextArrivageModal">Lister
                                                <i class="bx bx-right-arrow-alt align-middle text-success"></i>
                                            </button>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="successprofile" role="tabpanel">
                            <div class="col-12 ">
                                <div class="card my-0 py-0">
                                    <div class="card-body my-0 py-0">
                                        <div class="row my-0 py-0">
                                            <div class="col-12 col-lg-3">
                                                <div class="card shadow-none border radius-15" data-bs-target="#showViewOrderbystatusModal" data-bs-toggle="modal">
                                                    <div class="card-body cursor-pointer">
                                                        <h5 class="mt-3 mb-0">Démarrage Documentaire</h5>
                                                        <p class="mb-1 mt-4"><span>{{ $orderOnDocument->count() }}</span> <span><i class='bx bx-cart'></i></span>  <span class="float-end">{{ round($orderOnDocumentPercent) }} %</span>
                                                        </p>
                                                        <div class="progress" style="height: 7px;">
                                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $orderOnDocumentPercent }}%;" aria-valuenow="07" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="card shadow-none border radius-15" data-bs-target="#showOrderOnTransitModal" data-bs-toggle="modal">
                                                    <div class="card-body cursor-pointer">
                                                        <h5 class="mt-3 mb-0">En Transit</h5>
                                                        <p class="mb-1 mt-4"><span>{{ $orderOnTransit->count() }}</span><i class='bx bx-cart'></i>  <span class="float-end">{{ round($orderOnTransitPercent) }} %</span>
                                                        </p>
                                                        <div class="progress" style="height: 7px;">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $orderOnTransitPercent }}%;" aria-valuenow="{{ $orderOnTransitPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="card shadow-none border radius-15" data-bs-target="#showOrderOnDeliveryModal" data-bs-toggle="modal">
                                                    <div class="card-body cursor-pointer">
                                                        <h5 class="mt-3 mb-0">En Livraison</h5>
                                                        <p class="mb-1 mt-4"><span>{{ $orderOnDelivery->count() }}</span><i class='bx bx-cart'></i>  <span class="float-end">{{ round($orderOnDeliveryPercent) }} %</span>
                                                        </p>
                                                        <div class="progress" style="height: 7px;">
                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $orderOnDeliveryPercent }}%;" aria-valuenow="{{ $orderOnDeliveryPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="card shadow-none border radius-15" data-bs-target="#showOrderReceivModal" data-bs-toggle="modal">
                                                    <div class="card-body cursor-pointer">
                                                        <h5 class="mt-3 mb-0">Livré</h5>
                                                        <p class="mb-1 mt-4"><span>{{ $orderReceiv->count() }}</span><i class='bx bx-cart'></i>  <span class="float-end">{{ round($orderReceivPercent) }} %</span>
                                                        </p>
                                                        <div class="progress" style="height: 7px;">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $orderReceivPercent }}%;" aria-valuenow="{{ $orderReceivPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h5 class="mb-0">Mes Commandes</h5>
                                            </div>
                                            {{-- <div class="ms-auto"><a href="{{ route('admin.odre_expedition.index') }}" class="btn btn-sm btn-outline-secondary">Voir Tous</a>
                                            </div> --}}
                                        </div>
                                        
                                        <div class="table-responsive mt-2" >
                                            <table id="example2" class="table table-striped table-hover table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Code <i class='bx bx-up-arrow-alt ms-2'></i></th>
                                                        <th>Date De Livraison</th>
                                                        <th>Date de publication</th>
                                                        <th>Statut</th>
                                                        <th>Voie de transport</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @forelse ($allOrder as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div>{{ $item->code ?? '--' }}</div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $item->date_liv ?? '--'}}</td>
                                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                                        @if ($item->statut == 'startedDoc')
                                                            <td class="text-info">Démarrage Documentaire</td>
                                                        @elseif ($item->statut == 'odTransit')
                                                            <td class="text-primary">En Transit</td>
                                                        @elseif ($item->statut == 'odTransport')
                                                            <td class="text-danger">En Cours de Livraison</td>
                                                        @elseif ($item->statut == 'livered')
                                                            <td class="text-warning">Livré</td>
                                                        @else
                                                            <td class="text-secondary">Expedition en cours</td>
                                                        @endif
                                                        <td class="text-capitalize">{{ $item->transport->voie_exp ?? '--' }}</td>
                                                        <td class="cursor-pointer">
                                                            <a href="{{ route('admin.odre_expedition.show', $item->uuid) }}">
                                                                <i class="lni lni-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                        <span class="badge bg-success text-success-light px-3 py-1">Aucune Commande</span></span>
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
        {{-- include --}}
        @include('admin.stock.nextArrivageClient')
        @include('admin.orders.ByStatusClient.onFolder')
        @include('admin.orders.ByStatusClient.onTransit')
        @include('admin.orders.ByStatusClient.onDelivery')
        @include('admin.orders.ByStatusClient.onReceiv')
   </div>
@endsection