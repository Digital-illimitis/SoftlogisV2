<div class="modal fade" id="EditDoc{{$sourcingFile->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Modifié le documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.sourcing.edit_documents', $sourcingFile->id) }}" method="POST" enctype="multipart/form-data" class="submitForm">
                    @csrf

                    <hr class="mb-4">
                    <div class="mb-3">
                        <div class="mb-2">
                            <div class="col-5 mb-3">
                            <input type="text" name="name" class="form-control" value="{{$sourcingFile->name}}" placeholder="Titre du fichier">
                            </div>
                            <div class="col-6">
                                <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" value="{{$sourcingFile->files}}" class="form-control" name="files[]">
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
