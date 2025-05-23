<div class="modal fade" id="addTransitGrille" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter Une Grille Tarifaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

           <div class="modal-body">
                <form action="{{ route('admin.offre.storeTransit') }}" method="post" class="submitForm">
                    @csrf

                    <input type="hidden" name="transitaire_uuid" value="{{ $company->uuid }}">

                    <div class="form-group">
                        <label for="regime" class="form-label">Regime <span class="text-danger">*</span></label>
                        <select name="regime" id="regime" class="form-select" required>
                            <option class="form-option" value="D11">D11</option>
                            <option class="form-option" value="D3">D3</option>
                            <option class="form-option" value="D25">D23</option>
                        </select>
                    </div>

                    <div class="my-3 col-12">
                        <label for="container" class="form-label">Container <span class="text-danger">*</span></label>
                        <input type="text" name="container" class="form-control" required>
                    </div>

                    <div class="mb-3 col-12">
                        <label for="cout" class="form-label">Cout HAD <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="cout" name="cout" required>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="forfait" class="form-label">Forfait Transit <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="forfait" name="forfait" required>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="commission" class="form-label">Commission <span>%</span></label>
                        <input type="number" class="form-control" id="commission" name="commission">
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
