<div class="modal fade" id="confirmOrder{{ $expedition->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Reception de la commande </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.expedition.confirmOrder', $expedition->uuid) }}" method="POST"  class="submitForm">
                    @csrf
                    
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <input type="date" class="form-control" name="orderDate" autocomplete="off">
                            </div>

                            <div class="col-12 my-4">
                                <textarea class="form-control" name="orderContent" placeholder="lorem ipsum dolor" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary">Soumettre</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
