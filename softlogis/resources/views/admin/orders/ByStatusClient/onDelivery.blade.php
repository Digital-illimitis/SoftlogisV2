<div class="modal fade" id="showOrderOnDeliveryModal" tabindex="-1" aria-labelledby="showOrderOnDeliveryModal" aria-hidden="true"  >
    <div class="modal-dialog" style="min-width: 1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showOrderOnDeliveryModal">Vue sur les commandes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive mt-2" >
                    <table class="table table-striped table-hover table-sm mb-0" id="example2">
                        <thead>
                            <tr>
                                <th>Code <i class='bx bx-up-arrow-alt ms-2'></i></th>
                                <th>N° Commande</th>
                                <th>Date Depart</th>
                                <th>Date Arrivé</th>
                                <th>Date de publication</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @forelse ($orderOnDelivery as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>{{ $item->code ?? '--' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $item->num_order ?? '--' }}</div>
                                </td>
                                <td>{{ $item->date_arriver ?? '--'}}</td>
                                <td>{{ $item->date_depart ?? '--'}}</td>
                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                
                                <td class="cursor-pointer">
                                    <a href="{{ route('admin.odre_expedition.show', $item->uuid) }}">
                                        <i class="lni lni-eye"></i>
                                    </a>
                                </td>

                                
                            </tr>
                            @empty
                                <span class="badge bg-success text-success-light px-3 py-1">Aucune Commande</span></span>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
            

        </div>
    </div>
</div>