@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Facturation</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div id="invoice">
                <div class="toolbar hidden-print row">
                    <div class="col-sm-12 col-md-6 col-lg-6 text-start">

                            @if ($facture->statut == 'reccording')
                                <div class="badge rounded-pill text-white bg-secondary py-2 size_14 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Enregistrement
                                </div>
                            @endif
                            @if ($facture->statut == 'good_pay')
                                <div class="badge rounded-pill text-info bg-light-info py-2 size_14 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Bon à Payer
                                </div>
                            @endif
                            @if ($facture->statut == 'payed')
                                <div class="badge rounded-pill text-success bg-light-success py-2 size_14 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Payé
                                </div>
                            @endif
                            @if ($facture->statut == 'cancel')
                                <div class="badge rounded-pill text-danger bg-light-danger py-2 size_14 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Rejeter
                                </div>
                            @endif

                    </div>

                    <div class="text-end col-sm-12 col-md-6 col-lg-6">
                        @if ($facture->statut == 'reccording')
                        <div class="size_14 text-uppercase text-center btn">
                            <form action="{{ route('admin.marck_to_good_pay', $facture->uuid) }}" method="post" enctype="multipart/form-data" class="submitForm">
                                @csrf
                                <button type="submit" class="btn btn-primary" onclick="return confirmSubmission(event)">Bon à Payer</button>
                            </form>
                        </div>
                        @endif
                        @if ($facture->statut == 'good_pay')
                        @can('Payer Facture')
                        <div class="size_14 text-uppercase btn text-center">
                            <form action="{{ route('admin.marck_payed', $facture->uuid) }}" method="post" enctype="multipart/form-data" class="submitForm mx-0 px-0">
                                @csrf
                                <button type="submit" class="btn btn-success px-3" onclick="return confirmSubmission(event)">Payer</button>
                            </form>
                        </div>
                        @endcan
                        @endif
                        @if ($facture->statut !== 'payed')
                        <div class="size_14 text-uppercase text-center btn mx-0 px-0">
                            <form action="{{ route('admin.marck_canceled', $facture->uuid) }}" method="post" enctype="multipart/form-data" class="submitForm">
                                @csrf
                                <button type="submit" class="btn btn-danger custom-button" onclick="return confirmSubmission(event)">Rejeter</button>
                            </form>
                        </div>
                        @endif
                        <div class="size_14 text-uppercase btn text-center">
                            {{-- <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#docModal{{ $facture->uuid }}"><i class='bx bxs-file-pdf text-white me-2 font-24' ></i>Facture Original</button> --}}
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#factureListModal{{ $facture->uuid }}"><i class='bx bxs-file-pdf text-white me-2 font-24' ></i>Facture Original <sup class="badge rounded-pill bg-info text-white"> @if ($facture->factureDoc->count() > 0) {{ $facture->factureDoc->count() }} @endif</sup></button>
                        </div>
                        <div class="modal fade" id="factureListModal{{ $facture->uuid }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Facture Chargée</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        @foreach ($facture->factureDoc as $item)
                                        <div class="row mt-2 align-items-center">
                                            <div class="col-2"><span class="no">{{ $loop->iteration }}</span></div>
                                            <div class="col-10 d-flex align-items-center">
                                                <button class="me-2">
                                                    <a href="{{ asset('files/' . $item->file_path) }}" target="_blank"><i class='bx bxs-download text-white size_12 mx-2'></i> Télécharger</a>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                        <hr style="width: 100%;" class="my-2">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>
                <div class="invoice overflow-auto">
                    <div style="min-width: 600px">
                        <header>
                            <div class="row">
                                <div class="col">
                                    <a href="javascript:;">

                                        @if ($facture->typeFacture == 'transitaire')
                                        @if ($facture->transporteur != null)
                                        <img src="{{ asset('files/' . $facture->transitaire->logo) }}" width="80" alt="" />
                                        @else
                                            <img src="{{ asset('assets/images/logo.png') }}" width="80" alt="" />
                                        @endif
                                        @elseif ($facture->typeFacture == 'transporteur')
                                            @if ($facture->transporteur != null)
                                                <img src="{{ asset('files/' . $facture->transporteur->logo) }}" width="80" alt="" />
                                            @else
                                                <img src="{{ asset('assets/images/logo.png') }}" width="80" alt="" />
                                            @endif
                                        @endif
                                    </a>
                                </div>
                                <div class="col company-details">
                                    <div class="text-gray-light size_12 my-0 py-0">Enregistrer par:</div>
                                    @if (!empty($facture->create_By))
                                    <h2 class="name">
                                        <a target="" href="javascript:;" class="size_16">
                                            {{ $facture->create_By->name.' '.$facture->create_By->lastname }}
                                        </a>
                                    </h2>
                                    <div>{{ $facture->create_By->email ?? 'N/A' }}</div>
                                    @endif
                                    <div>{{ $facture->created_at->diffForHumans() }}</div>

                                </div>
                            </div>
                        </header>
                        <main>
                            <div class="row contacts">

                                @if ($facture->typeFacture == 'transitaire')
                                    <div class="col invoice-to">
                                        <div class="text-gray-light">Beneficiaire:</div>
                                        <h2 class="to">{{ $facture->transitaire->raison_sociale ?? 'N/A' }}</h2>
                                        <div class="email"><a href="mailto:{{ $facture->transitaire->email ?? 'N/A' }}">{{ $facture->transitaire->email ?? 'N/A' }}</a>
                                        <div class="address">{{ $facture->transitaire->localisation ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                @elseif ($facture->typeFacture == 'transporteur')
                                    <div class="col invoice-to">
                                        <div class="text-gray-light">Beneficiaire:</div>
                                        <h2 class="to">{{ $facture->transporteur->raison_sociale ?? 'N/A' }}</h2>
                                        <div class="email"><a href="mailto:{{ $facture->transporteur->email ?? 'N/A' }}">{{ $facture->transporteur->email ?? 'N/A' }}</a>
                                        <div class="address">{{ $facture->transporteur->localisation ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col invoice-details">
                                    <h1 class="invoice-id">{{ $facture->numFacture }}</h1>
                                    <div class="date">Date d'enregistrement: {{ $facture->created_at->format('d/m/Y') }}</div>
                                    <div class="date">Date d'echeance: {{ Carbon\Carbon::parse($facture->date_echeance)->format('d/m/Y') ?? 'N/A' }}</div>
                                </div>
                            </div>

                            <table>
                                <thead>
                                    <tr class="text-end">
                                        <th>#</th>
                                        <th class="text-left">RUBRIQUE</th>
                                        <th class="text-right">Prix Unitaire (Fcfa)</th>
                                        <th class="text-right">Quantité</th>
                                        <th class="text-right">Total ligne (Fcfa)</th>
                                        <th class="text-right">Total ligne (Euro)</th>
                                    </tr>
                                </thead>

                                <tbody class="size_12">
                                    @foreach ($facture->prestationLines->where('etat', 'actif') as $prestationLine)
                                    <tr>
                                        <td class="no">{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $prestationLine->rubrique ?? 'N/A' }}</td>
                                        <td class="unit">{{ number_format($prestationLine->prixUnitaire, 0, ',', ' ') ?? 'N/A' }}</td>
                                        <td class="qty">{{ $prestationLine->qty ?? 'N/A' }}</td>
                                        <td class="total">{{ number_format($prestationLine->totalLigne, 0, ',', ' ') ?? 'N/A' }}</td>
                                        <td class="total">{{ number_format($prestationLine->totalLigne / 655.900, 0, ',', ' ') ?? 'N/A' }}</td>
                                    </tr>

                                    @endforeach

                                </tbody>
                                <tfoot class="text-end w-25">
                                    @php
                                        $valeurEnEuros = $facture->prestationLines->sum('totalLigne') /  $taux->valeur;
                                        $valeurEnEurosFormattee = number_format($valeurEnEuros, 0, ',', ' ');
                                    @endphp
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">TOTAL</td>
                                        <td>{{ number_format($facture->prestationLines->where('etat', 'actif')->sum('totalLigne'), 0, ',', ' ') }} <span>  Fcfa</span></td>
                                        <td>{{ $valeurEnEurosFormattee}} <span class="st-icon-pandora"> Euro</span></td>
                                    </tr>
                                </tfoot>


                            </table>

                            <div class="notices">
                                <div>Note:</div>
                                <div class="notice">{{ $facture->note }}</div>
                            </div>
                        </main>
                        <footer>La facture a été créée sur un ordinateur et est valable sans signature ni sceau.</footer>
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div></div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function confirmSubmission(event) {
        let confirmation = confirm("Êtes-vous certain(e) de vouloir procéder à cette étape ?");
        
        if (!confirmation) {
            event.preventDefault(); // Bloque la soumission
            return false;
        }
        
        return true; // Continue la soumission si "OK"
    }
</script>
@endsection
