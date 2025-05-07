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
                    <li class="breadcrumb-item active" aria-current="page">Prestataires</li>
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
    
            <form method="GET" action="{{ route('admin.report.facture') }}">
                <div class="row">

                    <div class="col-md-4">
                        <div class="col">

                            <div class="m">
                                <legend class=""><small>Periode</small></legend>
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <label for="start_date">De :</label>
                                        <input type="date" class="form-control" name="start_date" id="date_range">
                                    </div>
                                    <div class="col">
                                        <label for="end_date">A:</label>
                                        <input type="date" class="form-control" name="end_date" id="date_range">
                                    </div>
                                </div>
                            </div>

                            <div class="col mt-3">
                                <label for="date_echeance">Date d'Échéance:</label>
                                <input type="date" class="form-control" name="date_echeance" id="date_echeance">
                            </div>
                        </div>

                        
                    </div>
                    
                   <fieldset class="col-md-4 mt-4">
                        <div class="col">
                            <label for="status">Statut:</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">Sélectionnez un statut</option>
                                <option value="payed">Payé</option>
                                <option value="good_pay">Bon à payer</option>
                                <option value="cancel">Annulé</option>
                            </select>
                        </div>
                        <div class="col mt-3">
                            <label for="FilterPrestataire">Prestataire:</label>
                            <select class="form-control" name="FilterPrestataire" id="FilterPrestataire">
                                <option value="">Sélectionnez un prestataire</option>
                                @foreach ($FilterPrestataire as $prestataire)
                                    <option value="{{ $prestataire->uuid }}">{{ $prestataire->raison_sociale }}</option>
                                @endforeach
                            </select>
                        </div>
                   </fieldset>
            
                    
                   <div class="col-md-4 mt-4">

                        <div class="col">
                            <label for="num_bl">Numéro BL:</label>
                            <input type="text" class="form-control" name="num_bl" id="num_bl" placeholder="Numéro BL">
                        </div>
                
                        <div class="col mt-3">
                            <label for="type_facture">Type de Facture:</label>
                            <select class="form-control" name="type_facture" id="type_facture">
                                <option value="">Sélectionnez un type</option>
                                <option value="transporteur">Transporteur</option>
                                <option value="transitaire">Transitaire</option>
                            </select>
                        </div>
                   </div>
                    
                </div>

                <div class="card-footer mt-4">
                    <div class="col-sm-12 col-md-6 col-lg-4 my-auto">
                        <button type="submit" class="btn btn-primary  w-100">Filtrer</button>
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
                            <p class="mb-0 text-secondary">Bon à Payer</p>
                            <h4 class="my-1">{{ number_format($valeur_bon_a_payer, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-info"><i class='bx bxs-up-arrow align-middle'></i>{{ $factureGoodPayCount->count() }} Factures</p>
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
                            <p class="mb-0 font-13 text-success"><i class='bx bxs-down-arrow align-middle'></i>{{ $factuPay->count() }} factures</p>
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
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14">#{{ $facture->numFacture ?? 'N/A'}}</h6>
                                    </div>
                                </div>

                            </td>
                            <td>
                                {{ $facture->num_bl ?? 'N/A' }}
                            </td>
                            <td>
                                @if ($facture->typeFacture == 'transitaire')
                                    {{ $facture->transitaire->raison_sociale ?? 'N/A' }}
                                @elseif ($facture->typeFacture == 'transporteur')
                                    {{ $facture->transporteur->raison_sociale ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @if ($facture->statut == 'reccording')
                                    <div class="badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3">
                                        <i class='bx bxs-circle me-1'></i> Enregistrement
                                    </div>
                                @endif
                                @if ($facture->statut == 'good_pay')
                                    <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                        <i class='bx bxs-circle me-1'></i> Bon à Payer
                                    </div>
                                @endif
                                @if ($facture->statut == 'payed')
                                    <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                        <i class='bx bxs-circle me-1'></i> Payé
                                    </div>
                                @endif
                                @if ($facture->statut == 'cancel')
                                    <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                        <i class='bx bxs-circle me-1'></i> Rejeter
                                    </div>
                                @endif
                            </td>
                            <td>
                                {{ number_format($facture->prestationLines->sum('totalLigne'), 0, ',', ' ') }}
                            </td>

                            <td @if($facture->statut !== 'payed' && Carbon\Carbon::parse($facture->date_echeance)->isPast()) class="text-danger" @endif>
                                {{ Carbon\Carbon::parse($facture->date_echeance)->format('d/m/Y') ?? 'N/A' }}
                            </td>

                            <td>
                                <div class="d-flex order-actions">

                                    <a href="{{ route('admin.facturation.show', $facture->uuid) }}" class="bg-transparent"><i class='bx bxs-show'></i></a>
                                   
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
