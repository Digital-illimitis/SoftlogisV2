<div class="modal fade" id="CreateOdrelivraison" tabindex="-1" aria-hidden="true" style="min-width: 1000px !important">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase size_16">Creer l'ordre de Transport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body size_13" id="stronger">
                <form action="{{ route('admin.od_livraisons.store', $sourcing->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                    @csrf
                    <div class="row col-12">
                        <div class="col-12">
                            <label for="transporteur_uuid" class="form-label border-0 text-uppercase size_14">Transporteur</label>
                            <select name="transporteur_uuid" class="form-control size_13" id="transporteur_uuid">
                                <option class="text-muted" value="" disabled selected>Selectionnez un transporteur</option>
                                @foreach ($transporteurs as $transporteur)
                                    <option value="{{ $transporteur->uuid }}">{{ $transporteur->raison_sociale ?? '--'}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row col-12 my-3 d-flex justify-content-between">
                            <div class="col form-group">
                                <label for="trajetStart_uuid" class="form-label border-0 text-uppercase size_14">Point de Depart</label>
                                <select name="trajetStart_uuid" class="form-select size_13" id="">
                                    <option class="text-muted" value="" disabled selected>Selectionnez un point de depart</option>
                                    @foreach ($destinations as $item)
                                        <option class="form-control" value="{{ $item->uuid }}">{{ $item->libelle ?? '--' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col form-group">
                                <label for="trajetEnd_uuid" class="form-label border-0 text-uppercase size_14">Point d'arrivée </label>
                                <select name="trajetEnd_uuid" class="form-select size_13" id="">
                                    <option value="" disabled selected>Selectionnez un point d'arrivée</option>
                                    @foreach ($destinations as $item)
                                        <option class="form-control" value="{{ $item->uuid }}">{{ $item->libelle ?? '--' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row col-12 my-3 d-flex justify-content-between">
                            <div class="col form-group">
                                <label for="numOt" class="form-label border-0 text-uppercase size_14">N°OT</label>
                                <input type="text" name="numOt" class="form-control size_13" autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="numFolder" class="form-label border-0 text-uppercase size_14">N°Dossier</label>
                                <input type="text" name="numFolder" class="form-control size_13" autocomplete="off">
                            </div>
                            <div class="col form-group">
                                <label for="numBl" class="form-label border-0 text-uppercase size_14">N°BL</label>
                                <input type="text" value="{{ $sourcing->num_bl }}" name="numBl" class="form-control size_13" autocomplete="off" placeholder="{{ $sourcing->num_bl }}">
                            </div>
                        </div>
                        <div class="row col-12 my-3 d-flex justify-content-between">
                            
                            <div class="col">
                                <label for="refCotation" class="form-label border-0 text-uppercase size_14">Ref Cotation</label>
                                <input type="text" name="refCotation" class="form-control size_13" autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="date_livraison" class="form-label border-0 text-uppercase size_14">Date de livraison</label>
                                <input type="date" name="date_livraison" class="form-control size_13" autocomplete="off">
                            </div>
                        </div>

                        <div class="my-3 mx-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <button id="add_doc" type="button"
                                    class=" add_new_box_product btn btn-outline-primary py-1 my-auto mb-3"><i
                                        class="bx bxs-plus-square size_14"></i>Ajouter une marchandise</button>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <label for="qty" class="form-label border-0 text-uppercase text-start px-0 size_12">Qte</label>
                                </div>
                                <div class="col-3">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">N°serie</label>
                                </div>
                                <div class="col-3">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">Designation</label>
                                </div>
                                
                                <div class="col-1">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">Lon(m)</label>
                                </div>
                                <div class="col-1">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">Lar(m)</label>
                                </div>
                                <div class="col-1">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">H(m)</label>
                                </div>
                                <div class="col-1">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">Poids(t)</label>
                                </div>
                                
                            </div>
                            {{-- <div class="add_new_product">
                                <div class="row add_new_prod gx-1 px-0 mb-3" id="0">
                                    <div class="col-1">
                                        <input type="number" name="qty[]" class="form-control px-0 text-center" placeholder="0">
                                    </div>
                                    <div class="col-3">
                                        <select class="form-select" id="single-select-field" data-placeholder="Choisir article">
                                            <option></option>
                                            @foreach ($sourcing->products as $item)
                                                <option value="{{ $item->product->uuid }}">{{ $item->product->numero_serie ?? '--' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control px-0 text-center" placeholder="CAT PELLE HYDRAULIQUE" disabled>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control px-0 text-center" placeholder="1500" disabled>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control px-0 text-center" placeholder="1500" disabled>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control px-0 text-center" placeholder="1500" disabled>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control px-0 text-center" placeholder="1500" disabled>
                                    </div>
                                    <div class="col-1 ">
                                        <button type="button"
                                            class="btn btn-outline-danger border border-1 border-danger  sup_new_box_doc" id=""><i
                                                class="bx bx-trash"></i></button>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="add_new_product">
                                <div class="row add_new_prod gx-1 px-0 mb-3" id="0">
                                    <div class="col-1">
                                        <input type="number" name="qty[]" class="form-control px-0 text-center" placeholder="0">
                                    </div>
                                    <input type="hidden" name="ot_uuid[]" value="{{ $sourcing->uuid }}" class="form-control px-0 text-center">
                                    <div class="col-3">
                                        <select class="form-select selectedProductUuid" data-placeholder="Choisir article" name="product_uuid[]">
                                            <option></option>
                                            @foreach ($sourcing->products as $item)
                                                <option value="{{ $item->product->uuid }}" data-uuid="{{ $item->product->uuid }}">{{ $item->product->numero_serie ?? '--' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control px-0 text-center designation" placeholder="CAT PELLE" disabled>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control px-0 text-center longueur" placeholder="" disabled>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control px-0 text-center largeur" placeholder="1500" disabled>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control px-0 text-center hauteur" placeholder="1500" disabled>
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control px-0 text-center poids" placeholder="0" disabled>
                                    </div>
                                    <div class="col-1 ">
                                        <button type="button" class="btn btn-outline-danger border border-1 border-danger sup_new_box_doc" id=""><i class="bx bx-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-12 mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <button id="add_do" type="button" class="btn btn-outline-primary py-1 my-auto mb-3" onclick="addNewDocLivraison()"><i class="bx bxs-plus-square"></i>Ajouter un document</button>
                            </div>
                            <div class="mb-2" id="doc_livraison_container">
                                <!-- Dom js pour l'ajout de nouveaux documents -->
                            </div>
                        </div>

                        <div class="col-12 my-4">
                            {{-- <label for="note" class="form-label text-uppercase">Note</label> --}}
                            <textarea name="note" id="note" cols="30" rows="3" placeholder="Ajouter une note a l'ordre de livraison" class="form-control"></textarea>
                        </div>

                        <input type="hidden" name="sourcing_id" value="{{ $sourcing->uuid }}">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

