<div class="modal fade" id="addStockage" tabindex="-1" aria-hidden="true" style="width: 100% !important">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Entré en Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger" style="min-height: 300px;">
                <div class="row col-12">
                    <div class="table-respsive">
                        <table class="table table-bordered">
                            <thead class="" style="max-height: 20px">
                                <tr>
                                    <th >Famille</th>
                                    <th >N° serie</th>
                                    <th >Entrepot</th>
                                    <th>Date de stockage</th>
                                    {{-- <th ></th> --}}
                                    <th >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sourcing->products as $product)
                                    <form action="{{ route('admin.stockaction.store') }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                                        @csrf
                                        <tr>
                                            <input type="hidden" name="sourcing_uuid" value="{{ $sourcing->uuid }}">
                                            <td >{{ $product->product->familly->libelle ?? '' }}</td>
                                            <td >{{ $product->product->numero_serie ?? '' }}</td>
                                            <input type="hidden" name="product_uuid" value="{{ $product->product->uuid }}">
                                            @if ($product->product->status == 'received')
                                                <td >
                                                    <select name="entrepot_uuid" class="form-select" id="entrepot_uuid" required>
                                                        <option selected disabled>Choisir entrepôt</option>
                                                        @foreach ($entrepots as $entrepot)
                                                            <option value="{{ $entrepot->uuid }}">{{ $entrepot->nom }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('entrepot_uuid')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="date_stockage" required>
                                                    @error('date_stockage')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary">Stocké</button>
                                                </td>
                                            @elseif($product->product->status !== 'received')
                                                <td class="col-md-3 text-danger size_12">Impossible de stocké un produit non receptionné</td>
                                            @elseif ($product->product->status == 'stocked')
                                                <td class="col-md-3">{{ $product->product->entrepot->nom ?? '' }}</td>
                                                <td class="col-md-3 text-success">Produit stocké</td>
                                            @endif
                                        </tr>
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="6">Tous les produits ont été Stocké</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Ajoutez cette section à votre code existant -->

<script>
    // Add this script to your page or include it in a separate script file
    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('input[name^="conformity"]');

        radioButtons.forEach(function (radio) {
            radio.addEventListener('change', function () {
                // Get the index from the radio button's ID
                const index = this.id.match(/\d+/)[0];

                // Remove the 'active' class from all labels with the corresponding index
                document.querySelectorAll('.btn-check[id^="conforme' + index + '"], .btn-check[id^="non-conforme' + index + '"]').forEach(function (label) {
                    label.classList.remove('active');
                });

                // Add the 'active' class to the selected label
                const selectedLabel = document.querySelector('label[for="' + this.id + '"]');
                selectedLabel.classList.add('active');
            });
        });
    });
</script>