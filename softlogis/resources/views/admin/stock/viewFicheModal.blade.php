 <!--modal pour afficher le fichier -->
 <!-- Modal -->
 <div class="modal fade" id="pdfModal{{$mvtUpdate->id}}" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lecture de la Fiche d'inspection :</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @php $lire = "documents/files/"; $var = $mvtUpdate->file; $cum = $lire.$var; @endphp


                @if($cum)
                <iframe src='{{ asset($cum) }}' width="100%" height="600"></iframe>
                @else

                @endif

                <!-- Conteneur pour le PDF -->
                <div id="pdfContainer"></div>
            </div>
        </div>
    </div>
</div>
<!--end modal pour afficher le fichier -->
<!-- Modal -->