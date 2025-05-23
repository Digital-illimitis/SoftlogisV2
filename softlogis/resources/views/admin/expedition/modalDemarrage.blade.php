<div class="modal fade" id="addOrdreDemarrage{{ $expedition->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Démarrage Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.expedition.validate', ['uuid' => $expedition->uuid]) }}" method="POST" enctype="multipart/form-data" class="submitForm">
                    @csrf
                    
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <input type="date" class="form-control" name="date_validate_doc" autocomplete="off">
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary" onclick="return confirmSubmission(event)">Démarrage Document</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
