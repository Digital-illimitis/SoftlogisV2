@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3 text-uppercase">Ordre de transit</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Détail</li>
                </ol>
            </nav>
        </div>
        <!--<div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
            </div>
        </div>-->
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body mt-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-title d-flex align-items-center justify-content-between px-2 py-auto pe-0">
                            <div class="col-12">
                                <h5 class="d-flex align-items-center text-uppercase px-2 my-2 size_16">Informations sur l'ordre de transit</h5>
                            </div>
                        </div>
                        <hr class="mb-2">

                        <div class="card-body size_14">
                            <div class="content">
                                <div class="">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">N°:</h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ ($expTransit->code) ? $expTransit->code : '--' }}</div>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-6">
                                                        <h6 class="mb-0 text-end size_14">Nombre de colis</h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->totalProduct  ?? 0 }}</div>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-6">
                                                        <h6 class="mb-0 text-end size_14">N° Connaissement</h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->numConnaissement  ?? '--' }}</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row my-2">
                                                    <div class="col-6">
                                                        <h6 class="mb-0 text-end size_14">N° Connaissement Original</h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->numConnaiOriginal ?? '--' }}</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Nom du Navire </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->navireName  ?? '--' }}</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row my-2">
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Port de Debarquement</h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->portDembarquement 	 ?? '--' }}</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_13">Montant Facture Fournisseur </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        {{ $expTransit->factFounisseur  ?? 0 }}
                                                    </div>
                                                </div>

                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Colisage</h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->colisage ?? "--" }}</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">N° Certificat d'assurance </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->assurCertifNum ?? "--" }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Montant Facture fret et frais</h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->factFret  ?? 0 }}</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14" title="Fiche Déclaration Importation">FDI </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->frie ?? "--" }}</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">SGSN </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->sgsn ?? "--" }}</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">N°Licence </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->numLicense ?? "--" }}</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Exonération </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->exoneration ?? "--" }}</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Marché </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->marche ?? "--" }}</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Les Marchandises sont à </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->marchandiseAction ?? "--" }}</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Réexpedié à </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->expediteTo ?? "--" }}</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" >
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 text-end size_14">Droit de taxe de douane à acquitter  </h6>
                                                    </div>:
                                                    <div class="col-md-5 text-secondary">
                                                        <div class="text-muted size_13">{{ $expTransit->droitCredit ?? "--" }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <hr class="my-2">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <h6 class="mb-0 size_14">Note <span class="text-muted">(interne)</span></h6>
                                            </div>
                                            <div class="col-12 text-secondary">
                                                <p class="form-control disabled text-start" style="min-height: 100px">
                                                    {{ $expTransit->note ?? '--' }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="col-12 row">
                                            <div class="col-8 row">
                                                <div class="col text-end">Créé par</div>:
                                                <div class="col">{{ $expTransit->user_uuid ?? '--' }}</div>
                                            </div>
                                            <div class="col row">
                                                <div class="col text-end">Le</div>:
                                                <div class="col">{{ $expTransit->created_at->format('d/m/Y') ?? '--' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>


                    <div class="content">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="d-flex align-items-center text-uppercase size_16">Marchandises à transiter</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="table-light">
                                                <tr class="text-uppercase size_14">
                                                    <th>N° Serie</th>
                                                    <th>Famille du produit</th>
                                                    <th>Long (m)</th>
                                                    <th>larg (m)</th>
                                                    <th>HAUT (m)</th>
                                                    <th>POIDS (t)</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            

                                            <tbody style="font-size: 12px !important">
                                                @if($expTransit->products->count() > 0)
                                                    @forelse ($expTransit->products as $otProduct)
                                                        <tr>
                                                            <td>
                                                                {{ $otProduct->numero_serie ?? '--' }}
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0 font-14">
                                                                    {{ $otProduct->familly->libelle ?? '--' }}
                                                                </h6>
                                                            </td>
                                                            <td>{{ $otProduct->longueur ?? '--' }}</td>
                                                            <td>{{ $otProduct->largeur ?? '--' }}</td>
                                                            <td>{{ $otProduct->hauteur ?? '--' }}</td>
                                                            <td>{{ $otProduct->poid_tonne ?? '--' }}</td>
                                                            <td class="d-flex justify-content-end text-end">
                                                                <button type="button" class="btn btn-sm radius-30 px-2 size_10">
                                                                    <a href="{{ route('admin.article.show', ['uuid' => $otProduct->uuid]) }}" class="text-uppercase tex-none  py-1 text-primary"><i class=" size_10 bx bx-show"></i></a>
                                                                </button>
                                                            </td>

                                                        </tr>
                                                    @empty
                                                        <tr>Aucun produit pour ce sourcing</tr>
                                                    @endforelse
                                                @endif
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
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('files/' . $expTransit->transitaire->logo) }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="75 " height="75">
                                <div class="mt-3">
                                    <h4>{{ $expTransit->transitaire->raison_sociale ?? '--' }}</h4>
                                    
                                    <button class="btn btn-primary size_12 p-1 mt-2">
                                        @if ($expTransit->transitaire !== null)
                                        <a href="{{ route('admin.company.show', $expTransit->transitaire->uuid) }}" class="btn btn-primary p-0 px-3">Info</a>
                                        @endif
                                    </button>
                                    {{-- <button class="btn btn-outline-primary">Message</button> --}}
                                </div>
                            </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">
                                        <i class="fadeIn animated bx bx-map"></i>{{  $expTransit->transitaire->localisation ?? '--' }}
                                    </h6>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class="lni lni-phone"></i>
                                        {{ $expTransit->transitaire->phone ?? '--' }}
                                    </h6>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">
                                        <i class="fadeIn animated bx bx-envelope-open"></i>
                                        {{  $expTransit->transitaire->email ?? '--' }}
                                    </h6>
                                </li>
                                
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="d-flex align-items-center mb-3 text-uppercase">Documents</h5>
                            <hr class="my-2">
                            <div class="ms-auto">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addDocTransit{{ $expTransit->uuid }}">
                                    <i class="bx bxs-plus-square"></i> Ajouter
                                </button>
                                
                            </div>
                            <hr class="my-2">
                            <div class="content mx-0 px-0">
                                @if($transite_files)
                                <ul class="list-group px-0 mx-0">
                                    @foreach ($expTransit->files as $transiteFile)
                                        @if($transiteFile->etat == 'actif')
                                            <li class="list-group-item d-flex align-items-center align-self-center row col-12 px-0 mx-0 my-2 w-100 mb-2" style="font-size: 12px;">
                                                <div class="row col-12 w-100" style="font-size: 12px;">
                                                    <div class="col-8 overflow-x-scroll text-start align-self-center">
                                                        <span class="text-uppercase">{{ $transiteFile->name }}</span>
                                                    </div>
                                                    <div class="col-3 d-flex row">
                                                        <button class="col-6 text-primary btn bg-transparent" data-bs-toggle="modal" data-bs-target="#pdfViewModal{{$transiteFile->id}}" title="Voir">
                                                            <i class="lni lni-eye"></i>
                                                        </button>
                                                        @include('admin.od_transite.files.viewDoc')

                                                        <a class="deleteConfirmation col-6 bg-transparent text-decoration-none" data-uuid="{{ $transiteFile->uuid }}"
                                                            data-type="confirmation_redirect" data-placement="top"
                                                            data-token="{{ csrf_token() }}"
                                                            data-url="{{ route('admin.od_transite.delette_doc',$transiteFile->uuid) }}"
                                                            data-title="Vous êtes sur le point de supprimer"
                                                            data-id="{{ $transiteFile->uuid }}" data-param="0"
                                                            data-route="{{ route('admin.od_transite.delette_doc',$transiteFile->uuid) }}">
                                                            <button class="border-0 col-6 text-primary btn bg-transparent" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Supprimer">
                                                                <i class='bx bxs-trash bg-transparent'></i>
                                                            </button>
                                                        </a>

                                                    </div>
                                                </div>
                                            </li>
                                        @endif

                                    @endforeach
                                </ul>
                                @else
                                <p>Aucun document associé à ce odre de transite.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
    @include('admin.expTransit.files.addModal')
    <!--end row-->
</div>
@endsection