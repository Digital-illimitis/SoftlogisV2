<div class="modal fade" id="nextArrivageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">Prochaine arrivée de Marchandise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <hr />
                <div class="">
                    <div class="car-body">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr class="size_12">
                                    <th scope="col">#</th>
                                    <th scope="col">Date d'arrivé</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($nextArrive as $index => $item)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    {{-- <td>{{ $item->products->numero_serie }}</td> --}}
                                    <td>
                                        <a href="{{ route('admin.sourcing.show', $item->uuid) }}"
                                            class=" text-decoration-none {{ Carbon\Carbon::parse($item->date_arriver)->isPast() ? 'text-danger' : '' }}">
                                            {{ Carbon\Carbon::parse($item->date_arriver)->format('d/m/Y') }}
                                            <span>
                                                <i class="bx bx-right-arrow-alt align-middle text-success"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">Aucune arrivée en cours</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

            </div>
        </div>
    </div>
</div>