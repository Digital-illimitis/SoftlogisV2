

@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div href="{{ route('admin.facturation') }}" class="breadcrumb-title pe-3">Facturation</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Modification</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <div id="stepper1" class="bs-stepper">
        <div class="card">

            <div class="card-body">

                <div class="bs-stent">
                    <form class="submitForm" action="{{ route('admin.facturation.update', $facture->uuid) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>

                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="numFacture" class="form-label">Numero de Facture <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $facture->numFacture ?? 'N/A' }}" id="numFacture" name="numFacture" required>
                                    @error('records.*.numFacture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="date_echeance" class="form-label">Date Limite de paiement</label>
                                    <input type="date" value="{{ $facture->date_echeance ?? 'N/A' }}" class="form-control" id="date_echeance" name="date_echeance">
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <label for="num_bl" class="form-label">N° BL</label>
                                    <input type="text" value="{{ $facture->num_bl ?? 'N/A' }}" class="form-control" id="num_bl" name="num_bl">
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <label for="file_Bl" class="form-label">Document BL</label>
                                    <input type="file" value="{{ $facture->file_bl ?? 'N/A' }}" class="form-control" id="file_Bl" name="file_bl">
                                </div>

                              
                            </div>
                            <!---end row-->

                            <div class="row g-3 mt-3">

                                <div class="form-group mt-4 col-12">
                                    <button class="btn btn-sm btn-primary my-2" type="button" onclick="cloneBlockEdit()" style="width: 200px">Ajouter une ligne</button>
                                    <div class="col-12 my-2 row text-start size_12 d-flex justify-content-around bold">
                                        <div class="col-4">RUBRIQUE</div>
                                        <div class="col-3">PRIX UNITAIRE (Fcfa)</div>
                                        <div class="col-2">Qty</div>
                                        <div class="col-3">TOTAL LIGNE (Fcfa)</div>
                                    </div>
                                    <hr>
                                </div>

                                <div >
                                    @foreach($facture->prestationLines as $key => $lignes)
                                    @if ($lignes->etat === "actif")
                                        <div class="row mb-4 d-flex justify-content-between align-items-center align-self-center py-auto">
                                            <div class="col-4">
                                                <input class="form-control form-control-sm rubrique" placeholder="{{   Str::limit($lignes->rubrique, 25, '...') }}" type="text" disabled>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" class="form-control form-control-sm" id="prixUnitaire" placeholder="{{ $lignes->prixUnitaire }}" disabled>
                                            </div>
                                            <div class="col-2">
                                                <input type="number" class="form-control form-control-sm" id="qty" placeholder="{{ $lignes->qty }}" disabled>
                                            </div>
                                            <div class="col-2">
                                                <input type="number" class="form-control form-control-sm muted" id="totalLigne" placeholder="{{ $lignes->totalLigne }}" disabled>
                                            </div>
                                            <div class="col-1">
                                                {{-- <button class="btn btn-sm btn-danger delete-btn" type="button">
                                                    <i class='bx bx-trash'></i>
                                                </button> --}}
                                                 <form action="{{ route('admin.destroyPrestationLines', $lignes->uuid) }}" method="post" class="submitForm">
                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-danger delete-btn"><i class='bx bx-trash'></i> </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                        
                                    @endforeach


                                <div id="container" class="mb-3">
                                    <div class="row mt-2 d-flex justify-content-between align-items-center align-self-center py-auto">
                                        <div class="col-4">
                                            <input class="form-control form-control-sm rubrique" placeholder="rubrique" name="rubrique[]">
                                        </div>
                                        <div class="col-3">
                                            <input type="number" class="form-control form-control-sm" id="prixUnitaire" name="prixUnitaire[]" placeholder="0">
                                        </div>
                                        <div class="col-2">
                                            <input type="number" class="form-control form-control-sm" id="qty" name="qty[]" placeholder="0">
                                        </div>
                                        <div class="col-2">
                                            <input type="number" class="form-control form-control-sm muted" id="totalLigne" name="totalLigne[]" readonly placeholder="" value="">
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-sm btn-danger delete-btn" type="button">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row g-3 mt-3">

                                <button class="btn btn-sm btn-primary mt-2" type="button" onclick="cloneBlockDoc()" style ="width: 200px">Ajouter une ligne</button>
                                <label for="InputCountry" class="form-label">Facture Original</label>
                             
                               <div class="container mb-3 mt-1" id="contentBlockDoc">
                                   <div class="docBlock row d-flex justify-content-between align-items-center align-self-center">
                                       <div class="col-11 col-lg-11">
                                           <input type="file" class="form-control" id="facture_original" name="facture_original[]">
                                       </div>
                                       <div class="col-1 mx-0 mt-2">
                                           <button class="btn btn-sm btn-danger delete-btn-doc" type="button">
                                               <i class='bx bx-trash'></i>
                                           </button>
                                       </div>
                                   </div>
                               </div>

                               <div class="mb-3">

                                   <div class="col-sm-12 col-lg-12">
                                       <textarea class="form-control" id="input47" name="note" rows="3">{{ $facture->note }}</textarea>
                                   </div>
                               </div>
                               <div class="col-12">
                                   <div class="d-flex align-items-center gap-3">
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
</div>
<script>
    function cloneBlockEdit() {
    let blockToClone = document.querySelector('.row.mt-2');
    let clonedBlock = blockToClone.cloneNode(true);

    // Vider les valeurs des inputs clonés
    let inputs = clonedBlock.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = '';
    });

    document.addEventListener('input', event => {
        if (event.target && (event.target.name === 'prixUnitaire[]' || event.target.name === 'qty[]')) {
            const prestation = event.target.closest('.row.mt-2');
            const prixUnitaire = prestation.querySelector('[name="prixUnitaire[]"]').value;
            const qty = prestation.querySelector('[name="qty[]"]').value;
            const total = prestation.querySelector('[name="totalLigne[]"]');
            total.value = (prixUnitaire * qty);
        }
    });


    let deleteButton = clonedBlock.querySelector('.delete-btn');
    deleteButton.addEventListener('click', function () {
        clonedBlock.remove();
    });

    let container = document.getElementById('container');
    container.appendChild(clonedBlock);


}
</script>
@endsection

