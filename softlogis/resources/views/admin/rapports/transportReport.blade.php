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
                    <li class="breadcrumb-item active" aria-current="page">Transport rapport</li>
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
                        <input type="search" class="form-control" id="search-transporteur" placeholder="Search" aria-label="Search">
                    </div>
                    <h5 class="my-3">Liste des transporteurs</h5>
                    
                   <div class="fm-menu overflow-hidden" style="max-width: 500px;">
                        <div class="list-group list-group-flush overflow-auto" id="list-transporteur" style="max-height: 300px; min-height: 200px; overflow-y: auto;">
                            @foreach ($transporteurs as $item)
                                <a href="javascript:;" class="list-group-item py-1" data-uuid="{{$item->uuid}}" onclick="loadTransporteurData('{{$item->uuid}}')">
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
                            <img id="transporteur-logo" width="110" height="110" class="rounded-circle shadow" alt="" src="">
                            <h5 class="mb-0 mt-5" id="transporteur-name">
                                {{-- nom du transporteur --}}
                            </h5>
                            <p class="mb-3" id="transporteur-email">
                                {{-- email transporteur --}}
                            </p>
                            <p class="mb-3" id="transporteur-phone">
                                {{-- phone transporteur --}}
                            </p>
                            <p class="mb-3" id="transporteur-identification">
                                {{-- identification transporteur --}}
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
                                    <h5 class="mt-3 mb-0">Total Transport</h5>
                                    <p class="mb-1 mt-4"><span id="total-transport">{{$totalTransport}} transport(s)</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <h5 class="mt-3 mb-0">Dans le délai</h5>
                                    <p class="mb-1 mt-4"><span id="dans-delai">{{$transportsDansDelai}} transport(s)</span></p>
                                    <div class="progress" style="height: 7px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $totalTransport > 0 ? ($transportsDansDelai / $totalTransport) * 100 : 0 }}%;" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <h5 class="mt-3 mb-0">Hors délai</h5>
                                    <p class="mb-1 mt-4"><span id="hors-delai">{{$transportsHorsDelai}} transport(s)</span></p>
                                    <div class="progress" style="height: 7px;">
                                        <div class="progress-bar bg-warning" style="width: {{ $totalTransport > 0 ? ($transportsHorsDelai / $totalTransport) * 100 : 0 }}%;" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <h5 class="mt-3 mb-0">Temps moyen</h5>
                                    <p class="mb-1 mt-4"><span id="temps-moyen-transit">{{ $tempsMoyenTransit }} jours</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--end row-->
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Transport Récent</h5>
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
                          <!-- Dans le délai -->
                            <div class="tab-pane fade show active table-responsive" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <table class="table table-striped table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Créé le</th>
                                            <th>Par</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="transport-in-delais">
                                        <!-- Les données des transports dans le délai seront injectées ici -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Hors délai -->
                            <div class="tab-pane fade table-responsive" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <table class="table table-striped table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Créé le</th>
                                            <th>Par</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="transport-hors-delais">
                                        <!-- Les données des transports hors délai seront injectées ici -->
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
        function loadTransporteurData(uuid) {
            // Effacer les anciens résultats
            $('#transporteur-info').html('<div class="p-4 border radius-15"><p>Chargement...</p></div>');
    
            // Faire une requête AJAX pour obtenir les détails du transporteur
            $.ajax({
                url: '/get-transporteur-details/' + uuid, // Assurez-vous que cette route existe
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        $('#transporteur-logo').attr('src', data.logo || 'default-logo.png');
                        $('#transporteur-name').text(data.name);
                        $('#transporteur-email').text(data.email || '--');
                        $('#transporteur-phone').text(data.phone || '--');
                        $('#transporteur-identification').text(data.identification || '--');
    
                        // Maintenant, chargez les statistiques du transporteur
                        loadTransportStats(uuid);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Erreur de chargement des informations du transporteur.');
                }
            });
        }

        
    
        function loadTransportStats(uuid) {
            $.ajax({
                url: '/get-transporteur-stats/' + uuid, // Nouvelle route pour les statistiques
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#total-transport').text(response.data.totalTransport + ' transport(s)');
                        $('#dans-delai').text(response.data.transportsDansDelai + ' transport(s)');
                        $('#hors-delai').text(response.data.transportsHorsDelai + ' transport(s)');
                        $('#temps-moyen-transit').text(response.data.tempsMoyenTransit + ' jours');

                        console.log(response.data);

                        // Mapper les listes dans le tableau
                        const listeDansDelai = response.data.listeDansDelai.map(transport => `
                            <tr>
                                <td>${transport.code}</td>
                                <td>${transport.created_at}</td>
                                <td>${transport.created_by}</td>
                                <td>${transport.delai} jours</td>
                            </tr>
                        `).join('');

                        const listeHorsDelai = response.data.listeHorsDelai.map(transport => `
                            <tr>
                                <td>${transport.code}</td>
                                <td>${transport.created_at}</td>
                                <td>${transport.created_by}</td>
                                <td>${transport.delai} jours</td>
                            </tr>
                        `).join('');

                        // Injecter dans les tableaux HTML
                        $('#transport-in-delais').html(listeDansDelai);
                        $('#transport-hors-delais').html(listeHorsDelai);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert('Erreur de chargement des statistiques du transporteur.');
                        }
                        
            });
        }
    </script>
    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const transporteurList = document.getElementById('list-transporteur');
            
            if (transporteurList) {
                transporteurList.addEventListener('click', function (e) {
                    const target = e.target.closest('.list-group-item');
                    
                    if (target) {
                        const uuid = target.getAttribute('data-uuid');
    
                        // Requête AJAX pour récupérer les détails du transporteur
                        fetch(`/transporteurs/${uuid}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Mise à jour des informations du transporteur
                                    document.getElementById('transporteur-logo').src = data.data.logo;
                                    document.getElementById('transporteur-name').innerText = data.data.name;
                                    document.getElementById('transporteur-email').innerText = data.data.email;
                                    document.getElementById('transporteur-phone').innerText = data.data.phone;
                                    document.getElementById('transporteur-identification').innerText = data.data.identification;
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => console.error('Erreur:', error));
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#search-transporteur').on('keyup', function() {
                var searchValue = $(this).val().toLowerCase();
                $('#list-transporteur a').each(function() {
                    var transporteurName = $(this).find('span').text().toLowerCase();
                    if (transporteurName.indexOf(searchValue) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

    </script>


</script>
@endsection()
