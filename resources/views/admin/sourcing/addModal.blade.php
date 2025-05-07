<div class="modal fade" id="CreateSourcing" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Démarrage de Sourcing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="stronger">
                <form action="{{ route('admin.sourcing.store') }}" method="POST" enctype="multipart/form-data"
                    class="submitForm">
                    @csrf
                    <div id="stepper1" class="bs-stepper">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between"
                                    role="tablist">
                                    <div class="step" data-target="#test-l-1">
                                        <div class="step-trigger" role="tab" id="stepper1trigger1"
                                            aria-controls="test-l-1">
                                            <div class="bs-stepper-circle">1</div>
                                            <div class="">
                                                <h5 class="mb-0 steper-title">Marchandise</h5>
                                                {{-- <p class="mb-0 steper-sub-title">Ajout des Produits a Importer</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-l-2">
                                        <div class="step-trigger" role="tab" id="stepper1trigger2"
                                            aria-controls="test-l-2">
                                            <div class="bs-stepper-circle">2</div>
                                            <div class="">
                                                <h5 class="mb-0 steper-title">Documentaires</h5>
                                                {{-- <p class="mb-0 steper-sub-title">Ajout des Documents Necessaires</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-l-3">
                                        <div class="step-trigger" role="tab" id="stepper1trigger3"
                                            aria-controls="test-l-3">
                                            <div class="bs-stepper-circle">3</div>
                                            <div class="">
                                                <h5 class="mb-0 steper-title">Detail</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="bs-stepper-content">
                                    <form onSubmit="return false">
                                        <div id="test-l-1" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger1">
                                            <h5 class="mb-1">Marchandise a Importer</h5>
                                            <p class="mb-4">Selectionné les marchandises a importer</p>
                                           
                                        
                                            
                                            <div class="my-3">
                                                <div class="card-header d-flex align-items-center justify-content-between">
                                                    <button type="button" class="btn btn-outline-primary py-1 my-auto mb-3 add_new_box_product">
                                                        <i class="bx bxs-plus-square"></i> Ajouter une ligne produit
                                                    </button>
                                                </div>
                                                <div class="product-line-container add_new_box_product">
                                                    <div class="mb-2 row product-line gx-2 add_new_doc">
                                                        <div class="col-md-5 form-group">
                                                            <label for="">Bon de commande</label>
                                                            <select name="product_uuid[]" id="" class="form-select select-product select2">
                                                                <option value="">Selectionné</option>
                                                                @foreach ($products as $item)
                                                                    <option value="{{ $item->uuid }}" class="form-control">{{ $item->numero_bon_commande }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <label for="">Numero de serie</label>
                                                            <select name="product_uuid[]" id="" class="form-select select-product">
                                                                <option value="">Selectionné</option>
                                                                @foreach ($products as $item)
                                                                    <option value="{{ $item->uuid }}" class="form-control">{{ $item->numero_serie }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        
                                                        <div class="col-md-2 form-group d-flex align-items-center justify-content-end">
                                                            <button type="button" class="btn sup_new_box_prod btn-danger py-1 my-auto ">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="my-3">
                                                <div class="card-header d-flex align-items-center justify-content-between">
                                                    <button type="button" class="btn btn-outline-primary py-1 my-auto mb-3 add_new_box_product">
                                                        <i class="bx bxs-plus-square"></i> Ajouter une ligne produit
                                                    </button>
                                                </div>
                                                <div class="product-line-container add_new_box_product">
                                                    <div class="mb-2 row product-line gx-2 add_new_doc">
                                                        <div class="col-md-5 form-group">
                                                            <label for="">Bon de commande</label>
                                                            <input type="text" id="bon-commande-search" class="form-control mb-2" placeholder="Filtrer bon de commande" />
                                                            <select name="product_uuid" id="bon-commande-select" class="form-select select-product">
                                                                <option value="">Selectionné</option>
                                                                @foreach ($products as $item)
                                                                    <option value="{{ $item->uuid }}">{{ $item->numero_bon_commande }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <label for="">Numero de serie</label>
                                                            <input type="text" id="numero-serie-search" class="form-control mb-2" placeholder="Filtrer numéro de série" />
                                                            <select name="product_uuid" id="numero-serie-select" class="form-select select-product">
                                                                <option value="">Selectionné</option>
                                                                @foreach ($products as $item)
                                                                    <option value="{{ $item->uuid }}">{{ $item->numero_serie }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 form-group d-flex align-items-center justify-content-end">
                                                            <button type="button" class="btn sup_new_box_prod btn-danger py-1 my-auto">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                <script>
                                                $(document).ready(function() {
                                                    // Événements de saisie pour les champs de recherche
                                                    $('#bon-commande-search').on('input', function() {
                                                        filterOptions('bon-commande-select', $(this).val(), 'numero_bon_commande');
                                                    });

                                                    $('#numero-serie-search').on('input', function() {
                                                        filterOptions('numero-serie-select', $(this).val(), 'numero_serie');
                                                    });

                                                    function filterOptions(selectId, searchValue, property) {
                                                        var searchText = searchValue.toLowerCase();
                                                        var $select = $('#' + selectId);

                                                        // Réinitialiser les options du sélecteur
                                                        $select.find('option').not(':first').remove(); // Supprimer toutes les options sauf la première

                                                        // Filtrer les options
                                                        @foreach ($products as $item)
                                                            if (searchText === '' || '{{ $item->numero_bon_commande }}'.toLowerCase().includes(searchText)) {
                                                                $select.append('<option value="{{ $item->uuid }}">{{ $item->numero_bon_commande }}</option>');
                                                            }
                                                        @endforeach

                                                        // Si aucune option n'est visible, afficher une option "Aucun résultat"
                                                        if ($select.find('option').length === 1) { // Seulement l'option "Sélectionné"
                                                            $select.append('<option disabled>Aucun résultat</option>');
                                                        }
                                                    }
                                                });
                                                </script>

                                                
                                            </div> --}}

                                            
                                            <div class="col-12">
                                                <div class="d-flex align-items-center gap-3">
                                                    <button class="btn btn-primary px-4"
                                                        onclick="event.preventDefault(); stepper1.next()">Suivant<i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="test-l-2" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger2">

                                            <h5 class="mb-1">Ajout des Documents</h5>
                                            <p class="mb-4">charger ici tous les documents necessaires. (PDF, Word,
                                                Excel)</p>
                                                <div class="mb-3 col-12" style="font-size: 13px">
                                                    <div>
                                                        <div class="my-3">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <button id="add_doc" type="button"
                                                                    class=" add_new_box_doc btn btn-outline-primary py-1 my-auto mb-3"><i
                                                                        class="bx bxs-plus-square"></i>Ajouter un
                                                                    document</button>
                                                            </div>
                                                            <div class="add_new_content">
                                                                <div class="row add_new_doc mb-3" id="0">
                                                                    <div class="col-3">
                                                                        <select name="doc_requis_uuid[]" class=" changeDocument form-select"
                                                                            id="" indexe="0">
                                                                            <option value="">Selectionner le document
                                                                            </option>
                                                                            @foreach ($documentRequises as $documentRequise)
                                                                                <option description="{{ $documentRequise->description }}" value="{{ $documentRequise->uuid }}">
                                                                                    {{ $documentRequise->libelle }}
                                                                                </option>
                                                                            @endforeach
                                                                            <option value="">Autre</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-4 ">
                                                                        <input type="text" id="p0" name="name[]"
                                                                            class="form-control docTitle"
                                                                            placeholder="Titre du fichier">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="file"
                                                                            accept=".pdf, .doc, .docx, .xls, .xlsx"
                                                                            class="form-control fileDoc" name="files[]" multiple>
                                                                    </div>
                                                                    <div class="col-1 ">
                                                                        <button type="button"
                                                                            class="btn btn-outline-danger border border-1 border-danger  sup_new_box_doc" id=""><i
                                                                                class="bx bx-trash"></i></button>
                                                                    </div>
                                                                </div>
    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <button class="btn btn-outline-secondary px-4"
                                                                onclick="event.preventDefault(); stepper1.previous()"><i
                                                                    class='bx bx-left-arrow-alt me-2'></i>Retour</button>
    
                                                            <button class="btn btn-primary px-4"
                                                                onclick="event.preventDefault(); stepper1.next()">Suivant<i
                                                                    class='bx bx-right-arrow-alt ms-2'></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>

                                        <div id="test-l-3" role="tabpanel" class="bs-stepper-pane"
                                            aria-labelledby="stepper1trigger3">
                                            <h5 class="mb-1">Information Complementaire</h5>
                                            <p class="mb-4">Information sur la compagnie & le navire</p>

                                            <div class="row g-3 mt-4">
                                                <div class="row ">
                                                    <div class="mb-3 col-6" style="font-size: 13px">
                                                        <label for="id_navire" class="form-label text-uppercase">Identifiant du navire <span><span class="text-danger">*</span></span></label>
                                                        <input type="text" class="form-control @error('id_navire') is-invalid @enderror" id="id_navire" name="id_navire" autocomplete="off">
                                                        @error('id_navire')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="inputCollection"
                                                            class="form-label">Packaging</label>
                                                        <select class="form-select" id="inputCollection"
                                                            name="packaging" autocomplete="off">
                                                            <option></option>
                                                            <option value="roro">Roro</option>
                                                            <option value="container">Container</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" row text-uppercase" style="font-size: 13px">
                                                    <div class="col-6">
                                                        <label for="date_depart" class="form-label">Date de départ</label>
                                                        <input type="date" class="form-control date-error @error('date_depart') is-invalid @enderror" id="date_depart" name="date_depart" autocomplete="off" >
                                                        @error('date_depart')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="date_arriver" class="form-label">Date estimative d'arrivée</label>
                                                        <input type="date" class="form-control date-error @error('date_arriver') is-invalid @enderror" id="date_arriver" name="date_arriver" autocomplete="off">
                                                        @error('date_arriver')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="my-3 col-4" style="font-size: 13px">
                                                    <label for="num_bl" class="form-label text-uppercase"> N° BL 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control @error('num_bl') is-invalid @enderror" id="num_bl" name="num_bl" autocomplete="off" required>
                                                    @error('num_bl')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="my-3 col-4" style="font-size: 13px">
                                                    <label for="numDossier" class="form-label text-uppercase"> N° Dossier 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control @error('numDossier') is-invalid @enderror" id="numDossier" name="numDossier" autocomplete="off" required>
                                                    @error('numDossier')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="my-3 col-4" style="font-size: 13px">
                                                    <label for="regime_uuid" class="form-label text-uppercase"> Regime
                                                    </label>
                                                    <select name="regime_uuid" id="regime_uuid" class="form-select">
                                                        <option value="" class="form-control">Selectionné un Regime ...</option>
                                                        @foreach ($regimes as $item)
                                                            <option class="form-control" value="{{ $item->uuid }}">
                                                                {{ $item->regime }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <hr class="mb-4 mt-2">

                                            <div class="">
                                                <div class="mb-3 col-12" style="font-size: 13px">
                                                    <label for="info_navire" class="form-label text-uppercase">Description du navire</label>
                                                    <textarea class="form-control" id="info_navire" name="info_navire" autocomplete="off"></textarea>
                                                </div>
                                            </div>
                                            <hr class="mb-4">
                                            <div class="">
                                                <div class="mb-3 col-12" style="font-size: 13px">
                                                    <label for="note" class="form-label text-uppercase">Note</label>
                                                    <textarea class="form-control" id="note" name="note" autocomplete="off"></textarea>
                                                </div>
                                            </div>

                                                <div class="col-12">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="btn btn-outline-secondary px-4"
                                                                onclick="event.preventDefault(); stepper1.previous()"><i
                                                                    class='bx bx-left-arrow-alt me-2'></i>Retour</button>
                                                        <button class="btn btn-primary px-4" type="submit">Enregistrer<i
                                                                class='bx bx-right-arrow-alt ms-2'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!---end row-->

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        // Sélection du bouton "Ajouter une ligne produit"
        const addNewBoxProductButton = document.querySelector('.add_new_box_product');

        // Sélection du conteneur des lignes de produit
        const productLineContainer = document.querySelector('.product-line-container');

            // Fonction pour cloner une ligne de produit
        function cloneProductLine() {
                // Clonage de la première ligne de produit
                const newProductLine = productLineContainer.querySelector('.product-line').cloneNode(true);
                
                // Ajout de la nouvelle ligne de produit clonée au conteneur
                productLineContainer.appendChild(newProductLine);
                
                // Ajout d'un écouteur d'événement pour le bouton de suppression de la nouvelle ligne
                const deleteButton = newProductLine.querySelector('.sup_new_box_prod');
                deleteButton.addEventListener('click', function() {
                    newProductLine.remove();
                });

            // Sélection des éléments de sélection dans la nouvelle ligne
            const selectElements = newProductLine.querySelectorAll('.select-product');

            // Écouteur pour le changement de sélection des éléments
            selectElements.forEach((select) => {
                select.addEventListener('change', function() {
                    if (this.value) {
                        selectElements.forEach((otherSelect) => {
                            if (otherSelect !== this) {
                                otherSelect.selectedIndex = 0; // Réinitialiser le champ autre
                            }
                        });
                    }
                });
            });
        }

        // Ajout de l'écouteur d'événement pour le bouton "Ajouter une ligne produit"
        addNewBoxProductButton.addEventListener('click', function() {
            cloneProductLine();
        });


   


    </script>
</div>