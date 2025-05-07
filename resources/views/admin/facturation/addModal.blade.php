<div class="modal fade" id="addFacture" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg " >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase size_16">Enregistrement d'une nouvelle facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="bs-stepper-content mt-3 p-3 modal-dialog-scrollable overflow-x scroll" style="max-height: auto;">

                <form action="{{ route('admin.facturation.store') }}" method="post" class="submitForm" enctype="multipart/form-data" >
                    @csrf

                    <div id="stepper1" class="bs-stepper">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between"
                                    role="tablist">
                                    <div class="step" data-target="#test-l-1">
                                        <div class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1">
                                            <div class="bs-stepper-circle">1</div>
                                            <div class="">
                                                <h5 class="mb-0 steper-title">Detail Facture</h5>
                                                <p class="mb-0 steper-sub-title">Entrer les details de la facture</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-l-2">
                                        <div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                                            <div class="bs-stepper-circle">2</div>
                                            <div class="">
                                                <h5 class="mb-0 steper-title">Prestation</h5>
                                                <p class="mb-0 steper-sub-title">Ligne de prestation</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-l-3">
                                        <div class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3">
                                            <div class="bs-stepper-circle">3</div>
                                            <div class="">
                                                <h5 class="mb-0 steper-title">Document/Facture</h5>
                                                <p class="mb-0 steper-sub-title">Facture original</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body">

                                <div class="bs-stepper-content">
                                    <form onSubmit="return false">
                                        <div id="test-l-1" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger1">

                                            <div class="row g-3">
                                                <div class="col-12 col-lg-6">
                                                    <label for="numFacture" class="form-label">Numero de Facture <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="numFacture" name="numFacture" required>
                                                    @error('records.*.numFacture')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <label for="date_echeance" class="form-label">Date Limite de paiement</label>
                                                    <input type="date" class="form-control" id="date_echeance" name="date_echeance">
                                                </div>

                                                <div class="col-6 col-md-6 col-lg-6">
                                                    <label for="num_bl" class="form-label">N° BL</label>
                                                    <input type="text" class="form-control" id="num_bl" name="num_bl">
                                                </div>

                                                <div class="col-6 col-md-6 col-lg-6">
                                                    <label for="file_Bl" class="form-label">Document BL</label>
                                                    <input type="file" class="form-control" id="file_Bl" name="file_Bl">
                                                </div>

                                                <div class="col-6 col-md-6 col-lg-6">
                                                    <label for="inputTypeFacture" class="form-label">Type de facture</label>
                                                    <select class="form-select" name="typeFacture" id="inputTypeFacture">
                                                        <option selected>Selectionnez un type de facture</option>
                                                        <option value="transporteur" id="idTransporteur">Transporteur</option>
                                                        <option value="transitaire" id="idTransitaire">Transitaire</option>

                                                    </select>

                                                </div>

                                                <div class="col-6 col-md-6 col-lg-6 type-block" id="idTransitaireBlock" data-type="transitaire">
                                                    <label for="transitaire_uuid" class="form-label">Bénéficiaire</label>
                                                    <select class="form-select" id="transitaire_uuid" name="transitaire_uuid">
                                                        <option>Selectionné un transitaire</option>
                                                        @foreach ($prestatairesTransits as $prestatairesTransit)
                                                            <option value="{{ $prestatairesTransit->uuid }}" class="transitre-option">{{ $prestatairesTransit->raison_sociale }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-6 col-md-6 col-lg-6 d-none type-block" id="idTransporteurBlock" data-type="transporteur">
                                                    <label for="transporteur_uuid" class="form-label">Bénéficiaire</label>
                                                    <select class="form-select"  name="transporteur_uuid">
                                                        <option selected>Selectionné un transporteur</option>
                                                        @foreach ($prestatairesTransports as $prestatairesTransport)
                                                            <option value="{{ $prestatairesTransport->uuid }}" class="transporteur">{{ $prestatairesTransport->raison_sociale }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <button class="btn btn-primary px-4"
                                                                onclick="event.preventDefault(); stepper1.next()">Suivant<i
                                                                    class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                            <!---end row-->

                                        </div>

                                        <div id="test-l-2" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger2">

                                            <div class="row g-3">

                                                <div class="form-group mt-4 col-12">
                                                    <button class="btn btn-sm btn-primary my-2" type="button" onclick="cloneBlock()" style="width: 200px">Ajouter une ligne</button>
                                                    <div class="col-12 my-2 row text-start size_12 d-flex justify-content-around bold">
                                                        <div class="col-4">RUBRIQUE</div>
                                                        <div class="col-3">PRIX UNITAIRE (Fcfa)</div>
                                                        <div class="col-2">Qty</div>
                                                        <div class="col-3">TOTAL LIGNE (Fcfa)</div>
                                                    </div>
                                                    <hr>
                                                </div>



                                                <div id="container">
                                                    <div class="row mt-2 d-flex justify-content-between align-items-center align-self-center py-auto">
                                                        <div class="col-4">
                                                            <input class="form-control form-control-sm rubrique" placeholder="rubrique" name="rubrique[]">
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="number" class="form-control form-control-sm" id="prixUnitaire" name="prixUnitaire[]" placeholder="0">
                                                        </div>
                                                        <div class="col-2">
                                                            <input type="number" class="form-control form-control-sm" id="qty" name="qty[]" placeholder="0">
                                                        </div>
                                                        <div class="col-2">
                                                            <input type="number" class="form-control form-control-sm muted" id="totalLigne" name="totalLigne[]" readonly placeholder="" value="">
                                                        </div>
                                                        <div class="col-1">
                                                            <button class="btn btn-sm btn-danger delete-btn" type="button">
                                                                <i class='bx bx-trash'></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="btn btn-outline-secondary px-4"
                                                        onclick="event.preventDefault(); stepper1.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Retour</button>
                                                            <button class="btn btn-primary px-4"
                                                            onclick="event.preventDefault(); stepper1.next()">Suivant<i
                                                                class='bx bx-right-arrow-alt ms-2'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!---end row-->

                                        </div>

                                        <div id="test-l-3" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger3">

                                            <div class="row g-3">

                                                 <button class="btn btn-sm btn-primary mt-2" type="button" onclick="cloneBlockDoc()" style ="width: 200px">Ajouter une ligne</button>
                                                 <label for="InputCountry" class="form-label">Facture Original</label>
                                                {{-- <div class="container mb-3 mt-1" id="contentBlockDoc">
                                                    <div class="docBlock row d-flex justify-content-between align-items-center align-self-center">
                                                        <div class="col-11 col-lg-11">

                                                            <input type="file" class="form-control" id="facture_original" name="facture_original[]">
                                                        </div>
                                                        <div class="col-1 mx-0 mt-2">
                                                            <button class="btn btn-sm btn-danger delete-btn-doc" type="button">
                                                                <i class='bx bx-trash'></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div> --}}
                                                <div class="container mb-3 mt-1" id="contentBlockDoc">
                                                    <div class="docBlock row d-flex justify-content-between align-items-center align-self-center">
                                                        <div class="col-11 col-lg-11">
                                                            <input type="file" class="form-control" id="facture_original" name="facture_original[]">
                                                        </div>
                                                        <div class="col-1 mx-0 mt-2">
                                                            <button class="btn btn-sm btn-danger delete-btn-doc" type="button">
                                                                <i class='bx bx-trash'></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">

                                                    <div class="col-sm-12 col-lg-12">
                                                        <textarea class="form-control" id="input47" name="note" rows="3" placeholder="Saisir une note"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="btn btn-outline-secondary px-4"
                                                        onclick="event.preventDefault(); stepper1.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Retour</button>
                                                            <button class="btn btn-primary px-4" type="submit">Enregistrer<i
                                                                class='bx bx-right-arrow-alt ms-2'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!---end row-->

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('idTransporteur').addEventListener('click', function () {
        var blockElement = document.getElementById('idTransporteurBlock');
        var blockTransit = document.getElementById('idTransitaireBlock');
        blockElement.classList.remove('d-none');
        blockTransit.classList.add('d-none');
    });
    document.getElementById('idTransitaire').addEventListener('click', function () {
        var blockTransporteur = document.getElementById('idTransporteurBlock');
        var blockTransitaire = document.getElementById('idTransitaireBlock');
        blockTransitaire.classList.remove('d-none');
        blockTransporteur.classList.add('d-none');
    });
</script>
