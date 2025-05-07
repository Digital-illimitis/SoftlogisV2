<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>SoftLogis : Refacturation</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <style>
        html, body {
            /* height: 90%; */
            margin: 0;
            padding: 0;
        }
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            text-decoration: uppercase;
            text-transform: uppercase;
            /* border: 1px solid red; */
        }

        .footer {
            background-color: rgba(0, 0, 0, 0.773);
            padding: 10px;
            text-align: center;
            color: #fff;
        }
        .header {
            height: 40px;
            width: 100%;
            padding: 10px 0;
            justify-content: center;
            align-items: center;
            align-self: center;
        }
        /* .footer {
            height: auto;
            width: 100%;
            justify-content: center;
            align-items: center;
            align-self: center;
        } */
        .content-logo {
            display: inline-block;
            flex-direction: row;
            /* justify-content: space-between; */
            align-items: center;
            align-self: center;
            margin-top: 10px;
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

        tbody td {
            border-bottom: 1px solid lightgray;
        }
        .table td {
            border-bottom: 1px solid lightgray;
        }
         th > div{
            margin-bottom: 3px;
         }

    </style>
</head>

<body>
    <div class="container">
        <!--start page wrapper -->
        <div class="page-content">
            <!--breadcrumb-->

            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body" style="min-height: 92vh; height: 92%;">
                    <div id="invoice">
                        <div class="invoice overflow-auto">
                            <div>
                                <div class="header" style="background-color: rgba(0, 0, 0, 0.773);">
                                    <div class="content-o row" style="width: 100% ;margin-bottom: 0px ; padding: 0 10px;">
                                        <div class="col" style="min-width: 100px">
                                            <img src="{{ asset('assets/images/logo_jalo.jpg') }}" style="width:100px" class="logo-icon"
                                            alt="logo icon">
                                        </div>
                                        <div class="col" style="min-width: 200px"><div style="text-transform: uppercase; margin-top: 0;" class="uppercase">jalo Logistics</div>
                                        <p style="margin-top: 0;" class="size_12">La Logistique Autrement</p></div>
                                    </div>

                                </div>
                                <table style="width:100%; margin: 50px 0 0 0;">
                                    <tbody>
                                        <tr>
                                            <th style="min-width: 20%; width: 20%;" ></th>
                                            <th style="min-width: 15%; width: 15%;"></th>
                                            <th></th>
                                            <th style="text-align: right; align-items: flex-end; justify-content: flex-end;">
                                                <b style="font-size: 8px; margin: 0;">N° DE FACTURE</b> : <br>
                                                <b style="font-size: 8px;">DATE</b> : <br>
                                                <b style="font-size: 8px;">RÉF CLIENT</b> : <br>
                                            </th>
                                            <th style="text-align: start; align-items: start; justify-content: start;">
                                                <span> </span> <span style="font-size: 8px; ">  {{ $refacturation->num_facture ?? 'N/A' }} </span> <br>
                                                <span> </span> <span style="font-size: 8px;">  {{ $refacturation->created_at->format('d/m/Y') ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">  {{ $refacturation->refClient ?? 'N/A' }}</span> <br>
                                            </th>
                                            <th></th>

                                            <th style="text-align: right; align-items: flex-end; justify-content: flex-end;">
                                                <b style="font-size: 8px;">DOIT</b> : <br>
                                                <b style="font-size: 8px;">ADRESSE COMPLETE</b> : <br>
                                                <b style="font-size: 8px;">N° CC</b> : <br>
                                            </th>
                                            <th style="text-align: start; align-items: start; justify-content: start;">
                                               <span> </span> <span style="font-size: 8px;">{{ $refacturation->doit ?? 'N/A' }}</span> <br>
                                               <span> </span> <span style="font-size: 8px;">{{ $refacturation->adresseComplete ?? 'N/A' }}</span> <br>
                                               <span> </span> <span style="font-size: 8px;">{{ $refacturation->num_cc ?? 'N/A' }}</span> <br>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr style="width: 80% ; margin: 0;">
                                <table style="width:100%; margin-top: 0;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: right; align-items: flex-end; justify-content: flex-end;">
                                                <b style="font-size: 8px;">N° COMMANDE</b> : <br>
                                                <b style="font-size: 8px;">N° BL</b> : <br>
                                                <b style="font-size: 8px;">N° DOSSIER JALÔ</b> : <br>
                                                <b style="font-size: 8px;">N° OT</b> : <br>
                                            </th>
                                            <th style="text-align: start; align-items: start; justify-content: start;">
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->num_Commande ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->num_Bl ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->num_Dossier ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->num_Ot ?? 'N/A' }}</span> <br>
                                            </th>
                                            <th></th>
                                            <th style="text-align: right; align-items: flex-end; justify-content: flex-end;">
                                                <b style="font-size: 8px;">NAVIRE/VOYAGE</b> : <br>
                                                <b style="font-size: 8px;">DESTINATON</b> : <br>
                                                <b style="font-size: 8px;">DÉSIGNATION</b> : <br>
                                                <b style="font-size: 8px;">VOLUME/POIDS</b> : <br>
                                            </th>
                                            <th style="text-align: start; align-items: start; justify-content: start;">
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->navire ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->destination ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->designation ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->volume ?? 'N/A' }}
                                                kg</span> <br>
                                            </th>
                                            <th style="text-align: right; align-items: flex-end; justify-content: flex-end;">
                                                <b style="font-size: 8px;">AMATEUR</b> : <br>
                                                <b style="font-size: 8px;">POL</b> : <br>
                                                <b style="font-size: 8px;">POD</b> : <br>
                                                <b style="font-size: 8px;">RÉGIME</b> : <br>
                                            </th>
                                            <th style="text-align: start; align-items: start; justify-content: start;">
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->amateur ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->pol ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->pod ?? 'N/A' }}</span> <br>
                                                <span> </span> <span style="font-size: 8px;">{{ $refacturation->regime ?? 'N/A' }}</span> <br>
                                            </th>
                                            <th class="text-right" style="height: 100px; font-size: 8px;"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <hr style="width: 80% ; margin: 0;">
                                <main style="margin-top: 20px;">
                                    <div class="container" style="min-width: 100%">
                                        <table class="" style="width: 100%;">
                                            <thead class="uppercase size_12" style="background: #000; color: #fff;">
                                                <tr>
                                                    <th class="id">ID Facturier</th>
                                                    <th class="poste">Poste</th>
                                                    <th class="condition-paiement">Condition de Paiement</th>
                                                    <th class="date-echeance">Date d'échéance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="size_12">
                                                    @if (!empty($user))
                                                    <td class="id">{{ $user->name.' '.$user->lastname}}</td>
                                                    @endif
                                                    <td class="poste">{{ $refacturation->poste_occuper ?? 'N/A' }}</td>
                                                    <td class="condition-paiement">{{ $refacturation->condition_paiement ?? 'N/A' }}
                                                    </td>
                                                    <td class="date-echeance">{{ $refacturation->date_echeance ?? 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="content-prestation" style="margin-top: 29px; margin-bottom: 10px;">
                                        <table class="able" style="width: 100%;">
                                            <thead class="uppercase size_12" style="background: #000; color: #fff;">
                                                <tr >
                                                    <th class="id">Nature Prestation</th>
                                                    <th class="poste" style="text-align: center; align-items: flex-center; justify-content: flex-center;">QTE</th>
                                                    <th class="condition-paiement" style="text-align: center; align-items: flex-center; justify-content: flex-center;">Description</th>
                                                    <th class="date-echeance" style="text-align: center; align-items: flex-center; justify-content: flex-center;">Prix Unitaire</th>
                                                    <th class="date-echeance" style="text-align: right; align-items: flex-end; justify-content: flex-end;">Total Ligne (XOF)</th>
                                                    <th class="date-echeance" style="text-align: right; align-items: flex-end; justify-content: flex-end;">TOTAL (€)</th>
                                                </tr>
                                            </thead>
                                            <tbody style="margin-bottom: 15px">
                                                @forelse ($prestations_debours as $prestations_debour)
                                                <tr class="size_12" style="margin-top: 10px; margin-bottom: 10px">
                                                    <td class="id" style="font-size: 8px; background: rgba(211, 211, 211, 0.321); height: 20px;" ><span style="font-size: 8px; text-decoration: uppercase; text-transform: uppercase;">{{ $prestations_debour->type_prestation ?? 'N/A'}}</td>
                                                    <td class="poste" style="text-align: center; align-items: flex-center; justify-content: flex-center; background: rgba(211, 211, 211, 0.321); height: 20px;">{{ $prestations_debour->qty ?? 'N/A' }}</td>
                                                    <td class="condition-paiement" style="text-align: center; align-items: flex-center; justify-content: flex-center; background: rgba(211, 211, 211, 0.321); height: 20px;">{{ $prestations_debour->description ?? 'N/A'  }}</td>
                                                    <td class="date-echeance" style="text-align: center; align-items: flex-center; justify-content: flex-center; background: rgba(211, 211, 211, 0.321); height: 20px;">
                                                        {{ number_format($prestations_debour->prixunitaire) }}
                                                    </td>
                                                    <td class="date-echeance" style="text-align: right; align-items: flex-end; justify-content: flex-end; background: rgba(211, 211, 211, 0.321); height: 20px;">
                                                        {{ number_format($prestations_debour->total) }}
                                                        {{-- {{ $prestations_debour->total ?? 'N/A' }}</td> --}}
                                                    <td class="date-echeance" style="text-align: right; align-items: flex-end; justify-content: flex-end; background: rgba(211, 211, 211, 0.321); height: 20px;">{{ $prestations_debour->total / $exchangeRate ?? 'N/A' }}</td>
                                                </tr>
                                                <hr style="margin-top: 5px; min-width: 100%;">
                                                @empty
                                                <tr>Aucune prestation enregistré</tr>
                                                @endforelse
                                                
                                            </tbody>
                                            <tfoot style="width: 100% ;">
                                                <tr style="100%">
                                                    <td style="background:#d8ea0b; height: 20px;">
                                                    </td>
                                                    <td style="background:#d8ea0b; height: 20px;"></td>
                                                    <td style="background: #d8ea0b; height: 20px;"><span
                                                        style="font-size: 8px; text-align: center; align-items: flex-center; justify-content: flex-center; color:#000;font-weight: 900;">SOUS TOTAL DEBOURS</span></td>
                                                    <td style="background:#d8ea0b; height: 20px;"></td>
                                                    <td style="background:#d8ea0b; height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;">
                                                        <span style="font-size: 8px;" >
                                                            {{ number_format($prestations_totals_debours), 0, ',', ' ' }}
                                                        </span>
                                                    </td>
                                                    <td style="background:#d8ea0b; height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                            style="font-size: 8px;">{{ number_format($prestations_totals_debours / $exchangeRate)}}</span>
                                                    </td>
                                                </tr>
                                                <hr style="margin: 5 0 5 0">
                                                <tr style="100% ; margin-bottom: 15px; margin-top: 10px; background: #000; font-size: 8px;">
                                                    <td style="background: lightgray; height: 20px"><span
                                                            style="font-size: 8px;">COMMISSION SUR DEBOURS</span>
                                                    </td>
                                                    <td style="background:lightgray; height: 20px; text-align: center; align-items: flex-center; justify-content: flex-center;">1</td>
                                                    <td style="background:lightgray; height: 20px;"></td>
                                                    <td style="background:lightgray; height: 20px; text-align: center; align-items: flex-center; justify-content: flex-center;">1,95%</td>
                                                    <td style="background:lightgray; height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;" ><span
                                                            style="font-size: 8px;">{{ $comm_sous_debours ?? 'N/A' }}</span>
                                                    </td>
                                                    <td style="background:lightgray; height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                            style="font-size: 8px;">{{ $comm_sous_debours / $exchangeRate ?? 'N/A' }}</span>
                                                    </td>
                                                </tr>
                                                
                                                @forelse ($prestations as $item )
												<tr class="table" >
													{{-- <td class="unit" style="font-size: 8px;"><span style="font-size: 8px; text-decoration: uppercase;"> {{ $item->type_prestation ?? 'N/A'}}</span></td> --}}

                                                    <td class="unit" style="font-size: 8px; background: rgba(211, 211, 211, 0.321); height: 20px;"><span style="font-size: 8px; text-decoration: uppercase; text-transform: uppercase;"> {{ $item->type_prestation ?? 'N/A'}}</span></td>

                                                    <td class="qty" style="font-size: 8px; text-align: center; align-items: flex-center; justify-content: flex-center; background: rgba(211, 211, 211, 0.321); height: 20px;"><span style="font-size: 8px;">{{ $item->qty ?? 'N/A' }}</span></td>
													<td class="unit" style="font-size: 8px; text-align: center; align-items: flex-center; justify-content: flex-center; background: rgba(211, 211, 211, 0.321); height: 20px;"><span style="font-size: 8px;">{{ $item->description ?? 'N/A'  }}</span></td>
													<td class="unit" style="font-size: 8px; text-align: center; align-items: flex-center; justify-content: flex-center; background: rgba(211, 211, 211, 0.321); height: 20px;">
                                                        <span style="font-size: 8px;">
                                                            {{ number_format($item->prixunitaire), 0, ',', ' ' }}
                                                        {{-- {{ $item->prixunitaire ?? 'N/A' }} --}}
                                                        </span>
                                                    </td>

													<td class="total" style="font-size: 8px; text-align: right; align-items: flex-end; justify-content: flex-end; background: rgba(211, 211, 211, 0.321); height: 20px;"><span style="font-size: 8px;">
                                                        {{ number_format($item->total), 0, ',', ' ' }}
                                                        {{-- {{ $item->total ?? 'N/A' }} --}}
                                                    </span></td>
													<td class="total" style="font-size: 8px; text-align: right; align-items: flex-end; justify-content: flex-end; background: rgba(211, 211, 211, 0.321); height: 20px;"><span style="font-size: 8px;">{{ $item->total / $exchangeRate ?? 'N/A' }}</span></td>
												</tr>
                                                <hr style="margin-top: 5px">
                                                @empty
                                                <tr>Aucune prestation enregistré</tr>
                                            	@endforelse
                                                
                                                <hr style="margin: 5 0 5 0">
                                                <tr style="100% ;">
                                                    <td style="background: #d8ea0b; height: 20px;">
                                                    </td>
                                                    <td style="background: #d8ea0b; height: 20px;"></td>
                                                    <td style="background: #d8ea0b; height: 20px;"><span
                                                        style="font-size: 8px; text-align: center; align-items:center; justify-content:center;  color:#000;font-weight: 900;">SOUS TOTAL DE PRESTATION</span></td>
                                                    <td style="background: #d8ea0b; height: 20px;"></td>
                                                    <td style="background:#d8ea0b; height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                            style="font-size: 8px;">{{ number_format($prestations_totals), 0, ',', ' ' }}</span>
                                                    </td>
                                                    <td style="background:#d8ea0b; height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;">
                                                        <span style="font-size: 8px;">{{ number_format($prestations_totals / $exchangeRate), 0, ',', ' ' }}</span>
                                                    </td>
                                                </tr>
                                                
                                                @php
                                                     $count_pres = count($prestations);
                                                @endphp
                                                @if ($count_pres < 5)
                                                    <hr style="margin: 3 0 2 0">
                                                   <!-- <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr>
                                                    <hr style="margin: 3 0 2 0">
                                                    <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr>
                                                    <hr style="margin: 3 0 2 0">
                                                    <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr>
                                                    <hr style="margin: 3 0 2 0">
                                                    <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr>
                                                    <hr style="margin: 3 0 2 0">
                                                    <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr>
                                                    <hr style="margin: 3 0 2 0">
                                                    <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr>
                                                    <hr style="margin: 3 0 2 0">
                                                    <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr>-->
                                                
                                                @elseif ($count_pres > 5 && $count_pres < 15)
                                                    <hr style="margin: 3 0 2 0">
                                                   <!-- <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr>
                                                    <hr style="margin: 3 0 2 0">
                                                    <tr style="100% ;">
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px;"></td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                        <td style="background: rgba(211, 211, 211, 0.321); height: 20px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span
                                                                style="font-size: 8px;"></span>
                                                        </td>
                                                    </tr> -->
                                                @endif
                                                
                                                <tr>
													<td colspan="2"></td>
													<td colspan="2"></td>
													<td></td>
												</tr>

												<tr>
													<td colspan="2"></td>
													<td colspan="2" style="20px; font-size: 8px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px;">TVA</span></td>
													<td style="height: 20px; font-size: 8px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px;">{{ number_format($tva)}}</span></td>
													<td style="height: 20px; font-size: 8px ; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px;">{{ number_format($tva / $exchangeRate)}}</span></td>
												</tr>
												<tr>
													<td colspan="2"></td>
													<td colspan="2" style="height: 20px; font-size: 8px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px; text-align: right; align-items: flex-end; justify-content: flex-end;">TOTAL HT</span></td>
													<td style="height: 20px; font-size: 8px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px;">{{ number_format($total_ht), 0, ',', ' ' }}</span> XOF</td>
													<td style="height: 20px; font-size: 8px; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px;">{{ number_format($total_ht / $exchangeRate), 0, ',', ' ' }}</span> €</td>
												</tr>
                                                <tr>
													<td colspan="2"></td>
													<td colspan="2"></td>
													<td></td>
												</tr>
                                                <tr style="padding-left: 10px">
													<td colspan="2"></td>
													<td colspan="2" style="height: 20px; font-size: 8px; background: #000; color: #fff; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px;">TOTAL XOF</span></td>
													<td style=" height: 20px; font-size: 8px; background: #000; color: #fff; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px;">{{ number_format($total_xof), 0, ',', ' ' }} </span> <span>XOF</span> </td>
													<td style=" height: 20px; font-size: 8px; background: #000; color: #fff; text-align: right; align-items: flex-end; justify-content: flex-end;"><span style="font-size: 8px;">{{ number_format($total_xof / $exchangeRate), 0, ',', ' ' }}</span> <span>€</span></td>

												</tr>

                                            </tfoot>
                                        </table>


                                    </div>

                                </main>
                            </div>

                            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                            <div></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="min-height: 8vh; height: 8vh;">
                    <div class="conta" style="width: 100%;">
                        <div class="footer size_12" style="background-color: rgba(0, 0, 0, 0.773);">
                            <div class="size_12" style="padding: 0 10px; display: flex; justify-content: center; align-items: center; align-self: center; text-align: center;">
                                01BP 8169 ABIDJAN 01, COCODY Deux Plateaux Rue des Jardins, Cote d'ivoire. SAS au capital de 200 000 000 CFA
                                Régime d'imposition : Réel Normal Direction des Grandes Entreprises. (DGE), RCCM N° CI-ABJ-03-2023-B16-00087
                                COFINA N° CI201 01001 109046290985 21 ECOBANK CI93 CI05 9010 5612 1686 9560 0148
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end page wrapper -->
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>

</html>
