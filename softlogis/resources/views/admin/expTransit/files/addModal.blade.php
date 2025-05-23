<div class="modal fade" id="addDocTransit{{ $expTransit->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <span>Ajout de Document</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
               <form action="{{ route('admin.transit_doc.add') }}" method="post" class="submitForm" >
                @csrf
                    <input type="hidden" name="transite_uuid" value="{{ $expTransit->uuid }}">
                    <div class="col-12">
                        <div class="my-3">
                            <strong class="text-uppercase text-primary my-auto">Documents de transite (PDF, Word, Excel)</strong>
                            <div class=" card-headerd-flex align-items-center justify-content-between">
                                <button id="add_doc_exp" type="button" class="btn btn-outline-primary py-1 my-auto mb-3" onclick="addExpDoctransite()"><i class="bx bxs-plus-square"></i>Ajouter un document</button>
                            </div>
                            <div class="mb-2 card-body" id="doc_transite_export">
                                <!-- Dom js pour l'ajout de nouveaux documents de transite-->
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
               </form>
            </div>
        </div>
    </div>
</div>
