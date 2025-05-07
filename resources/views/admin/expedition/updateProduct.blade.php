<div class="modal fade" id="productListModal{{ $expedition->uuid }}" tabindex="-1"
    aria-labelledby="productListModalLabel{{ $expedition->uuid }}" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productListModalLabel{{ $expedition->id }}">Modifier la Liste des Produits de l'expedition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                @if ($expedition->products->count() > 0)
                <div class="content px-4">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Famille</th>
                                <th scope="col">N° serie</th>
                                <th scope="col">N° Bon Commande</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expedition->products as $index => $item)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $item->product->familly->libelle ?? '' }}</td>
                                <td>{{ $item->product->numero_serie }}</td>
                                <td>{{ $item->product->numero_bon_commande }}</td>
                                <td>
                                    <form action="{{ route('admin.expedition.deletteproduct', $item->product->id) }}"
                                        method="post" class="submitForm delete-product-form" id="deleteForm">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        <input type="hidden" name="expedition_id" value="{{ $expedition->id }}">
                                        <button type="submit" class="btn btn-danger">
                                            <img src="{{ asset('icone/poubelle.gif') }}" alt="" class="img-fluid"
                                                style="width: 20px; height: 20px">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif


                <div class="content-block">
                    <form action="{{ route('admin.expedition.editProduct', $expedition->uuid) }}" method="post" class="submitForm">
                        @csrf
                        <div>
                            <input type="hidden" name="expedition_uuid" value="{{ $expedition->uuid }}">
                            <div class="col my-2">
                                <button type="button" class="btn btn-outline-primary" onclick="addNewRowExp()"><i class="bx bxs-plus-square"></i>Ajouter une ligne produit</button>
                            </div>

                            <div class="content row gy-2 mb-2 col-12 d-flex " id="clone_ligne_prodt">
                                <div class="col-5">
                                    <select class="form-control families_select" id="families_select" name="famille_id">
                                        <option value="">Sélectionnez une famille</option>
                                        @foreach ($families as $family)
                                            <option value="{{ $family->id }}">{{ $family->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">
                                    <select class="form-control col-3 products_select"  id="products_select" name="product_id[]">
                                        <option value="">Sélectionnez un produit</option>
                                        @foreach ($products as $product)
                                            <option id="product_option_{{ $product->id }}" data-famille-exp-id="{{ $product->familly->id }}" value="{{ $product->id }}" class="product-option">{{ $product->numero_serie }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-1 d-flex text-center justify-content-center text-align-center">
                                    <button class="delete-button btn-outline-danger w-75 h-75 my-auto" type="button" onclick="deleteRow(this)"><i class="fadeIn animated bx bx-x"></i></button>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var familiesSelect = document.getElementById('families_select');
        var productsSelect = document.getElementById('products_select');
        var productOptions = document.getElementsByClassName('product-option');

        familiesSelect.addEventListener('change', function () {
            var selectedFamilleId = familiesSelect.value;

            for (var i = 0; i < productOptions.length; i++) {
                var option = productOptions[i];
                var familleId = option.getAttribute('data-famille-exp-id');

                // Afficher ou masquer l'option en fonction de la famille sélectionnée
                option.style.display = (selectedFamilleId === '' || selectedFamilleId === familleId) ? 'block' : 'none';
            }
        });
    });

</script>
