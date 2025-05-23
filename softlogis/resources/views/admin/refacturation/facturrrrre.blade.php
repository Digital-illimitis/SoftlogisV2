<!DOCTYPE html>
<html lang="fr">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
<title>SoftLogis : Refacturation</title>

<body>
    <div class="container">
        <!--start page wrapper -->
        <div class="page-content">
            <style>
                .header {
                    height: 60px;
                    width: 100%;
                    padding: 10px 0;
                    justify-content: center;
                    align-items: center;
                    align-self: center;
                }

                .footer {
                    height: auto;
                    width: 100%;
                    padding: 10px 0;
                    justify-content: center;
                    align-items: center;
                    align-self: center;
                }

                .content-logo {
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    align-items: center;
                    align-self: center;
                    margin-top: 20px;
                    padding-left: 20px;
                    padding-right: 20px;
                    color: #fff;
                }

                .uppercase {
                    text-transform: uppercase;
                    font-size: 15px;
                }

                .size_12 {
                    font-size: 11px;
                }

                .spacer_gap {
                    margin-top: 3px;
                    margin-bottom: 0px;
                    /* border: 1px solid red; */
                }

                .table tbody td {
                    border-bottom: 1px solid #ccc;
                }

            </style>
            <div class="container">
                <div class="header" style="background-color: rgba(0, 0, 0, 0.773);">
                    <div class="content-logo row ">
                        <div class="col">
                            <img src="{{ asset('assets/images/logo_jalo.jpg') }}" style="width:100px" class="logo-icon"
                                alt="logo icon">
                        </div>
                        <div class="col">FACTURE</div>
                    </div>
                    <div style="margin-top: 35px; margin-left: 20px;">
                        <div style="text-transform: uppercase;">jalo Logistics</div>
                        <p style="margin-top: 0;" class="size_12">La Logistique Autrement</p>
                    </div>

                </div>

                <div class="col-4 content-logo" style="margin-top: 30px;">
                    <div class="col"></div>
                    <div class="col" style="color: black; margin-left: 30px;">
                        <p class="uppercase"><span style="font-weight: bold;">N° De Facture :</span> <span
                                class="size_12">{{ $refacturation->num_facture ?? 'N/A' }}</span></p>
                        <p class="uppercase"><span style="font-weight: bold;">Date :</span> <span
                                class="size_12">{{ $refacturation->created_at->format('d/m/Y') ?? 'N/A' }}</span></p>
                        <p class="uppercase"><span style="font-weight: bold;">Ref Client :</span> <span class="size_12">
                                {{ $refacturation->refClient ?? 'N/A' }}</span></p>
                    </div>
                    <div class="col" style="color: black;">
                        <p class="uppercase"><span style="font-weight: bold;">Doit :</span> <span
                                class="size_12">{{ $refacturation->doit ?? 'N/A' }}</span></p>
                        <p class="uppercase"><span style="font-weight: bold;">adresse complete :</span> <span
                                class="size_12">{{ $refacturation->adresseComplete ?? 'N/A' }}</span></p>
                        <p class="uppercase"><span style="font-weight: bold;">N° Dossier :</span> <span
                                class="size_12">{{ $refacturation->num_cc ?? 'N/A' }}</span></p>
                    </div>
                </div>
                <hr style="margin-top: 20px; width: 80%;">

                <div class="container">
                    <div class="row content-logo">
                        <div class="col" style="color: black;">
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">Designation :</span> <span
                                    class="size_12">{{ $refacturation->designation ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">N° Commande :</span> <span
                                    class="size_12">{{ $refacturation->num_Commande ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">N° BLs :</span> <span
                                    class="size_12">{{ $refacturation->num_Bl ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">Navire/Voyage :</span>
                                <span class="size_12">{{ $refacturation->navire ?? 'N/A' }}</span></p>
                        </div>
                        <div class="col" style="color: black;">
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">Destination :</span> <span
                                    class="size_12">{{ $refacturation->destination ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">N° Dossier :</span> <span
                                    class="size_12">{{ $refacturation->num_Dossier ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">N° Ot :</span> <span
                                    class="size_12">{{ $refacturation->num_Ot ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">Amateur/ consignataire
                                    :</span> <span class="size_12">{{ $refacturation->amateur ?? 'N/A' }}</span></p>
                        </div>
                        <div class="col" style="color: black;">
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">Poids :</span> <span
                                    class="size_12">{{ $refacturation->volume ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">pol :</span> <span
                                    class="size_12">{{ $refacturation->pol ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span class="" style="font-weight: bold;">Pod :</span> <span
                                    class="size_12">{{ $refacturation->pod ?? 'N/A' }}</span></p>
                            <p class="uppercase spacer_gap"><span style="font-weight: bold;">Regime :</span> <span
                                    class="size_12">{{ $refacturation->regime ?? 'N/A' }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="container" style="margin-top: 25px;">
                    <div class="content-title">
                        <table class="table" style="width: 100%;">
                            <thead class="uppercase size_12" style="background: #000; color: #fff;">
                                <tr>
                                    <th class="id">ID Facturier</th>
                                    <th class="poste">Poste</th>
                                    <th class="condition-paiement">Condition de Paiement</th>
                                    <th class="date-echeance">Date d'échéance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="id">{{ $user->name.' '.$user->lastname}}</td>
                                    <td class="poste">{{ $refacturation->poste_occuper ?? 'N/A' }}</td>
                                    <td class="condition-paiement">{{ $refacturation->condition_paiement ?? 'N/A' }}
                                    </td>
                                    <td class="date-echeance">{{ $refacturation->date_echeance ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="content-prestation" style="margin-top: 29px;">
                <table class="table" style="width: 100%;">
                    <thead class="uppercase size_12" style="background: #000; color: #fff;">
                        <tr>
                            <th class="id">Nature Prestation</th>
                            <th class="poste">QTE</th>
                            <th class="condition-paiement">Description</th>
                            <th class="date-echeance">Prix Unitaire</th>
                            <th class="date-echeance">Total Ligne (XOF)</th>
                            <th class="date-echeance">---- (€)</th>
                        </tr>
                    </thead>
                    @php $exchangeRate = 0.00152; @endphp
                    <tbody>
                        @forelse ($prestations_debours as $prestations_debour)
                        <tr>
                            <td class="id">{{ $prestations_debour->type_prestation ?? 'N/A'}}</td>
                            <td class="poste">{{ $prestations_debour->qty ?? 'N/A' }}</td>
                            <td class="condition-paiement">{{ $prestations_debour->description ?? 'N/A'  }}</td>
                            <td class="date-echeance">{{ $prestations_debour->prixunitaire ?? 'N/A' }}</td>
                            <td class="date-echeance">{{ $prestations_debour->total ?? 'N/A' }}</td>
                            <td class="date-echeance">{{ $prestations_debour->total * $exchangeRate ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>Aucune prestation enregistré</tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="content-logo" style="height: 20px; color: #000; background: #ccc;">
                    <div class="col-8 uppercase" style="width: 52%; justify-content: center;">Sous total debours</div>
                    <div class="col-2" style="justify-content: end; align-items: end;">
                        {{ number_format($prestations_totals_debours)}}</div>
                    <div class="col-2">{{ number_format($prestations_totals_debours * $exchangeRate)}}</div>
                </div>
                <table class="table" style="width: 100%; margin-top: 10px;">
                    <thead class="uppercase size_12" style="background: #000; color: #fff;">

                    </thead>
                    <tbody>
                        @forelse ($prestations as $item )
                        <tr style="display: flex; flex-direction: row; width: 100%;">
                            <td class="id col" style="width: 30%;">{{ $item->type_prestation ?? 'N/A'}}</td>
                            <td class="poste col" style="width: 10%;">{{ $item->qty ?? 'N/A' }}</td>
                            <td class="condition-paiement col" style="width: 15%;">{{ $item->description ?? 'N/A'  }}
                            </td>
                            <td class="date-echeance col" style="width: 25%;">{{ $item->prixunitaire ?? 'N/A' }}</td>
                            <td class="date-echeance col" style="width: 18%;">{{ $item->total ?? 'N/A' }}</td>
                            <td class="date-echeance col" style="width: 15%; display: flex; justify-content: end;">
                                {{ $item->total * $exchangeRate ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>Aucune prestation enregistré</tr>
                        @endforelse
                        <tr style="display: flex; flex-direction: row; width: 100%;">
                            <td class="id col" style="width: 30%;">PRESTATION</td>
                            <td class="poste col" style="width: 10%;">1</td>
                            <td class="condition-paiement col" style="width: 15%;">COMMISSION SUR DEBOURS</td>
                            <td class="date-echeance col" style="width: 25%;">1,95%</td>
                            <td class="date-echeance col" style="width: 18%;">{{ $comm_sous_debours ?? 'N/A' }}</td>
                            <td class="date-echeance col" style="width: 15%; display: flex; justify-content: end;">
                                {{ $comm_sous_debours * $exchangeRate ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="content-logo" style="height: 20px; color: #000; background: #ccc;">
                <div class="col-8 uppercase" style="width: 52%; justify-content: center;">Sous total Prestation</div>
                <div class="col-2" style="justify-content: end; align-items: end;">
                    {{ number_format($prestations_totals)}}</div>
                <div class="col-2">{{ number_format($prestations_totals * $exchangeRate)}}</div>
            </div>

            <hr>
            <div class="row" style="display: flex; flex-direction: row;">
                <div class="col-6" style="width: 50%;"></div>

                <div class="col-6" style="width: 50%; display: flex; flex-direction: row; justify-content: end;">
                    <div class="col" style="
                    width: 100%;">
                        <p style="font-weight: bold; display: flex; justify-content: space-between;">
                            <span>TVA</span> <span
                                style="margin: 0 15px;">{{ number_format($tva)}}</span><span>{{ number_format($tva * $exchangeRate)}}</span>
                        </p>
                        <div style="background-color: #ccc; min-height: 50px; width: 100%;">
                            <p style="font-weight: bold; display: flex; justify-content: space-between;">
                                <span>TOTAL HT</span> <span
                                    style="margin: 0 15px;">{{ number_format($total_ht)}}</span><span>{{ number_format($total_ht * $exchangeRate)}}</span>
                            </p>
                            <p style="font-weight: bold; display: flex; justify-content: space-between;">
                                <span>TOTAL XOF</span> <span
                                    style="margin: 0 15px;">{{ number_format($total_xof)}}</span><span>{{ number_format($total_xof * $exchangeRate)}}</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container" style="margin-top: 15px; ">
                <div class="footer" style="background-color: rgba(0, 0, 0, 0.773);">
                    <div class="content-logo row size_12"
                        style="padding: 0 40px; display: flex; justify-content: center; align-items: center; align-self: center; text-align: center;">
                        01BP 8169 ABIDJAN 01, COCODY Deux Plateaux Rue des Jardins, Cote d'ivoire. SAS au capital de 200
                        000 000 CFA
                        Régime d'imposition : Réel Normal Direction des Grandes Entreprises. (DGE), RCCM N°
                        CI-ABJ-03-2023-B16-00087
                        COFINA N° CI201 01001 109046290985 21 ECOBANK CI93 CI05 9010 5612 1686 9560 0148
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div></div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>

</html>
