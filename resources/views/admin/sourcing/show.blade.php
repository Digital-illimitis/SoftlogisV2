@extends('admin.layouts.admin')
@section('section')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Sourcing</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:history.back();"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Détail</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <div class="col-md-12 col-lg-12 d-flex justify-content-between gap-2 d-flex align-items-center py-auto mt-1 pe-0 mx-0">
                        @if ($sourcing->statut === 'draft')
                            <form action="{{ route('admin.statut.ToStarted', ['uuid' => $sourcing->uuid]) }}" method="POST" class="submitForm">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirmSubmission(event)">Soumettre</button>
                            </form>
                        @endif

                        @if ($sourcing->statut === 'started')
                        <form action="{{ route('admin.statut.TostartValidateDoc', ['uuid' => $sourcing->uuid]) }}" method="POST" class="submitForm">
                            @csrf
                            <button type="submit" class="deleteConfirmation btn btn-primary text-primary-light size_16 px-1 w-auto btn-sm" onclick="return confirmSubmission(event)">Démarrage </button>
                        </form>
                        @endif

                        @if (in_array($sourcing->statut, ['started', 'validateDoc']))
                            <form action="{{ route('admin.sourcing.receptCommercialFact', ['uuid' => $sourcing->uuid]) }}" method="POST" class="submitForm @if ($sourcing->is_receivFactCom === 'true') d-none @endif
                                ">
                                @csrf
                                <input type="hidden" value="{{ $sourcing->uuid }}" name="sourcing_uuid">
                                <button type="submit" class="btn btn-primary text-primary-light size_16 px-1 w-auto btn-sm" onclick="return confirmSubmission(event)">Reception Facture commerciale </button>
                            </form>
                        @endif

                        @if ($sourcing->statut === 'validateDoc')
                            <button type="submit" data-bs-toggle="modal" data-bs-target="#CreateOdreTransite" class="btn btn-primary btn-sm" >Ordre de transit</button>
                        @endif

                        @if ($sourcing->statut === 'odTransit')
                        <div class="">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#CreateOdrelivraison">Ordre de livraison
                            </button>
                        </div>
                        @endif

                        @can(['Gerer le Stock'])
                            @if (in_array($sourcing->statut, ['received', 'odlivraison']))
                                @if ($sourcing->products->where('is_received', true)->count() < $sourcing->products->count())
                                    <div class="">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addReception">Reception de produit</button>
                                    </div>

                                @endif
                            @endif
                        @elsecan('Faire Des Entrées De Stock')

                            @if (in_array($sourcing->statut, ['received','odlivraison']))
                                @if ($sourcing->products->where('is_received', true)->count() < $sourcing->products->count())
                                    <div class="">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addReception">Reception de produit</button>
                                    </div>

                                @endif

                            @endif
                        @endcan

                        @can(['Gerer le Stock'])
                            @if (in_array($sourcing->statut, ['odlivraison','stocked', 'received']))
                            <div class="">
                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addStockage">Stocker le produit</button>
                            </div>
                            @endif
                        @endcan
                        <div class="">
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addSendMail">Envoyer un mail</button>
                        </div>

                        <div class="">
                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateDeclaration">Date de declaration </button>
                        </div>
                        

                        @include('admin.stock.reception')
                        @include('admin.stock.stockage')
                        @include('admin.od_livraison.addLivraison')
                        @include('admin.mailToModal')
                        @include('admin.sourcing.modalDeclaration')

                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="container text-center row">
            <div id="stepper1" class="bs-stepper col-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between overflow-x-scroll"
                            role="tablist">

                            @if (in_array($sourcing->statut, ['started', 'validateDoc']))
                            <div class="">
                                <div class="step" data-target="#test-l-1">
                                    <div class="step-trigger " role="tab" id="stepper1trigger1" aria-controls="test-l-1">
                                        <div class="bs-stepper-circle {{ $sourcing->statut === 'started' ? 'bg-success text-light' : '' }}">1</div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title {{ $sourcing->statut === 'started' ? ' text-success' : '' }}">Démarrage Sourcing</h5>
                                            <p class="mb-0 steper-sub-title">Démarrage du sourcing</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-stepper-line"></div>
                            @endif

                            <div class="step" data-target="#test-l-2">
                                <div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                                    <div class="bs-stepper-circle {{ $sourcing->statut === 'validateDoc' ? 'bg-success text-light' : '' }}">2</div>
                                    <div class="">
                                        <h5 class="mb-0 steper-title {{ $sourcing->statut === 'validateDoc' ? 'text-success' : '' }}">Démarrage Document</h5>
                                        <p class="mb-0 steper-sub-title">Validation document</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-stepper-line"></div>

                            <div class="step" data-target="#test-l-3">
                                <div class="step-trigger " role="tab" id="stepper1trigger3" aria-controls="test-l-3">
                                    <div class="bs-stepper-circle {{ $sourcing->statut === 'odTransit' ? 'bg-success text-light' : '' }}">3</div>
                                    <div class="">
                                        <h5 class="mb-0 steper-title {{ $sourcing->statut === 'odTransit' ? 'text-success' : '' }}">Ordre de transit</h5>
                                        <p class="mb-0 steper-sub-title">En cours de transit</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-l-4">
                                <div class="step-trigger " role="tab" id="stepper1trigger4" aria-controls="test-l-4">
                                    <div class="bs-stepper-circle {{ $sourcing->statut === 'odlivraison' ? 'bg-success text-light' : '' }}">4</div>
                                    <div class="">
                                        <h5 class="mb-0 steper-title {{ $sourcing->statut === 'odlivraison' ? 'text-success' : '' }}">Ordre de livraison</h5>
                                        <p class="mb-0 steper-sub-title">En Cours de Livraison</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bs-stepper-line"></div>

                            <div class="step" data-target="#test-l-5">
                                <div class="step-trigger" role="tab" id="stepper1trigger5" aria-controls="test-l-5">
                                    <div class="bs-stepper-circle {{ $sourcing->statut === 'received' ? 'bg-success text-light' : '' }}">5</div>
                                    <div class="">
                                        <h5 class="mb-0 steper-title {{ $sourcing->statut === 'received' ? 'text-success' : '' }}">Reçu</h5>
                                        <p class="mb-0 steper-sub-title">Reception</p>
                                    </div>
                                </div>
                            </div>

                            @if (!in_array($sourcing->statut, ['started', 'validateDoc']))
                            <div class="bs-stepper-line"></div>

                            <div class="step" data-target="#test-l-6">
                                <div class="step-trigger " role="tab" id="stepper1trigger5" aria-controls="test-l-5">
                                    <div class="bs-stepper-circle {{ $sourcing->statut === 'stocked' ? 'bg-success text-light' : '' }}">6</div>
                                    <div class="">
                                        <h5 class="mb-0 steper-title {{ $sourcing->statut === 'stocked' ? 'text-success' : '' }}">Stocké</h5>
                                        <p class="mb-0 steper-sub-title">Mise en stock</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container">
            <div class="main-body mt-4">
                <div class="row">

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-title d-flex align-items-center justify-content-between px-2 py-auto pe-0">
                                <div class="col-12">
                                    <h5 class="d-flex align-items-center text-uppercase px-2 my-2 size_16">Informations sur le sourcing</h5>
                                </div>
                            </div>

                            <hr>
                            <div class="card-body w-100 row">
                                <div class="col-12 row">
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">N° de sourcing</dt>
                                        <dd class="col-sm-6">{{ ($sourcing->code) ? $sourcing->code : '--' }}</dd>
                                    </dl>
                                    {{-- <dl class="row col-6">
                                        <dt class="col-sm-6">N° BL</dt>
                                        <dd class="col-sm-6">{{ ($sourcing->num_bl) ?? '--' }}</dd>
                                    </dl> --}}
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">N° Dossier</dt>
                                        <dd class="col-sm-6">{{ ($sourcing->numDossier) ?? '--' }}</dd>
                                    </dl>

                                </div>

                                <div class="col-12 row my-3">
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Date de départ</dt>
                                        <dd class="col-sm-6">{{ Carbon\Carbon::parse($sourcing->date_depart)->format('d/m/Y') ?? '--' }}</dd>
                                    </dl>
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Date d'arrivée prévisionnelle</dt>
                                        <dd class="col-sm-6">{{ Carbon\Carbon::parse($sourcing->date_arriver)->format('d/m/Y') ?? '--' }}</dd>
                                    </dl>
                                </div>
                                <div class="col-12 row my-3">
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Date réelle d'arrivée </dt>
                                        <dd class="col-sm-6">{{ Carbon\Carbon::parse($sourcing->date_reel_arriver)->format('d/m/Y') ?? '--' }}</dd>
                                    </dl>
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Regime</dt>
                                        <dd class="col-sm-6">{{ $sourcing->regime->regime ?? '--' }}</dd>
                                    </dl>
                                </div>
                                <div class="col-12 row my-3">
                                <dl class="row col-6 my-3">
                                    <dt class="col-sm-6">Identifiant du Navire</dt>
                                    <dd class="col-sm-6">{{ ($sourcing->id_navire) ? $sourcing->id_navire : '--' }}</dd>
                                </dl>
                                
                                <dl class="row col-6 my-3">
                                    <dt class="col-sm-6">Packaging</dt>
                                    <dd class="col-sm-6">{{ $sourcing->packaging ?? '--' }}</dd>
                                </dl>
                                </div>
                                {{-- @dd($sourcing->odLivraisons) --}}
                                <hr class="my-3">

                                <div class="col-12 row mb-3">
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Date de publication</dt>
                                        <dd class="col-sm-6">{{ Carbon\Carbon::parse($sourcing->created_at)->format('d/m/Y') ?? '--' }}</dd>
                                    </dl>
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Publié par</dt>
                                        <dd class="col-sm-6">{{ ($sourcing->created_by) ? $sourcing->created_by : '--' }}</dd>
                                    </dl>
                                </div>
                                <div class=" my-3 col-12">
                                    <div class="col-md-4">
                                        <h6 class="mb-0">Information sur le navire</h6>
                                    </div>
                                    <div class="col-md-12 text-secondary">
                                        <div class="form-control disabled text-start" disabled @readonly(true)>
                                            {{ ($sourcing->info_navire) ? $sourcing->info_navire : '--' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('admin.od_transite.addmodal')
                        </div>
                        <div class="content">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between row">
                                        <h5 class="col d-flex align-items-center text-uppercase size_16">Marchandises</h5>
                                        <div class=" col ms-auto float-end d-flex justify-content-end text-align-end align-items-center align-self-center">
                                            <a href="" data-bs-toggle="modal" data-bs-target="#productListModal{{ $sourcing->uuid }}">
                                                <img src="{{ asset('icone/choix.gif') }}" alt="Modifier" class="img-fluid" style="width: 40px; height: 30px">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead class="table-light">
                                                    <tr class="text-uppercase size_14">
                                                        <th>N° serie</th>
                                                        <th>Famille</th>
                                                        <th>Statut</th>
                                                        <th>Conformité</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size: 12px !important">
                                                    @forelse ($sourcing->products as $sourcingProduct)

                                                        @if($sourcingProduct)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-2">
                                                                        <h6 class="mb-0 font-14">#{{ $sourcingProduct->product->numero_serie ?? '--' }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $sourcingProduct->product->familly->libelle }}</td>
                                                            <td>
                                                                @if ($sourcingProduct->product->status == 'enFabrication')
                                                                    <span class="badge bg-info text-light text-uppercase p-2">En Fabrication</span>
                                                                @endif
                                                                @if ($sourcingProduct->product->status == 'sortiUsine')
                                                                    <span class="badge bg-warning text-uppercase text-light p-2">Sortie d'usine</span>
                                                                @endif
                                                                @if ($sourcingProduct->product->status == 'enExpedition')
                                                                <span class="badge badge-info p-2 bg-info">
                                                                    En cours d'expedition import
                                                                </span>
                                                                @endif
                                                                @if ($sourcingProduct->product->status == 'arriverAuPod')
                                                                <span class="badge badge-success p-2 bg-success">
                                                                    Arrivé au POD
                                                                </span>
                                                                @endif
                                                                @if ($sourcingProduct->product->status == 'received')
                                                                <span class="badge bg-warning py-2 rounded"> <span class="text-uppercase">Reçu</span> | {{  $sourcingProduct->product->date_reception  }}</span>
                                                                @endif
                                                                @if ($sourcingProduct->product->status == 'stocked')
                                                                <span class="badge bg-warning py-2 rounded">Stocké</span>
                                                                @endif
                                                                @if ($sourcingProduct->product->status == 'expEnCours')
                                                                <span class="badge bg-primary py-2 rounded">En cours d'expedition Export</span>
                                                                @endif
                                                                @if ($sourcingProduct->product->status == 'delivered')
                                                                    <span class="badge bg-success py-2 rounded">Livrer</span>
                                                                @endif

                                                            </td>
                                                            <td>
                                                                @php
                                                                    $productConformity = App\Models\stockUpdate::where(['mouvement' => 'In' ,'product_id' => $sourcingProduct->product->id])->first();
                                                                    if ($productConformity) {
                                                                        $result = $productConformity->conformity;
                                                                    }
                                                                @endphp

                                                                @if ($productConformity)
                                                                    @if ($result == 'indefinie')
                                                                    <span class="badge badge-warning p-2 bg-warning">
                                                                        Pas encore receptionné
                                                                    </span>
                                                                    @endif

                                                                    @if ($result === 'off')
                                                                        <span class="badge badge-danger p-2 bg-danger">
                                                                            Non conforme
                                                                        </span>
                                                                    @elseif ($result === 'on')
                                                                        <span class="badge badge-success p-2 bg-success">
                                                                            Conforme
                                                                        </span>
                                                                    @endif

                                                                @endif
                                                            </td>
                                                            <td class=" col ms-auto float-end d-flex justify-content-end text-align-end align-items-center align-self-center">
                                                                <button type="button" class="btn btn-info btn-sm radius-30 px-3 size_12">
                                                                    <a href="{{ route('admin.article.show', ['uuid' => $sourcingProduct->product->uuid]) }}" class="text-uppercase text-decoration-none text-light py-1">Voir</a>
                                                                </button>
                                                            </td>

                                                        </tr>
                                                        @endif
                                                    @empty
                                                        <tr>Aucun produit pour ce sourcing</tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header my-0 py-0 d-flex justify-content-between align-items-center row">
                                <div class="text-uppercase  col-10 size_16">Documents de sourcing</div>
                                <div class="bg-transparent text-center border-0 col-2 p-1 rounded">
                                    <button type="button" class="btn btn-success text-success border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#CreateSourcingFile">
                                        <i class="bx bxs-file-plus fs-3"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
								<div class="table-responsive mt-3">
									<table class="table table-striped table-hover table-sm mb-0">
										<thead>
											<tr>
												<th><i class='bx bx-up-arrow-alt ms-2'></i> Libellé
												</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
                                            @forelse ($sourcing->files as $sourcingFile)
                                            <tr>
												<td>
													<div class="d-flex align-items-center row">
														<div class="col-auto">
                                                            @if ($sourcingFile->statut === 'validate')
                                                                <i class='bx bxs-file-pdf text-success me-2 font-24' ></i>
                                                            @elseif ($sourcingFile->statut === 'refused')
                                                                <i class='bx bxs-file-pdf text-danger me-2 font-24' ></i>
                                                            @else ()
                                                                <i class='bx bxs-file-pdf text-info me-2 font-24' ></i>
                                                            @endif
														</div>
														<div class="font-weight-bold text-primary col-7">
                                                            {{ $sourcingFile->name }}
                                                            <p class="size_12 text-muted">{{ $sourcingFile->created_at->diffForHumans() }}</p>
                                                        </div>

													</div>
												</td>
												<td class="text-center col-3">
                                                    <button class="col-6 text-primary btn bg-transparent" data-bs-toggle="modal" data-bs-target="#pdfModal{{$sourcingFile->id}}" title="Lecture">
                                                        <i class="lni lni-eye"></i>
                                                    </button>
												</td>

											</tr>
                                            @include('admin.sourcing.lirePdf')
                                            @include('admin.sourcing.editDoc')
                                            @empty
                                            <tr>Aucun document associé à ce sourcing.</tr>
                                            @endforelse

										</tbody>
									</table>
								</div>
                            </div>
                            @if ($sourcing->declarationFile)
                            <div class="card-footer">
                                <h6>Declaration import 
                                    <span> 
                                        <button class="text-primary btn bg-transparent" data-bs-toggle="modal" data-bs-target="#pdfModal{{$sourcingFile->id}}" title="Lecture">
                                        <i class="lni lni-eye"></i>
                                        </button>
                                    </span>
                                </h6>
                                <p>{{ $sourcing->declarationDate ?? 'N/A' }}</p>
                            </div>
                            @endif
                            
                        </div>

                        <div class="card">
                            @if ($transit != null)
                            <div class="row col-12 p-3">
                                <div class="col-10 size_14 text-uppercase">Ordre de transit</div>
                                <div class="col-2 text-end"><span> <a href="{{ route('admin.od_transite.show', ['uuid' => $transit->uuid]) }}"><i class="bx bxs-right-arrow-circle size_16"></i></a> </span></div>
                            </div>
                            @endif
                            <hr class="my-2">
                            @if ($transport != null)
                                @foreach ($otBySourcing as $ot)
                                    <div class="row col-12 p-3">
                                        <div class="col-10 size_14 text-uppercase">
                                            Ordre de transport
                                            <div class="text-muted size_10">{{ $ot->transporteur->raison_sociale ?? '--' }}</div>
                                        </div>

                                        <div class="col-2 text-end"><span> <a href="{{ route('admin.od_livraisons.show', ['uuid' => $ot->uuid]) }}"><i class="bx bxs-right-arrow-circle size_16"></i></a> </span></div>
                                    </div>
                                    <hr>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal de creation de documents  --}}
    <!-- Modal -->
    @include('admin.sourcing.productListModal')
    @include('admin.sourcing.addDoc')

    </div>
<script>
    function confirmSubmission(event) {
        let confirmation = confirm("Êtes-vous certain(e) de vouloir procéder à cette étape ?");
        
        if (!confirmation) {
            event.preventDefault(); // Bloque la soumission
            return false;
        }
        
        return true; // Continue la soumission si "OK"
    }
</script>
@endsection