<div class="modal fade" id="EditOdrelivraison{{ $oDLivraison->uuid }}" tabindex="-1" aria-hidden="true" style="min-width: 750px">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Modifier l'ordre de livraison</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.od_livraisons.update', $oDLivraison->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                    @csrf
                    <div class="row col-12">
                        <div class="col-12">
                            <label for="transporteur_uuid" class="form-label text-uppercase">Transporteur</label>
                            {{-- <select name="transporteur_uuid" class="form-control" id="transporteur_uuid">
                                <option value="{{ $oDLivraison->transporteur->uuid ?? '' }}" disabled selected>{{ $oDLivraison->transporteur->raison_sociale ?? '--' }}</option>
                                @foreach ($transporteurs as $transporteur)
                                    <option value="{{ $transporteur->uuid }}">{{ $transporteur->raison_sociale }}</option>
                                @endforeach
                            </select> --}}

                            <select class="form-select" id="transporteur_uuid" name="transporteur_uuid" >
                                <option value="{{ $oDLivraison->transporteur->uuid ?? "" }}">{{ $oDLivraison->transporteur->raison_sociale ?? ""}}</option>
                                @foreach ($transporteurs as $transporteur)
                                    {{-- @if ($transporteur->uuid != $oDLivraison->transporteur->uuid ?? '') --}}
                                    <option value="{{ $transporteur->uuid }}">{{ $transporteur->raison_sociale }}</option>
                                    {{-- @endif --}}
                                @endforeach
                            </select>
                        </div>
                        <div class="row col-12 my-3 d-flex justify-content-between">
                            <div class="col">
                                <label for="date_livraison" class="form-label text-uppercase">Date de livraison</label>
                                <input type="date" name="date_livraison" class="form-control" value="{{ $oDLivraison->date_livraison }}" autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="lieu_livraison" class="form-label text-uppercase">Lieu de livraison</label>
                                <input type="text" name="lieu_livraison" class="form-control" value="{{ $oDLivraison->lieu_livraison }}" placeholder="{{ $oDLivraison->lieu_livraison }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 my-4">
                            {{-- <label for="note" class="form-label text-uppercase">Note</label> --}}
                            <textarea name="note" id="note" cols="30" rows="3" class="form-control" value="{{ $oDLivraison->note }}">{{ $oDLivraison->note }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

