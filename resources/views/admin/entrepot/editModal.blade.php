<div class="modal fade" id="editEntrepotModal{{ $entrepot->uuid }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mise a jour de l'entrepot {{ $entrepot->nom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.stock_entrepot.update', $entrepot->uuid) }}" method="post" class="submitForm">
                <div class="modal-body my-4">
                    @csrf

                    <div class="row">
                        <div class="form-group col">
                            <label for="">Nom <span><span class="text-danger">*</span></span></label>
                            <input class="form-control" type="text" name="nom" value="{{ $entrepot->nom }}" autocomplete="off" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col">
                            <label for="">Emplacement <span><span class="text-danger">*</span></span></label>
                            <input class="form-control" type="text" name="emplacement" value="{{ $entrepot->emplacement }}" autocomplete="off" required>
                            @error('emplacement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="">Couleur</label>
                            <input class="form-control" type="color" name="color" value="{{ $entrepot->color }}" autocomplete="off">
                        </div>
                        <div class="form-group col">
                            <label for="">Capacité</label>
                            <input class="form-control" type="text" name="capacity" autocomplete="off" value="{{ $entrepot->capacity }}">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="description">Description <span class="text-muted">(facultatif)</span></label>
                        <textarea class="form-control" name="description" id="" cols="30" rows="2" autocomplete="off" value="{{ $entrepot->description }}"> {{ $entrepot->description }}</textarea>
                    </div>

                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-outline-success">Modifier</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
