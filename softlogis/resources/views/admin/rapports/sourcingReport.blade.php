@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Rapport de sourcing</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">sourcing</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="container-fluid my-5 mx-3">
    
            <form method="GET" action="{{ route('admin.report.sourcing') }}">
                <div class="row">
                    
                    <div class="form-group">
                        <p>Date estimative d'arrivée</p>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="start_date">Du:</label>
                                <input type="date" class="form-control" name="start_date" id="date_range">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">Au:</label>
                                <input type="date" class="form-control" name="end_date" id="date_range">
                            </div>
                        </div>
                    </div>
            
                    <div class="col-md-3">
                        <label for="created_at">Date de creation:</label>
                        <input type="date" class="form-control" name="created_at" id="created_at">
                    </div>
            
                    <div class="col-md-3">
                        <label for="status">Statut:</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Sélectionnez un statut</option>
                            <option value="draft">Brouillon</option>
                            <option value="started">Demarrer</option>
                            <option value="validateDoc">Validation Documentaire</option>
                            <option value="odTransit">ordre de transit</option>
                            <option value="odlivraison">Ordre de livraison</option>
                            <option value="received">Reçu</option>
                            <option value="stocked">Stocké</option>
                        </select>
                    </div>
            
                    <div class="col-md-3">
                        <label for="num_bl">Numéro BL:</label>
                        <input type="text" class="form-control" name="num_bl" id="num_bl" placeholder="Numéro BL">
                    </div>
                    <div class="col-md-3">
                        <label for="num_bl">Numéro Dossier:</label>
                        <input type="text" class="form-control" name="numDossier" id="numDossier" placeholder="Numéro Dossier">
                    </div>
                    
            
                    <div class="col-md-3 mt-4">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </div>
                </div>
            </form>
            

        </div>
    </div>


    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
        <div class="col" id="widget-allArticle">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total articles</p>
                            <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>{{ count($allArticle) }} Articles</p>
                        </div>
                        <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col" id="widget-articleSource">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center" >
                        <div>
                            <p class="mb-0 text-secondary">Articles sourcés</p>
                            <p class="mb-0 font-13 text-info"><i class='bx bxs-up-arrow align-middle'></i>{{ count($articleSource) }} articles</p>
                        </div>
                        <div class="widgets-icons bg-light-info text-danger ms-auto" ><i class='bx bxs-group'></i>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="col" id="widget-articleNonSource">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Articles non sourcés</p>
                            <p class="mb-0 font-13 text-success"><i class='bx bxs-down-arrow align-middle'></i>{{ count($articleNonSource) }} articles</p>
                        </div>
                        <div class="widgets-icons bg-light-danger text-info ms-auto"><i class='bx bxs-binoculars'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="card">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All sourcing</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Articles Sourcés</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Articles non sourcés</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table  class="table table-striped table-bordered mb-0 " id="example">
                    <thead class="table-light text-uppercase">
                        <tr>
                            <th>N° Bl</th>
                            <th>N° Dossier</th>
                            <th>N° Declaration</th>
                            <th>Date declaration</th>
                            <th>Produits</th>
                            <th>Date estimative A</th>
                            <th>Date Réel A</th>
                            <th>ID du navire</th>
                            <th>Documents</th>
                            <th>Statut</th>
                            <th>Publié le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px !important" >
                            @forelse($sourcings as $sourcing)
                                <tr>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->num_bl ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->numDossier ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->declarationNum ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->declarationDate ?? '--' }}</h6>
                                    </td>
                                    
                                    <td class="">
                                        <span>{{ $sourcing->products->count() }}</span>
                                    </td>

                                    <td>{{ $sourcing->date_arriver ?? '--'}}</td>

                                    <td class="text-center">{{ $sourcing->date_reel_arriver ?? "N/D"}}</td>

                                    <td>{{ $sourcing->id_navire ?? '--'}}</td>
                                    <td class="h-100">
                                        <span>{{ $sourcing->files->count() }}</span>
                                    </td>

                                    <td>
                                        @if ($sourcing->statut == "draft")
                                        <div class="badge rounded-pill text-light bg-secondary p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Brouillon
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "started")
                                        <div class="badge rounded-pill text-light bg-secondary p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Demarrage
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "validateDoc")
                                        <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Demarrage document
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "odTransit")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>En cour de transit import
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "odlivraison")
                                        <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>en cours de livraison
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "received")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Reçu ||
                                            <span>{{   $sourcing->products->where('is_received', true)->count()  }}</span> /
                                            <span>{{ $sourcing->products->count() }}</span>
                                        </div>
                                        @endif
                                        @if ($sourcing->statut == "stocked")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Stocké
                                        </div>
                                        @endif

                                    </td>
                                    <td>{{ $sourcing->created_at->diffForHumans() }}</td>
                                    <td style="max-width: 100px">
                                        <div class="d-flex order-actions text-end justify-content-between">

                                            <a href="{{ route('admin.sourcing.show', $sourcing->uuid) }}" class="bg-transparent col" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Voir"><i class="lni lni-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun sourcing</td>
                            </tr>
                            @endforelse
                        {{-- @endforeach --}}

                    </tbody>
                    
                </table>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table  class="table table-striped table-bordered mb-0 articleSource"  id="example2" style="font-size: 10px">
                    <thead class="table-light text-uppercase">
                        <tr>
                            <th>Code</th>
                            <th>N* Commande</th>
                            <th>N* Serie</th>
                            <th>Familly Group</th>
                            <th>Model</th>
                            <th>Entrepot</th>
                            <th>Date Reception </th>
                            <th>Date stockage</th>
                            <th>ETA</th>
                            <th>Date de Sortie</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody style="font-size: 12px !important" >
                            @forelse($articleSource as $sourcing)
                                <tr>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->code ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->numero_bon_commande ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->numero_serie ?? '--' }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $sourcing->familyGroup ?? '--' }}</h6>
                                    </td>
                                    
                                    <td class="">
                                        <span>{{ $sourcing->model_Materiel ?? '--' }}</span>
                                    </td>

                                    <td>{{ $sourcing->entrepot->nom ?? '--'}}</td>

                                    <td class="text-center">{{ $sourcing->date_reception ?? "N/D"}}</td>

                                    <td>{{ $sourcing->date_stockage ?? '--'}}</td>
                                    <td class="h-100">
                                        <span>{{ $sourcing->date_Eta ?? '--' }}</span>
                                    </td>
                                    <td>{{ $sourcing->date_outStock ?? '--'}}</td>

                                    <td>
                                        @if ($sourcing->status == "enFabrication")
                                        <div class="badge rounded-pill text-light bg-secondary p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>En Fabrication
                                        </div>
                                        @endif
                                        @if ($sourcing->status == "sortiUsine")
                                        <div class="badge rounded-pill text-light bg-secondary p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Sortie d'usine
                                        </div>
                                        @endif
                                        @if ($sourcing->status == "enExpedition")
                                        <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>En cour d'expedition
                                        </div>
                                        @endif
                                        @if ($sourcing->status == "arriverAuPod")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Arriver au POD
                                        </div>
                                        @endif
                                        @if ($sourcing->status == "received")
                                        <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Reçu/Stocké
                                        </div>
                                        @endif
                                        @if ($sourcing->status == "expEnCours")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>En cour d'expedition
                                        </div>
                                        @endif
                                        @if ($sourcing->status == "delivered")
                                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                            <i class='bx bxs-circle me-1'></i>Delivré
                                        </div>
                                        @endif

                                    </td>
                                    <td style="max-width: 100px">
                                        <div class="d-flex order-actions text-end justify-content-between">

                                            <a href="{{ route('admin.article.show', $sourcing->uuid) }}" class="bg-transparent col" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Voir"><i class="lni lni-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun sourcing</td>
                            </tr>
                            @endforelse
                        {{-- @endforeach --}}

                    </tbody>
                    {{-- @dd($articleSource) --}}
                    
                </table>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <table  class="table table-striped table-bordered mb-0 articleNonSource" id="example3"  style="font-size: 10px">
                    <thead class="table-light text-uppercase">
                        <tr>
                            <th>Code</th>
                            <th>N* Commande</th>
                            <th>N* Serie</th>
                            <th>Familly Group</th>
                            <th>Model</th>
                            <th>Entrepot</th>
                            <th>Date Reception/th>
                            <th>Date stockage</th>
                            <th>ETA</th>
                            <th>Date de Sortie</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px !important" >
                            @forelse($articleNonSource as $sourcing)
                            <tr>
                                <td>
                                    <h6 class="mb-0 font-14">{{ $sourcing->code ?? '--' }}</h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 font-14">{{ $sourcing->numero_bon_commande ?? '--' }}</h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 font-14">{{ $sourcing->numero_serie ?? '--' }}</h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 font-14">{{ $sourcing->familyGroup ?? '--' }}</h6>
                                </td>
                                
                                <td class="">
                                    <span>{{ $sourcing->model_Materiel ?? '--' }}</span>
                                </td>

                                <td>{{ $sourcing->entrepot->nom ?? '--'}}</td>

                                <td class="text-center">{{ $sourcing->date_reception ?? "N/D"}}</td>

                                <td>{{ $sourcing->date_stockage ?? '--'}}</td>
                                <td class="h-100">
                                    <span>{{ $sourcing->date_Eta ?? '--' }}</span>
                                </td>
                                <td>{{ $sourcing->date_outStock ?? '--'}}</td>

                                <td>
                                    @if ($sourcing->status == "enFabrication")
                                    <div class="badge rounded-pill text-light bg-secondary p-2 text-uppercase px-3 border-0">
                                        <i class='bx bxs-circle me-1'></i>En Fabrication
                                    </div>
                                    @endif
                                    @if ($sourcing->status == "sortiUsine")
                                    <div class="badge rounded-pill text-light bg-secondary p-2 text-uppercase px-3 border-0">
                                        <i class='bx bxs-circle me-1'></i>Sortie d'usine
                                    </div>
                                    @endif
                                    @if ($sourcing->status == "enExpedition")
                                    <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3 border-0">
                                        <i class='bx bxs-circle me-1'></i>En cour d'expedition
                                    </div>
                                    @endif
                                    @if ($sourcing->status == "arriverAuPod")
                                    <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                        <i class='bx bxs-circle me-1'></i>Arriver au POD
                                    </div>
                                    @endif
                                    @if ($sourcing->status == "received")
                                    <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3 border-0">
                                        <i class='bx bxs-circle me-1'></i>Reçu/Stocké
                                    </div>
                                    @endif
                                    @if ($sourcing->status == "expEnCours")
                                    <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                        <i class='bx bxs-circle me-1'></i>En cour d'expedition
                                    </div>
                                    @endif
                                    @if ($sourcing->status == "delivered")
                                    <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 border-0">
                                        <i class='bx bxs-circle me-1'></i>Delivré
                                    </div>
                                    @endif

                                </td>
                                <td style="max-width: 100px">
                                    <div class="d-flex order-actions text-end justify-content-between">

                                        <a href="{{ route('admin.article.show', $sourcing->uuid) }}" class="bg-transparent col" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Voir"><i class="lni lni-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun sourcing</td>
                            </tr>
                            @endforelse
                        {{-- @endforeach --}}

                    </tbody>
                    {{-- @dd($articleSource) --}}
                    
                </table>
            </div>
          </div>
          
    </div>
</div>

<script>

   

    // $(document).ready(function () {
    //     $('#widget-allArticle').on('click', function () {
    //         $('#allSourcing').removeClass('d-none').siblings('table').addClass('d-none');
    //     });
    //     $('#widget-articleSource').on('click', function () {
    //         $('.articleSource').removeClass('d-none').siblings('table').addClass('d-none');
    //     });
    //     $('#widget-articleNonSource').on('click', function () {
    //         $('.articleNonSource').removeClass('d-none').siblings('table').addClass('d-none');
    //     });
    // });

    // $(document).ready(function () {
    //     $('#allSourcing, #articleSource, #articleNonSource').DataTable();
    // });

</script>


<script type="text/javascript">
    $(function() {
        $('#date_range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
    </script>

    

@endsection
