@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Rapport</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i
                                class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Transit rapport</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-grid">
                        <input type="search" class="form-control" id="search-transitaire" placeholder="Search" aria-label="Search">
                    </div>
                    <h5 class="my-3">Liste des transitaires</h5>
                    
                    <div class="fm-menu overflow-hidden" style="max-width: 500px;">
                        <div class="list-group list-group-flush overflow-auto" id="list-transporteur" style="max-height: 300px; min-height: 200px; overflow-y: auto;">

                            
                            @foreach ($transitaires as $item)
                                @php
                                    // Récupérer les transits d'import et d'export
                                    $transitByTransitaireImport = App\Models\ExTransit::where('transitaire_uuid', $item->uuid)->get();
                                    $transitByTransitaireExport = App\Models\OdTransite::where('transitaire_uuid', $item->uuid)->get();

                                    // Fusionner les deux collections
                                    $allTransits = $transitByTransitaireImport->merge($transitByTransitaireExport);


                                    // Nombre total de transits
                                    $totalTransits = $allTransits->count();

                                    $inTimeTransits = $allTransits->filter(function ($transit) {
                                        return $transit->expedition && 
                                            $transit->expedition->date_transit > now()->subDays(2) &&
                                            !in_array($transit->expedition->status, ['oderRecu', 'facturer', 'livered']);
                                    })->count();

                                    $outOfTimeTransits = $totalTransits - $inTimeTransits;

                                    // Transits dans le délai
                                    $inTimeTransitsList = $allTransits->filter(function ($transit) {
                                        return $transit->expedition && 
                                            $transit->expedition->date_transit > now()->subDays(2) &&
                                            !in_array($transit->expedition->status, ['oderRecu', 'facturer', 'livered']);
                                    })->values();

                                    // Transits hors délai
                                    $outOfTimeTransitsList = $allTransits->filter(function ($transit) {
                                        return !$transit->expedition || 
                                            $transit->expedition->date_transit <= now()->subDays(2) ||
                                            in_array($transit->expedition->status, ['oderRecu', 'facturer', 'livered']);
                                    })->values();


                                    // Temps moyen de transit (date_transit -> date_livraison ou autre)
                                    $transitTimes = $allTransits->map(function ($transit) {
                                        if ($transit->expedition && $transit->expedition->date_transit && $transit->expedition->date_transport) {
                                            return Carbon\Carbon::parse($transit->expedition->date_transit)->diffInHours(Carbon\Carbon::parse($transit->expedition->date_transport));
                                        }
                                        return null;
                                    })->filter()->values();

                                    

                                    $averageTransitTime = $transitTimes->isNotEmpty() ? $transitTimes->average() : 0;
                                @endphp

                                <a href="javascript:;" class="list-group-item py-1"
                                data-transitaire-id="{{$item->id}}"
                                data-transitaire-name="{{$item->raison_sociale}}"
                                data-transitaire-email="{{$item->email}}"
                                data-transitaire-logo="{{$item->logo}}"
                                data-transitaire-phone="{{$item->phone}}"
                                data-transitaire-identification="{{$item->identification}}"
                                data-total-transits="{{$totalTransits}}"
                                data-in-time-transits="{{$inTimeTransits}}"
                                data-out-of-time-transits="{{$outOfTimeTransits}}"
                                data-average-time-transits="{{$averageTransitTime}}"
                                data-list-in-time-transits="{{ json_encode($inTimeTransitsList) }}"
                                data-list-out-of-time-transits="{{ json_encode($outOfTimeTransitsList) }}">
                                <i class='bx bx-folder me-2'></i><span>{{$item->raison_sociale ?? ''}}</span>
                                </a>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-15">
                    <div class="card-body text-center">
                        <div class="p-4 border radius-15">
                            <img id="transitaire-logo" width="110" height="110" class="rounded-circle shadow" alt="">
                            <h5 class="mb-0 mt-5" id="transitaire-name">
                                {{-- nom du transitaire --}}
                            </h5>
                            <p class="mb-3" id="transitaire-email">
                                {{-- email transitaire --}}
                            </p>
                            <p class="mb-3" id="transitaire-phone">
                                {{-- phone transitaire --}}
                            </p>
                            <p class="mb-3" id="transitaire-identification">
                                {{-- identification transitaire --}}
                            </p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    
                    <div class="row mt-3">
                        <div class="col-12 col-lg-3">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <h5 class="mt-3 mb-0">Total Transit</h5>
                                    <p class="mb-1 mt-4" id="total-transits"><span>x transit</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <h5 class="mt-3 mb-0">Transit dans le délai</h5>
                                    <p class="mb-1 mt-4" id="in-time-transits"><span>x transit</span></p>
                                    <div class="progress" style="height: 7px;">
                                        <div id="progress-in-time" class="progress-bar bg-primary" style="width: 0%;" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-lg-3">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <h5 class="mt-3 mb-0">Hors délai</h5>
                                    <p class="mb-1 mt-4" id="out-of-time-transits"><span>x transit</span></p>
                                    <div class="progress" style="height: 7px;">
                                        <div id="progress-out-of-time" class="progress-bar bg-warning" style="width: 0%;" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <h5 class="mt-3 mb-0">Temps moyen de transit</h5>
                                    <p class="mb-1 mt-4" id="average-time-transits"><span>x transit</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--end row-->
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Transit Récent </h5>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Dans le Délai</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Hors Délai</button>
                            </li>
                            
                          </ul>
                          <div class="tab-content " id="myTabContent">
                            <div class="tab-pane fade show active table-responsive" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <table class="table table-striped table-bordered mb-0 ">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Créé le</th>
                                            <th>Par</th>
                                            <th>Code d'expedition</th>
                                            <th>Statut d'expedition</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inTimeTransitsList as $item)
                                        <tr>
                                            <td>{{$item->code ?? '--'}}</td>
                                            <td>{{$item->created_at ?? '--'}}</td>
                                            <td>{{$item->user_uuid ?? '--'}}</td>
                                            <td>{{$item->expedition->code ?? '--'}}</td>
                                            <td>{{$item->expedition->statut ?? '--'}}</td>
                                            <td>
                                                <a href="{{ route('admin.ex_transit.show', $item->uuid) }}" class="text-decoration-none">Detail</div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade table-responsive" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <table class="table table-striped table-bordered mb-0 " id="outOfTimeTransitsList">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Créé le</th>
                                            <th>Par</th>
                                            <th>Code d'expedition</th>
                                            <th>Statut d'expedition</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($outOfTimeTransitsList as $item)
                                        <tr>
                                            <td>{{$item->code ?? '--'}}</td>
                                            <td>{{$item->created_at ?? '--'}}</td>
                                            <td>{{$item->user_uuid ?? '--'}}</td>
                                            <td>{{$item->expedition->code ?? '--'}}</td>
                                            <td>{{$item->expedition->statut ?? '--'}}</td>
                                            <td>
                                                <a href="{{ route('admin.ex_transit.show', $item->uuid) }}" class="text-decoration-none">Detail</div>
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

    <script>
        $(document).ready(function() {
            $('#list-transitaire a').on('click', function() {
                var transitaireId = $(this).data('transitaire-id');
                var transitaireName = $(this).data('transitaire-name');
                var transitaireEmail = $(this).data('transitaire-email');
                var transitaireLogo = $(this).data('transitaire-logo');
                var transitairePhone = $(this).data('transitaire-phone');
                var totalTransits = $(this).data('total-transits');
                var inTimeTransits = $(this).data('in-time-transits');
                var outOfTimeTransits = $(this).data('out-of-time-transits');
                var transitaireIdentification = $(this).data('transitaire-identification');
                var averageTransitTime = $(this).data('average-time-transits');

                // Parse les données JSON pour les listes de transits
                var inTimeTransitsList = $(this).data('list-in-time-transits');
                var outOfTimeTransitsList = $(this).data('list-out-of-time-transits');

                // Update transitaire information
                $('#transitaire-logo').attr('src', "{{ asset('avatars/') }}/" + transitaireLogo);
                $('#transitaire-name').text(transitaireName);
                $('#transitaire-email').text(transitaireEmail);
                $('#transitaire-phone').text(transitairePhone);
                $('#transitaire-identification').text(transitaireIdentification);
                $('#total-transits').text(totalTransits);
                $('#in-time-transits').text(inTimeTransits);
                $('#out-of-time-transits').text(outOfTimeTransits);
                $('#average-time-transits').text(averageTransitTime);

                // Update in-time transits tabler
                updateTransitTable('#home-tab-pane tbody', inTimeTransitsList);

                // Update out-of-time transits table
                updateTransitTable('#profile-tab-pane tbody', outOfTimeTransitsList);
            });

            function updateTransitTable(tableBodySelector, transitList) {
                var tableBody = $(tableBodySelector);
                tableBody.empty(); // Clear existing rows

                transitList.forEach(function(item) {
                    var row = $('<tr></tr>');
                    row.append($('<td></td>').text(item.code || '--'));
                    row.append($('<td></td>').text(item.created_at || '--'));
                    row.append($('<td></td>').text(item.user_uuid || '--'));
                    row.append($('<td></td>').text(item.expedition?.code || '--'));
                    row.append($('<td></td>').text(item.expedition?.statut || '--'));
                    tableBody.append(row);
                });
            }
        });

    </script>
</div>
@endsection()

{{-- row.append($('<td></td>').html(`<a href="{{ route('admin.ex_transit.show', '') }}/${item.uuid}" class="text-decoration-none">Detail</a>`)); --}}
