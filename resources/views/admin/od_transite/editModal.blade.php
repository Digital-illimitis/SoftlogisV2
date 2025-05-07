<div class="modal fade modal-lg modal-dialog-scrollable text-start" data-bs-backdrop="static" id="EditOdreTransite{{ $odretransite->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Modification de l'ordre de transit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.od_transite.update', $odretransite->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                    @csrf

                    <div class="row col-12">
                        <div class="col-12">
                            <label for="transitaire_uuid" class="form-label text-uppercase">Transitaire</label>
                            <select name="transitaire_uuid" class="form-control" id="transitaire_uuid">
                                <option value="{{ $odretransite->transitaire->uuid ?? '--' }}" selected>{{ $odretransite->transitaire->raison_sociale ?? '--' }}</option>
                                @foreach ($transitaires as $transitaire)
                                    <option value="{{ $transitaire->uuid }}">{{ $transitaire->raison_sociale }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr class="my-4">
                        <div class="col-12">
                            <label for="note" class="form-label text-uppercase">Note</label>
                            <textarea name="note" id="note" cols="30" rows="3" class="form-control">{{ $odretransite->note }}</textarea>
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
