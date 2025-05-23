<div class="modal fade" id="CreateLivraisonFile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Ajouter des nouveaux documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.od_livraisons.add') }}" method="POST" enctype="multipart/form-data" class="submitForm">
                    @csrf

                    <input type="text" class="form-control" id="sourcing_id" hidden value="{{$oDLivraison->id}}" name="livraison_id" autocomplete="off">

                    <div class="col-12 mb-4 card">
                        <div class="d-flex align-items-center justify-content-between">
                            <button id="add_doc" type="button" class="btn btn-outline-primary py-1 my-auto mb-3" onclick="addNewDocLivraison()"><i class="bx bxs-plus-square"></i>Ajouter un document</button>
                        </div>
                        <div class="mb-2" id="doc_livraison_container">
                            <!-- Dom js pour l'ajout de nouveaux documents -->
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

