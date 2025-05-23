@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3 text-uppercase">Facturation</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total factures</p>
                            <h4 class="my-1 size_12">{{ number_format($valeur_global_facture, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-success size_12"><i class="bx bxs-up-arrow align-middle"></i>{{ $facture_count }} Factures</p>
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
                            <p class="mb-0 text-secondary">Envoyé au Beneficiaire</p>
                            <h4 class="my-1 size_12">{{ number_format($valeur_totalFactSend, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-info size_12"><i class='bx bxs-up-arrow align-middle'></i>{{ $totalFactSend }} Factures</p>
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
                            <p class="mb-0 text-secondary">Facture payé</p>
                            <h4 class="my-1 size_12">{{ number_format($valeur_totalFactPay, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-success size_12"><i class='bx bxs-down-arrow align-middle'></i>{{ $totalFactPay }} factures</p>
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
                            <p class="mb-0 text-secondary ">Factures échues non réglées</p>
                            <h4 class="my-1 size_12">{{ number_format($valeur_factureEchu, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-danger size_12"><i class='bx bxs-down-arrow align-middle'></i>{{ $factureEchuCount}} factures</p>
                        </div>
                        <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-line-chart-down'></i>
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
                            <p class="mb-0 text-secondary ">Total Debours</p>
                            <h4 class="my-1 size_12">{{ number_format($valeurTotalDebou, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-info size_12"><i class='bx bxs-down-arrow align-middle'></i>{{ $totalFactDebou}} Debours</p>
                            
                        </div>
                        <div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bx-line-chart-down'></i>
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
                            <p class="mb-0 text-secondary ">Total Prestations</p>
                            <h4 class="my-1 size_12">{{ number_format($valeurTotalPrestation, 0, ',', ' ') }} Fcfa</h4>
                            <p class="mb-0 font-13 text-info size_12"><i class='bx bxs-down-arrow align-middle'></i>{{ $totalFactPrestation}} Prestation</p>
                            
                            
                        </div>
                        <div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bx-line-chart-down'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">

              <div class="ms-auto" data-bs-toggle="modal" data-bs-target="#addFactureModal">
                <button class="btn btn-primary radius-30"><i class="bx bxs-plus-square"></i>Nouvelle facture</button>
              </div>
            </div>

            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>N°</th>
                            <th>N° Bl</th>
                            <th>Beneficiaire</th>
                            <th>Date Facture</th>
                            <th>Statut</th>
                            <th>Nbr d'articles</th>
                            <th>Tva</th>
                            <th class="text-end">Total ht <sup>XOF</sup></th>
                            <th class="text-end">Total ht <sup>€</sup></th>
                            <th>Date Echeance</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($refacturations as $item )

                        @php
                            $fac_pres = DB::table('facture_prestations')->where('etat', 'actif')->where('facture_uuid', $item->uuid)->sum('total');

                            // $exchangeRate = 0.00152;
                            

                            $prestations_totalsS = DB::table('facture_prestations')->where(['facture_uuid'=>$item->uuid])->where(['type_prestation'=>'prestation'])->where(['etat'=>"actif"])->sum('total');
                            $prestations_totals_debours = DB::table('facture_prestations')->where(['facture_uuid'=>$item->uuid])->where(['type_prestation'=>'debours'])->where(['etat'=>"actif"])->sum('total');
                            $com = 1.95;
                            $comm_debours = $prestations_totals_debours * $com;
                            $comm_sous_debours = ($comm_debours / 100);

                            $tvaPerCent = $item->tva;
                            $prestations_totals = $prestations_totalsS + $comm_sous_debours;
                            $tva = ($prestations_totals * $tvaPerCent) / 100;
                            $total_ht = ($prestations_totals + $prestations_totals_debours);
                            $total_xof = ($total_ht + $tva);
                            $euroAmount = $total_xof / $exchangeRate;
                        @endphp  
                        <tr>
                            <td>
                                {{ $item->num_facture ?? 'N/A'}}
                            </td>
                            <td>{{ $item->num_Bl ?? 'N/A' }}</td>
                            <td>{{ $item->doit ?? 'N/A' }}</td>
                            <td>
                                {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') ?? 'N/A' }}
                            </td>
                            <td>
                                @if ($item->statut == 'draft')
                                <div
                                    class="badge rounded-pill text-light bg-primary p-2 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Brouillon
                                </div>
                                @endif
                                @if ($item->statut == 'sendToClient')
                                <div
                                    class="badge rounded-pill text-light bg-danger p-2 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i>Envoyé
                                </div>
                                @endif
                                @if ($item->statut == 'payed')
                                <div
                                    class="badge rounded-pill text-light bg-gradient-quepal p-2 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Payé
                                </div>
                                @endif
                                @if ($item->statut == 'canceled')
                                <div
                                    class="badge rounded-pill text-light bg-gradient-blooker p-2 text-uppercase px-3">
                                    <i class='bx bxs-circle me-1'></i> Rejeté
                                </div>
                                @endif
                            </td>
                            <td>{{ $item->nbr_product ?? '--' }}</td>
                            <td>{{ $item->tva ?? '--'}}%</td>
                            <td class="text-end">{{ number_format($total_xof) ?? 'N/A'  }}</td>
                            <td class="text-end">{{ number_format($euroAmount) ?? 'N/A'  }}</td>

                            <td @if($item->statut !== 'payed' && Carbon\Carbon::parse($item->date_echeance)->isPast()) class="text-danger" @endif>
                                {{ Carbon\Carbon::parse($item->date_echeance)->format('d/m/Y') ?? 'N/A' }}
                            </td>

                            <td>
                                <i class="bx bx-comment text-primary cursor-pointer" title="{{ $item->comment ?? 'N/A' }}"></i>
                            </td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href="{{ route('admin.refacturation.show', $item->uuid) }}"
                                        style="cursor: pointer"><i class="lni lni-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.refacturation.edit', $item->uuid)}}" class="mx-3">
                                        <i class='bx bxs-edit'></i>
                                    </a>

                                    <a class=" deleteConfirmation" data-uuid="{{$item->uuid}}"
                                        data-type="confirmation_redirect" data-placement="top"
                                        data-token="{{ csrf_token() }}"
                                        data-url="{{route('admin.refacturation.destroy',$item->uuid)}}"
                                        data-title="Vous êtes sur le point de supprimer {{$item->code}} "
                                        data-id="{{$item->uuid}}" data-param="0"
                                        data-route="{{route('admin.refacturation.destroy',$item->uuid)}}"><i
                                            class='bx bxs-trash' style="cursor: pointer"></i>
                                    </a>
                                </a>
                                </div>
                            </td>
                        </tr>
                        @include('admin.refacturation.editFactureModal')
                        @empty
                        <tr>Aucune Facture enregistré</tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.refacturation.addFactureModal')

</div>
@endsection