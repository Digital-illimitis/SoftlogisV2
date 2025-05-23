<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            <!--<div class="d-lg-flex align-items-center mb-4 gap-3">

              <div class="ms-auto" data-bs-toggle="modal" data-bs-target="#addFactureModal">
                <button class="btn btn-primary radius-30"><i class="bx bxs-plus-square"></i>Nouvelle facture</button>
              </div>
            </div>-->
            <div class="table-responsive">

                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="background-color: #000000; color: #fff;">ID FACTURE</th>
                            <th style="background-color: #000000; color: #fff;">POSTE</th>
                            <th style="background-color: #000000; color: #fff;">CONDITION DE PAIEMENT</th>
                            <th style="background-color: #000000; color: #fff;">DATE DÉCHÉANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $refacturation->code ?? 'N/A' }}</td> 
                            <td>{{ $refacturation->poste_occuper ?? 'N/A' }}</td>
                            <td>{{ $refacturation->condition_paiement ?? 'N/A' }}</td>
                            <td>{{ $refacturation->date_echeance ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
               
                <table class="table table-striped table-bordered" style="margin-top: 30px;">
                    <thead class="table-light">
                        <tr>
                            <th style="background-color: #000000; color: #fff;">NATURE PRESTATION</th>
                            <th style="background-color: #000000; color: #fff;">QTE</th>
                            <th style="background-color: #000000; color: #fff;">DESCRIPTION</th>
                            <th style="background-color: #000000; color: #fff;">PRIX UNITAIRE</th>
                            <th style="background-color: #000000; color: #fff;">TOTAL LIGNE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prestations as $item )
                        <tr>
                            <td>
                               {{ $item->prestation ?? 'N/A'}}
                            </td> 
                            <td>{{ $item->qty ?? 'N/A' }}</td>
                            <td>{{ $item->description ?? 'N/A'  }}</td>
                            <td>{{ $item->prixunitaire ?? 'N/A' }}</td>
                            <td style="background-color: gray; color: #000000;">{{ $item->total ?? 'N/A' }} XOF</td>
                           
                        </tr>
                        @empty
                        <tr>Aucune prestation enregistré</tr>
                        @endforelse

                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                         
                        <tr>
                            <td></td> 
                            <td></td>
                            <td style="background-color: gray; color: #000000;">SOUS TOTAL PRESTATION</td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;">{{ number_format($prestations_totals)}} XOF</td>
                        </tr>

                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: gray; color: #000000;"></td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td>TVA</td>
                            <td>181 893</td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td>TOTAL HT</td>
                            <td style="background-color: gray; color: #000000;">6792000 XOF</td>
                        </tr>
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td>TOTAL XOF</td>
                            <td style="background-color: gray; color: #000000;">6792000 XOF</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
			</div>
		<!--end page wrapper -->
  </div>
  
  <script src="{{ asset('js/app.js') }}" type="text/js"></script>

	
</body>
</html>