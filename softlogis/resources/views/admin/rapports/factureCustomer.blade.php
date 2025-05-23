@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Rapport de facturation</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">client</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="container-fluid my-5 mx-3">
            <form method="GET" action="{{ route('admin.report.facture.customer') }}">
                <div class="row">
                    <div class="col-md-2">
                        <label for="start_date">De:</label>
                        <input type="date" class="form-control" name="start_date" id="date_range">
                    </div>
                    <div class="col-md-2">
                        <label for="end_date">A:</label>
                        <input type="date" class="form-control" name="end_date" id="date_range">
                    </div>
            
                    <div class="col-md-2">
                        <label for="date_echeance">Date d'Échéance:</label>
                        <input type="date" class="form-control" name="date_echeance" id="date_echeance">
                    </div>
            
                    <div class="col-md-3">
                        <label for="status">Statut:</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Sélectionnez un statut</option>
                            <option value="draft">Brouillon</option>
                            <option value="sendToClient">Envoyée au client</option>
                            <option value="payed">Payé</option>
                            <option value="canceled">Annulée</option>
                        </select>
                    </div>

            
                    <div class="col-md-3 mt-4">
                        <button type="submit" class="btn btn-primary px-4">Filtrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total factures</p>
                            <h4 class="my-1">{{ number_format($totalGlobalLine, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>{{ $facturesCount }} Factures</p>
                        </div>
                        <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Envoyé au Client</p>
                            <h4 class="my-1">{{ number_format($valeur_bon_a_payer, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-info"><i class='bx bxs-up-arrow align-middle'></i>{{ $facGoodPay->count() }} Factures</p>
                        </div>
                        <div class="widgets-icons bg-light-info text-danger ms-auto"><i class='bx bxs-group'></i>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Factures payées</p>
                            <h4 class="my-1">{{ number_format($valeur_payer, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-success"><i class='bx bxs-down-arrow align-middle'></i>{{ $factPayed->count() }} factures</p>
                        </div>
                        <div class="widgets-icons bg-light-danger text-info ms-auto"><i class='bx bxs-binoculars'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Factures Rejetées</p>
                            <h4 class="my-1">{{ number_format($valeur_canceled, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-danger"><i class='bx bxs-down-arrow align-middle'></i>{{ $factCancel->count() }} factures</p>
                        </div>
                        <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-line-chart-down'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>N° Facture</th>
                            <th>N° BL</th>
                            <th>Beneficiaire</th>
                            <th>Statut</th>
                            <th>Total (XOF)</th>
                            <th>Date d'echeance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($factures as $facture)
                        <tr>
                            <td>
                                {{ $facture->code ?? 'N/A'}}
                            <td>
                                {{ $facture->num_Bl ?? 'N/A' }}
                            </td>
                            <td>{{ $facture->doit ?? 'N/A' }}</td>
                            <td>
                                @if ($facture->statut == 'draft')
                                <div
                                    class="badge rounded-pill text-light bg-primary p-2 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Brouillon
                                </div>
                                @endif
                                @if ($facture->statut == 'sendToClient')
                                <div
                                    class="badge rounded-pill text-light bg-danger p-2 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i>Envoyé
                                </div>
                                @endif
                                @if ($facture->statut == 'payed')
                                <div
                                    class="badge rounded-pill text-light bg-gradient-quepal p-2 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Payé
                                </div>
                                @endif
                                @if ($facture->statut == 'canceled')
                                <div
                                    class="badge rounded-pill text-light bg-gradient-blooker p-2 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Rejeté
                                </div>
                                @endif
                            </td>
                            <td>
                                {{ number_format($facture->prestations->sum('total'), 0, ',', ' ') }}
                            </td>

                            <td @if($facture->statut !== 'payed' && Carbon\Carbon::parse($facture->date_echeance)->isPast()) class="text-danger" @endif>
                                {{ Carbon\Carbon::parse($facture->date_echeance)->format('d/m/Y') ?? 'N/A' }}
                            </td>

                            <td>
                                <div class="d-flex order-actions">

                                    <a href="{{ route('admin.refacturation.show', $facture->uuid) }}" class="bg-transparent"><i class='bx bxs-show'></i></a>
                                   
                                </div>
                            </td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(function() {
        $('#date_range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
    </script>

@endsection
