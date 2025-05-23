@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Facturation</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Proforma</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row">
        <div class="col-7 card p-3">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 text-uppercase">Offres Tarifaire</h5>
                </div>
            </div>
            {{-- <div class="bs-stepper-cotent card-body">
                <form action="{{ route('admin.proforma.store') }}" method="post" class="submitForm">
                    @csrf
                    <div id="tst-l-1" class="bs-steper-pane" aria-labelledby="stepper2tger1">

                        <div class="row g-3">
                            <div class="col-12 col-lg-6">
                                <label for="transporteur_uuid" class="form-label">Transporteur</label>
                                <select id="transporteur_uuid" name="transporteur_uuid" class="form-select">
                                    @foreach ($transports as $transport)
                                        <option class="form-control" value="{{ $transport->uuid }}">{{ $transport->raison_sociale }}</option>
                                    @endforeach
                                </select>
                                <div id="grille-tarifs"></div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="destination_uuid" class="form-label">Destination</label>
                                <select class="form-select" id="destination_uuid" name="destination_uuid"
                                aria-label="Default select destination">
                                <option selected>---</option>
                                @foreach ($destinations as $item)
                                    <option class="form-control" value="{{ $item->uuid }}">{{ $item->libelle }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="porteChar_uuid" class="form-label">PorteChar</label>
                                <select class="form-select" id="porteChar_uuid" name="porteChar_uuid"
                                    aria-label="Default select porteChar">
                                    <option selected>---</option>
                                    @foreach ($porteChars as $item)
                                        <option class="form-control" value="{{ $item->uuid }}">{{   $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="cout_prestation" class="form-label">Cout Prestation</label>
                                <input type="text" class="form-control" id="cout_prestation" name="cout_prestation"
                                    placeholder="0.00">
                            </div>



                            <div class="col-12 col-lg-6">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer<i
                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                            </div>
                        </div>
                    </div>

                </form>
            </div> --}}
            <div class="modal-body ">
                <div id="stepper1" class="bs-stepper">
                    <div class="card">

                        <div class="card-body mt-4">

                            <div class="bs-stepper-content">
                                <form method="post" class="submitForm">
                                    @csrf
                                    <div>
                                        <div class="row g-3">
                                            <div class="col-12 col-md-4 col-lg-4">
                                                <label for="transporteur_uuid" class="form-label">Transporteur</label>
                                                <select id="transporteur_uuid" name="transporteur_uuid" class="form-select">
                                                    @foreach ($transports as $transport)
                                                        <option class="form-control" value="{{ $transport->uuid }}">{{ $transport->raison_sociale }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @php
                                                $transporteurUuid = session('transporteur_uuid', '');

                                                $destinations = \App\Models\GrilleTarif::where('transporteur_uuid', $transporteurUuid)
                                                ->distinct('destination_uuid')
                                                ->pluck('destination_uuid');

                                                // $destinationsDetails = \App\Models\Destination::whereIn('uuid', $destinations)->get();

                                                $destinationsDetails = \App\Models\Destination::all();

                                                $porteChar = \App\Models\GrilleTarif::where('transporteur_uuid', $transporteurUuid)
                                                ->distinct('porteChar_uuid')
                                                ->pluck('porteChar_uuid');

                                                // $porteCharsDetails = \App\Models\PorteChar::whereIn('uuid', $porteChar)->get();

                                                $porteCharsDetails = \App\Models\PorteChar::all();
                                            @endphp

                                            <div class="col-12 col-md-4 col-lg-4">
                                                <label for="destination_uuid" class="form-label">Destination</label>
                                                <select class="form-select" id="destination_uuid" name="destination_uuid" aria-label="Default select destination">
                                                    <option selected>---</option>
                                                    @foreach ($destinationsDetails as $item)
                                                        <option class="form-control" value="{{ $item->uuid }}">{{ $item->libelle }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-12 col-md-4 col-lg-4">
                                                <label for="porteChar_uuid" class="form-label">PorteChar</label>
                                                <select class="form-select" id="porteChar_uuid" name="porteChar_uuid" aria-label="Default select porteChar">
                                                    <option selected>---</option>
                                                    @foreach ($porteCharsDetails as $item)
                                                        <option class="form-control" value="{{ $item->uuid }}">{{ $item->libelle }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                        <!---end row-->

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div id="resultats-grilles-tarifaires"></div>
        </div>


    </div>

    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                    aria-controls="flush-collapseOne">
                    Grille Tarifaire
                </button>

            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse"
                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Transporteur</th>
                                            <th>Destination</th>
                                            <th>PorteChar</th>
                                            <th>Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grilleTarifaires->groupBy('destination.libelle') as $libelle => $items)
                                            <tr>
                                                <td>{{ $items[0]->transporteur->raison_sociale ?? '--' }}</td>
                                                <td rowspan="{{ count($items) }}">{{ $libelle ?? '--' }}</td>
                                                <td>{{ $items[0]->porteChar->libelle ?? '--' }}</td>
                                                <td>{{ $items[0]->cout }}</td>
                                            </tr>
                                            @for ($i = 1; $i < count($items); $i++)
                                                <tr>
                                                    <td>{{ $items[0]->transporteur->raison_sociale ?? '--' }}</td>
                                                    <td>{{ $items[$i]->porteChar->libelle ?? '--'}}</td>
                                                    <td>{{ $items[$i]->cout }}</td>
                                                </tr>
                                            @endfor
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Transporteur</th>
                                            <th>Destination</th>
                                            <th>PorteChar</th>
                                            <th>Montant</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- <script>


        // Ajoutez une fonction pour mettre à jour les grilles tarifaires
        function updateGrillesTarifaires(grillesTarifaires) {

            let grilleTarifsContainer = document.getElementById('grille-tarifs');

            // Construisez le HTML pour afficher les nouvelles grilles tarifaires
            let newHTML = '';
            grillesTarifaires.forEach(grille => {
                Exemple : newHTML += `<div>${grille.cout}</div>`;
            });

            // Mettez à jour la partie de la page avec les nouvelles grilles tarifaires
            grilleTarifsContainer.innerHTML = newHTML;
        }

        let transporteurUuid = document.getElementById('transporteur_uuid');
        transporteurUuid.addEventListener('change', function() {
            let selectedValue = transporteurUuid.value;

            // Envoi de la valeur sélectionnée au serveur via une requête AJAX
            fetch('/update-transporteur-uuid', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ajoutez ceci pour la protection CSRF
                },
                body: JSON.stringify({ transporteurUuid: selectedValue })
            })
            .then(response => response.json())
            .then(data => {
                // Appel de la fonction pour mettre à jour les grilles tarifaires
                updateGrillesTarifaires(data.grillesTarifaires);

                // Gestion de la réponse du serveur (si nécessaire)
                console.log(data);
            });
        });

    </script> --}}

    <script>
        // function updateGrillesTarifaires(grillesTarifaires) {
        //     let grilleTarifsContainer = document.getElementById('grille-tarifs');
        //     let newHTML = '';

        //     grillesTarifaires.forEach(grille => {
        //         newHTML += `<div>${grille.cout}</div>`;
        //     });

        //     grilleTarifsContainer.innerHTML = newHTML;
        // }
        function updateGrillesTarifaires(grillesTarifaires) {
        let resultatsContainer = document.getElementById('resultats-grilles-tarifaires');
        let newHTML = '';

        grillesTarifaires.forEach(grille => {
            newHTML += `
            <div>
                <div class="row g-3 mt-4 card border border-2 border-info text-center d-flex justify-content-center align-items-center align-self-center">

                    <div class="container mt-4 table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Raison Sociale</th>
                                    <th>Destination</th>

                                    <th>Coût</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${grille.transporteur.raison_sociale}</td>
                                    <td>${grille.destination.libelle}</td>

                                    <td>${grille.cout}</td>
                                </tr>
                                <tr class="table-success mt-4">
                                    <td colspan="2">Total</td>
                                    <td>${grille.cout}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>`;
        });

        resultatsContainer.innerHTML = newHTML;
    }

        let transporteurUuid = document.getElementById('transporteur_uuid');
        let destinationUuidSelect = document.getElementById('destination_uuid');
        let porteCharUuidSelect = document.getElementById('porteChar_uuid');

        transporteurUuid.addEventListener('change', function () {
            updateGrillesTarifaires(); // Mettez à jour les grilles avec les valeurs actuelles
        });

        destinationUuidSelect.addEventListener('change', function () {
            updateGrilles(); // Mettez à jour les grilles avec les valeurs actuelles
        });

        porteCharUuidSelect.addEventListener('change', function () {
            updateGrilles(); // Mettez à jour les grilles avec les valeurs actuelles
        });

        function updateGrilles() {
            let selectedTransporteurUuid = transporteurUuid.value;
            let selectedDestinationUuid = destinationUuidSelect.value;
            let selectedPorteCharUuid = porteCharUuidSelect.value;

            fetch('/update-transporteur-uuid', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    transporteurUuid: selectedTransporteurUuid,
                    destinationUuid: selectedDestinationUuid,
                    porteCharUuid: selectedPorteCharUuid
                })
            })
                .then(response => response.json())
                .then(data => {
                    updateGrillesTarifaires(data.grillesTarifaires);
                    console.log(data);
                });
        }
    </script>


</div>
@endSection()



{{-- Raison Sociale: ${grille.transporteur.raison_sociale} | Destination: ${grille.destination.libelle} | Coût: ${grille.cout} --}}

