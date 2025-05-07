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
                    <li class="breadcrumb-item active" aria-current="page">Proforma Transit</li>
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
                                                <label for="transitaire_uuid" class="form-label">Transporteur</label>
                                                <select id="transitaire_uuid" name="transitaire_uuid" class="form-select">

                                                    @foreach ($transports as $transport)
                                                        <option class="form-control" value="{{ $transport->uuid }}">{{ $transport->raison_sociale }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @php
                                                $transitaireUuid = session('transitaire_uuid', '');

                                                $destinations = \App\Models\GrilleTransit::where('transitaire_uuid', $transitaireUuid)
                                                ->distinct('had_uuid')
                                                ->pluck('had_uuid');

                                                // $destinationsDetails = \App\Models\Destination::whereIn('uuid', $destinations)->get();

                                                $destinationsDetails = \App\Models\GrilleHad::all();

                                            @endphp

                                            <div class="col-12 col-md-4 col-lg-4">
                                                <label for="had_uuid" class="form-label">Had</label>
                                                <select class="form-select" id="had_uuid" name="had_uuid" aria-label="Default select had">
                                                    <option selected>---</option>
                                                    @foreach ($destinationsDetails as $item)
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

    <script>

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
                                    <th>Had</th>

                                    <th>Coût</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${grille.transitaire.raison_sociale}</td>
                                    <td>${grille.had.libelle}</td>

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

        let transitaireUuid = document.getElementById('transitaireUuid');
        let hadUuid = document.getElementById('hadUuid');

        transitaireUuid.addEventListener('change', function () {
            updateGrillesTarifaires(); // Mettez à jour les grilles avec les valeurs actuelles
        });

        hadUuid.addEventListener('change', function () {
            updateGrilles(); // Mettez à jour les grilles avec les valeurs actuelles
        });

        function updateGrilles() {
            let selectedTransitUuid = transitaireUuid.value;
            let selectedHadUuid = hadUuid.value;

            fetch('/update-transitaire-uuid', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    transitaireUuid: selectedTransitUuid,
                    hadUuid: selectedHadUuid,
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

