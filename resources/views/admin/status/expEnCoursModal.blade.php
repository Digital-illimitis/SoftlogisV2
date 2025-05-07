<div class="modal fade" id="showExportModal" tabindex="-1" aria-hidden="true" style="min-width: 750px !important">
    <div class="modal-dialog modal-dialog-scrollable" style="min-width: 650px !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Liste des produits En route pour exportation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Famille</th>
										<th>N°Serie</th>
										<th>Image</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ( $inWaitExpediteExport as $item )
									<tr>
                                        <td>{{ $item->familly->libelle ?? '--' }}</td>
										<td>{{ $item->numero_serie ?? '--' }}</td>
										<td>
                                            <img src="{{ asset('files/' . $item->image) }}" alt="" class="img-fluid"
                                                style="max-height: 60px; min-height: 60px; min-width: 80px">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.article.show', $item->uuid) }}" class="text-decoration-none">Detail</div>
                                        </td>

                                    </tr>
                                    @endforeach
								</tbody>
								<tfoot>
									<tr>
										<th>Famille</th>
										<th>N°Serie</th>
										<th>Image</th>

									</tr>
								</tfoot>
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
