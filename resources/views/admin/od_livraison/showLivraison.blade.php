@extends('admin.layouts.admin')
@section('section')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3 row">
            <div class="breadcrumb-title pe-3 text-uppercase size_14 col-2">Ordre de Livraison</div>
            <div class="ps-3 col-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:history.back();"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active size_14" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
            {{-- <div class="text-end d-flex  justify-content-end col-3">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addReception">
                    <i class="bx bxs-plus-square"></i>Reception
                </button>
            </div>
            @include('admin.stock.reception') --}}
            <div class="ms-auto">
                <div class="btn-group float-lg-end">
                    <button type="button" class="btn btn-primary btn-sm rounded my-auto text-white">
                        <a href="{{route('admin.od_livraison.downloadOtPDF', $oDLivraison->id)}}"
                            class="text-center text-decoration-none text-white"><i class="bx bxs-file-pdf"></i> Export PDF</a>
                    </button>
                     @if($oDLivraison->transporteur)
                    <button class="btn btn-primary btn-sm rounded  ms-2 my-auto text-white" data-bs-toggle="modal" data-bs-target="#addSendMail{{ $oDLivraison->id }}"><i class="bx bxs-envelope"></i>Envoyer</button>
                     @else
                     <button class="btn btn-primary btn-sm rounded  ms-2 my-auto text-white disabled" title="Ce transporteur n'a pas d'email"><i class="bx bxs-envelope"></i>Envoyer</button>
                     @endif
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="container">
            <div class="main-body mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-title d-flex align-items-center justify-content-between px-2 py-auto pe-0">
                                <div class="col-12">
                                    <h5 class="d-flex align-items-center text-uppercase px-2 my-2 size_16">Informations sur l'ordre de livraison</h5>
                                </div>
                            </div>
                            <hr class="mb-2">

                            <div class="card-body size_14">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-5">
                                            {{-- <p class="mb-0">Transporteur</p>
                                            <div class="my-2">
                                                <div class="col-md-4">
                                                    <h6 class="mb-0 text-muted">{{ $oDLivraison->transporteur->raison_sociale ?? '--' }}</h6>
                                                </div>
                                                <div class="col-md-6 text-secondary">
                                                    <div class="text-muted">{{ ($oDLivraison->transporteur->email ?? '') ? $oDLivraison->transporteur->email : '--' }}</div>
                                                </div>
                                                <div class="col-md-2">
                                                    @if ($oDLivraison->transporteur !== null)
                                                    <a href="{{ route('admin.company.show', $oDLivraison->transporteur->uuid) }}" class="btn btn-primary">Plus d'info</a>
                                                    @endif
                                                </div>
                                            </div> --}}

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column align-items-center text-center">
                                                        @if($oDLivraison->transporteur)
                                                        <img src="{{ asset('files/' . $oDLivraison->transporteur->logo) }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="75 " height="75">
                                                        @else
                                                        <img src="https://th.bing.com/th?id=OIP.rBP2tD2fhhH0dtnmnuIIswHaH0&w=243&h=256&c=8&rs=1&qlt=90&r=0&o=6&pid=3.1&rm=2" alt="Admin" class="rounded-circle p-1 bg-primary" width="75 " height="75">
                                                        @endif
                                                        <div class="mt-3">
                                                            <h4>{{ $oDLivraison->transporteur->raison_sociale ?? '--' }}</h4>
                                                            

                                                            
                                                            <button class="btn btn-primary size_12 p-1 mt-2">
                                                                @if ($oDLivraison->transporteur !== null)
                                                                <a href="{{ route('admin.company.show', $oDLivraison->transporteur->uuid) }}" class="btn btn-primary p-0 px-3">Info</a>
                                                                @endif
                                                            </button>
                                                            {{-- <button class="btn btn-outline-primary">Message</button> --}}
                                                        </div>
                                                    </div>
                                                    <hr class="my-4" />
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <h6 class="mb-0">
                                                                <i class="fadeIn animated bx bx-map"></i>{{  $oDLivraison->transporteur->localisation ?? '--' }}
                                                            </h6>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <h6 class="mb-0"><i class="lni lni-phone"></i>
                                                                {{ $oDLivraison->transporteur->phone ?? '--' }}
                                                            </h6>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <h6 class="mb-0">
                                                                <i class="fadeIn animated bx bx-envelope-open"></i>
                                                                {{  $oDLivraison->transporteur->email ?? '--' }}
                                                            </h6>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6 class="mb-0 text-end size_14">N°:</h6>
                                                </div>:
                                                <div class="col-md-7 text-secondary">
                                                    <div class="text-muted size_13">{{ ($oDLivraison->code) ? $oDLivraison->code : '--' }}</div>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-4">
                                                    <h6 class="mb-0 text-end size_14">Date</h6>
                                                </div>:
                                                <div class="col-md-7 text-secondary">
                                                    <div class="text-muted size_13">{{ $oDLivraison->created_at->format('d/m/Y') }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6 class="mb-0 text-end size_14">N°Dossier</h6>
                                                </div>:
                                                <div class="col-md-7 text-secondary">
                                                    <div class="text-muted size_13">{{ $oDLivraison->numFolder ?? '--' }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="row my-2">
                                                <div class="col-md-4">
                                                    <h6 class="mb-0 text-end size_14">N° BL</h6>
                                                </div>:
                                                <div class="col-md-7 text-secondary">
                                                    <div class="text-muted size_13">{{ $oDLivraison->numBl ?? '--' }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6 class="mb-0 text-end size_13">Trajet</h6>
                                                </div>:
                                                <div class="col-md-7 text-secondary row">
                                                    <div class="text-start col-3 size_12 "><strong>{{ $oDLivraison->trajetStart->libelle ?? '--' }}</strong></div> 
                                                    <div class="col-1 size_12">à</div>
                                                    <div class="text-start col-3 size_12 "><strong>{{ $oDLivraison->trajetEnd->libelle ?? '--' }}</strong></div>
                                                </div>
                                            </div>

                                            <div class="row mt-2" >
                                                <div class="col-md-4">
                                                    <h6 class="mb-0 text-end size_14">Ref Cotation</h6>
                                                </div>:
                                                <div class="col-md-7 text-secondary">
                                                    <div class="text-muted size_13">{{ $oDLivraison->refCotation ?? '--' }}</div>
                                                </div>
                                            </div>

                                            <hr class="my-2">
                                            <div class="col-12">
                                                <div class="col-12">
                                                    <h6 class="mb-0 size_14">Note <span class="text-muted">(interne)</span></h6>
                                                </div>
                                                <div class="col-12 text-secondary">
                                                    <p class="form-control disabled text-start" style="min-height: 100px">
                                                        {{ $oDLivraison->note ?? '--' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <hr class="my-2">
                                            <div class="col-12 row">
                                                <div class="col-8 row">
                                                    <div class="col text-end">Créé par</div>:
                                                    <div class="col">{{ $oDLivraison->created_by ?? '--' }}</div>
                                                </div>
                                                <div class="col row">
                                                    <div class="col text-end">Le</div>:
                                                    <div class="col">{{ $oDLivraison->created_at->format('d/m/Y') ?? '--' }}</div>
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
                                        <h5 class="d-flex align-items-center text-uppercase size_16">Marchandises Attendues</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead class="table-light">
                                                    <tr class="text-uppercase size_14">
                                                        <th>Nbre</th>
                                                        <th>Famille du produit</th>
                                                        <th>Long (m)</th>
                                                        <th>larg (m)</th>
                                                        <th>HAUT (m)</th>
                                                        <th>POIDS (t)</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                

                                                <tbody style="font-size: 12px !important">
                                                    @if ($oDLivraison->otProducts->count() > 0)
                                                        @forelse ($oDLivraison->otProducts as $otProduct)
                                                            <tr>
                                                                <td>
                                                                    {{ $otProduct->qty ?? '--' }}
                                                                </td>
                                                                <td>
                                                                    <h6 class="mb-0 font-14">
                                                                        {{ $otProduct->product->familly->libelle ?? '--' }}
                                                                    </h6>
                                                                </td>
                                                                <td>{{ $otProduct->product->longueur ?? '--' }}</td>
                                                                <td>{{ $otProduct->product->largeur ?? '--' }}</td>
                                                                <td>{{ $otProduct->product->hauteur ?? '--' }}</td>
                                                                <td>{{ $otProduct->product->poid_tonne ?? '--' }}</td>
                                                                <td class="d-flex justify-content-end text-end">
                                                                    <button type="button" class="btn btn-sm radius-30 px-2 size_10">
                                                                        <a href="{{ route('admin.article.show', ['uuid' => $otProduct->product->uuid]) }}" class="text-uppercase tex-none  py-1 text-primary"><i class=" size_10 bx bx-show"></i></a>
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
                            <div class="card-header my-0 py-0 d-flex justify-content-between align-items-center row">
                                <div class="text-uppercase  col-10 size_16">Documents</div>
                                <div class="bg-transparent text-center border-0 col-2 p-1 rounded">
                                    <button type="button" class="btn btn-success text-success border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#CreateLivraisonFile">
                                        <i class="bx bxs-file-plus fs-3"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
								<div class="table-responsive mt-3">
									<table class="table table-striped table-hover table-sm mb-0">
										<thead>
											<tr>
												<th class="w-75"><i class='bx bx-up-arrow-alt ms-2'></i> Libellé
												</th>
												<th class="w-25">Action</th>

											</tr>
										</thead>
										<tbody>
                                            @forelse ($oDLivraison->files as $livraisonFile)
                                            <tr class="w-100">
												<td class="w-75">
													<div class="d-flex align-items-center row">
														<div class="col-2">
                                                            <i class='bx bxs-file-pdf text-info me-2 font-24' ></i>
														</div>
														<div class="font-weight-bold text-primary col-10">
                                                            {{ $livraisonFile->name }}
                                                            <p class="size_12 text-muted">{{ $livraisonFile->created_at->diffForHumans() }}</p>
                                                        </div>

													</div>
												</td>

                                                <td class="w-25">
                                                    <div class="d-flex row">
                                                        <button class="col-6 btn bg-transparent" data-bs-toggle="modal" data-bs-target="#pdfViewModal{{$livraisonFile->id}}" title="Voir">
                                                            <i class="lni lni-eye"></i>
                                                        </button>
                                                        @include('admin.od_livraison.files.viewDoc')

                                                        <a class="deleteConfirmation col-6 bg-transparent text-decoration-none" data-uuid="{{ $livraisonFile->uuid }}"
                                                            data-type="confirmation_redirect" data-placement="top"
                                                            data-token="{{ csrf_token() }}"
                                                            data-url="{{ route('admin.od_livraison_doc.destroy', $livraisonFile->uuid) }}"
                                                            data-title="Vous êtes sur le point de supprimer {{ $livraisonFile->code }} "
                                                            data-id="{{ $livraisonFile->uuid }}" data-param="0"
                                                            data-route="{{ route('admin.od_livraison_doc.destroy', $livraisonFile->uuid) }}">
                                                            <button class="border-0 btn bg-transparent" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Supprimer">
                                                                <i class='bx bxs-trash bg-transparent'></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </td>

											</tr>

                                            @empty
                                            <tr>Aucun document associé à ce sourcing.</tr>
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
        {{-- Modal de creation de documents  --}}

        @include('admin.od_livraison.files.addModal')
        @include('admin.od_livraison.sendMail')

        <script>
            $(function () {
                $('[data-bs-toggle="popover"]').popover();
                $('[data-bs-toggle="tooltip"]').tooltip();
            })
        </script>
    </div>

@endsection