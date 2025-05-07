<div class="col">
    <!-- Modal -->
    <div class="modal fade " id="addnewproduct" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="margin-top:0; margin-right: 0">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter nouveaux produits</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="form-body mt-4">
                                <form method="post" action="{{ route('admin.article.store') }}" class="submitForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="border border-3 p-4 rounded">

                                                <div class="col-sm-12 col-md-12 mb-3">
                                                    <label for="famille_uuid" class="form-label">Designation de l' article</label>
                                                    <select name="famille_uuid" class="form-select"
                                                        id="famille_uuid" autocomplete="off">
                                                        @foreach ($articleFamilys as $articleFamily)
                                                        <option value="{{ $articleFamily->uuid }}">
                                                            {{ $articleFamily->libelle }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                                    <label for="model_uuid" class="form-label">Model d'article</label>
                                                    <select name="model_uuid" class="form-select"
                                                        id="model_uuid" autocomplete="off">
                                                        @foreach ($articleModels as $articleModel)
                                                        <option value="{{ $articleModel->uuid }}">
                                                            {{ $articleModel->libelle }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <div class="row col-12 d-flex wrap mx-auto">
                                                    <div class="col-sm-12 col-md-12 col-lg-6 mb-3">
                                                        <label for="model_uuid" class="form-label">Model d'article</label>
                                                        <input type="text" class="form-control" id="model_Materiel" name="model_Materiel" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6 mb-3">
                                                        <label for="num_billOfLading" class="form-label">N° Bill Of Lading</label>
                                                        <input type="text" class="form-control" id="num_billOfLading" name="num_billOfLading" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="row col-12 d-flex wrap mx-auto px-0">

                                                    <div class="col-xm-12 col-sm-12 col-md-6 col-lg-6">
                                                        <label id="numero_serie" class="form-label">N° de serie</label>
                                                        <input class="form-control" type="text" name="numero_serie"
                                                            id="numero_serie" placeholder="00XX0000" autocomplete="off" />
                                                    </div>

                                                    <div class="mb-3 col-sm-12 col-md-6 col-lg-6">
                                                        <label for="inputProductTitle" class="form-label">N° Matériel</label>
                                                        <input type="text" class="form-control" id="inputProductTitle"
                                                            placeholder="N° Matériel" name="numero_bon_commande"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="row col-12 d-flex wrap mx-auto px-0 mt-2">

                                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                                        <label for="familyGroup" class="form-label">Family Group</label>
                                                        <select class="form-select" name="familyGroup" id="familyGroup">
                                                            <option value="">Choisir...</option>
                                                            @foreach ($famillyGroups as $item)
                                                                <option value="{{$item->uuid}}" class="form-option">{{ $item->libelle ?? ''}}</option>
                                                            @endforeach
                                                            {{-- <option value="JALO">JALO</option>
                                                            <option value="NEEMBA CI">NEEMBA CI</option>
                                                            <option value="NEEMBA INTERNATIONAL">NEEMBA INTERNATIONAL</option> --}}
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <label for="source_uuid" class="form-label">Ship
                                                            Source</label>
                                                        <select name="source_uuid" class="form-select"
                                                            id="source_uuid" autocomplete="off">
                                                            @foreach ($sources as $source)
                                                            <option value="{{ $source->uuid }}">
                                                                {{ $source->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row my-4">
                                                    <div class="col-6">
                                                        <label for="inputProductMarque"
                                                            class="form-label">Marque</label>
                                                        <select class="form-select" id="inputProductMarque"
                                                            name="marque_uuid" autocomplete="off">
                                                            @foreach ($marques as $marque)
                                                            <option value="{{ $marque->uuid }}">
                                                                {{ $marque->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="inputCategory"
                                                            class="form-label">Categorie</label>
                                                        <select class="form-select" id="inputCategory"
                                                            name="categorie_uuid" autocomplete="off">
                                                            @foreach ($categories as $categorie)
                                                            <option value="{{ $categorie->uuid }}">
                                                                {{ $categorie->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="product_description"
                                                        class="form-label">Description</label>
                                                    <textarea class="form-control" rows="3" name="description"
                                                        autocomplete="off" id="product_description"></textarea>
                                                </div>

                                                <div class="file-upload">
                                                    <button class="file-upload-btn" type="button"
                                                        onclick="$('.file-upload-input').trigger( 'click' )">Ajouter
                                                        Image du produit</button>

                                                    <div class="image-upload-wrap">
                                                        <input class="file-upload-input" type='file'
                                                            onchange="readURL(this);" accept="image/*"
                                                            name="image" />
                                                        <div class="drag-text">
                                                            <h4>Faites glisser et déposez un fichier ou sélectionnez
                                                                Ajouter une image</h4>
                                                        </div>
                                                    </div>
                                                    <div class="file-upload-content">
                                                        <img class="file-upload-image" src="#" alt="your image" />
                                                        <div class="image-title-wrap">
                                                            <button type="button" onclick="removeUpload()"
                                                                class="remove-image">Remove <span
                                                                    class="image-title">Uploaded
                                                                    Image</span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="border border-3 p-4 rounded">
                                                <div class="row g-3 col-12">
                                                   Les points(.) representent les virgules(,)
                                                    <div class="col-xm-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                        <label id="hauteur" class="form-label">Hauteur(m)</label>
                                                        <input class="form-control" type="decimal" name="hauteur"
                                                            id="hauteur" placeholder="00.00" autocomplete="off" />
                                                    </div>
                                                    <div class="col-xm-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                        <label id="poid_tonne"
                                                            class="form-label">Poids/Tonnes</label>
                                                        <input class="form-control" type="decimal" name="poid_tonne"
                                                            id="poid_tonne" placeholder="00.00"
                                                            autocomplete="off" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                        <label id="volume" class="form-label">Volume(m3)</label>
                                                        <input class="form-control" type="decimal" name="volume"
                                                            id="volume" placeholder="00.00" autocomplete="off" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                        <label for="longueur" class="form-label">Longueur(m)</label>
                                                        <input type="decimal" class="form-control" id="longueur"
                                                            placeholder="00.00" name="longueur" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="largeur" class="form-label">Largeur</label>
                                                        <input type="decimal" class="form-control" id="largeur"
                                                            placeholder="00.00" name="largeur" autocomplete="off">
                                                    </div>
                                                    
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="packaging" class="form-label">Packaging</label>
                                                        <select name="packaging" id="packaging" class="form-control">
                                                            <option value="Roro">Roro</option>
                                                            <option value="Container">Container</option>
                                                        </select>                                                            
                                                    </div>
                                                    <div class="col-sm-12 col-md-12" id="typeContainerField">
                                                        <label for="type_container" class="form-label">Type Container</label>
                                                        <select name="type_container" class="form-control">
                                                            <option value="20">20</option>
                                                            <option value="40">40</option>
                                                        </select>
                                                    </div>  
                                                    
                                                    @php
                                                        $euro = App\Models\Device::first()->valeur ?? 0;
                                                        $dolar = App\Models\Dollars::first()->value ?? 0;
                                                        
                                                    @endphp

                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="price_unitaire" class="form-label">Prix (FCFA)</label>
                                                        <input type="number" class="form-control" id="price_unitaire"
                                                            placeholder="00.00" name="price_unitaire" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="price_dollars" class="form-label">Prix (Dollars)</label>
                                                        <input type="text" class="form-control" id="price_dollars"
                                                            placeholder="00.00" name="price_dollars" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="price_euro" class="form-label">Prix (Euro)</label>
                                                        <input type="text" class="form-control" id="price_euro"
                                                            placeholder="00.00" name="price_euro" autocomplete="off">
                                                    </div>

                                                    <input type="hidden" name="status" id="status" value="enFabrication">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button type="submit"
                                                                class="btn btn-primary">Sauvegarder</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <script>
                const priceInput = document.getElementById('price_unitaire');
                priceInput.addEventListener('input', updatePriceInEuroAndDollars);  
                function updatePriceInEuroAndDollars() {
                const priceCfa = parseFloat(priceInput.value);
                const priceEuro = priceCfa / @php echo $euro; @endphp;
                const priceDollars = priceCfa / @php echo $dolar; @endphp;

                document.getElementById('price_euro').value = priceEuro.toFixed(2);
                document.getElementById('price_dollars').value = priceDollars.toFixed(2);
                }
            </script>
        </div>
    </div>
</div>