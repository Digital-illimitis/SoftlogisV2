<div class="modal fade" id="CreateOdreTransite" tabindex="-1" aria-hidden="true" style="min-width: 950px">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase size_16">Creer l'ordre de transit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body size_13 px-4 mt-4">
                <form action="{{ route('admin.od_transite.store') }}" method="POST" enctype="multipart/form-data" class="submitForm row">
                    @csrf
                    @if ($sourcing)
                    <input type="text" class="form-control" id="sourcing_uuid" hidden value="{{ $sourcing->uuid }}" name="sourcing_uuid" autocomplete="off">
                    @endif
                    <input type="hidden" name="typeOp" value="import">
                    <div class="col-12">
                        <label for="transitaire_uuid" class="form-label text-uppercase">Transitaire</label>
                        <select name="transitaire_uuid" class="form-control" id="transitaire_uuid" required>
                            <option disabled selected>Selectionnez un transitaire</option>
                            @foreach ($transitaires as $transitaire)
                                <option value="{{ $transitaire->uuid }}">{{ $transitaire->raison_sociale }}</option>
                            @endforeach
                        </select>
                        @error('transitaire_uuid')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row col-12 my-4">
                        <div class="col-6">
                            <label for="navireName" class="form-label border-0 text-uppercase size_14">Nom du Navire</label>
                            <input type="text" name="navireName" class="form-control size_13">
                        </div>
                        <div class="col-6 form-group">
                            <label for="totalProduct" class="form-label border-0 text-uppercase size_14">Nombre total de produits</label>
                            <input type="number" name="totalProduct" class="form-control size_13">
                        </div>
                        <div class="row my-3">
                            <div class="col form-group">
                                <label for="numConnaissement" class="form-label border-0 text-uppercase size_14">N°Connaissement</label>
                                <input type="text" name="numConnaissement" class="form-control size_13">
                            </div>
                            <div class="col form-group">
                                <label for="portDembarquement" class="form-label border-0 text-uppercase size_14">Port d'embarquement </label>
                                <input type="text" name="portDembarquement" class="form-control size_13">
                            </div>
                        </div>

                        <div class="my-3 mx-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <button id="add_doc" type="button"
                                    class=" add_new_box_product btn btn-outline-primary py-1 my-auto mb-3"><i
                                        class="bx bxs-plus-square size_14"></i>Ajouter une marchandise</button>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">Qty</label>
                                </div>
                                <div class="col-4">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">N°serie</label>
                                </div>
                                <div class="col-4">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">Nature de la marchandise</label>
                                </div>
                                <div class="col-2">
                                    <label for="product_ids" class="form-label border-0 text-uppercase text-start px-0 size_12">Poids(t)</label>
                                </div>
                                
                            </div>
                            <div class="add_new_product">
                                <div class="row add_new_prod gx-1 px-0 mb-3" id="0">
                                    <div class="col-2">
                                        <input type="number" min="1" name="qty[]" class="form-control px-0 text-center" placeholder="00">
                                    </div>
                                    <div class="col-4">
                                        <select class="form-select selectedProductUuid" data-placeholder="Choisir article" name="product_uuid[]">
                                            <option></option>
                                            @foreach ($sourcing->products as $item)
                                                <option value="{{ $item->product->uuid }}" data-uuid="{{ $item->product->uuid }}">{{ $item->product->numero_serie ?? '--' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control px-0 text-center nature" placeholder="niveleuse" disabled>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control px-0 text-center poids" placeholder="0" disabled>
                                    </div>
                                    <div class="col-1 ">
                                        <button type="button" class="btn btn-outline-danger border border-1 border-danger sup_new_box_doc" id=""><i class="bx bx-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <hr>
                        <center class="my-4"><h5 class="text-uppercase size_16">documents correspondant a l'arrivage ci dessus et joint au present ordre(1)</h5></center>
                        <div class="row col-12 my-3">
                            <div class="col form-group">
                                <label for="numConnaiOriginal" class="form-label border-0 text-uppercase size_13">N°Connaissement
                                     original </label>
                                <input type="text" name="numConnaiOriginal" class="form-control size_13" autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="garantieBancaire" class="form-label border-0 text-uppercase size_12">Lettre de garantie bancaire</label>
                                <input type="text" name="garantieBancaire" class="form-control size_12" autocomplete="off">
                            </div>
                            <div class="col form-group">
                                <label for="factFounisseur" class="form-label border-0 text-uppercase size_12">facture fournisseur d'un montant de</label>
                                <input type="text" name="factFounisseur" class="form-control size_13" autocomplete="off">
                            </div>
                        </div>
                        <div class="row col-12 my-3 d-flex justify-content-between">
                            
                            <div class="col">
                                <label for="factFret" class="form-label border-0 text-uppercase size_14">Facture fret et frais d'un montant de</label>
                                <input type="text" name="factFret" class="form-control size_13" autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="colisage" class="form-label border-0 text-uppercase size_14">colisage</label>
                                <input type="text" name="colisage" class="form-control size_13" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="assurCertifNum" class="form-label border-0 text-uppercase size_14">N°certificat d'assurance</label>
                            <input type="text" name="assurCertifNum" class="form-control size_13" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="frie" class="form-label border-0 text-uppercase size_14">Frie</label>
                            <input type="text" name="frie" class="form-control size_13" autocomplete="off">
                        </div>
                        <div class="col-6 my-3">
                            <label for="numLicense" class="form-label border-0 text-uppercase size_14">n°License</label>
                            <input type="text" name="numLicense" class="form-control size_13" autocomplete="off">
                        </div>
                        <div class="col-6 my-3">
                            <label for="sgsn" class="form-label border-0 text-uppercase size_14">SGSN</label>
                            <input type="text" name="sgsn" class="form-control size_13" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="marche" class="form-label border-0 text-uppercase size_14">Marché</label>
                            <input type="text" name="marche" class="form-control size_13" autocomplete="off">
                        </div>
                        
                        <div class="col-6 my-3">
                            <label for="exoneration" class="form-label border-0 text-uppercase size_14">Exonération</label>
                            <input type="text" name="exoneration" class="form-control size_13" autocomplete="off">
                        </div>
                        <div class="col-12 my-3">
                            <label for="divers" class="form-label border-0 text-uppercase size_14">divers</label>
                            <input type="text" name="divers" class="form-control size_13" autocomplete="off">
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label for="marchandiseAction" class="form-label border-0 text-uppercase size_14">Les Marchandises sont a</label>
                                <select name="marchandiseAction" id="" class="form-select">
                                    <option value="">Selectionnez une option</option>
                                    <option class="form-control" value="Mettre a la consommation">Mettre a la consommation</option>
                                    <option class="form-control" value="Mettre en entrepot fictif">Mettre en entrepot fictif</option>
                                    <option class="form-control" value="Mettre en entrepot fictif">Mettre en admission temporaire</option>
                                    <option class="form-control" value="Reexpedié a">Reexpedié à</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="expediteTo" class="form-label border-0 text-uppercase size_14">Expedié à</label>
                                <input type="text" name="expediteTo" class="form-control size_13" autocomplete="off">
                            </div>
                        </div>
                        
                        

                        <div class="col-12 my-4">
                            <label for="nulll" class="form-label border-0 text-uppercase size_14">Droit et taxe de douane a acquitter à: </label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="droitCredit" class="form-label border-0 text-capitalize">Par crédit Jalo logistics SAS ou notre crédit</label>
                                    <input type="text" name="droitCredit" class="form-control size_13" autocomplete="off">
                                </div>
                                <div class="col-6">
                                    <label for="exoneration" class="form-label border-0 text-capitalize">Exonération des droits et taxe au titre de </label>
                                    <input type="text" name="exoneration" class="form-control size_13" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 my-4">
                            <label for="note" class="form-label text-uppercase">Instructions particulières </label>
                            <textarea name="note" id="note" cols="30" rows="3" placeholder="Ajouter une note a l'ordre de transit" class="form-control"></textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="factAlibelle" class="form-label border-0 text-uppercase size_14">Facture a libeller a l'ordre de</label>
                            <input type="text" name="factAlibelle" class="form-control size_13" autocomplete="off">
                        </div>
                        <div class="col-12 mb-4">
                            <label for="factAlibelle" class="form-label border-0 text-uppercase size_14">Adresse de livraison (Commune, Adresse géographique, références Cadastrale)</label>
                            <input type="text" name="adresseLivraison" class="form-control size_13" autocomplete="off">
                        </div>

                        

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
