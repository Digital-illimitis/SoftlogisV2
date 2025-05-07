<div class="modal fade" id="editExpeditionModal{{ $expedition->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="page-content">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title size_16">Mise a jour de l'ordre d'expedition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body page-content size_13">
                    <form action="{{ route('admin.odre_expedition.update', $expedition->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm">
                        @csrf
                        <div id="t" role="tabpanel" class="bs" aria-labelledby="">
                            <div class="row g-3">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <label for="client_uuid" class="form-label">Clients</label>
                                    <select class="form-select" id="client_uuid" name="client_uuid" aria-label="Default select example">
                                        @if ($expedition->client)
                                        <option value="{{ $expedition->client->uuid}}" selected>{{ $expedition->client->raison_sociale ?? 'N/A'}}</option>
                                        @else
                                            <option selected>Selectionné un client</option>
                                        @endif
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->uuid }}">{{ $client->raison_sociale }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-12 col-lg-6">
                                    <label for="date_liv" class="form-label">Date de livraison</label>
                                    <input type="date" class="form-control" value="{{ $expedition->date_liv }}" id="date_liv" name="date_liv">
                                </div>

                                <div class="col-12 col-md-12 col-lg-12">
                                    <label for="lieu_liv" class="form-label">Lieu de livraison</label>
                                    <input type="text" class="form-control" id="lieu_liv" name="lieu_liv" value="{{ $expedition->lieu_liv }}">
                                </div>
                                <input type="hidden" name="expedition_id" value="{{ $expedition->id }}">

                                <div class="col-12 col-lg-12">
                                    <label for="incoterm" class="form-label">Incoterm</label>
                                    <textarea name="incoterm" id="incoterm" class="form-control" cols="30" rows="3" value="{{ $expedition->incoterm }}">{{ $expedition->incoterm }}</textarea>
                                </div>

                                <div class="col-12">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
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
