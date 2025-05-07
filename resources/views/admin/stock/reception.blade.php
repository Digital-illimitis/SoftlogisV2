{{-- <div class="modal fade" id="addReception" tabindex="-1" aria-hidden="true" style="min-width: 920px !important">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Entré en Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="stronger" style="min-height: 300px">

                <div class="row col-12">
                    <table class="table table-bordered">
                        <thead class="" style="max-height: 20px">
                            <tr>
                                <th class="col-4">Famille</th>
                                <th class="col-2">N° serie</th>

                                <th class="col-2">Entrepot</th>
                                <th class="col-3"></th>
                                <th class="col-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sourcing->products as $product)
                                @if ($product->product->status == 'arriverAuPod')
                                <form action="{{ route('admin.stock_reception.store') }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                                    @csrf
                                    <tr>
                                        <input type="hidden" name="sourcing_uuid" value="{{ $sourcing->uuid }}">
                                        <td class="col-4">{{ $product->product->familly->libelle }}</td>
                                        <td class="col-2">{{ $product->product->numero_serie }}</td>
                                        <input type="hidden" name="product_id" value="{{ $product->product->id }}">
                                        <td class="col-3">
                                            <select name="entrepot_uuid" class="form-select" id="entrepot_uuid">
                                                <option value="" selected disabled>Choisir entrepot</option>
                                                @foreach ($entrepots as $entrepot)
                                                <option value="{{ $entrepot->uuid }}">{{ $entrepot->nom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="col-3">
                                            <input type="file" class="form-control" name="file">
                                        </td>
                                        <td class="col-3">
                                            <button type="button" id="conformityBtn" class="btn btn-primary">Receptionné</button>
                                        </td>
                                    </tr>
                                    @include('admin.expTransport.conformity')
                                </form>
                                @else
                                <center>
                                    <p><h4 class="pb-3 text-danger">Aucune marchandise à réceptionner</h4>
                                        <small>
                                            - Vérifiez que la marchandise attendue est bien arrivée au port de débarquement.<br>
                                            - Vérifiez que vous avez mis à jour le statut de la marchandise attendue.<br>
                                            - Seules les machines arrivées au port de débarquement peuvent être réceptionnées.
                                        </small>

                                    </p>
                                </center>
                                @endif
                            @empty
                            <div>Tous les prodiuits on été receptionné</div>
                            @endforelse()

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>

            </div>
        </div>
    </div>
</div> --}}

<!-- Ajoutez cette section à votre code existant -->
{{-- <script>
    document.getElementById('conformityBtn').addEventListener('click', function () {
        var cardElement = document.querySelector('.card-data');
        cardElement.classList.remove('d-none');
    });
    document.getElementById('closeBtnConformity').addEventListener('click', function () {
        var cardElement = document.querySelector('.card-data');
        cardElement.classList.add('d-none');
    });
</script> --}}


<div class="modal fade" id="addReception" tabindex="-1" aria-hidden="true" style="width: 100% !important">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Reception de Marchandise</h5>
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
                                    <th>Date de reception</th>
                                    <th >Conforme</th>
                                    <th ></th>
                                    <th >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sourcing->products as $product)
                                    <form action="{{ route('admin.stock_reception.store') }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                                        @csrf
                                        <tr>
                                            <input type="hidden" name="sourcing_uuid" value="{{ $sourcing->uuid }}">
                                            <td >{{ $product->product->familly->libelle ?? '' }}</td>
                                            <td >{{ $product->product->numero_serie ?? '' }}</td>
                                            <input type="hidden" name="product_uuid" value="{{ $product->product->uuid }}">
                                            @if ($product->product->status == 'arriverAuPod')

                                                <td>
                                                    <input type="date" class="form-control" name="date_reception" required>
                                                    @error('date_reception')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>

                                                <td class="row d-flex justify-content-between px-0">
                                                    <input type="radio" name="conformity" value="on" class="btn-check" id="conforme{{$loop->index}}" autocomplete="off">
                                                    <label class="btn btn-outline-success" for="conforme{{$loop->index}}">Oui</label>

                                                    <input type="radio" name="conformity" value="off" class="btn-check" id="non-conforme{{$loop->index}}" autocomplete="off">
                                                    <label class="btn btn-outline-danger" for="non-conforme{{$loop->index}}">Non</label>
                                                </td>
                                                <td style="max-width: 140px">
                                                    <input type="file" class="form-control" name="file">
                                                </td>
                                                <td class="text-center">
                                                    <button type="submit" class="btn btn-primary text-center">Receptionné</button>
                                                </td>
                                            @elseif (in_array($product->product->status, ['enFabrication', 'sortiUsine', 'enExpedition']))
                                                <td class="col-md-3 text-danger size_12">Produit pas encore au POD</td>
                                            @elseif ($product->product->status == 'stocked')
                                                <td class="col-md-3">{{ $product->product->entrepot->nom ?? '' }}</td>
                                                <td class="col-md-3 text-success">Produit receptionné</td>
                                            @endif
                                        </tr>
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="6">Tous les produits ont été receptionnés</td>
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