<div class="modal fade" id="fileListModal{{ $sourcing->uuid }}" tabindex="-1" aria-labelledby="fileListModal{{ $sourcing->uuid }}" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileListModal{{ $sourcing->id }}">Liste des Documents du Sourcing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @if ($sourcing->files->count() > 0)
                    <ul class="list-group ">
                        @foreach ($sourcing->files as $sourcingFile)

                        <li class="list-group-item mb-3" id="fileListBlock">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="overflow-x-scroll me-3">
                                    <a href="" class="text-uppercase text-dark">{{ $sourcingFile->files }}</a>
                                </div>
                                <button class="btn btn-dowload m-0" data-file="{{ asset('documents/files'.'/'.$sourcingFile->files) }}">
                                    <a href="{{ asset('documents/files'.'/'.$sourcingFile->files) }}"><i  class="bx bx-download btn btn-outline-info fs-6"></i></a>
                                </button>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucun document associé à ce sourcing.</p>
                @endif
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


