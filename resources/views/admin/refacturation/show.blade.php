@extends('admin.layouts.admin')
@section('section')


<!--start page wrapper -->
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3 text-uppercase">Refacturation</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="/admin/home"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Facture Fournisseur</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm rounded my-auto text-white">
                    <a href="{{route('admin.refacturation.downloadPDF', $refacturation->id)}}"
                        class="text-center text-decoration-none text-white"><i class="bx bxs-file-pdf"></i> Export PDF</a>
                </button>
                {{-- <form action="{{route('admin.refacturation.marckToSend', $refacturation->uuid)}}" method="post" class="submitForm">
                    @csrf
                        <button class="btn btn-primary btn-sm rounded  ms-2 my-auto text-white" type="submit"><i class="bx bxs-envelope"></i>Marqué comme Envoyé</button>
                </form> --}}

                <button class="btn btn-primary btn-sm rounded  ms-2 my-auto text-white" data-bs-toggle="modal" data-bs-target="#addSendMail{{ $refacturation->id }}"><i class="bx bxs-envelope"></i>Envoyer</button>


                <form action="{{route('admin.refacturation.marckToPayed', $refacturation->uuid)}}" method="post" class="submitForm">
                    @csrf
                        <button class="btn btn-primary btn-sm rounded  ms-2 my-auto text-white" type="submit"><i class='bx bxs-wallet'></i>Marqué comme Payé</button>
                </form>
                <form action="{{route('admin.refacturation.marckToConceled', $refacturation->uuid)}}" method="post" class="submitForm">
                    @csrf
                    <button class="btn btn-primary btn-sm rounded  ms-2 my-auto text-white" type="submit"><i class='bx bxs-x-circle'></i>Marqué comme Annulé</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="invoice">

                <div class="invoice overflow-auto">
                    <div style="min-width: auto ;">
                        <div>
                            <h3>
                                @if ($refacturation->statut == 'draft')
                                <div class="badge size_12 rounded-pill text-light bg-primary text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Brouillon
                                </div>
                                @endif
                                @if ($refacturation->statut == 'sendToClient')
                                <div class="badge size_12 rounded-pill text-light bg-danger text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i>Envoyé
                                </div>
                                @endif
                                @if ($refacturation->statut == 'payed')
                                <div
                                    class="badge size_12 rounded-pill text-light bg-gradient-quepal text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Payé
                                </div>
                                @endif
                                @if ($refacturation->statut == 'canceled')
                                <div
                                    class="badge size_12 rounded-pill text-light bg-gradient-blooker text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Rejeter
                                </div>
                                @endif
                            </h3>
                        </div>
                        <header>
                            <div class="row">
                                <div class="col">
                                    <img src="{{ asset('assets/images/logo_jalo.jpg') }}" style="width:100px"
                                        class="logo-icon" alt="logo icon">
                                </div>
                                <div class="col company-details">
                                    <div class="col company-details size_14">
                                        <dl class="row col-12">
                                            <dt class="col-sm-8 text-end">N° DE FACTURE :</dt>
                                            <dd class="col-sm-4 text-start">{{ $refacturation->num_facture ?? 'N/A' }}</dd>
                                        </dl>
                                        <dl class="row col-12">
                                            <dt class="col-sm-8 text-end">DATE :</dt>
                                            <dd class="col-sm-4 text-start">{{ $refacturation->created_at->format('d/m/Y') ?? 'N/A' }}</dd>
                                        </dl>
                                        <dl class="row col-12">
                                            <dt class="col-sm-8 text-end">RÉF CLIENT :</dt>
                                            <dd class="col-sm-4 text-start">{{ $refacturation->refClient ?? 'N/A' }}</dd>
                                        </dl>
                                        <dl class="row col-12">
                                            <dt class="col-sm-8 text-end">DOIT :</dt>
                                            <dd class="col-sm-4 text-start">{{ $refacturation->doit ?? 'N/A' }}</dd>
                                        </dl>
                                        <dl class="row col-12">
                                            <dt class="col-sm-8 text-end">ADRESSE COMPLETE :</dt>
                                            <dd class="col-sm-4 text-start">{{ $refacturation->adresseComplete ?? 'N/A' }}</dd>
                                        </dl>
                                        <dl class="row col-12">
                                            <dt class="col-sm-8 text-end">N° CC :</dt>
                                            <dd class="col-sm-4 text-start">{{ $refacturation->num_cc ?? 'N/A' }}</dd>
                                        </dl>

                                    </div>
                                </div>
                            </div>
                        </header>
                        <main>
                            <div class="row contacts">
                                <div class="col invoice-to">

                                    <dl class="row col-12 text-gray-light">
                                        <dt class="col-sm-8 text-end">DÉSIGNATION :</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->designation ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12 text-gray-light">
                                        <dt class="col-sm-8 text-end">N° BL :</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->num_Bl ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12 text-gray-light">
                                        <dt class="col-sm-8 text-end">NAVIRE/VOYAGE :</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->navire ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12 text-gray-light">
                                        <dt class="col-sm-8 text-end">DESTINATON :</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->destination ?? 'N/A' }}</dd>
                                    </dl>
                                </div>

                                <div class="col invoice-details">
                                    <dl class="row col-12">
                                        <dt class="col-sm-8 text-end">AMATEUR:</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->amateur ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12">
                                        <dt class="col-sm-8 text-end">N° DOSSIER JALÔ:</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->num_Dossier ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12">
                                        <dt class="col-sm-8 text-end">N° OT:</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->num_Ot ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12">
                                        <dt class="col-sm-8 text-end">VOLUME/POIDS:</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->volume ?? 'N/A' }}</dd>
                                    </dl>
                                </div>

                                <div class="col invoice-details">
                                    <dl class="row col-12">
                                        <dt class="col-sm-8 text-end">POL:</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->pol ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12">
                                        <dt class="col-sm-8 text-end">POD:</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->pod ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12">
                                        <dt class="col-sm-8 text-end">RÉGIME:</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->regime ?? 'N/A' }}</dd>
                                    </dl>
                                    <dl class="row col-12">
                                        <dt class="col-sm-8 text-end">NOMBRE DE MARCHANDISES:</dt>
                                        <dd class="col-sm-4 text-start">{{ $refacturation->nbr_product ?? 'N/A' }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <br>
                            <table>
                                <thead class
                                ="bg-dark">
                                    <tr class="bg-dark text-black text-center">
                                        <th>ID FACTURIER</th>
                                        <th class="text-center">POSTE</th>
                                        <th class="text-center">CONDITION DE PAIEMENT</th>
                                        <th class="text-center">DATE D'ECHEANCE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="size_12 text-center">
                                        @if (!empty($user))
                                            <td class="">{{ $user->name.' '.$user->lastname }}</td>
                                        @endif
                                        <td class="text-dark">{{ $refacturation->poste_occuper ?? 'N/A'}}
                                        </td>
                                        <td class="text-center">{{ $refacturation->condition_paiement ?? 'N/A' }}</td>
                                        <td class="">{{ $refacturation->date_echeance ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">DESCRIPTION</th>
                                        <th class="text-right text-end">PRIX UNITAIRE</th>
                                        <th class="text-right text-end">QTE</th>
                                        <th class="text-right text-end">Total (XOF)</th>
                                        <th class="text-right text-end">Total (€)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse ($prestations_debours as $prestations_debour)
                                    <tr>
                                        <td class="no">{{ $loop->iteration }}</td>
                                        <td class="text-left">
                                            <h3>
                                                <a target="_blank" href="javascript:;">
                                                    {{ $prestations_debour->type_prestation ?? 'N/A'}}
                                                </a>
                                            </h3>
                                            {{ $prestations_debour->description ?? 'N/A'  }}
                                        </td>
                                        <td class="unit">{{ $prestations_debour->prixunitaire ?? 'N/A' }}</td>
                                        <td class="qty">{{ $prestations_debour->qty ?? 'N/A' }}</td>
                                        <td class="total">{{ $prestations_debour->total ?? 'N/A' }} XOF</td>
                                        <td class="total">{{ $prestations_debour->total / $exchangeRate ?? 'N/A' }} €</td>
                                    </tr>
                                    @empty
                                    <tr>Aucune prestation enregistré</tr>
                                    @endforelse


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">SOUS TOTAL DEBOURS</td>
                                        <td>{{ number_format($prestations_totals_debours)}} XOF</td>
                                        <td>{{ number_format($prestations_totals_debours / $exchangeRate)}} €</td>
                                    </tr>

                                    <tr class="">
                                        <td class="no"></td>
                                        <td class="text-left">
                                            COMMISSION SUR DEBOURS
                                        </td>
                                        <td class="unit">1,95%</td>
                                        <td class="qty">1</td>
                                        <td class="total">{{ $comm_sous_debours ?? 'N/A' }} XOF</td>
                                        <td class="total">{{ $comm_sous_debours / $exchangeRate ?? 'N/A' }} €</td>
                                    </tr>

                                    @forelse ($prestations as $item )
                                    <tr>
                                        <td class="no">{{ $loop->iteration}}</td>
                                        <td class="text-start">
                                            <h3>
                                                <a target="_blank" href="javascript:;">
                                                    {{ $item->type_prestation ?? 'N/A'}}
                                                </a>
                                            </h3>
                                            {{ $item->description ?? 'N/A'  }}
                                        </td>
                                        <td class="unit">{{ $item->prixunitaire ?? 'N/A' }}</td>
                                        <td class="qty">{{ $item->qty ?? 'N/A' }}</td>
                                        <td class="total">{{ $item->total ?? 'N/A' }} XOF</td>
                                        <td class="total">{{ $item->total / $exchangeRate ?? 'N/A' }} €</td>
                                    </tr>
                                    @empty
                                    <tr>Aucune prestation enregistré</tr>
                                    @endforelse


                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">SOUS TOTAL DE PRESTATION</td>
                                        <td>{{ number_format($prestations_totals)}} XOF</td>
                                        <td>{{ number_format($prestations_totals / $exchangeRate)}} €</td>
                                    </tr>

                                    {{-- <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2"></td>
                                        <td></td>
                                    </tr> --}}

                                    <tr class="mt-4">
                                        <td colspan="2"></td>
                                        <td colspan="2">TVA</td>
                                        <td>{{ number_format($tva)}}</td>
                                        <td>{{ number_format($tva / $exchangeRate)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">TOTAL HT</td>
                                        <td>{{ number_format($total_ht)}} XOF</td>
                                        <td>{{ number_format($total_ht / $exchangeRate)}} €</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">TOTAL</td>
                                        <td>{{ number_format($total_xof)}} XOF</td>
                                        <td>{{ number_format($total_xof / $exchangeRate, 2, ',', ' ') }} €</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!--<div class="thanks">Thank you!</div>-->
                            <hr>
                            <br>
                            <div class="notices">
                                <div class="notice size_12" style="text-align : center;">OIBP 8169 ABIDJAN, COCODY Deux Plateaux
                                    Rue des Jardins, Côte d'Ivoire. SAS au Capital de 200 000 000 FCFA Régime
                                    d'imposition : Réel Normal Direction Des Grandes Entreprises (DGE), RCCM N°
                                    CI-ABJ-03-2023-B16-00087 COFINA N° CI93 CI201 01001 109046290985 21 ECOBANK CI93
                                    CI05 9010 5612 1686 9560 0148</div>
                            </div>
                        </main>
                        <!--<footer>Invoice was created on a computer and is valid without the signature and seal.</footer>-->
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.refacturation.sendMail', ['refacturation' => $refacturation])
</div>
<!--end page wrapper -->


@endsection
