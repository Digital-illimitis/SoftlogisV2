<div class="modal fade " id="addSendMail{{ $oDLivraison->id }}" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content blockSendmail">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Envoi de l'ordre de transport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Début du formulaire -->
                <form  method="POST" class="submitForm" action="{{ route('admin.send.ot.email', $oDLivraison->id) }}">
                    @csrf
                    <div class="email-form">
                        {{-- <input type="hidden" name="refacturationId" value="{{ $oDLivraison->id }}"> --}}
                        <div class="mb-3">
                             @if($oDLivraison->transporteur)
                            <input type="text" class="form-control" name="destinataire" value="{{ $oDLivraison->transporteur->email }}"/>
                            @endif
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Objet" name="objet" />
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Message" rows="10" cols="10" name="message"></textarea>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex align-items-center row">
                                <div class="col-4">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary btn-sm size_11">Soumettre</button>
                                    </div>
                                </div>
                                <div class="col-8 d-flex justify-content-end" style="font-size: 18px">

                                    <strong title="Odre de transport" class="pointer btn-sm me-2">
                                        <a href="{{route('admin.od_livraison.downloadOtPDF', $oDLivraison->id)}}" target="_blank"><i class="bx bxs-file-pdf " ></i></a>
                                    </strong>

                                    @foreach ($oDLivraison->files as $livraisonFile)
                                        
                                        <strong title="{{ $livraisonFile->name }}" class="pointer btn-sm me-2 text-primary">
                                            <i class="bx bxs-file-pdf pointer" ></i>
                                        </strong>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Fin du formulaire -->
            </div>
        </div>
    </div>
</div>


