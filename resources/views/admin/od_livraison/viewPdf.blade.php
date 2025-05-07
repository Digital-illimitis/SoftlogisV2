<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .size_10 {
            font-size: 10px;
        }
        .size_11 {
            font-size: 11px;
        }
        .size_12 {
            font-size: 12px;
        }
        .size_13 {
            font-size: 13px;
        }
        .size_14 {
            font-size: 14px;
        }
        .table {
            display: table;
            border-collapse: collapse;
            margin-top: 50px;
            width: 100%;
        }
        .min-table {
            display: table;
            border-collapse: collapse;
            width: 100%;
        }

        .min-table-site {
            display: table;
            width: 100%;
            border: 0;
            border-right: 1px solid #000;
        }

        .center {
            text-align: center;
            justify-content: center;
        }
    
        .row {
            display: table-row;
        }
    
        .cell {
            display: table-cell;
            border: 1px solid black;
            padding: 5px;
        }
        .min-cell {
            display: table-cell;
            border: 1px solid black;
            padding: 5px;
        }

        .min-cell-title {
            display: table-cell;
            border-right: 1px solid black;
            padding: 5px
        }

        .border {
            border-left: 1px solid #000;
        }
        .border-bottom {
            border-bottom: 1px solid #000;
        }

        .align-row {
            display: flexbox;
            flex-direction: row;
        }

        .content-signature {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .col-signature {
            display: flex;
            position: absolute;
            left: 5px
        }
        .col-signature-2 {
            display: flex;
            position: absolute;
            right: 5px
        }


    </style>
</head>
<body style="display: flex; justify-content: center; align-items: center;">

    <div class="container" style="padding: 20px 50px; max-width: 90%; width: 90%;">
        <div class="header" style="display: flex ; justify-content: space-between; flex-direction: row; padding: 0 20px 0 20px; max-height: 90px;">
            <div class="col" style=" width: 32%; ">
                <img src="{{ asset('assets/images/logo_jalo.jpg') }}" alt="" class="border-dark-subtle" style="height: 50px;">
            </div>
            <div class="col" style=" width: 32%;"></div>
            <div class="col" style=" width: 32%;"></div>
        </div>

        <div class="title size_14" style=" display: flex; justify-content: center; padding: 20px 0 20px 0; text-align: center;">
            <span style="text-transform: uppercase; text-decoration: underline; margin: auto">ordre de transport</span>
        </div>

        <div class="content size_11" style="position: relative; margin-top: 100px;">
            <div style="display: flex; position: absolute; right: 0;">
                Transporteur : <span>{{ $otPdf->transporteur->raison_sociale ?? 'N/A' }}</span> <br>
                Email : <span>{{ $otPdf->transporteur->email ?? 'N/A' }}</span> <br>
                Telephone : <span>{{ $otPdf->transporteur->phone ?? 'N/A' }}</span> <br>
            </div>
        </div>
        

        <div class="col size_11" style=" position: relative; margin-top: 100px; width: 100%;">

            <div style="display: flex; flex-direction: row; color
            : rgb(0, 0, 0);">
                <div style="position: absolute; min-width: 50%;">Date</div>
                <div style="position: absolute; left: 0; min-width: 50%; margin-left: 100px"> : {{ $otPdf->created_at->format('d/m/Y') ?? 'N/A' }}</div>
            </div>
            <br>
            <div style="display: flex; flex-direction: row; color
            : rgb(0, 0, 0);">
                <div style="position: absolute; min-width: 50%;">N°OT</div>
                <div style="position: absolute; left: 0; min-width: 50%; margin-left: 100px"> : {{ $otPdf->numOt ?? 'N/A' }}</div>
            </div>
            <br>
            <div style="display: flex; flex-direction: row; color
            : rgb(0, 0, 0);">
                <div style="position: absolute; min-width: 50%;">N° Dossier</div>
                <div style="position: absolute; left: 0; min-width: 50%; margin-left: 100px"> : {{ $otPdf->numFolder ?? 'N/A' }}</div>
            </div>
            <br>
            <div style="display: flex; flex-direction: row; color
            : rgb(0, 0, 0);">
                <div style="position: absolute; min-width: 50%;">N°BL</div>
                <div style="position: absolute; left: 0; min-width: 50%; margin-left: 100px"> : {{ $otPdf->numBl ?? 'N/A' }}</div>
            </div>
            <br>
            <div style="display: flex; flex-direction: row; color
            : rgb(0, 0, 0);">
                <div style="position: absolute; min-width: 50%;">Trajet</div>
                <div style="position: absolute; left: 0; min-width: 50%; margin-left: 100px"> : {{ $otPdf->trajetStart->libelle ?? 'N/A' }} à {{ $otPdf->trajetEnd->libelle ?? 'N/A' }}</div>
            </div>
            <br>
            <div style="display: flex; flex-direction: row; color
            : rgb(0, 0, 0);">
                <div style="position: absolute; min-width: 50%;">Ref</div>
                <div style="position: absolute; left: 0; min-width: 50%; margin-left: 100px"> : {{ $otPdf->refCotation ?? 'N/A' }}</div>
            </div>
        </div>
        
        <div class="table center" style="margin-top: 100px">
            <div class="row size_12">
                <div class="cell">NOMBRE</div>
                <div class="cell" style="min-width: 150px">DESIGNATION</div>
                <div class="cell" style="min-width: 300px ; padding-left: 0; padding-right: 0; padding-bottom: 0;">
                    <div class="border-bottom">DIMENSION</div>
                    <div class="min-table size_11" style="padding: 0; border-bottom: 0; min-width: 300px">
                        <div class="min-cell-title" style="min-width: 75px">LONG</div>
                        <div class="min-cell-title" style="min-width: 75px">LARG</div>
                        <div class="min-cell-title" style="min-width: 75px">HAUT</div>
                        <div class="min-cell-title" style="border-right: 0; min-width: 75px">POIDS</div>
                    </div>
                </div>
            </div>
            @foreach ($otPdf->otProducts as $item)
                <div class="row size_10" style="padding: 0">
                    <div class="cell">{{ $item->qty ?? '--'}}</div>
                    <div class="cell size_10" style="min-width: 150px">{{ $item->product->familly->libelle ?? '--'}} </div>
                    <div class="min-table-site size_10" style="padding: 0; padding-right: 0; padding-bottom: 0; min-width: 300px">
                        <div class="min-cell" style="border-top: 0;  border-left: 0; min-width: 75px">{{ $item->product->longueur ?? '--'}}</div>
                        <div class="min-cell"  style="border-top: 0; border-left: 0; min-width: 75px">{{ $item->product->largeur ?? '--'}}</div>
                        <div class="min-cell" style="border-top: 0; border-left: 0; min-width: 75px">{{ $item->product->hauteur ?? '--'}}</div>
                        <div class="min-cell" style="border-top: 0; border-left: 0; min-width: 75px">{{ $item->product->poid_tonne ?? '--'}}</div>
                    </div>
                </div>
            @endforeach
            
        </div>

        <div class="content-signature size_11" style="margin-top: 100px">
            <div class="col-signature" style=" ">
                <h5>LE TRANSPORTEUR</h5>
            </div>
            <div class="col-signature-2" style="">
                <h5>LE DIRECTEUR OPERATION</h5>
            </div>
        </div>

        <div class="footer" style="display: flex; justify-content: space-between; flex-direction: row; align-items: center; margin: 0; text-align: center; margin-bottom: 20px !important; position: fixed; bottom: 0;">
            <div class="size_11" style="padding: 0 10px; display: flex; justify-content: center; align-items: center; align-self: center; text-align: center; margin-bottom: 0 !important;">
                01BP 8169 ABIDJAN 01, COCODY Deux Plateaux Rue des Jardins, Cote d'ivoire. SAS au capital de 200 000 000 CFA
                Régime d'imposition : Réel Normal Direction des Grandes Entreprises. (DGE), RCCM N° CI-ABJ-03-2023-B16-00087
                COFINA N° CI201 01001 109046290985 21 ECOBANK CI93 CI05 9010 5612 1686 9560 0148
            </div>
        </div>
    </div>

</body>
</html>