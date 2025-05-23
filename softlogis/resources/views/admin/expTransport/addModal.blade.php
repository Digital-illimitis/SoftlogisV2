<div class="modal fade" id="addOrdreTransport{{ $expedition->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase size_16">Creation de l'ordre de transport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body size_13" id="stronger">
                <form action="{{ route('admin.transport.to_expedition.store') }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                    @csrf
                    <div class="row col-12">
                        <input type="hidden" name="expedition_uuid" value="{{ $expedition->uuid }}">

                        <div class="col-12 w-100 mb-4 mx-auto" id="block_toggle">
                            <div class="btn-group w-100 d-flex row mx-auto px-0" data-toggle="buttons">
                                <label class="btn btn-primary active col-6">
                                    <input type="radio" name="voie_exp" value="terrestre" checked> Voie Terrestre
                                </label>
                                <label class="btn btn-primary col-6">
                                    <input type="radio" name="voie_exp" value="maritime"> Voie Maritime
                                </label>
                            </div>
                        </div>
                        <div class="col-12" id="terrestre-transporteurs">
                            <label for="transporteur_uuid" class="form-label text-uppercase">Transporteur Terrestre</label>
                            <select name="transporteur_uuid" class="form-control" id="transporteur_uuid">
                                <option value="" disabled selected>Selectionnez un transporteur</option>
                                @foreach ($transporteurs as $transporteur)
                                    <option value="{{ $transporteur->uuid }}">{{ $transporteur->raison_sociale }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12" id="maritime-transporteurs" style="display: none;">
                            <label for="transporteur_uuid" class="form-label text-uppercase">Transporteur Maritime</label>
                            <select name="transporteur_uuid" class="form-control" id="transporteur_uuid">
                                <option value="" disabled selected>Selectionnez un transporteur</option>
                                @foreach ($transpormarines as $transpormarine)
                                    <option value="{{ $transpormarine->uuid }}">{{ $transpormarine->raison_sociale }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 row mt-3">
                            <div class="col-6">
                                <label for="date_transport">Date de Livraison</label>
                                <input type="date" name="date_transport" id="date_transport" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="destination">Destination</label>
                                <input type="text" name="destination" id="destination" class="form-control">
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <textarea name="note" id="note" cols="30" rows="3" placeholder="Ajouter une note a l'ordre de transport" class="form-control"></textarea>
                        </div>
                        <hr class="my-2">
                        <div class="col-12">
                            <div class="my-3">
                                <strong class="text-uppercase text-primary my-auto">Documents de transport (PDF, Word, Excel)</strong>
                                <div class=" card-headerd-flex align-items-center justify-content-between">
                                    <button id="doc_transport" type="button" class="btn btn-outline-primary py-1 my-auto mb-3" onclick="addExpDoctransport()"><i class="bx bxs-plus-square"></i>Ajouter un document</button>
                                </div>
                                <div class="mb-2 card-body" id="doc_transport_export">
                                    <!-- Dom js pour l'ajout de nouveaux documents de transite-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
     const voieTerrestreButton = document.querySelector('input[name="voie_exp"][value="terrestre"]');
    const voieMaritimeButton = document.querySelector('input[name="voie_exp"][value="maritime"]');
    const terrestreTransporteurs = document.getElementById('terrestre-transporteurs');
    const maritimeTransporteurs = document.getElementById('maritime-transporteurs');

    // Ajoutez des gestionnaires d'événements aux boutons radio
    voieTerrestreButton.addEventListener('change', () => {
        if (voieTerrestreButton.checked) {
            terrestreTransporteurs.style.display = 'block';
            maritimeTransporteurs.style.display = 'none';
            voieTerrestreButton.parentElement.classList.add('active');
            voieMaritimeButton.parentElement.classList.remove('active');
        }
    });

    voieMaritimeButton.addEventListener('change', () => {
        if (voieMaritimeButton.checked) {
            terrestreTransporteurs.style.display = 'none';
            maritimeTransporteurs.style.display = 'block';
            voieMaritimeButton.parentElement.classList.add('active');
            voieTerrestreButton.parentElement.classList.remove('active');
        }
    });

    if (voieTerrestreButton.checked) {
        terrestreTransporteurs.style.display = 'block';
        maritimeTransporteurs.style.display = 'none';
        voieTerrestreButton.parentElement.classList.add('active');
    } else if (voieMaritimeButton.checked) {
        terrestreTransporteurs.style.display = 'none';
        maritimeTransporteurs.style.display = 'block';
        voieMaritimeButton.parentElement.classList.add('active');
    }
</script>
