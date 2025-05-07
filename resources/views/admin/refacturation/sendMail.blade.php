<div class="modal fade " id="addSendMail{{ $refacturation->id }}" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content blockSendmail">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Envoi de facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Début du formulaire -->
                <form  method="POST" class="submitForm" action="{{ route('admin.send.invoice.email', $refacturation->id) }}">
                    @csrf
                    <div class="email-form">
                        <input type="hidden" name="refacturationId" value="{{ $refacturation->id }}">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Destinataire" name="destinataire" />
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Objet" name="objet" />
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Message" rows="10" cols="10" name="message"></textarea>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">Soumettre</button>
                                    </div>
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


