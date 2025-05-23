
<div class="modal-content card card-data  d-none translate-middle" tabindex="-1" aria-hidden="true">
    <div class="card-header py-1 text-uppercase">Verifier la conformité de sortir</div>
    <div class="card-body">
        <div class="form-group row d-flex justify-content-between">
            <div class="btn-group" role="group" aria-label="Conformité" style="max-height: 40px">
                <input type="radio" name="conformityOut" id="conforme" value="on" class="btn-check" autocomplete="off" @error('conformityOut') is-invalid @enderror required>
                <label class="btn btn-outline-primary col" for="conforme">Conforme</label>

                <input type="radio" name="conformityOut" id="non-conforme" value="off" class="btn-check" autocomplete="off" @error('conformityOut') is-invalid @enderror required>
                <label class="btn btn-outline-primary col" for="non-conforme">Non Conforme</label>
                @error('conformity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group w-100 mt-3">
            <textarea name="noteOut" id="noteOut" cols="30" rows="2" placeholder="Note de conformité de sortir" class="form-control p-3"></textarea>
        </div>
    </div>
    <div class="card-footer" style="max-height: 40px">
        <button type="submit" class="btn btn-primary">Valider</button>
        <button type="button" class="btn btn-secondary" id="closeBtnConformity" >Fermer</button>
    </div>
</div>

<style>
    .card-data {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    z-index: 1000;
    max-width: 500px;
}
</style>
