<div class="modal fade" id="updateDeclaration" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Declaration import</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.declaration-import.update', $sourcing->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm">
                    @csrf
                    
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <input type="file" class="form-control" name="declarationFile" autocomplete="off" value="{{ $sourcing->declarationFile }}">
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" name="declarationDate" autocomplete="off" value="{{ $sourcing->declarationDate }}">
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" name="declarationNum" autocomplete="off" placeholder="N° declaration" value="{{ $sourcing->declarationNum }}">
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">Soumettre</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
