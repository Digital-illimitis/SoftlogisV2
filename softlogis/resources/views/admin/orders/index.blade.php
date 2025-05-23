@extends('admin.layouts.admin')
@section('section')
   <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Centrale d'achat</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Commandes</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

                <button class="order-btn btn-sm">
                    <div>
                        <div class="pencil"></div>
                        <div class="folder">
                            <div class="top">
                                <svg viewBox="0 0 24 27">
                                    <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                                </svg>
                            </div>
                            <div class="paper"></div>
                        </div>
                    </div>
                    <a href="javascript:void(0);" data-bs-target="#addInstruction" data-bs-toggle="modal" class="text-white">Instruction de commande</a>
                </button>
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
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#instructionCMD" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Instruction de Commande</div>
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
                                                <div class="d-flex align-items-center cursor-pointer justify-content-between"
                                                    onclick="redirectToInFabrication()">
                                                    <div>
                                                        <p class="mb-0 text-secondary text-uppercase size_12">En Fabrications</p>
                                                        <h4 class="my-1">{{ $inFabrication->count() }}</h4>
                                                        <p class="mb-0 font-13 text-success"><i
                                                                class='bx bxs-up-arrow align-middle'></i>{{ number_format($inFabrication->sum('price_unitaire')), 0, ',', ' ' }}
                                                            <span>Fcfa</span></p>
                                                    </div>
                                                    <div class="widgets-icons bg-info text-white text-end float-end size_12">
                                                        <strong>{{ $percentageInFabrication }} %</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card radius-10">
                                            {{-- <a href="{{ route('admin.insortiUsine') }}"> --}}
                                            <div class="card-body">
                                                <div class="d-flex align-items-center cursor-pointer"
                                                    onclick="redirectToInsortiUsine()">
                                                    <div>
                                                        <p class="mb-0 text-secondary text-uppercase size_12">Sortie d'usine</p>
                                                        <h4 class="my-1">{{ $inUsineOut->count() }}</h4>
                                                        <p class="mb-0 font-13 text-danger"><i
                                                                class='bx bxs-down-arrow align-middle'></i>{{ number_format($inUsineOut->sum('price_unitaire')), 0, ',', ' ' }}
                                                            <span>Fcfa</span></p>
                                                    </div>
                                                    <div class="widgets-icons bg-light-danger text-danger ms-auto">
                                                        <strong class="size_12">{{ $percentageinUsineOut }} %</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- </a> --}}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card radius-10">
                                            {{-- <a href="{{ route('admin.enExpedition') }}"> --}}
                                            <div class="card-body">
                                                <div class="d-flex align-items-center cursor-pointer"
                                                    onclick="redirectToEnExpedition()">
                                                    <div>
                                                        <p class="mb-0 text-secondary text-uppercase size_12">Cours de route
                                                            import</p>
                                                        <h4 class="my-1">{{ $inWaitExpediteImport->count() }} </h4>
                                                        <p class="mb-0 font-13 text-danger"><i
                                                                class='bx bxs-down-arrow align-middle'></i>{{ number_format($inWaitExpediteImport->sum('price_unitaire')), 0, ',', ' ' }}
                                                            <span>Fcfa</span></p>
                                                    </div>
                                                    <div class="widgets-icons bg-light-warning text-warning ms-auto">
                                                        <strong class="size_12">{{ $percentageinWaitExpediteImport }} %</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- </a> --}}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card radius-10">
                                            {{-- <a href="{{ route('admin.arriverAuPod') }}"> --}}
                                            <div class="card-body">
                                                <div class="d-flex align-items-center cursor-pointer"
                                                    onclick="redirectToArriverAuPod()">
                                                    <div>
                                                        <p class="mb-0 text-secondary text-uppercase size_12">Arrivé au pod</p>
                                                        <h4 class="my-1">{{ $arrivagePod->count() }} </h4>
                                                        <p class="mb-0 font-13 text-danger"><i
                                                                class='bx bxs-down-arrow align-middle'></i>{{ number_format($arrivagePod->sum('price_unitaire')), 0, ',', ' ' }}
                                                            <span>Fcfa</span></p>
                                                    </div>
                                                    <div class="widgets-icons bg-light-warning text-warning ms-auto">
                                                        <strong class="size_12">{{ $percentagearrivagePod }} %</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- </a> --}}
                                        </div>
                                    </div>
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
                                </div>
                                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2" style="min-height: 150px">
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
                                    <div class="col">
                                        <div class="mb-4">
                                            <p class="mb-2 size_12">NEEMBA CI || <span class="text-primary">{{ $familyNemba->count() }}</span><span
                                                    class="float-end">{{ round($percenfamilyNembaCount) }}%</span></p>
                                            <div class="progress" style="height: 7px;">
                                                <div class="progress-bar bg-primary progress-bar-striped"
                                                    role="progressbar" style="width: {{ $percenfamilyNembaCount }}%"></div>
                                            </div>
                                        </div>
            
                                        <div class="mb-4">
                                            <p class="mb-2 size_12">NEEMBA INTERNATIONAL || <span class="text-danger">{{ $familyNembaInter->count() }}</span><span
                                                    class="float-end">{{ round($percenfamilyNembaInter) }}%</span></p>
                                            <div class="progress" style="height: 7px;">
                                                <div class="progress-bar bg-danger progress-bar-striped"
                                                    role="progressbar" style="width: {{ $percenfamilyNembaInter}}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
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
                                        <h5 class="mb-0">{{ $stockPreview }}</h5>
                                        <small class="mb-0">Stock Prévisionnel</small>
                                        <p> <i class="bx bx-up-arrow-alt align-middle"></i>
                                            {{ number_format($stockPreviewValue), 0, ',', ' ' }} <span>Fcfa</span></p>
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
                                                <h5 class="mb-0">Commandes Récentes</h5>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive mt-2" >
                                            <table id="example2" class="table table-striped table-hover table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Code <i class='bx bx-up-arrow-alt ms-2'></i></th>
                                                        <th>N° Dossier</th>
                                                        <th>Date Depart</th>
                                                        <th>Date Arrivée</th>
                                                        <th>Date d'instruction</th>
                                                        <th>Statut</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($orderByCentrals as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div>{{ $item->code ?? '--' }}</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="font-weight-bold">{{ $item->numDossier ?? '--' }}</div>
                                                        </td>
                                                        <td>{{ $item->date_arriver ?? '--'}}</td>
                                                        <td>{{ $item->date_depart ?? '--'}}</td>
                                                        <td>{{ $item->created_at->format("d/m/Y") }}</td>
                                                        @if ($item->statut == 'validateDoc')
                                                            <td class="text-info">Démarrage Documentaire</td>
                                                        @elseif ($item->statut == 'odTransit')
                                                            <td class="text-primary">En Transit</td>
                                                        @elseif ($item->statut == 'odlivraison')
                                                            <td class="text-danger">En Cours de Livraison</td>
                                                        @elseif ($item->statut == 'received')
                                                            <td class="text-warning">Livré</td>
                                                        @else
                                                            <td class="text-secondary">En phase de Démarrage</td>
                                                        @endif
                                                        <td class="cursor-pointer">
                                                            <a href="{{ route('admin.sourcing.show', $item->uuid) }}">
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
                        <div class="tab-pane fade" id="instructionCMD" role="tabpanel">
                            <div class="col-12 ">
                                <div class="card my-0 py-0">
                                    <div class="card-body my-0 py-0">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h5 class="mb-0">Instructions Récentes </h5>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive mt-2" >
                                            <table class="table table-striped table-hover table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Code <i class='bx bx-up-arrow-alt ms-2'></i></th>
                                                        <th>Client</th>
                                                        <th>N° Dossier</th>
                                                        <th>Date Depart</th>
                                                        <th>Lieu de livraison</th>
                                                        <th>Date d'instruction</th>
                                                        <th>Statut</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div>{{ $item->code ?? '--' }}</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="font-weight-bold">{{ $item->client->raison_sociale ?? '--' }}</div>
                                                        </td>
                                                        <td>{{ $item->num_exp ?? '--'}}</td>
                                                        <td>{{ $item->date_liv ?? '--'}}</td>
                                                        <td>{{ $item->lieu_liv ?? '--'}}</td>
                                                        <td>{{ $item->created_at->format("d-m-Y") }}</td>
                                                        @if ($item->statut == 'send')
                                                            <td class="text-info">Brouillon</td>
                                                        @elseif ($item->statut == 'received')
                                                            <td class="text-success">Reçu/Lancement</td>
                                                        @endif
                                                        <td class="cursor-pointer">
                                                            <a href="{{ route('admin.orders.show', $item->uuid) }}"><i class="lni lni-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    
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
        @include('admin.stock.nextArrivage')
        @include('admin.orders.ByStatus.onFolder')
        @include('admin.orders.ByStatus.onTransit')
        @include('admin.orders.ByStatus.onDelivery')
        @include('admin.orders.ByStatus.onReceiv')
        @include('admin.orders.addInstruction')
   </div>
@endsection