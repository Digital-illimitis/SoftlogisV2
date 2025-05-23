<div class="modal fade myModal" id="assignModal{{ $item->uuid }}" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.manage_folder.assign', $item->uuid) }}" method="post" class="submitForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Assigner à un agent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">

                        <input type="hidden" name="folderUuid" value="{{ $item->uuid }}">

                        <div class="input-group">
                            <div class="input-group-text text-light bg-success pe-3">Agent <span class="text-danger">*</span></div>
                            <select class="form-select " id="mySelect2" data-placeholder="Choisir un agent" name="userUuid" required>
                               <option value=""></option>
                                @foreach ($allAgents as $agent)
                                    @if (!empty($agent))
                                        <option value="{{ $agent->uuid }}">
                                           <button type="button" class="btn btn-primary">{{ $agent->name.' '. $agent->lastname }} <span class="badge bg-dark">{{ countFolderByAgent($agent->uuid); }}</span>
                                            </button>
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            @error('userUuid')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group my-3">
                            <div class="input-group-text text-light bg-primary">Backup</div>
                            <select class="form-select" id="prepend-text-single-backup" data-placeholder="Choisir un agent" name="backupUuid">
                                <option></option>
                                @foreach ($allAgents as $agent)
                                    @if (!empty($agent))
                                        <option value="{{ $agent->uuid }}">{{ $agent->name.' '. $agent->lastname }}--- 
                                            <span>{{ countFolderByBackup($agent->uuid) }}</span></option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Assigner <i class="bx bx-arrow-from-left"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>