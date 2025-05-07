@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Ordre Tr</p>
                            <h4 class="my-1 text-info">{{count($allTransports)}}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i
                                class='bx bxs-cart'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Temps moyens de transport</p>
                            <h4 class="my-1 text-danger">{{$averageTransportTime}} Jours</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i
                                class='bx bxs-wallet'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        
                        <div>
                            <p class="mb-0 text-secondary">Total Factures</p>
                            <h4 class="my-1 text-success">{{count($facturesTRansport)}}</h4>
                            <p class="mb-0 font-13">{{$prestationTotalTr->where('etat', 'actif')->sum('totalLigne')}} Fcfa</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                class='bx bxs-bar-chart-alt-2'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total en attente de paiement</p>
                            <h4 class="my-1 text-warning">{{count($factureAccepteTr)}}</h4>
                            <p class="mb-0 font-13">{{$prestationTotalTrAccepter->where('etat', 'actif')->sum('totalLigne')}} Fcfa</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                class='bx bxs-group'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Recent Ordre de transport</h6>
                </div>
                <div class="dropdown ms-auto">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                            class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                    </a>
                   
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>N° Ot</th>
                            <th>N° Bl</th>
                            <th>Point de depart </th>
                            <th>Lieu de livraison</th>
                            <th>Nombre de colis</th>
                            <th>publié le</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allTransports as $item )
                        <tr>
                            <td>{{$item->code ?? 'N/A'}}</td>
                            <td>{{$item->numOt ?? 'N/A' }}</td>
                            <td>{{$item->numBl ?? 'N/A' }}</td>
                            <td>{{$item->trajetStart->libelle ?? 'N/A' }}</td>
                            <td>{{$item->trajetEnd->libelle ?? 'N/A' }}</td>
                            <td>{{$item->nbrMachine ?? 0 }}</td>
                            <td>{{$item->created_at ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
