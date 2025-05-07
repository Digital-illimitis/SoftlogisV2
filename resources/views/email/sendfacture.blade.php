<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>SoftLogis : Refacturation</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="container">
     <!--start page wrapper -->
     <div class="page-content">
                  <!--breadcrumb-->

                  <!--end breadcrumb-->
                  <div class="card">
                      <div class="card-body">
                          <div id="invoice">
                              <div class="invoice overflow-auto">
                                  <div style="min-width: 600px">
                                      <header>
                                          <div class="row">
                                              <div class="col">
                                                  <a href="javascript:;">
                                                  <img src="{{ asset('assets/images/logo_jalo.jpg') }}" style="width:100px" class="logo-icon" alt="logo icon">
                                                  </a>

                                                  </div>

                                          </div>

                                      </header>
                                      <br>
                                          <table style="width:100%;">
                                              <tbody>
                                                  <tr>
                                                      <th></th>
                                                      <th class="text-left" style="height: 100px; width: 50%;"></th>
                                                      <th class="text-left" style="height: 100px;"></th>
                                                      <th class="text-left" style="height: 100px; width: 20%;"></th>
                                                      <th class="text-left" style="height: 100px; width: 30%;">
                                                          <h5 >
                                                                <b>N° DE FACTURE</b> :  {{ $refacturation->num_facture ?? 'N/A' }}
                                                          </h5>
                                                          <div><b>DATE</b> : {{ $refacturation->date_payed ?? 'N/A' }}</div>
                                                          <div><b>RÉF CLIENT</b> : {{ $refacturation->refClient ?? 'N/A' }}</div>
                                                          <br><br>
                                                          <h5 >
                                                          <b>DOIT</b> :  {{ $refacturation->doit ?? 'N/A' }}
                                                          </h5>
                                                          <div><b>ADRESSE COMPLETE</b> : {{ $refacturation->adresseComplete ?? 'N/A' }}</div>
                                                          <div><b>N° CC</b> : {{ $refacturation->num_cc ?? 'N/A' }}</div>
                                                      </th>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      <hr>
                                      <table style="width:100%;">
                                              <thead>
                                                  <tr>
                                                      <th></th>
                                                      <th class="text-left" style="height: 100px;">
                                                      <div class="name" style="text-align: left;">
                                                          <b>DÉSIGNATION</b> :  {{ $refacturation->designation ?? 'N/A' }}
                                                          </div>
                                                          <div style="text-align: left;"><b>N° COMMANDE</b> : {{ $refacturation->num_Commande ?? 'N/A' }}</div>
                                                          <br>
                                                          <div style="text-align: left;"><b>N° BI</b> : {{ $refacturation->num_BI ?? 'N/A' }}</div>
                                                          <br>
                                                          <div style="text-align: left;"><b>NAVIRE/VOYAGE</b> : {{ $refacturation->navire ?? 'N/A' }}</div>
                                                          <div style="text-align: left;"><b>DESTINATON</b> : {{ $refacturation->destination ?? 'N/A' }}</div>
                                                  </th>
                                                      <th class="text-right" style="height: 100px;">
                                                      <div class="name" style="text-align: left;">
                                                          <b>AMATEUR</b> :  {{ $refacturation->amateur ?? 'N/A' }}
                                                          </div>
                                                          <div style="text-align: left;"><b>N° DOSSIER</b> : {{ $refacturation->num_Dossier ?? 'N/A' }}</div>
                                                          <br>
                                                          <div style="text-align: left;"><b>N° OT</b> : {{ $refacturation->num_Ot ?? 'N/A' }}</div>
                                                          <br>
                                                          <div style="text-align: left;"><b>VOLUME/POIDS</b> : {{ $refacturation->volume ?? 'N/A' }}</div>
                                                      </th>
                                                      <th class="text-right" style="height: 100px;">
                                                      <div class="to" style="text-align: left;"> <b>POL</b> : {{ $user->pol ?? 'N/A' }}</div>
                                                      <div class="address" style="text-align: left;"> <b>POD</b> : {{ $refacturation->pod ?? 'N/A' }}</div>
                                                      <div class="email" style="text-align: left;"> <b>RÉGIME</b> : {{ $refacturation->regime ?? 'N/A' }}</div>
                                                      </th>
                                                      <th class="text-right" style="height: 100px;"></th>
                                                  </tr>
                                              </thead>
                                          </table>
                                      <main>
                                          <!--<div id="fact">
                                              <div class="col invoice-to">
                                                  <h5 class="to"> <b>ID FACTURIER</b> : {{ $user->name ?? 'N/A' }}</h5>
                                                  <div class="address"> <b>POSTE</b> : {{ $refacturation->poste_occuper ?? 'N/A' }}</div>
                                                  <div class="email"> <b>CONDITIONS DE PAIEMENT</b> : {{ $refacturation->condition_paiement ?? 'N/A' }}
                                                  </div>
                                                  <div class="address"> <b>DATE D'ÉCHÉANCE</b> : {{ $refacturation->date_echeance ?? 'N/A' }}</div>
                                              </div>
                                          </div>-->
                                          <hr>
                                          <table style="width:100%;">
                                              <thead>
                                                  <tr>
                                                      <th></th>
                                                      <th class="text-left" style="height: 100px;">
                                                      <h5 class="to"> <b>ID FACTURIER</b> : {{ $user->name ?? 'N/A' }}</h5>
                                                      <div class="address"> <b>POSTE</b> : {{ $refacturation->poste_occuper ?? 'N/A' }}</div>
                                                      <div class="email"> <b>CONDITIONS DE PAIEMENT</b> : {{ $refacturation->condition_paiement ?? 'N/A' }}</div>
                                                      <div class="address"> <b>DATE D'ÉCHÉANCE</b> : {{ $refacturation->date_echeance ?? 'N/A' }}</div>
                                                  </th>
                                                      <th class="text-right" style="height: 100px;"></th>
                                                      <th class="text-right" style="height: 100px;"></th>
                                                      <th class="text-right" style="height: 100px;"></th>
                                                  </tr>
                                              </thead>
                                          </table>
                                          @php $exchangeRate = 0.00152; @endphp
                                          <table style="width:100%;">
                                              <thead>
                                                  <tr>
                                                      <th></th>
                                                      <th class="text-left" style="background:lightgray; height: 80px;">DESCRIPTION</th>
                                                      <th class="text-right" style="background:lightgray; height: 80px;">PRIX UNITAIRE</th>
                                                      <th class="text-right" style="background:lightgray; height: 80px;">QTE</th>
                                                      <th class="text-right" style="background:lightgray; height: 80px;">TOTAL (XOF)</th>
                                                      <th class="text-right" style="background:lightgray; height: 80px;">TOTAL (€)</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              @forelse ($prestations_debours as $prestations_debour)
                                                  <tr>
                                                      <td class="no"></td>
                                                      <td class="text-left">
                                                          <h5>
                                                          <a target="_blank" href="javascript:;">
                                                          {{ $prestations_debour->type_prestation ?? 'N/A'}}
                                                          </a>
                                                      </h5>
                                                      {{ $prestations_debour->description ?? 'N/A'  }}</td>
                                                      <td class="unit">{{ $prestations_debour->prixunitaire ?? 'N/A' }}</td>
                                                      <td class="qty">{{ $prestations_debour->qty ?? 'N/A' }}</td>
                                                      <td class="total">{{ $prestations_debour->total ?? 'N/A' }}</td>
                                                      <td class="total">{{ $prestations_debour->total * $exchangeRate ?? 'N/A' }}</td>
                                                  </tr>
                                                  @empty
                                                  <tr>Aucune prestation enregistré</tr>
                                              @endforelse
                                              </tbody>
                                              <tfoot>
                                                  <tr>
                                                      <td colspan="2" ></td>
                                                      <td colspan="2" style="background:lightgray; height: 80px;">SOUS TOTAL DEBOURS</td>
                                                      <td style="background:lightgray; height: 80px;">{{ number_format($prestations_totals_debours)}}</td>
                                                      <td style="background:lightgray; height: 80px;">{{ number_format($prestations_totals_debours * $exchangeRate)}}</td>

                                                  </tr>
                                              <hr>
                                                  @forelse ($prestations as $item )
                                                  <tr>
                                                      <td class="no"></td>
                                                      <td class="text-left">
                                                          <h5>
                                                          <a target="_blank" href="javascript:;">
                                                          {{ $item->type_prestation ?? 'N/A'}}
                                                          </a>
                                                      </h5>
                                                      {{ $item->description ?? 'N/A'  }}</td>
                                                      <td class="unit">{{ $item->prixunitaire ?? 'N/A' }}</td>
                                                      <td class="qty">{{ $item->qty ?? 'N/A' }}</td>
                                                      <td class="total">{{ $item->total ?? 'N/A' }}</td>
                                                      <td class="total">{{ $item->total * $exchangeRate ?? 'N/A' }}</td>
                                                  </tr>
                                                  @empty
                                                  <tr>Aucune prestation enregistré</tr>
                                              @endforelse
                                                  <tr>
                                                      <td class="no"></td>
                                                      <td class="text-left">
                                                          COMMISSION SUR DEBOURS
                                                      </td>
                                                      <td class="unit">1,95%</td>
                                                      <td class="qty">1</td>
                                                      <td class="total">{{ $comm_sous_debours ?? 'N/A' }}</td>
                                                      <td class="total">{{ $comm_sous_debours * $exchangeRate ?? 'N/A' }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td colspan="2"></td>
                                                      <td colspan="2" style="background:lightgray; height: 80px;">SOUS TOTAL DE PRESTATION</td>
                                                      <td style="background:lightgray; height: 80px;">{{ number_format($prestations_totals)}}</td>
                                                      <td style="background:lightgray; height: 80px;">{{ number_format($prestations_totals * $exchangeRate)}}</td>

                                                  </tr>

                                                  <tr>
                                                      <td colspan="2"></td>
                                                      <td colspan="2"></td>
                                                      <td></td>
                                                  </tr>

                                                  <tr>
                                                      <td colspan="2"></td>
                                                      <td colspan="2"></td>
                                                      <td></td>
                                                  </tr>

                                                  <tr>
                                                      <td colspan="2"></td>
                                                      <td colspan="2" style="80px;">TVA</td>
                                                      <td style="height: 80px;">{{ number_format($tva)}}</td>
                                                      <td style="height: 80px;">{{ number_format($tva * $exchangeRate)}}</td>
                                                  </tr>
                                                  <tr>
                                                      <td colspan="2"></td>
                                                      <td colspan="2" style="height: 80px;">TOTAL HT</td>
                                                      <td style="height: 80px;">{{ number_format($total_ht)}}</td>
                                                      <td style="height: 80px;">{{ number_format($total_ht * $exchangeRate)}}</td>
                                                  </tr>
                                                  <tr>
                                                      <td colspan="2"></td>
                                                      <td colspan="2"></td>
                                                      <td></td>
                                                  </tr>
                                                  <tr>
                                                      <td colspan="2"></td>
                                                      <td colspan="2" style="background:lightgray; height: 80px;">TOTAL XOF</td>
                                                      <td style="background:lightgray; height: 80px;">{{ number_format($total_xof)}}</td>
                                                      <td style="background:lightgray; height: 80px;">{{ number_format($total_xof * $exchangeRate)}}</td>

                                                  </tr>
                                              </tfoot>
                                          </table>
                                          <!--<div class="thanks">Thank you!</div>
                                          <div class="notices">
                                              <div>NOTICE:</div>
                                              <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                                          </div>-->
                                      </main>
                                  </div>
                                  <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                                  <div></div>
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
