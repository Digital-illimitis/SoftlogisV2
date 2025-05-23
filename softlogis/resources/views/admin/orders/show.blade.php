@extends('admin.layouts.admin')
@section('section')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Détail de l'instruction</div>
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
                        @if ($order->statut === 'send')
                            <form action="{{ route('admin.orders.updateStatus', $order->uuid) }}" method="POST" class="">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm">Marquer comme reçu</button>
                            </form>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="container text-center row">
            <div id="stepper1" class="bs-stepper col-12">
                <div class="card">

                    <div class="card-header">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif

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
                                    <h5 class="d-flex align-items-center text-uppercase px-2 my-2 size_16">Informations sur l'instruction</h5>
                                </div>
                            </div>

                            <hr>
                            <div class="card-body w-100 row">
                                <div class="col-12 row">
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">N* de commande</dt>
                                        <dd class="col-sm-6">{{ ($order->code) ?? '--' }}</dd>
                                    </dl>
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Client</dt>
                                        <dd class="col-sm-6">{{ ($order->client->raison_sociale) ?? '--' }}</dd>
                                    </dl>

                                </div>

                                <div class="col-12 row my-3">
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Lieu de livraison</dt>
                                        <dd class="col-sm-6">{{ $order->lieu_liv ?? '--' }}</dd>
                                    </dl>
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Date Livraison</dt>
                                        <dd class="col-sm-6">{{ Carbon\Carbon::parse($order->date_liv)->format('d/m/Y') ?? '--' }}</dd>
                                    </dl>
                                </div>
                                <dl class="row col-6">
                                    <dt class="col-sm-6">Incoterm</dt>
                                    <dd class="col-sm-6">{{ ($order->incoterm) ?? '--' }}</dd>
                                </dl>

                                <hr class="my-3">

                                <div class="col-12 row mb-3">
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Date d'instruction</dt>
                                        <dd class="col-sm-6">{{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y') ?? '--' }}</dd>
                                    </dl>
                                    <dl class="row col-6">
                                        <dt class="col-sm-6">Publié par</dt>
                                        <dd class="col-sm-6">{{ ($order->created_by) ?? '--' }}</dd>
                                    </dl>
                                </div>
                                <div class=" my-3 col-12">
                                    <div class="col-md-4">
                                        <h6 class="mb-0">Statut</h6>
                                    </div>
                                    <div class="col-md-12 text-secondary">
                                        <div class="form-control disabled text-start" disabled @readonly(true)>
                                            @if ($order->statut === 'send')
                                                Envoyé
                                            @else
                                                Reçu
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between row">
                                        <h5 class="col d-flex align-items-center text-uppercase size_16">Marchandises</h5>
                                        <div class=" col ms-auto float-end d-flex justify-content-end text-align-end align-items-center align-self-center">
                                            
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead class="table-light">
                                                    <tr class="text-uppercase size_14">
                                                        <th>N* serie</th>
                                                        <th>Famille</th>
                                                        <th>Status</th>
                                                        <th>Conformité</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size: 12px !important">
                                                    @forelse ($order->products as $sourcingProduct)

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
                                                        <tr>Aucun produit pour cete commande</tr>
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
                                <div class="text-uppercase  col-10 size_16">Documents</div>
                                <div class="bg-transparent text-center border-0 col-2 p-1 rounded">
                                   
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
                                            @forelse ($order->files as $sourcingFile)
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
                                            <tr>Aucun document associé à cette commande.</tr>
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
    <!-- Modal -->

    <script>
        // Écoute de la soumission du formulaire
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.submitFor').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du formulaire

            const uuid = this.getAttribute('data-uuid'); // Récupère l'UUID de la commande depuis l'attribut data-uuid
            const formData = new FormData(this); // Crée un objet FormData à partir du formulaire

            // Envoi de la requête AJAX
            fetch(`/orders/update/${uuid}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ajoutez le jeton CSRF si nécessaire
                }
            })
            .then(response => {
                if (response.ok) {
                    // Mettez à jour l'interface utilisateur ou effectuez d'autres actions en cas de succès
                    // Par exemple, vous pouvez recharger la page
                    location.reload();
                } else {
                    // Gérez les erreurs
                    console.error('Erreur lors de la mise à jour du statut de la commande');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la requête AJAX:', error);
            });
        });
    });
});

    </script>

    </div>

@endsection
