<div class="modal fade" id="editTransportGrille" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier Une Grille Tarifaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

           <div class="modal-body">
                <form action="{{ route('admin.offre.update', $items[0]->id) }}" method="post" class="submitForm">
                    @csrf

                   

                    <div class="mb-3 col-12">
                        <label for="destination_uuid" class="form-label">Destination</label>
                        <select name="destination_uuid" id="destination_uuid" class="form-select">
                            <option value="{{ $items[0]->destination_uuid }}" class="form-control">{{  $items[0]->destination->libelle ?? "" }}</option>
                            @foreach ($destinations as $destination)
                            @if($destination->uuid <>  $items[0]->destination_uuid)
                                <option value="{{ $destination->uuid }}" class="form-control">{{ $destination->libelle ?? "" }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="porteChar_uuid" class="form-label">Porte Char</label>
                        <select name="porteChar_uuid" id="porteChar_uuid" class="form-select">
                            <option value="{{ $items[0]->porteChar_uuid }}" class="form-control">{{ $items[0]->porteChar->libelle ?? "" }}</option>
                            @foreach ($porteChars as $porteChar)
                            @if($porteChar->uuid <>  $items[0]->porteChar_uuid)
                                <option value="{{ $porteChar->uuid }}" class="form-control">{{ $porteChar->libelle ?? "" }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="cout" class="form-label">Cout</label>
                        <input type="text" class="form-control" id="cout" value="{{ $items[0]->cout ?? '0' }}" name="cout">
                    </div>

                    <hr>

                    <div class="mb-3 col-12 text-end">
                        <button type="submit" class="btn btn-primary col-4">Modifier</button>
                    </div>
                </form>
           </div>

        </div>
    </div>
</div>
