<div class="modal fade" id="CreateSourcing" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Démarrage de Sourcing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.sourcing.store') }}" method="POST" enctype="multipart/form-data" class="submitForm">
                    @csrf
                    <div>
                        <div class="my-3">
                            <strong class="text-uppercase text-primary my-auto"></strong>
                            <div class=" card-headerd-flex align-items-center justify-content-between">
                                <button id="doc_t" type="button" class="btn btn-outline-primary py-1 my-auto mb-3" onclick="addnewBlockProduct()"><i class="bx bxs-plus-square"></i>Ajouter une ligne produit</button>
                            </div>
                            <div class="mb-2 card-body" id="productBlock">
                                <!-- Dom js pour l'ajout de nouveaux documents de transite-->
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <div class="content">
                        <div class="row ">
                            <div class="mb-3 col-6" style="font-size: 13px">
                                <label for="id_navire" class="form-label text-uppercase">Identifiant du navire <span><span class="text-danger">*</span></span></label>
                                <input type="text" class="form-control @error('id_navire') is-invalid @enderror" id="id_navire" name="id_navire" autocomplete="off">
                                @error('id_navire')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="inputCollection"
                                    class="form-label">Packaging</label>
                                <select class="form-select" id="inputCollection"
                                    name="packaging" autocomplete="off">
                                    <option></option>
                                    <option value="roro">Roro</option>
                                    <option value="container">Container</option>
                                </select>
                            </div>
                        </div>
                        <div class=" row text-uppercase" style="font-size: 13px">
                            <div class="col-6">
                                <label for="date_depart" class="form-label">Date de départ</label>
                                <input type="date" class="form-control date-error @error('date_depart') is-invalid @enderror" id="date_depart" name="date_depart" autocomplete="off">
                                @error('date_depart')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="date_arriver" class="form-label">Date estimative d'arrivée</label>
                                <input type="date" class="form-control date-error @error('date_arriver') is-invalid @enderror" id="date_arriver" name="date_arriver" autocomplete="off">
                                @error('date_arriver')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    <hr class="mb-4 mt-2">

                    <div class="">
                        <div class="mb-3 col-12" style="font-size: 13px">
                            <label for="info_navire" class="form-label text-uppercase">Description du navire</label>
                            <textarea class="form-control" id="info_navire" name="info_navire" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <div class="">
                        <div class="mb-3 col-12" style="font-size: 13px">
                            <label for="note" class="form-label text-uppercase">Note</label>
                            <textarea class="form-control" id="note" name="note" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <hr class="mb-4">

                    <div class="mb-3">
                        <strong class="text-uppercase text-secondary my-auto">Documents de sourcing (PDF, Word, Excel)</strong>
                        <div class="d-flex align-items-center justify-content-between">
                            <button id="add_doc" type="button" class="btn btn-outline-primary py-1 my-auto mb-3" onclick="addNewDocument()"><i class="bx bxs-plus-square"></i>Ajouter un document</button>
                        </div>
                        <div class="mb-2" id="docu_content">

                        </div>
                    </div>

                    <input type="hidden" class="form-control" id="created_by" value="{{ Auth::user()->name . ' ' . Auth::user()->lastname }}" name="created_by">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    document.addEventListener('click', function (event) {
        var isBonCommandClick = event.target.id === 'bon_commande_input';

        if (!isBonCommandClick) {

            document.getElementById('search_resultsByBon').innerHTML = '';
        }
    });
    document.addEventListener('click', function (event) {
        var isBonSerialClick = event.target.id === 'numero_serie_input';
        if (!isBonSerialClick) {

            document.getElementById('search_results').innerHTML = '';
        }
    });

</script>


