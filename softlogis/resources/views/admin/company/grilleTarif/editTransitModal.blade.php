<div class="modal fade" id="editTransitGrille" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier Une Grille Tarifaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

           <div class="modal-body">
                <form action="{{ route('admin.offre.updateTransit', $item->id) }}" method="post" class="submitForm">
                    @csrf

                    <div class="form-group">
                        <label for="regime" class="form-label">Regime <span class="text-danger">*</span></label>
                        <select name="regime" id="regime" class="form-select" required>
                            <option class="form-option" value="D11" @if($item->regime == 'D11') selected @endif >D11</option>
                            <option class="form-option" value="D3" @if($item->regime == 'D3') selected @endif >D3</option>
                            <option class="form-option" value="D25" @if($item->regime == 'D25') selected @endif >D23</option>
                        </select>
                    </div>

                    <div class="my-3 col-12">
                        <label for="container" class="form-label">Container <span class="text-danger">*</span></label>
                        <input type="text" name="container" value="{{$item->container ?? ''}}" class="form-control" required>
                    </div>

                    <div class="mb-3 col-12">
                        <label for="cout" class="form-label">Cout HAD <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" value="{{$item->cout ?? ''}}" id="cout" name="cout" required>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="forfait" class="form-label">Forfait Transit <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="forfait" value="{{$item->forfait ?? ''}}" name="forfait" required>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="commission" class="form-label">Commission <span>%</span></label>
                        <input type="number" class="form-control" value="{{$item->commission ?? ''}}" id="commission" name="commission">
                    </div>

                    <hr>

                    <div class="mb-3 col-12 text-end">
                        <button type="submit" class="btn btn-primary col-4">Modifier</button>
                    </div>
                </form>
           </div>

        </div>
    </div>
</div>
