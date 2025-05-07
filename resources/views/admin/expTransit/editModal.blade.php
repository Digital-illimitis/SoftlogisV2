<div class="modal fade" id="EditOdreTransite{{ $transit->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase size_16">Mise a jour de l'ordre de transite</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body size_13" id="stronger">
                <form action="{{ route('admin.transit.to_expedition.update', $transit->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                    @csrf

                    <div class="row col-12">
                        <div class="col-12">
                            <label for="transitaire_uuid" class="form-label text-uppercase">Transitaire Export</label>
                            <select name="transitaire_uuid" class="form-control" id="transitaire_uuid">
                                @if ($transit->transitaire)
                                <option value="{{ $transit->transitaire->uuid}}" selected>{{ $transit->transitaire->raison_sociale ?? "N/A" }}</option>
                                @else
                                <option value="" disabled selected>Selectionnez un transitaire</option>
                                @endif
                                @foreach ($transitaires as $transitaire)
                                    @if ($transit->transitaire)
                                        @if ($transitaire->uuid !== $transit->transitaire->uuid)
                                        <option value="{{ $transitaire->uuid }}">{{ $transitaire->raison_sociale }}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-4">

                            <textarea name="note" id="note" cols="30" rows="3" class="form-control" value="{{ $transit->note }}">{{ $transit->note }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Mettre a jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
