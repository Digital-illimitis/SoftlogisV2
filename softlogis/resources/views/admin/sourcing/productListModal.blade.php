<div class="modal fade" id="productListModal{{ $sourcing->uuid }}" tabindex="-1"
    aria-labelledby="productListModalLabel{{ $sourcing->uuid }}" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productListModalLabel{{ $sourcing->id }}">Modifier la Liste des Produits du
                    Sourcing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                @if ($sourcing->products->count() > 0)
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
                            @foreach ($sourcing->products as $index => $item)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $item->product->familly->libelle ?? '' }}</td>
                                <td>{{ $item->product->numero_serie }}</td>
                                <td>{{ $item->product->numero_bon_commande }}</td>
                                <td>
                                    <form action="{{ route('admin.sourcing.deletteproduct', $item->product->id) }}"
                                        method="post" class="submitForm delete-product-form" id="deleteForm">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        <input type="hidden" name="sourcing_id" value="{{ $sourcing->id }}">
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
                    <form action="{{ route('admin.sourcing.editProduct', $sourcing->uuid) }}" method="post" class="submitForm">
                        @csrf
                        <input type="hidden" class="form-control" value="{{ $sourcing->uuid }}" name="sourcing_uuid">

                        <div class="my-3">
                            <strong class="text-uppercase text-primary my-auto"></strong>
                            <div class=" card-headerd-flex align-items-center justify-content-between">
                                <button id="doc_t" type="button" class="btn btn-outline-secondary py-1 my-auto mb-3"
                                    onclick="addnewBlockProduct()"><i class="bx bxs-plus-square"></i>Ajouter une ligne
                                    produit</button>
                            </div>
                            <div class="mb-2 card-body" id="productBlock">
                                <!-- Dom js pour l'ajout de nouveaux documents de transite-->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
