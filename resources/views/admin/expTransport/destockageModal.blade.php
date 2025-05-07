<div class="modal fade h-100" id="destockageModal" tabindex="-1" aria-hidden="true">
    <div class="page-content">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title size_16">Mettre a disposition les marchandise a expedié</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body page-content size_13" style="min-height: 300px">


                        <div class="row col-12">

                            <table class=" table table-striped table-hover table-responsive table table-bordered">
                                <thead class="" style="max-height: 20px">
                                    <tr>
                                        <th class="col-1">Image</th>
                                        <th class="col-3">Famille</th>
                                        <th class="col-2">Numero de serie</th>
                                        <th class="col-3">Conforme</th>
                                        <th class="col-2">Fiche de sortie</th>
                                        <th class="col-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expedition->products as $product)
                                    {{-- @if (!empty($product)) --}}
                                        @if ($product->product->status == 'stocked')
                                            <form action="{{ route('admin.export.destockage') }}" method="POST" enctype="multipart/form-data" class=" submitForm row">
                                                @csrf
                                                <tr>
                                                    <td class="col-1">
                                                        <img src="{{ asset('files/' . $product->product->image) }}" alt="Product img"  class="img-fluid" style="max-width: 60px; max-height: 50px">
                                                    </td>
                                                    <td class="col-3">{{ $product->product->familly->libelle ?? ''}}</td>
                                                    <td class="col-2">{{ $product->product->numero_serie ?? ''}}</td>
                                                    @if ($product->product->is_destock === 'false')

                                                        <input type="hidden" name="product_id" value="{{ $product->product->id }}">
                                                        <input type="hidden" name="expedition_uuid" value="{{ $expedition->uuid }}">
                                                        <td class="col-3">
                                                            <div class="row">
                                                                <input type="radio" name="conformityOut" value="on" class="btn-check" id="conforme{{$loop->index}}" autocomplete="off">
                                                                <label class="btn btn-outline-success col" for="conforme{{$loop->index}}">Oui</label>

                                                                <input type="radio" name="conformityOut" value="off" class="btn-check" id="non-conforme{{$loop->index}}" autocomplete="off">
                                                                <label class="btn btn-outline-danger col" for="non-conforme{{$loop->index}}">Non</label>
                                                            </div>
                                                        </td>
                                                        <td class="col-2">
                                                            <input type="file" class="form-control" name="file">
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-sm btn-primary">Destockage</button>
                                                            <td class="col-1">
                                                        </td>
                                                    @else
                                                        <td class="col-3 text-info text-center align-self-center align-middle">Produit destocké </td>
                                                    @endif

                                                    {{-- @include('admin.expTransport.outConform') --}}
                                                </tr>
                                            </form>
                                        @endif
                                    {{-- @endif --}}
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>


                </div>

            </div>
        </div>
    </div>
</div>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('input[name^="conformityOut"]');

        radioButtons.forEach(function (radio) {
            radio.addEventListener('change', function () {

                const index = this.id.match(/\d+/)[0];


                document.querySelectorAll('.btn-check[id^="conforme' + index + '"], .btn-check[id^="non-conforme' + index + '"]').forEach(function (label) {
                    label.classList.remove('active');
                });

                const selectedLabel = document.querySelector('label[for="' + this.id + '"]');
                selectedLabel.classList.add('active');
            });
        });
    });
</script>

