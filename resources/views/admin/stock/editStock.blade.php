<div class="modal fade" id="editStock" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mise a jour du stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center d-none">

                    <div class="ms-auto d-flex align-items-center">
                        <div class="me-3"><a href="javascript:;" class="btn btn-sm btn-outline-success text-light-success text-uppercase px-3" id="buttonIn">In</a>

                        </div>
                        <div class="ms-auto"><a href="javascript:;" class="btn btn-sm btn-outline-danger text-light-danger text-uppercase" id="buttonOut">Out</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover table-sm mb-0 px-0 w-100">
                        <thead class="table-light w-100 px-0 mx-0">
                            <tr class="row col-12 w-100 px-0 mx-0">
                                <th class="col-2">N° Serie <i class='bx bx-up-arrow-alt'></i></th>
                                <th class="col-4">Famille</th>
                                <th class="col-2">Entrepot actuel</th>
                                <th class="col-3">Entrepot cible</th>
                                <th class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody id="blockIn" class="w-100 mx-0 px-0">
                            @forelse ($products as $product)
                            <tr class="my-auto row col-12 w-100 px-0 mx-0">
                                <td class="col-2">
                                   {{ $product->numero_serie }}
                                </td>
                                <td class="col-4">
                                    <div class="font-weight-bold">{{ $product->familly->libelle }}</div>
                                </td>

                                <td class="col-2">
                                    @if ($product->entrepot)
                                    <div class="font-weight-bold">{{ $product->entrepot->nom }}</div>
                                    @endif
                                </td>
                                <form action="{{ route('admin.stock.add.store') }}" method="post" class="submitForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <td class="col-3">
                                        <select name="entrepot_uuid" class="form-select" id="entrepot_uuid">
                                            <option value="" selected disabled>Choisir entrepot</option>
                                            @foreach ($entrepots as $entrepot)
                                            <option value="{{ $entrepot->uuid }}">{{ $entrepot->nom }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="col-1">
                                        <button type="submit" class="btn btn-outline-success"><i class="fadeIn animated bx bx-check fs-2"></i></button>
                                    </td>
                                </form>
                            </tr>
                            @empty

                            @endforelse

                        </tbody>
                        <tbody id="blockOut" class="w-100 mx-0 px-0">
                            @forelse ($products as $product)
                            <tr class="my-auto row col-12 w-100 px-0 mx-0">
                                <td class="col-3">
                                   {{ $product->numero_serie }}
                                </td>
                                <td class="col-5">
                                    <div class="font-weight-bold">{{ $product->familly->libelle }}</div>
                                </td>
                                <form action="{{ route('admin.stock.remove') }}" method="post" class="submitForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <td class="col-3">
                                        <select name="entrepot_uuid" class="form-select" id="entrepot_uuid">
                                            <option value="" selected disabled>Choisir entrepot</option>
                                            @foreach ($entrepots as $entrepot)
                                            <option value="{{ $entrepot->uuid }}">{{ $entrepot->nom }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="col-1">
                                        <button type="submit" class="btn btn-outline-danger"><i class="fadeIn animated bx bx-check fs-2"></i></button>
                                    </td>
                                </form>
                            </tr>
                            @empty

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