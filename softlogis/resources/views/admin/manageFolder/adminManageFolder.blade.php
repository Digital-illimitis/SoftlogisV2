<div class="col-12 col-lg-12">
    <div class="card">
        <div class="card-body">

            <div class="row mt-3">
                <div class="row">
                    <div class="card col-3">
                        <div class="d-grid">
                            <a href="javascript:;" class="btn btn-primary">Agent en charge de dossier</a>
                        </div>
                        <div class="card-body overflow-scroll" style="max-height: 520px; overflow-y: auto;">

                            <div class="fm-menu">
                                <div class="list-group list-group-flush">
                                    @forelse ($allAgents as $agent)
                                        @php
                                            // $folderByAgentCount = App\Models\DocAssigned::where('etat', 'actif')->where('userUuid', $agent->uuid)->groupBy('userUuid')->count();

                                            $folderByAgentCount = countFolderByAgent($agent->uuid);
                                        @endphp

                                        @if ($folderByAgentCount > 0)
                                            <a href="javascript:;" class="list-group-item py-1">
                                                <img src="{{ asset('avatars/' . $agent->avatar) ?? '/avatars/default.jpg' }}"
                                                    width="25" height="25" class="rounded-circle me-2"
                                                    alt="" />
                                                <span class="size_12 me-2">
                                                    {{ $agent->name . ' ' . $agent->lastname }}
                                                </span>

                                                <span class="float-end badge badge-info badge-rounded bg-info p-1"
                                                    style="font-size: 8px">
                                                    {{ $folderByAgentCount }}
                                                </span>
                                            </a>
                                        @endif
                                    @empty
                                        <span>Aucun agent</span>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary ">Nombre Total Agent</p>
                                            <h4 class="my-1">{{ $allAgents->count() }}</h4>
                                        </div>
                                        <div class="text-primary ms-auto font-35"><i class="bx bxs-group"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Nombre Total agent Assigné</p>
                                            <h4 class="my-1">{{ $countUserAssignFolder }}</h4>
                                        </div>
                                        <div class="text-primary ms-auto font-35"><i class='bx bxl-chrome'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-9 row">
                       

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart4"  route="{{route('admin.manager_dossier.stat')}}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card d-none">
                <div class="container card-body">
                    <form method="GET" action="{{ route('admin.manager_dossier.index') }}" class="d-flex align-items-center">
                        <!-- Filtre par Agent -->
                        <select class="form-select me-2" name="agent">
                            <option value="" selected>Rechercher par Agent</option>
                            @foreach ($allAgents as $agent)
                                <option value="{{ $agent->uuid }}">{{ $agent->name ?? '' }}</option>
                            @endforeach
                        </select>
                    
                        <!-- Filtre par Date -->
                        <input type="date" class="form-control me-2" name="date">
                    
                        <!-- Filtre par Statut -->
                        <select class="form-select me-2" name="status">
                            <option value="" selected>Rechercher par statut</option>
                            <option value="N/A">N/A</option>
                            <option value="En cours">En Cours</option>
                            <option value="Terminé">Terminé</option>
                        </select>
                    
                        <!-- Bouton de recherche -->
                        <button type="submit" class="btn btn-primary">Recherche</button>
                    </form>
                    
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-0">Dossiers Recents</h5>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table id="example3"
                    class="table table-striped table-hover table-sm mb-0 table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N° BL <i class='bx bx-up-arrow-alt ms-2'></i>
                            </th>
                            <th>ALERTE</th>
                            <th>ETA</th>
                            <th>ETD</th>
                            {{-- <th>ARTICLES</th> --}}
                            @foreach ($docs as $doc)
                                <th>{{ $doc->libelle }}</th>
                            @endforeach
                            <th>AGENT</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($sourcingByBlist as $item)
                            @php
                                $date_eta = Carbon\Carbon::parse($item->date_arriver);
                                $date_alerte = $date_eta->subDays(10)->format('d/m/y');
                            @endphp
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-primary">
                                        <a
                                            href="{{ route('admin.sourcing.show', $item->uuid) }} ">{{ $item->num_bl ?? '--' }}</a>
                                    </div>
                                </td>
                                <td class="text-danger"> {{ $date_alerte ?? '--' }} </td>
                                <td>{{ Carbon\Carbon::parse($item->date_arriver)->format('d/m/y') ?? '--' }}</td>
                                <td>{{ Carbon\Carbon::parse($item->date_depart)->format('d/m/y') ?? '--' }}</td>
                                {{-- <td>{{ $item->products->count() ?? '--' }}</td> --}}
                                @foreach ($docs as $doc)
                                    <td>
                                        <div class="form-check form-switch  form-check-success"
                                            clickedUrl="{{ route('admin.updateStatusFolder') }}"
                                            value="{{ $doc->uuid }}" name="folderCheck"
                                            sourcing="{{ $item->uuid }}">

                                            @if (isMyfolderCheck($item->uuid, $doc->uuid))
                                                <input class="form-check-input folderCheck"
                                                    clickedUrl="{{ route('admin.updateStatusFolder') }}"
                                                    value="{{ $doc->uuid }}" name="folderCheck"
                                                    sourcing="{{ $item->uuid }}" type="checkbox"
                                                    @if (isfolderCheck($item->uuid, $doc->uuid)) {{ 'checked disabled' }} @endif
                                                    role="switch" id="flexSwitchCheckSuccess">
                                            @else
                                                <input type="checkbox" class="form-check-input folderCheck" disabled
                                                    readonly>
                                            @endif

                                        </div>
                                    </td>
                                @endforeach

                                <td>
                                    @if ($item->folderAssign)
                                        <div class="user-groups ms-auto">
                                            @if ($item->folderAssign->user)
                                                <img src="{{ asset('avatars/' . $item->folderAssign->user->avatar) }}"
                                                    width="35" height="35" class="rounded-circle"
                                                    alt=""
                                                    title="{{ ' Lead : ' . $item->folderAssign->user->name . ' ' . $item->folderAssign->user->lastname }}">
                                            @else
                                                <img src="{{ asset('avatars/plus.png') }}" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->folderAssign->uuid }}"
                                                    style="cursor:pointer;" width="35" height="35"
                                                    class="rounded-circle" alt="">
                                            @endif
                                            @if ($item->folderAssign->backup)
                                                <img src="{{ asset('avatars/' . $item->folderAssign->user->avatar) }}"
                                                    width="35" height="35" class="rounded-circle"
                                                    alt=""
                                                    title="{{ 'Backup: ' . $item->folderAssign->backup->name . ' ' . $item->folderAssign->backup->lastname }}">
                                            @else
                                                <img src="{{ asset('avatars/plus.png') }}" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->folderAssign->uuid }}"
                                                    style="cursor:pointer;" width="35" height="35"
                                                    class="rounded-circle" alt="">
                                            @endif
                                        </div>
                                    @else
                                        <div class="user-groups ms-auto">
                                            <img src="{{ asset('avatars/plus.png') }}" data-bs-toggle="modal"
                                                data-bs-target="#assignModal{{ $item->uuid }}"
                                                style="cursor:pointer;" width="35" height="35"
                                                class="rounded-circle" alt="">
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center align-self-center">

                                    {{-- <a data-bs-toggle="modal" data-bs-target="#assignModal{{ $item->uuid }}"
                                        class="text-success" style="cursor:pointer;"><i
                                            class="lni lni-network"></i></a>

                                    <a data-bs-toggle="modal" data-bs-target="#editModal{{ $item->uuid }}"
                                        class="mx-2" style="cursor:pointer;"><i class='bx bxs-edit'></i></a> --}}

                                    <a class="" style="cursor:pointer;" data-bs-toggle="modal"
                                        data-bs-target="#commentModal{{ $item->uuid }}">
                                        <i class="lni lni-comments-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            {{-- include --}}
                            @include('admin.manageFolder.assignModal')
                            @if ($item->folderAssign)
                                @include('admin.manageFolder.editModal')
                            @endif
                            @include('admin.manageFolder.commentModal')
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        
    })
</script>
