<div class="modal fade" id="CreateTransiteFile{{ $odretransite->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Ajouter des nouveaux documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.od_transite_doc.add') }}" method="POST" enctype="multipart/form-data" class="submitForm">
                    @csrf

                     <input type="text" class="form-control" id="sourcing_id" hidden value="{{$odretransite->id}}" name="od_transite_id" autocomplete="off">


                    <div class="col-12 card mb-3">
                        <div class="">
                            <div class=" card-headerd-flex align-items-center justify-content-between">
                                <button id="add_document" type="button" class="btn btn-outline-primary py-1 my-auto mb-3" onclick="addNewDoctransite()"><i class="bx bxs-plus-square"></i>Ajouter un document</button>
                            </div>
                            <div class="mb-2 card-body" id="doc_transite_container">
                                <!-- Dom js pour l'ajout de nouveaux documents de transite-->
                            </div>
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
