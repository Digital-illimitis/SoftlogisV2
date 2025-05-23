<div class="modal fade"  id="editFacture{{ $item->uuid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modification de la facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bs-stepper">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <h5 class="mb-0 steper-title">Prestation</h5>
                                <p class="mb-0 steper-sub-title">Ligne de prestation ajoutée</p>
                            </div>

                            <div id="prestationss">
                                <div class="prestationss mb-2">
                                    <div class="">
                                        @php
                                            $prestations = DB::table('facture_prestations')->where(['facture_uuid'=>$item->uuid])->where(['etat'=>"actif"])->get();
                                        @endphp
                                        @forelse ($prestations as $prestation )
                                            @if($prestation)

                                            <div class="col my-3 row flex-row">

                                                <div class="col-3">
                                                    <div class="form-control">
                                                        <span>{{ $prestation->type_prestation ?? 'N/A'  }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <input placeholder="{{ $prestation->qty ?? 'N/A'  }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-3">
                                                    <input placeholder="{{ $prestation->description ?? 'N/A'  }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-2">
                                                    <input placeholder="{{ $prestation->prixunitaire ?? 'N/A'  }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-2">
                                                    <input placeholder="{{ $prestation->total ?? 'N/A'  }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-auto">

                                                    <form action="{{ route('admin.delete.prestationLine', $prestation->uuid) }}" method="post" class="submitForm">
                                                        @csrf

                                                        <input type="hidden" name="facture_uuid" value="{{ $item->uuid }}">
                                                        <button type="submit" class="btn btn-danger px-2 text-center"><i class='bx bxs-trash'></i></button>
                                                    </form>
                                                </div>
                                            </div>

                                            @endif
                                        @empty
                                        <div>Aucune Facture enregistré</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                             <hr class="my-4">
                            <div class="bs-stepper-coent">
                                <form action="{{ route('admin.refacturation.update', $item->uuid) }}" method="post" class="submitForm" enctype="multipart/form-data" >
                                    @csrf

                                    <div class="">
                                        <h5 class="mb-0 steper-title">Detail</h5>
                                        <p class="mb-0 steper-sub-title">Information Complementaire</p>
                                    </div>

                                    <div class="row g-3 mt-3">
                                        <div class="col-12 col-lg-4">
                                            <label for="refClient" class="form-label">Ref Client</label>
                                            <input type="text" class="form-control" value="{{ $item->refClient ?? 'N/A'  }}" id="refClient" name="refClient"
                                                placeholder="Ref Client">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label for="num_cc" class="form-label">N° Client</label>
                                            <input type="text" class="form-control" id="num_cc" value="{{ $item->num_cc ?? 'N/A'  }}" name="num_cc"
                                                placeholder="cc012ff879">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label for="adresseComplete" class="form-label">Adresse Complete</label>
                                            <input type="text" class="form-control" value="{{ $item->adresseComplete ?? 'N/A'  }}" id="adresseComplete"
                                                name="adresseComplete" placeholder="Adresse Complete">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label for="email" class="form-label">E-mail Address</label>
                                            <input type="text" class="form-control" value="{{ $item->email ?? 'N/A'  }}" id="email" name="email"
                                                placeholder="example@xyz.com">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label for="pol" class="form-label">Pol</label>
                                            <input type="text" id="pol" class="form-control" value="{{ $item->pol ?? 'N/A'  }}" name="pol">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label for="pod" class="form-label">PoD</label>
                                            <input type="text" id="pod" class="form-control" value="{{ $item->pod ?? 'N/A'  }}" name="pod">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label for="regime" class="form-label">Regime</label>
                                            <input type="text" id="regime" class="form-control" value="{{ $item->regime ?? 'N/A'  }}" name="regime">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label for="doit" class="form-label">Doit</label>
                                            <input type="text" class="form-control" id="doit" value="{{ $item->doit ?? 'N/A'  }}" name="doit"
                                                placeholder="Doit">
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label for="num_Dossier" class="form-label">N° Dossier</label>
                                            <input type="text" class="form-control" id="num_Dossier" value="{{ $item->num_Dossier ?? 'N/A'  }}"
                                                placeholder="N° Dossier" name="num_Dossier">
                                        </div>
                                    </div>

                                    <div  class="bs-stepper-pane2">
                                        <div class="row g-3">
                                            <div class="col-12 col-lg-4">
                                                <label for="designation" class="form-label">Designation</label>
                                                <input type="text" class="form-control" id="designation" value="{{ $item->designation ?? 'N/A'  }}"
                                                    name="designation" placeholder="Groupe Electrogene">
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="num_Commande" class="form-label">N° Commande</label></label>
                                                <input type="text" class="form-control" id="num_Commande" value="{{ $item->num_Commande ?? 'N/A'  }}"
                                                    name="num_Commande" placeholder="cmd023564">
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="num_Bl" class="form-label">N° Bon Livraison</label>
                                                <input type="text" class="form-control" id="num_Bl" value="{{ $item->num_Bl ?? 'N/A'  }}" name="num_Bl"
                                                    placeholder="cmd023564">
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="navire" class="form-label">Navire/Voyage</label>
                                                <input type="text" class="form-control" id="navire" value="{{ $item->navire ?? 'N/A'  }}" name="navire"
                                                    placeholder="navire xxxx">
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="destination" class="form-label">Destination</label>
                                                <input type="text" class="form-control" id="destination" value="{{ $item->destination ?? 'N/A'  }}"
                                                    placeholder="destination" name="destination">
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="amateur" class="form-label">Amateur</label>
                                                <input type="text" class="form-control" id="amateur" value="{{ $item->amateur ?? 'N/A'  }}"
                                                    placeholder="amateur" name="amateur">
                                            </div>
                                            
                                            <div class="col-12 col-lg-4">
                                                <label for="num_Ot" class="form-label">N° OT</label>
                                                <input type="text" class="form-control" id="num_Ot" placeholder="N° OT" value="{{ $item->num_Ot ?? 'N/A'  }}"
                                                    name="num_Ot">
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="volume" class="form-label">Volume</label>
                                                <input type="text" class="form-control" id="volume" placeholder="volume" value="{{ $item->volume ?? 'N/A'  }}"
                                                    name="volume">
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="tva" class="form-label">tva (%)</label>
                                                <input type="text" class="form-control" value="{{ $item->tva }}" id="tva" placeholder="% TVA"
                                                    name="tva">
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="nbr_product" class="form-label">Nombre de Marchandises</label>
                                                <input type="text" class="form-control" value="{{ $item->nbr_product }}" id="nbr_product" placeholder="0"
                                                    name="nbr_product">
                                            </div>
                                        </div>
                                        <!---end row-->

                                    </div>
                                     <hr class="my-3">
                                    <div class="bs-stepper-pane2"
                                        aria-labelledby="stepper11trigger44">
                                        <div class="my-3">
                                            <h5 class="mb-0 steper-title">ID Facturier</h5>
                                            <p class="mb-0 steper-sub-title">Detail sur le responsable</p>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-12 col-lg-6">
                                                <label for="facturier_uuid" class="form-label">Facturier</label>
                                                <input type="text" class="form-control" id="facturier_uuid"
                                                    placeholder="{{ Auth::user()->name.' '.Auth::user()->lastname }}" readonly>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="poste_occuper" class="form-label">Poste</label>
                                                <input type="text" class="form-control" id="poste_occuper" value="{{ $item->poste_occuper ?? 'N/A'  }}"
                                                    placeholder="Poste Occuper" name="poste_occuper">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="num_facture" class="form-label">N° Facture</label>
                                                <input type="text" class="form-control" id="num_facture" value="{{ $item->num_facture ?? 'N/A'  }}"
                                                    placeholder="fact 001205v 01" name="num_facture">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="date_echeance" class="form-label">Date d'écheance</label>
                                                <input type="date" class="form-control" id="date_echeance" value="{{ $item->date_echeance ?? 'N/A'  }}"
                                                    name="date_echeance">
                                            </div>
                                            <div class="col-12 col-lg-12">
                                                <label for="condition_paiement" class="form-label">Condition de paiement</label>
                                                <textarea class="form-control" name="condition_paiement" id="condition_paiement" cols="30" rows="3">{{ $item->condition_paiement ?? 'N/A'  }}</textarea>
                                            </div>
                                            <div class="col-12 col-lg-12">
                                                <label for="comment" class="form-label">Commentaire</label>
                                                <textarea class="form-control" name="comment" id="comment" cols="30" rows="3">{{ $item->comment ?? 'N/A'  }}</textarea>
                                            </div>

                                            
                                        </div>
                                        <!---end row-->

                                    </div>
                                    <button type="submit" class="btn btn-outline-primary px-4 mt-3"
                                                >Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>-->
                {{-- <button type="button" class="btn btn-primary">Sauvegarder changements</button> --}}
            </div>
        </div>
    </div>
</div>