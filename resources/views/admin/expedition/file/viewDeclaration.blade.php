<div class="modal fade" id="declarationModal{{ $expedition->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <iframe src='{{ asset("documents/files/", $expedition->declaration) }}' width="100%" height="600"></iframe>
            </div>
        </div>
    </div>
</div>
