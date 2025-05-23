<div class="modal fade" id="addFactureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="stepper1" class="bs-stepper">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between"
                                role="tablist">
                                <div class="step" data-target="#test-l-1">
                                    <div class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1">
                                        <div class="bs-stepper-circle">1</div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Beneficiaire</h5>
                                            <p class="mb-0 steper-sub-title">Entrer les details du fournisseur</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-stepper-line"></div>
                                <div class="step" data-target="#test-l-2">
                                    <div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                                        <div class="bs-stepper-circle">2</div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Marchandises</h5>
                                            <p class="mb-0 steper-sub-title">Detail des marchandises</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-stepper-line"></div>
                                <div class="step" data-target="#test-l-3">
                                    <div class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3">
                                        <div class="bs-stepper-circle">3</div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Prestation</h5>
                                            <p class="mb-0 steper-sub-title">Detail des Prestations</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-stepper-line"></div>
                                <div class="step" data-target="#test-l-4">
                                    <div class="step-trigger" role="tab" id="stepper1trigger4" aria-controls="test-l-4">
                                        <div class="bs-stepper-circle">4</div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">ID Facturier</h5>
                                            <p class="mb-0 steper-sub-title">Detail sur le responsable</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                                <div class="bs-stepper-content">
                                    <form method="post" action="{{ route('admin.refacturation.store') }}" class="submitForm" enctype="multipart/form-data">
                                        @csrf
                                        <div id="test-l-1" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger1">

                                            <div class="row g-3">
                                                <div class="col-12 col-lg-6">
                                                    <label for="refClient" class="form-label">Ref Client</label>
                                                    <input type="text" class="form-control" id="refClient" name="refClient"
                                                        placeholder="Ref Client">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="num_cc" class="form-label">N° Compte Contribuable</label>
                                                    <input type="text" class="form-control" id="num_cc" name="num_cc"
                                                        placeholder="cc012ff879">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="adresseComplete" class="form-label">Adresse Complete</label>
                                                    <input type="text" class="form-control" id="adresseComplete"
                                                        name="adresseComplete" placeholder="Adresse Complete">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="email" class="form-label">E-mail Address</label>
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="example@xyz.com">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="pol" class="form-label">Pol</label>
                                                    <input type="text" id="pol" class="form-control" name="pol">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="pod" class="form-label">PoD</label>
                                                    <input type="text" id="pod" class="form-control" name="pod">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="regime" class="form-label">Regime</label>
                                                    <input type="text" id="regime" class="form-control" name="regime">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="doit" class="form-label">Doit</label>
                                                    <input type="text" class="form-control" id="doit" name="doit"
                                                        placeholder="Doit">
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <button class="btn btn-primary px-4" onclick="event.preventDefault(); stepper1.next()">Suivant<i class='bx bx-right-arrow-alt ms-2'></i></button>
                                                  </div>
                                            </div>
                                            <!---end row-->

                                        </div>
                                        <div id="test-l-2" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger2">

                                            <div class="row g-3">
                                                <div class="col-12 col-lg-6">
                                                    <label for="designation" class="form-label">Designation</label>
                                                    <input type="text" class="form-control" id="designation"
                                                        name="designation" placeholder="Groupe Electrogene">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="num_Commande" class="form-label">N° Commande</label></label>
                                                    <input type="text" class="form-control" id="num_Commande"
                                                        name="num_Commande" placeholder="cmd023564">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="num_Bl" class="form-label">N° BL</label>
                                                    <input type="text" class="form-control" id="num_Bl" name="num_Bl"
                                                        placeholder="cmd023564">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="navire" class="form-label">Navire/Voyage</label>
                                                    <input type="text" class="form-control" id="navire" name="navire"
                                                        placeholder="navire xxxx">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="destination" class="form-label">Destination</label>
                                                    <input type="text" class="form-control" id="destination"
                                                        placeholder="destination" name="destination">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="amateur" class="form-label">Amateur</label>
                                                    <input type="text" class="form-control" id="amateur"
                                                        placeholder="amateur" name="amateur">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="num_Dossier" class="form-label">N° Dossier</label>
                                                    <input type="text" class="form-control" id="num_Dossier"
                                                        placeholder="N° Dossier" name="num_Dossier">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="num_Ot" class="form-label">N° OT</label>
                                                    <input type="text" class="form-control" id="num_Ot" placeholder="N° OT"
                                                        name="num_Ot">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="volume" class="form-label">Volume</label>
                                                    <input type="text" class="form-control" id="volume" placeholder="volume"
                                                        name="volume">
                                                </div>
                                                <div class="col-12 col-lg-3">
                                                    <label for="tva" class="form-label">tva (%)</label>
                                                    <input type="text" class="form-control" id="tva" placeholder="% TVA"
                                                        name="tva">
                                                </div>
                                                <div class="col-12 col-lg-3">
                                                    <label for="tva" class="form-label">Nombre de marchandises</label>
                                                    <input type="text" class="form-control" id="tva" placeholder="0"
                                                        name="nbr_product">
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
                                                <div id="prestationsb">
                                                    <div class="prestationb mb-2">
                                                        <div class="form-row row">
                                                            <div class="col-3">
                                                                <select name="type_prestation[]" class="form-control">
                                                                <option value="">Sélect le type</option>
                                                                <option value="prestation">PRESTATION</option>
                                                                <option value="debours">DEBOURS</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-1">
                                                                <input type="number" name="qty[]" class="form-control"
                                                                    placeholder="0">
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="text" name="description[]" class="form-control"
                                                                    placeholder="Description">
                                                            </div>
                                                            <div class="col-2">
                                                                <input type="number" name="prixunitaire[]"
                                                                    class="form-control" placeholder="Prix unitaire">
                                                            </div>
                                                            <div class="col-2">
                                                                <input type="number" name="total[]" class="form-control"
                                                                    placeholder="Total" readonly>
                                                            </div>
                                                            <div class="col-auto">

                                                                <button type="button" class="btn btn-danger remove-btnb px-2 text-center"><i class='bx bxs-trash remove-btnb'></i></button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <button type="button" id="add-btnb" class="btn btn-primary col-3"><i class="bx bxs-plus-square"></i> Ajouter une prestation</button>

                                                <hr>
                                                <div class="col-12 mt-4">
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

                                        <div id="test-l-4" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger4">
                                            <div class="row g-3">
                                                <div class="col-12 col-lg-6">
                                                    <label for="facturier_uuid" class="form-label">Facturier</label>
                                                    <input type="text" class="form-control" id="facturier_uuid"
                                                        placeholder="{{ Auth::user()->name.' '.Auth::user()->lastname }}" readonly>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="poste_occuper" class="form-label">Poste</label>
                                                    <input type="text" class="form-control" id="poste_occuper"
                                                        placeholder="Poste Occuper" name="poste_occuper">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="num_facture" class="form-label">N° Facture</label>
                                                    <input type="text" class="form-control" id="num_facture"
                                                        placeholder="fact 001205v 01" name="num_facture">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="date_echeance" class="form-label">Date d'écheance</label>
                                                    <input type="date" class="form-control" id="date_echeance"
                                                        name="date_echeance">
                                                </div>
                                                <div class="col-12 col-lg-12">
                                                    <label for="condition_paiement" class="form-label">Condition de paiement</label>
                                                    <textarea class="form-control" name="condition_paiement" id="condition_paiement" cols="30" rows="3"></textarea>
                                                </div>
                                                <div class="col-12 col-lg-12">
                                                    <label for="comment" class="form-label">Commentaire</label>
                                                    <textarea class="form-control" name="comment" id="comment" cols="30" rows="3"></textarea>
                                                </div>

                                                <div class="col-12">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="btn btn-primary px-4"
                                                            onclick="event.preventDefault(); stepper1.previous()"><i
                                                                class='bx bx-left-arrow-alt me-2'></i>Retour</button>
                                                        <button type="submit" class="btn btn-success px-4"
                                                            >Enregistrer</button>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                {{-- <button type="button" class="btn btn-primary">Sauvegarder changements</button> --}}
            </div>
        </div>
    </div>
</div>
<script>
    function clonePrestation() {
      const prestation = document.querySelector('.prestationb');
      // Clone le bloc de prestation
      const newPrestation = prestation.cloneNode(true);
      // Réinitialise les valeurs des champs de saisie
      newPrestation.querySelectorAll('input').forEach(input => input.value = '');
      document.querySelector('#prestationsb').appendChild(newPrestation);
    }
    document.querySelector('#add-btnb').addEventListener('click', clonePrestation);

    document.addEventListener('click', event => {
      if (event.target && event.target.classList.contains('remove-btnb')) {
        event.target.closest('.prestationb').remove();
      }
    });

    document.addEventListener('input', event => {
      if (event.target && event.target.name === 'qty[]' || event.target.name === 'prixunitaire[]') {
        const prestation = event.target.closest('.prestationb');
        const qty = prestation.querySelector('[name="qty[]"]').value;
        const prixunitaire = prestation.querySelector('[name="prixunitaire[]"]').value;
        const total = prestation.querySelector('[name="total[]"]');
        total.value = qty * prixunitaire;
      }
    });
</script>
