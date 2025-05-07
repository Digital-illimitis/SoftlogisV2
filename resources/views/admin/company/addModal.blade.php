<!-- Modal add Company-->
<div class="modal fade" id="addcompany" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter Compagnie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('admin.company.store') }}" class="submirm"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body gy-3" style="max-height: 80vh; overflow-y: auto;">

                    <div class="form-group">
                        <label for="logo" class="col-form-label">logo:</label>
                        <input type="file" class="form-control" id="logo" name="logo">
                    </div>

                    <div class="row">
                        <div class="form-group col">
                            <label for="identification" class="col-form-label">Registre de commerce:</label>
                            <input type="text" class="form-control" id="identification" name="identification"
                                placeholder="000000xxxxx">
                        </div>
                        <div class="form-group col">
                            <label for="raison_sociale" class="col-form-label">Raison Sociale <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control @error('raison_sociale') is-invalid @enderror" id="raison_sociale" name="raison_sociale" required>
                            @error('raison_sociale')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type" class="col-form-label">Type organisation <span class="text-danger">*</span>:</label>
                        <select name="type" id="typeAdd" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="client">Client</option>
                            <option value="transitaire">Transitaire</option>
                            <option value="transporteur">Transporteur</option>
                            <option value="organisation">Organisation</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group row col-12 mx-auto my-3" id="voie-transport-block-add" style="display: none;">
                        <label class="col-form-label">Voie de transport :</label>
                        <div class="form-check col-sm-6">
                            <input type="radio" class="form-check-input" name="voie_transport" id="terrestre" value="terrestre">
                            <label class="form-check-label" for="terrestre">Terrestre</label>
                        </div>
                        <div class="form-check col-sm-6">
                            <input type="radio" class="form-check-input" name="voie_transport" id="maritime" value="maritime">
                            <label class="form-check-label" for="maritime">Maritime</label>
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="form-group col">
                            <label for="email" class="col-form-label">E-mail de l'entreprise <span class="text-danger">*</span>:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="exemple@example.com" name="email" required unique>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col">
                            <label for="phone" class="col-form-label">Télephone Entreprise: <span class="text-danger">*</span></label>
                            <input type="phone" class="form-control" id="phone" placeholder="+123456789" name="phone" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="localisation" class="col-form-label">Localisation:</label>
                        <input type="text" class="form-control" id="localisation" name="localisation">
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-form-label">Description:</label>
                        <textarea name="description" id="description" cols="30" rows="3"
                            class="form-control"></textarea>
                    </div>

                    <div class="form-group py-3">
                        <label for="add_access" class="col-form-label text-danger btn">Donner l'accès aux systemes</label>
                        <input type="checkbox" id="add_access" name="add_access">
                    </div>
                    <hr class="my-3">

                    <input type="text" class="form-control disabled" disabled placeholder="Contact 1">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="contact_one_email" class="col-form-label">Email Contact:</label>
                            <input type="email" class="form-control" id="contact_one_email"
                                placeholder="exemple@example.com" name="contact_one_email">
                        </div>
                        <div class="form-group col-6">
                            <label for="contact_one_name" class="col-form-label">Nom du contact:</label>
                            <input type="text" class="form-control" id="phone" name="contact_one_name">
                        </div>
                        <div class="form-group col-6">
                            <label for="contact_one_lastName" class="col-form-label">Prénom du contact:</label>
                            <input type="text" class="form-control"
                            id="contact_one_lastName" name="contact_one_lastName">
                        </div>
                    </div>
                    <hr class="my-3">
                    <input type="text" class="form-control disabled" disabled placeholder="Contact 2">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="contact_two_email" class="col-form-label">Email Contact:</label>
                            <input type="email" class="form-control" id="contact_two_email"
                                placeholder="exemple@example.com" name="contact_two_email">
                        </div>
                        <div class="form-group col-6">
                            <label for="contact_two_name" class="col-form-label">Nom du contact:</label>
                            <input type="text" class="form-control" id="contact_two_name" name="contact_two_name">
                        </div>
                        <div class="form-group col-6">
                            <label for="contact_two_lastName" class="col-form-label">Prénom du contact:</label>
                            <input type="text" class="form-control" id="contact_two_lastName"
                                name="contact_two_lastName">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- </div> --}}