<div class="modal fade" id="EditSourcing{{ $sourcing->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Modification de Sourcing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body delete-product-form">
                <form action="{{ route('admin.sourcing.update', $sourcing->uuid) }}" method="POST" enctype="multipart/form-data" class="submitForm">
                    @csrf
                    <hr class="mb-4">
                    <!-- Date de départ et Date d'arrivée -->
                    <div class="content">
                        <div class=" row text-uppercase" style="font-size: 13px">
                            <div class="col-6">
                                <label for="date_depart" class="form-label">Date de départ</label>
                                <input type="date" class="form-control" id="date_depart" name="date_depart" autocomplete="off" value="{{ $sourcing->date_depart }}">
                            </div>
                            <div class="col-6">
                                <label for="date_arriver" class="form-label">Date estimative d'arrivée</label>
                                <input type="date" class="form-control" id="date_arriver" name="date_arriver" autocomplete="off" value="{{ $sourcing->date_arriver }}">
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4 my-2">

                    <div class="row" style="font-size: 13px">
                        <div class="col-6">
                            <label for="date_reel_arriver" class="form-label">Date Reel d'arrivée</label>
                            <input type="date" class="form-control" id="date_reel_arriver" name="date_reel_arriver" autocomplete="off" value="{{ $sourcing->date_reel_arriver }}">
                        </div>
                        <div class="col-6" style="font-size: 13px">
                            <label for="regime_uuid" class="form-label text-uppercase">Regime
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

                    <!-- Informations sur le Navire -->
                    <div class=" row my-3">

                        <div class="mb-3 col-6" style="font-size: 13px">
                            <label for="id_navire" class="form-label text-uppercase">Identifiant du navire</label>
                            <input type="text" class="form-control" id="id_navire" name="id_navire"  value="{{ $sourcing->id_navire }}">
                        </div>

                        <div class="col-6">
                            <label for="inputCollection" class="form-label">Packaging</label>
                            <select class="form-select" id="inputCollection" name="packaging" value="{{ $sourcing->packaging }}">
                                <option>{{ $sourcing->packaging ?? ''}}</option>
                                @if ($sourcing->packaging == 'container')
                                    <option value="roro">Roro</option>
                                @elseif ($sourcing->packaging == 'roro')
                                    <option value="container">Container</option>
                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="my-3 col-6" style="font-size: 13px">
                            <label for="num_bl" class="form-label text-uppercase"> N° BL 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('num_bl') is-invalid @enderror" id="num_bl" name="num_bl" autocomplete="off" value="{{ $sourcing->num_bl ?? '--' }}">
                            @error('num_bl')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="my-3 col-6" style="font-size: 13px">
                            <label for="numDossier" class="form-label text-uppercase"> N° Dossier 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('numDossier') is-invalid @enderror" id="numDossier" name="numDossier" autocomplete="off" value="{{ $sourcing->numDossier}}">
                            @error('numDossier')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="mb-3 row" style="font-size: 13px">
                        <label for="info_navire" class="form-label text-uppercase col-12">Description du navire</label>
                        <textarea class="form-control col-12" id="info_navire" name="info_navire" >{{ $sourcing->info_navire ?? '' }}</textarea>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

