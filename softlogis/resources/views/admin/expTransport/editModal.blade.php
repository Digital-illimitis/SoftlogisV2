<div class="modal fade" id="editOrdreTransport{{ $ordreTransport->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase size_16">Mise a jour de l'ordre de transport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body size_13" id="stronger">
                <form action="{{ route('admin.transport.update', $ordreTransport->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                    @csrf
                    <div class="row col-12">

                        @if ($ordreTransport->voie_exp == 'terrestre')
                        <div class="col-12" id="terrestre-transporteurs">
                            <label for="transporteur_uuid" class="form-label text-uppercase">Transporteur Terrestre</label>
                            <select name="transporteur_uuid" class="form-control" id="transporteur_uuid">
                                <option value="" disabled selected>Selectionnez un transporteur</option>
                                @foreach ($transporteurs as $transporteur)
                                    <option value="{{ $transporteur->uuid }}">{{ $transporteur->raison_sociale }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="col-12" id="maritime-transporteurs">
                            <label for="transporteur_uuid" class="form-label text-uppercase">Transporteur Maritime</label>
                            <select name="transporteur_uuid" class="form-control" id="transporteur_uuid">
                                <option value="" disabled selected>Selectionnez un transporteur</option>
                                @foreach ($transpormarines as $transpormarine)
                                    <option value="{{ $transpormarine->uuid }}">{{ $transpormarine->raison_sociale }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-12 row mt-3">
                            <div class="col-6">
                                <label for="date_transport">Date de Livraison</label>
                                <input type="date" value="{{ $ordreTransport->date_transport }}" name="date_transport" id="date_transport" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="destination">Destination</label>
                                <input type="text" value="{{ $ordreTransport->destination }}" name="destination" id="destination" class="form-control">
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <textarea name="note" id="note" cols="30" rows="3" value="{{ $ordreTransport->note }}" class="form-control">{{ $ordreTransport->note }}</textarea>
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
