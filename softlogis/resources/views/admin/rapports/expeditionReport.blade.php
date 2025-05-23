@extends('admin.layouts.admin')
@section('section')
   <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Rapport</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Expedition</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

              
            </div>
        </div>
        <!--end breadcrumb-->
        <hr class="my-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total livraisons</p>
                                <h4 class="my-1">{{count($expeditions) ?? 0 }}</h4>
                                <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>{{ count($expeditionsForWeek) }} cette semaine</p>
                            </div>
                            <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Livraison dans le delais</p>
                                <h4 class="my-1">{{ count($expeditionsInDelais) }}</h4>
                                <p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i></p>
                            </div>
                            <div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-group'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Livraison en retard</p>
                                <h4 class="my-1">{{ count($expeditionsAfterDelai) }}</h4>
                                <p class="mb-0 font-13 text-danger"><i class='bx bxs-down-arrow align-middle'></i></p>
                            </div>
                            <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-binoculars'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Taux de livraison</p>
                                <h4 class="my-1">{{ $tauxLivraisonTotal }}%</h4>
                                <p class="mb-0 font-13 text-danger"><i class='bx bxs-down-arrow align-middle'></i>{{ $tauxLivraisonSemaine }}% semaine en cour</p>
                            </div>
                            <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-line-chart-down'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
        <div class="container-fluid px-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ecart de date d'instruction / livraison</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.report.expedition') }}">
                        <div class="form-group">
                            <label for="num_dossier">Numéro de Commande</label>
                            <input type="text" class="form-control" id="num_dossier" name="num_dossier" placeholder="Saisissez le numéro de dossier" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Filtrer</button>
                    </form>
                </div>
            </div>


            
            @if(isset($order) && isset($expedition))
                <div class="card mt-5">
                    <div class="card-body gy-3">
                        <h5>Commande et Expédition pour le dossier : {{ $order->num_dossier }}</h5>
                        <p><strong>Commande créée le :</strong> {{ $order->created_at }}</p>
                        <p><strong>Expédition créée le :</strong> {{ $expedition->created_at }}</p>
                        <p><strong>Temps de traitement :</strong> {{ $tempsTraitement->days }} jours, {{ $tempsTraitement->h }} heures et {{ $tempsTraitement->i }} minutes</p>
                    </div>
                </div>
            @endif
            @if(isset($order) && isset($expedition))
            <div class="row">
                <div class="card col">
                    <h6 class="mb-3">INSTRUCTION DE COMMANDE</h6>
                    <table class="table table-striped table-bordered">
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
                            {{-- @foreach ($orders as $item) --}}
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>{{ $order->code ?? '--' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $order->client->raison_sociale ?? '--' }}</div>
                                </td>
                                <td>{{ $order->num_exp ?? '--'}}</td>
                                <td>{{ $order->date_liv ?? '--'}}</td>
                                <td>{{ $order->lieu_liv ?? '--'}}</td>
                                <td>{{ $order->created_at->format("d-m-Y") }}</td>
                                @if ($order->statut == 'send')
                                    <td class="text-info">Brouillon</td>
                                @elseif ($order->statut == 'received')
                                    <td class="text-success">Reçu/Lancement</td>
                                @endif
                                <td class="cursor-pointer">
                                    <a href="{{ route('admin.orders.show', $order->uuid) }}"><i class="lni lni-eye"></i></a>
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                            
                        </tbody>
                    </table>
                </div>
                <div class="card col">
                    <h6 class="mb-3">EXPEDITION</h6>
                    <table class="table table-striped table-bordered">
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
                                        <span class="badge bg-success text-success-light px-3 py-1">Facturer</span>
                                    @endif
                                    @if ($expedition->statut == 'orderRecu')
                                        <span class="badge bg-success text-success-light px-3 py-1">Reçu/Client</span>
                                    @endif
                                </td>

                                <td>{{ $expedition->date_liv ?? 'N/A' }}</td>
                                <td>{{ $expedition->created_at->format("d-m-Y") ?? 'N/A'}}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.odre_expedition.show', $expedition->uuid) }}" class="">
                                            <i class="lni lni-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
   </div>
@endsection