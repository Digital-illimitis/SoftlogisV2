 <!--modal pour afficher le fichier -->
 <!-- Modal -->
 <div class="modal fade" id="pdfModal{{$sourcingFile->id}}" tabindex="-1" aria-hidden="true">

     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Lecture du PDF :
                     {{($sourcingFile->name) ?? '' }} Validation :
                     @if($sourcingFile->statut == "waiting")
                        <b class="btn btn-warning">En cours</b>
                     @elseif($sourcingFile->statut == "validate")
                        <b style="color: green;">Validé</b>
                     @elseif($sourcingFile->statut == NULL)
                        <b class="btn btn-warning">En cours</b>
                     @else
                        <b style="color:red;">Refusé</b>
                     @endif
                 </h5>
                 <div style="margin:auto; display:flex; justify-content: space-between;">
                    @if($sourcingFile->statut !== "validate")
                     <form action="{{ route('admin.validate.sourcing', $sourcingFile->id) }}" method="POST"
                         enctype="multipart/form-data" class="submitForm">
                         @csrf
                         <button type="submit" class="btn btn-success">
                             Valider
                         </button>
                     </form>
                     @endif
                     <form style="margin-left: 10px;" action="{{ route('admin.refused.sourcing', $sourcingFile->id) }}"
                         method="POST" enctype="multipart/form-data" class="submitForm">
                         @csrf
                         <button type="submit" onclick="return confirm('Vous confirmez le refus ?')" class="btn btn-danger">
                             Refuser
                         </button>
                     </form>
                 </div>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             
             <div class="modal-body">
                 @php $lire = "documents/files/"; $var = $sourcingFile->files; $cum = $lire.$var; @endphp

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
