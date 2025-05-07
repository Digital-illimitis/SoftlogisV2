<div class="col-12 col-lg-12">
    <div class="card">
        <div class="card-body">

            <div class="row mt-3">
                {{-- <div class="col-12 row">
                    <div class="col-12 col-lg-4">
                        <div class="card shadow-none border radius-15">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="fm-icon-box radius-15 bg-primary text-white"><i
                                            class='lni lni-google-drive'></i>
                                    </div>
                                    <div class="ms-auto font-24"><i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                </div>
                                <h5 class="mt-3 mb-0">Mes Dossiers</h5>
                                <p class="mb-1 mt-4">
                                    <span>{{ $mesDossiers->count() }}
                                        @if ($mesDossiers->count() > 0)
                                            dossiers
                                        @else
                                            dossier
                                        @endif
                                    </span>
                                </p>
                                <div class="progress" style="height: 7px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"
                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card shadow-none border radius-15">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="fm-icon-box radius-15 bg-danger text-white"><i
                                            class='lni lni-dropbox-original'></i>
                                    </div>
                                    <div class="ms-auto font-24"><i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                </div>
                                <h5 class="mt-3 mb-0">Dossier Assigné</h5>
                                <p class="mb-1 mt-4">
                                    <span>{{ $nombreDossiersAssignes }}
                                        @if ($nombreDossiersAssignes > 0)
                                            dossiers
                                        @else
                                            dossier
                                        @endif
                                    </span>
                                </p>
                                <div class="progress" style="height: 7px;">
                                    <div class="progress-bar bg-danger" role="progressbar"
                                        style="width: {{ $perCentdocAssign }}%;" aria-valuenow="{{ $perCentdocAssign }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card shadow-none border radius-15">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="fm-icon-box radius-15 bg-warning text-dark"><i
                                            class='bx bxs-door-open'></i>
                                    </div>
                                    <div class="ms-auto font-24"><i class='bx bx-dots-horizontal-rounded'></i>
                                    </div>
                                </div>
                                <h5 class="mt-3 mb-0">Dossier Non Assigné</h5>
                                <p class="mb-1 mt-4">
                                    <span>{{ $nombreDossiersEnAttente }}
                                        @if ($nombreDossiersEnAttente > 0)
                                            dossiers
                                        @else
                                            dossier
                                        @endif
                                    </span>
                                </p>
                                <div class="progress" style="height: 7px;">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{ $perCentdocNotAssign }}%;"
                                        aria-valuenow="{{ $perCentdocNotAssign }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> --}}

            </div>
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-0 text-uppercase">Mes Dossiers</h5>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table id="example2" class="table table-striped table-hover table-sm mb-0 table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N° BL <i class='bx bx-up-arrow-alt ms-2'></i>
                            </th>
                            <th>ALERTE</th>
                            <th>ETA</th>
                            <th>ETD</th>
                            <th>ARTICLES</th>
                            @foreach ($docs as $doc)
                                <th>{{ $doc->libelle }}</th>
                            @endforeach
                            <th>BACKUP</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($mesDossiers as $item)
                        @if ($item && $item->folder)
                        @php
                        $date_eta = Carbon\Carbon::parse($item->folder->date_arriver ?? '');
                        $date_alerte = $date_eta->subDays(10)->format('d/m/y');
                    @endphp
                    <tr>
                        <td>
                            <div class="font-weight-bold text-primary">
                                <a
                                    href="{{ route('admin.sourcing.show', $item->folder->uuid) }} ">{{ $item->folder->num_bl ?? '--' }}</a>
                            </div>
                        </td>
                        <td class="text-danger"> {{ $date_alerte ?? '--' }} </td>
                        <td>{{ Carbon\Carbon::parse($item->folder->date_arriver)->format('d/m/y') ?? '--' }}
                        </td>
                        <td>{{ Carbon\Carbon::parse($item->folder->date_depart)->format('d/m/y') ?? '--' }}
                        </td>
                        <td>{{ $item->folder->products->count() ?? '--' }}</td>
                        @foreach ($docs as $doc)
                            <td>
                                <div class="form-check form-switch  form-check-success"
                                    clickedUrl="{{ route('admin.updateStatusFolder') }}"
                                    value="{{ $doc->uuid }}" name="folderCheck"
                                    sourcing="{{ $item->folder->uuid }}">
                                    <input class="form-check-input folderCheck" unchecked
                                        clickedUrl="{{ route('admin.updateStatusFolder') }}"
                                        value="{{ $doc->uuid }}" name="folderCheck"
                                        sourcing="{{ $item->folder->uuid }}" type="checkbox"
                                        @if (isfolderCheck($item->folder->uuid, $doc->uuid)) {{ 'checked disabled' }} @endif
                                        role="switch" id="flexSwitchCheckSuccess">
                                    {{-- {{isfolderCheck($item->uuid,$doc->uuid)}} --}}
                                </div>
                            </td>
                        @endforeach
                        <td>
                            <div class="user-groups ms-auto">
                                @if ($item->backup)
                                    <img src="{{ asset('avatars/' . $item->backup->avatar) }}" width="35"
                                        height="35" class="rounded-circle" alt=""
                                        title="{{ $item->backup->name . ' ' . $item->backup->lastname }}">
                                @else
                                    Aucun Backup
                                @endif
                            </div>

                        </td>

                        <td class="text-center align-self-center">
                            <a class="" style="cursor:pointer;" data-bs-toggle="modal"
                                data-bs-target="#commentModal{{ $item->uuid }}">
                                <i class="lni lni-comments-alt"></i>
                            </a>
                        </td>
                    </tr>
                    {{-- include --}}

                    @include('admin.manageFolder.commentModal')
                        @endif
                            
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
