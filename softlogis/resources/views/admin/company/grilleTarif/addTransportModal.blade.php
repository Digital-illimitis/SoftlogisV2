<div class="modal fade" id="addTransportGrille" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter Une Grille Tarifaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

           <div class="modal-body">
                <form action="{{ route('admin.offre.store') }}" method="post" class="submitForm">
                    @csrf

                    <input type="hidden" name="transporteur_uuid" value="{{ $company->uuid }}">

                    <div class="mb-3 col-12">
                        <label for="destination_uuid" class="form-label">Destination</label>
                        <select name="destination_uuid" id="destination_uuid" class="form-select">
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->uuid }}" class="form-control">{{ $destination->libelle ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="porteChar_uuid" class="form-label">Porte Char</label>
                        <select name="porteChar_uuid" id="porteChar_uuid" class="form-select">
                            @foreach ($porteChars as $porteChar)
                                <option value="{{ $porteChar->uuid }}" class="form-control">{{ $porteChar->libelle ?? "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="cout" class="form-label">Cout</label>
                        <input type="text" class="form-control" id="cout" name="cout">
                    </div>

                    <hr>

                    <div class="mb-3 col-12 text-end">
                        <button type="submit" class="btn btn-primary col-4">Ajouter</button>
                    </div>
                </form>
           </div>

        </div>
    </div>
</div>
