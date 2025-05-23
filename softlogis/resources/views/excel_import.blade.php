@extends('admin.layouts.admin')

@section('section')
<div class="page-content">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('import.excel') }}" class="row" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-10">
                <label for="file">Charger le fichier a importer</label>
                <input type="file" name="file" id="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-outline-primary col-2 btn-sm py-1">Import</button>
        </form>
    </div>

    <div class="container">
        <h6 class="text-danger">Pour reussir l'importation il faut avoir un gabarie Excel avec les colonnes suivantes :</h6>

        <div class="download">
            <a href="{{ asset('articles.xlsx') }}" class="btn btn-outline-primary" download>Télécharger le modèle</a>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-hover table-striped table-sm table-bordered">
            <thead>
                <tr>
                    <th>(A) -- uuid Article</th>
                    <th>(B) -- code Article</th>
                    <th>(C) -- bon de commande</th>
                    <th>(D) -- numero serie</th>
                    <th>(E) -- description</th>
                    <th>(F) -- image</th>
                    <th>(G) -- marque_uuid</th>
                    <th>(H) -- categorie_uuid</th>
                    <th>(I) -- model Materiel</th>
                    <th>(J) -- designation</th>
                    <th>(K) -- ship source</th>
                    <th>(L) -- entrepot_uuid</th>
                    <th>(M) -- status</th>
                    <th>(N) -- poid</th>
                    <th>(P) -- hauteur</th>
                    <th>(Q) -- largeur</th>
                    <th>(R) -- longueur</th>
                    <th>(S) -- price (xof)</th>
                    <th>(T) -- etat </th>
                    <th>(U) -- Bill OL</th>
                    <th>(V) -- FamilyGroup</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>88972a46-9120-11ee-b9d1-0242ac120</td>
                    <td>Article-00001</td>
                    <td>M3RTW</td>
                    <td>TMG23SED0332</td>
                    <td>description</td>
                    <td>image</td>
                    <td>82c09a91-d5f5-4578-83a3-90576e55d467</td>
                    <td>e41ef617-a65e-46fc-ba32-c6660b5299dc</td>
                    <td>FLEXIROC T35</td>
                    <td>39f3383f-fba8-4cc1-b3cd-cb5d07e26bd6</td>
                    <td>40f3383f-fba8-4cc1-b3cd-cb5d07e26bd6</td>
                    <td>25f3383f-fba8-4cc1-b3cd-cb5d07e26bd6</td>
                    <td>stocked</td>
                    <td>450</td>
                    <td>555</td>
                    <td>879</td>
                    <td>829</td>
                    <td>20 000</td>
                    <td>actif</td>
                    <td>S324400044</td>
                    <td>NEEMBA CI</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
