<div class="modal fade" id="inTransitExportModal" tabindex="-1" aria-hidden="true" style="min-width: 750px !important">
    <div class="modal-dialog modal-dialog-scrollable" style="min-width: 650px !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Liste des Expeditions En Cours De Transit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
					<div class="card-body">
						<div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>N°</th>
										<th>Date de livraison</th>
										<th>Lieu de livraison</th>
										<th>Client</th>
										<th>Nombre de Produits</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ( $nbrExpeditionStarted as $item )
									<tr>
                                        <td>{{ $item->num_exp ?? '--'}}</td>
										<td>{{ Carbon\Carbon::parse($item->date_liv)->format('d/m/Y') ?? '--'}}</td>
										<td>{{ $item->lieu_liv ?? '--'}}</td>
										<td>{{ $item->client->raison_sociale ?? '--'}}</td>
										<td>{{ $item->products->count() ?? '--'}}</td>
                                        <td>
                                            <a href="{{ route('admin.odre_expedition.show', $item->uuid) }}" class="text-decoration-none">Detail</div>
                                        </td>
                                    </tr>
                                    @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
