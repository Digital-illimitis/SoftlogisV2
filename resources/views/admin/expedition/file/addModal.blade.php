<div class="modal fade" id="addExpFile{{ $expedition->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Ajouter des nouveaux documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.expedition.add', $expedition->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm">
                    @csrf

                    <input type="text" class="form-control" id="expedition_id" hidden value="{{$expedition->id}}" name="expedition_id" autocomplete="off">

                    <div class="col-12 mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <button id="add_doc" type="button" class="btn btn-outline-secondary py-1 my-auto mb-3" onclick="addExpDoc()"><i class="bx bxs-plus-square"></i>Ajouter un document</button>
                        </div>
                        <div class="mb-2" id="docu_expedition">
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

