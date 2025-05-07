<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture de Transit</title>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice {
            width: 100%; /* Ajuste la largeur ici, par exemple à 80% */
            max-width: 700px; /* Limite la largeur maximale en pixels */
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
            box-sizing: border-box;
        }

        table {
            width: 100%; /* Assure que les tableaux s'ajustent à la largeur du container */
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td, th {
            padding: 5px;
            border: 1px solid #000;
        }

        .client-info, .company-info {
            width: 50%;
            vertical-align: top;
        }

        .table-container h6 {
            margin: 10px 0;
            text-align: center;
            font-size: 12px;
        }

        .infos-table p {
            margin: 2px 0;
            font-size: 13px;
        }

        .infos-table {
            margin: 2px 0;
            font-size: 13px;
        }

        .tboder {
            border: 1px solid black;
        }
    </style>
</head>
<body>
        <div class="invoice">
            <main>  
                <table class="infos-table">
                    <tr>
                        <td class="client-info">
                            <p><strong>JALO</strong></p>
                            <p>Siège Social : Cocody 2 Plateaux</p>
                            <p>Rue de Jardins</p> 
                            <p>01 BP 8169 Abidjan 01</p>
                            <p>Tél : 27 21 24 92 99 - N°CC : 2302825 k</p>
                            <p>Email : info@jalo-logistics.com</p>
                            <p>RCCM : CI-ABJ-03-2023-B16-00087</p>
                        </td>
                        <td class="company-info" style="text-align : right;">
                            <p style="text-align : right;">Importateur : ....{{ $transitPdf->transitaire->raison_sociale ?? '--' }}</p>
                            <p style="text-align : right;">Téléphone : ....{{ $transitPdf->transitaire->phone ?? '--' }}....</p>
                            <p style="text-align : right;">E-Mail : ....{{  $transitPdf->transitaire->email ?? '--' }}....</p>
                            <p style="text-align : right;">Fax : ...........................</p>
                            <p style="text-align : right;">Compte Contribuable : .........................</p>
                            <p style="text-align : right;">Code Importateur : ....{{  $transitPdf->transitaire->identification ?? '--' }}....</p>
                        </td>
                    </tr>
                </table>

                <div class="table-container">
                    <h6>ORDRE DE TRANSIT N° : {{  $transitPdf->code ?? '--' }}  JALO</h6>
                    <table class="infos-table">
                        <thead>
                            <tr>
                                <th class="infos-table">Nom du Navire :</th>
                                <th class="infos-table">Référence des Marchandises</th>
                                <th class="infos-table">Nombre de Colis</th>
                                <th class="infos-table">Nature de la Marchandise</th>
                                <th class="infos-table">Poids</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>N° du Connaissement: {{ $transitPdf->numConnaissement  ?? '--' }}</td>
                                <td class="tboder"></td>
                                <td class="tboder"></td>
                                <td class="tboder"></td>
                                <td class="tboder"></td>
                            </tr>
                            <tr>
                                <td>Port d'Embarquement: {{ $transitPdf->portDembarquement 	 ?? '--' }}</td>
                                <td class="tboder"></td>
                                <td class="tboder">{{ $transitPdf->totalProduct  ?? 0 }} colis</td>
                                <td class="tboder">NIVELEUSE + CHARGEUSE SUR INEUS</td>
                                <td class="tboder">110 KG</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h6 style="text-align : left;">DOCUMENTS CORRESPONDANTS A L'ARRIVAGE CI-DESSUS ET JOINTS AU PRESENT ORDRE (1)</h6>
                <table class="infos-table">
                    <tr>
                        <td class="company-info">
                            <p>- Connaisement Original N° : ....{{ $transitPdf->numConnaiOriginal ?? '--' }}....</p>
                            <p>- Lettre de garantie bancaire : ....{{ $transitPdf->garantieBancaire ?? '--' }}....</p>
                            <p>- Facture Fournisseur d'un montant de : ....{{ $odretransite->factFounisseur  ?? 0 }}....</p>
                            <p>- Facture Fret d'un montant de : ....{{ $transitPdf->factFret  ?? 0 }}....</p>
                            <p>- Colisage : ....{{ $transitPdf->colisage ?? "--" }}....</p>
                            <p>- Certificat d'assurance N° : ....{{ $transitPdf->assurCertifNum ?? "--" }}....</p>
                        </td>
                        <td class="company-info" style="text-align : right;">
                            <p style="text-align : right;">- FRI : ....{{ $transitPdf->frie ?? "--" }}....</p>
                            <p style="text-align : right;">- Licence N° : ....{{ $transitPdf->numLicense ?? "--" }}....</p>
                            <p style="text-align : right;">- S.G.S N° : ....{{ $transitPdf->sgsn ?? "--" }}....</p>
                            <p style="text-align : right;">- Divers : ....{{ $otProduct->numero_serie ?? '--' }}....</p>
                            <p style="text-align : right;">- Exonération : ....{{ $transitPdf->exoneration ?? "--" }}....</p>
                            <p style="text-align : right;">- Marché : ....{{ $transitPdf->marche ?? "--" }}....</p>
                        </td>
                    </tr>
                </table>
                  <br><br>
                <table class="infos-table">
                    <tr>
                        <td>
                            <p><b>Les MARCHANDISES SONT A (1)</b></p>
                            <p>{{ $transitPdf->marchandiseAction ?? "--" }}.</p>
                            <p>Mettre en entrepot Fictif</p>
                            <p>Mettre en admission temporaire</p>
                            <p>Réexpédier à : ....{{ $transitPdf->expediteTo ?? "--" }}....</p>
                        </td>
                        <td style="text-align : right;">
                            <p style="text-align : right;"><b>DROITS ET TAXES DE DOUANES A ACQUITTER (1) : {{ $transitPdf->droitCredit ?? "--" }}</b></p>
                            <p style="text-align : right;">Par Crédit JALO LOGISTICS SAS ou notre crédit</p>
                            @if ($transitPdf->products->count() > 0)
                                @forelse ($transitPdf->products as $otProduct)
                            <p style="text-align : right;">n° ....{{ $otProduct->numero_serie ?? '--' }}....</p>
                             @empty
                            <p style="text-align : right;">n° ....................</p>
                            @endforelse
                            @endif
                            <p style="text-align : right;">Exonération des droits et taxes au titre de (2): ....{{ $transitPdf->exoneration ?? "--" }}....</p>
                        </td>
                    </tr>
                </table>
                <br><br>
                <table class="infos-table" style="border : none;">
                    <tr style="border : none;">
                        <td style="border : none;">
                            <p>FACTURE A LIBERER A L'ORDRE DE : ................ {{ $transitPdf->factAlibelle ?? "--" }}..........................................................................</p>
                            <p>Adresse de Livraison : ................ {{ $transitPdf->adresseLivraison ?? "--" }}..........................................................................................</p>
                            <p>....................................... ....................................................................................................</p>
                            <p>...................... ................ ....................................................................................................</p>
                        </td>
                    </tr>
                </table>
                <br><br>
                <table class="infos-table" style="border : none;">
                     <tr style="border : none;">
                        <td style="border : none;">
                            <p><b>Par M ...{{  $transitPdf->transitaire->raison_sociale ?? '--' }}.....Signature et Cachet du Transitaire</b></p>
                        </td>
                       
                         <td style="border : none;">
                            <p style="text-align : right;"><b>Signature, Nom et Cachet de l'Importateur</b></p>
                        </td>
                    </tr>
                </table>
                    <br><br>
                <p class="infos-table">(01) Rayer les mentions inutiles</p>
                <p class="infos-table">(02) N° de la décision pour les Entreprises Prioritaires, références des franchises et exonérations éventuelles</p>
            </main>
        </div>
</body>
</html>
