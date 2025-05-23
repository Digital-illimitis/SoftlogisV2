@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Transit</p>
                            <h4 class="my-1 text-info">{{count($allTransitAssigned)}}</h4>
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
                            <p class="mb-0 text-secondary">Temps moyen de transit</p>
                            <h4 class="my-1 text-danger">{{$averageTransitTime}} Jours</h4>
                            <p class="mb-0 font-13"></p>
                        </div>
                        
                        <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i
                            class='bx bxs-bar-chart-alt-2'></i>
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
                            <p class="mb-0 text-secondary">Total facture</p>
                            <h4 class="my-1 text-success">{{ number_format($prestationLigne->where('etat', 'actif')->sum('totalLigne'), 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13">{{ count($factures)}} factures</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                            class='bx bxs-wallet'></i>
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
                            <p class="mb-0 text-secondary">Facture en attente de paiement</p>
                            <h4 class="my-1 text-warning">{{ number_format($prestationLignefactureAccepteUuid->where('etat', 'actif')->sum('totalLigne'), 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13">{{count($factureAccepte)}} factures</p>
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
                    <h6 class="mb-0">Recent Transit</h6>
                </div>
                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="example2">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Nom du Navire</th>
                            <th>N° de license</th>
                            <th>Marchandise à </th>
                            <th>Publier le </th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allTransitAssigned as $item)
                        <tr>
                            <td>{{ $item->code ?? '--'}}</td>
                            <td>{{ $item->navireName ?? '--' }}</td>
                            <td>{{ $item->numLicense ?? '--' }}</td>
                            <td>{{ $item->marchandiseAction ?? '--' }}</td>
                            <td>{{ $item->created_at->diffForHumans() ?? '--' }}</td>
                            <td>
                                <a href="{{ route('admin.od_transite.show', $item->uuid) }}"><i  class='lni lni-eye'></i></a>
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
