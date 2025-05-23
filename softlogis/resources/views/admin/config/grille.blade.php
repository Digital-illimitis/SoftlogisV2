@extends('admin.layouts.admin')

@section('section')

<div class="page-content">
    <div class="row">
        <div class="col-9">
            <h6 class="mb-0 text-uppercase mb-3">Offres Tarifaire</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Transporteur</th>
										<th>Destination</th>
										<th>PorteChar</th>
										<th>Montant</th>
									</tr>
								</thead>
								<tbody>

                                    @foreach ($grilleTarifaires->groupBy('destination.libelle') as $libelle => $items)

                                        <tr>
                                            <td>{{ $items[0]->transporteur->raison_sociale ?? 'N/A' }}</td>
                                            <td rowspan="{{ count($items) }}">{{ $libelle ?? 'N/A' }}</td>
                                            <td>{{ $items[0]->porteChar->libelle ?? 'N/A' }}</td>
                                            <td>{{ $items[0]->cout ?? 'N/A'}}</td>
                                        </tr>
                                        @for ($i = 1; $i < count($items); $i++)
                                            <tr>
                                                <td>{{ $items[$i]->transporteur->raison_sociale ?? 'N/A' }}</td>
                                                <td>{{ $items[$i]->porteChar->libelle ?? 'N/A' }}</td>
                                                <td>{{ $items[$i]->cout ?? 'N/A' }}</td>
                                            </tr>
                                        @endfor
                                    @endforeach

								</tbody>
								<tfoot>
									<tr>
										<th>Transporteur</th>
										<th>Destination</th>
										<th>PorteChar</th>
										<th>Montant</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
                <hr>

                <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Transitaire</th>
										<th>HAD</th>
										<th>Montant</th>
									</tr>
								</thead>
								<tbody>

                                    @foreach ($grilleTariftransits->groupBy('transitaire.raison_sociale') as $libelle => $items)

                                        <tr>
                                            <td rowspan="{{ count($items) }}">{{ $libelle ?? '--' }}</td>
                                            <td>{{ $items[0]->had->libelle ?? '--' }}</td>
                                            <td>{{ $items[0]->cout ?? '--' }}</td>
                                        </tr>
                                        @for ($i = 1; $i < count($items); $i++)
                                            <tr>
                                                <td>{{ $items[$i]->had->libelle ?? '--' }}</td>
                                                <td>{{ $items[$i]->cout ?? '--' }}</td>
                                            </tr>
                                        @endfor
                                    @endforeach

								</tbody>
								<tfoot>
									<tr>
										<th>Transitaire</th>
										<th>HAD</th>
										<th>Montant</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
        </div>

        <div class="col-3 mt-3">
            <div class="email-wrapper w-100  mb-2" style="max-height: 250px">
                <div class="email-sidear w-100">
                    <div class="email-sidebar-hader d-grid mb-3" data-bs-toggle="modal" data-bs-target="#addDestinationModal"> <a href="javascript:;" class="btn btn-primary compose-mail-btn"><i class='bx bx-plus me-2'></i> Ajouter Destination</a>
                    </div>

                    <div class="email-sidebar-contnt">
                        <div class="email-navigation" style="max-height: 250px; overflow-y: auto;">
                            <div class="list-group list-group-flush">
                                @foreach ($destinations as $destination)
                                <div class="row list-group-item d-flex align-items-center">
                                    <a href="javascript:;" class=" col-9">
                                        <i class='bx bxs-inbox me-3 font-20'></i>
                                        <span>{{ $destination->libelle ?? '--' }}</span>
                                    </a>
                                    <span class="ms-auto col-3 text-end">
                                        <a class="deleteConfirmation" data-uuid="{{$destination->uuid}}"
                                            data-type="confirmation_redirect" data-placement="top"
                                            data-token="{{ csrf_token() }}"
                                            data-url="{{route('admin.destroyDestinations',$destination->uuid)}}"
                                            data-title="Vous êtes sur le point de supprimer {{$destination->libelle}} "
                                            data-id="{{$destination->uuid}}" data-param="0"
                                            data-route="{{route('admin.destroyDestinations',$destination->uuid)}}">
                                            <i class='bx bxs-trash-alt font-20 cursor-pointer'></i>
                                        </a>
                                    </span>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr class="my-3">

            <div class="email-wrapper w-100  mb-2" style="max-height: 250px">
                <div class="email-sidear w-100">
                    <div class="email-sidebar-hader d-grid mb-3" data-bs-toggle="modal" data-bs-target="#addPortecharModal"> <a href="javascript:;" class="btn btn-primary compose-mail-btn"><i class='bx bx-plus me-2'></i> Ajouter Porte Char</a>
                    </div>

                    <div class="email-sidebar-contnt">
                        <div class="email-navigation" style="max-height: 250px; overflow-y: auto;">
                            <div class="list-group list-group-flush">
                                @foreach ($porteChars as $porteChar)
                                <div class="row list-group-item d-flex align-items-center">
                                    <a href="javascript:;" class=" col-9">
                                        <i class='bx bxs-inbox me-3 font-20'></i>
                                        <span>{{ $porteChar->libelle ?? '--' }}</span>
                                    </a>
                                    <span class="ms-auto col-3 text-end">
                                        <a class="deleteConfirmation" data-uuid="{{$porteChar->uuid}}"
                                            data-type="confirmation_redirect" data-placement="top"
                                            data-token="{{ csrf_token() }}"
                                            data-url="{{route('admin.destroyPorteChar',$porteChar->uuid)}}"
                                            data-title="Vous êtes sur le point de supprimer {{$porteChar->libelle}} "
                                            data-id="{{$porteChar->uuid}}" data-param="0"
                                            data-route="{{route('admin.destroyPorteChar',$porteChar->uuid)}}">
                                            <i class='bx bxs-trash-alt font-20 cursor-pointer'></i>
                                        </a>
                                    </span>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr class="my-3">
            <div class="email-wrapper w-100  mb-2" style="max-height: 250px">
                <div class="email-sidear w-100">
                    <div class="email-sidebar-hader d-grid mb-3" data-bs-toggle="modal" data-bs-target="#addHadModal"> <a href="javascript:;" class="btn btn-primary compose-mail-btn"><i class='bx bx-plus me-2'></i> Ajouter HAD</a>
                    </div>

                    <div class="email-sidebar-contnt">
                        <div class="email-navigation" style="max-height: 250px; overflow-y: auto;">
                            <div class="list-group list-group-flush">
                                @foreach ($grilleHads as $item)
                                <div class="row list-group-item d-flex align-items-center">
                                    <a href="javascript:;" class=" col-9">
                                        <i class='bx bxs-inbox me-3 font-20'></i>
                                        <span>{{ $item->libelle ?? '--' }}</span>
                                    </a>
                                    <span class="ms-auto col-3 text-end">
                                        <a class="deleteConfirmation" data-uuid="{{$item->uuid}}"
                                            data-type="confirmation_redirect" data-placement="top"
                                            data-token="{{ csrf_token() }}"
                                            data-url="{{route('admin.destroyHad',$item->uuid)}}"
                                            data-title="Vous êtes sur le point de supprimer {{$item->libelle}} "
                                            data-id="{{$item->uuid}}" data-param="0"
                                            data-route="{{route('admin.destroyHad',$item->uuid)}}">
                                            <i class='bx bxs-trash-alt font-20 cursor-pointer'></i>
                                        </a>
                                    </span>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    @include('admin.config.destinationModal')
    @include('admin.config.porteCharModal')
    @include('admin.config.hadModal')
</div>


@endsection