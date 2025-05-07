<div class="modal fade" id="addFactureProformaS" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase size_16">Enregistrement d'une nouvelle facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="bs-steper-cotent p-3">
                <form action="{{ route('admin.facture_proforma.store') }}" method="post" class="submitForm">
                    @csrf

                    <div id="" class="bs-ser-pane"
                        aria-labelledby="stepper2trigger1">
                        <h5 class="mb-3">Facture Proforma</h5>

                        <div class="row g-3">

                            <div class="col-12 col-lg-6">
                                <label for="transporteur_uuid" class="form-label">Transporteur</label>
                                <select class="form-select" id="transporteur_uuid" name="transporteur_uuid"
                                    aria-label="Default select transporteur">
                                    <option selected>---</option>
                                    @foreach ($transports as $item)
                                        <option class="form-control" value="{{ $item->uuid }}">{{ $item->raison_sociale }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!--<div class="col-12 col-lg-6">
                                <label for="destination_uuid" class="form-label">Destination</label>
                                <select class="form-select" id="destination_uuid" name="destination_uuid" aria-label="Default select destination">
                                    <option value=""></option>
                                </select>
                            </div>-->

                            <div class="col-12 col-lg-6">
                                <label for="porteChar_uuid" class="form-label">Destination</label>
                                <select class="form-select" id="destination_uuid" name="destination_uuid"
                                    aria-label="Default select porteChar">
                                    <option selected>---</option>
                                    @foreach ($destinations as $destination)
                                        <option class="form-control" value="{{ $destination->uuid }}">{{   $destination->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-12 col-lg-6">
                                <label for="porteChar_uuid" class="form-label">PorteChar</label>
                                <select class="form-select" id="porteChar_uuid" name="porteChar_uuid"
                                    aria-label="Default select porteChar">
                                    <option selected>---</option>
                                    @foreach ($porteChars as $item)
                                        <option class="form-control" value="{{ $item->uuid }}">{{   $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="cout_prestation" class="form-label">Montant</label>
                                <input type="text" class="form-control" id="montant" name="cout_prestation"
                                    placeholder="0.00">
                            </div>

                            <div class="col-12 col-lg-6">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer<i
                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                            </div>
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



