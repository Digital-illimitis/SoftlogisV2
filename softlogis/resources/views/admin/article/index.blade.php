@extends('admin.layouts.admin')
@section('section')

<div class="page-content" id="ArticleIndex">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Articles</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="/admin/home"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste</li>
                </ol>
            </nav>
        </div>

        {{-- <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm">PARAMETRES</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <a href="{{ route('import.index') }}" class="dropdown-item font-size_12"><i class="bx bxs-file-export"></i>Importer</a>
                </div>
            </div>
        </div> --}}

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">

                        <div class="position-relative col-sm-12 col-md-4 col-lg-6 col-xl-5 search-bar d-md-block d-none">
                            <input class="form-control px-5" type="search" id="Articlesearch" placeholder="Recherche">
                            <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-5"><i class='bx bx-search'></i></span>
                        </div>

                        <div class="col-sm-12 col-md-5 col-lg-4 col-xl-5 ">
                            <form class="float-lg-start">
                                <div class="row row-cols-lg-2 row-cols-xl-auto g-2">
                                    <div class="col">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-white btn-sm">Filtrer par Designation</button>
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button"
                                                        class="btn btn-white dropdown-toggle dropdown-toggle-nocaret px-1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class='bx bxs-category'></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="btnGroupDrop1" style="min-width: 300px">
                                                    <li class="d-flex justify-content-center col-12 text-center mx-0 px-0">
                                                        <form action="{{ route('admin.article.index') }}" method="GET" class="form-inlne mx-0 px-0 ">
                                                            @csrf
                                                            <div class="form-group mx-0 px-2 w-100">
                                                                <select name="famille_id" id="famille_id" class="form-control mr-2">
                                                                    <option value="all">Toutes les Designation</option>
                                                                    @foreach($articleFamilys as $articleFamily)
                                                                            <option value="{{ $articleFamily->uuid }}">{{ Str::limit($articleFamily->libelle, 25, '...') }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary mb-2 mx-1">Filtrer</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 justify-content-end text-end float-lg-end">
                            <!-- Button trigger modal -->
                            @can('Create Articles')
                            <button type="button" class="btn btn-primary mb-3 mb-lg-0 btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addnewproduct">
                                <i class='bx bxs-plus-square'></i>Nouveau Produit</button>
                            @endcan
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 product-grid mx-auto" id="articleList">
        @forelse ($articles as $article)
         @if ($article->image)
        <div class="col content-product d-flex gx-3">
            <a href="{{ route('admin.article.show', $article->uuid) }}" class="text-decoration-none">
                <div class="card">
                    @if($article->image == "default_logo.jpg")
                    <img src="https://img.batiweb.com/repo-images/article/44272/caterpillarresultats.jpg" class="card-img-top w-100 cover img-fluid" alt="article image" style="max-height: 200px; min-height: 200px; min-width: 280px">
                    @elseif($article->image == NULL)
                    <img src="https://img.batiweb.com/repo-images/article/44272/caterpillarresultats.jpg" class="card-img-top w-100 cover img-fluid" alt="article image" style="max-height: 200px; min-height: 200px; min-width: 280px">
                    @else
                    <img src="{{url('files', $article->image)}}" class="card-img-top w-100 cover img-fluid" alt="article image" style="max-height: 200px; min-height: 200px; min-width: 280px">
                    @endif
                    <div class="position-absolute bg-info badge p-2 d-flex mt-1 end-0 text-uppercase">{{ $article->numero_serie }}</div>
                    <div class="card-body mt-2">
                        <h6 class="card-title cursor-pointer text-uppercase" style="min-height: 50px !important; max-width: 200px;">
                            @if ($article->familly)
                                {{ Str::limit($article->familly->libelle, 25, '...') }}
                            @else
                                N/A
                            @endif
                        </h6>

                        <div class="row pb-0 mb-0">
                            <p class="text-muted col-6 mb-0" style="font-size: 11px">Model de vente</p>
                            <p class="text-muted col-6 mb-0" style="font-size: 11px">Marque</p>
                        </div>
                        <div class="row py-0">
                            {{-- <p class="mb-0 col-6 text-uppercase fw-bold" style="font-size: 12px">{{ $article->model->libelle ?? "" }}</p> --}}
                            <p class="mb-0 col-6 text-uppercase fw-bold" style="font-size: 12px">
                                {{ $article->model_Materiel ?? "--" }}
                            </p>
                            <p class="mb-0 fw-bold col-6 text-uppercase" style="font-size: 12px">{{ $article->marque->libelle ?? "" }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif
        </h6>
        @empty
        <div class="container h-75 px-auto py-auto d-flex justify-content-between align-item-center align-self-center" style="min-height: 60vh">
            <div class="text-uppercase text-center text-primary my-auto mx-auto" style="font-size: 40px;">aucune marchandise sur la ligne de production</div>
        </div>
        @endforelse
    </div>

    {{-- modal ajout de produit --}}
    @include('admin.article.addArticle')

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 product-grid mx-auto" id="articleList">
        <!-- La liste des articles sera affichée ici -->
    </div>

<script>
    const searchInput = document.getElementById('Articlesearch');
    const articleListContainer = document.getElementById('articleList');
    const addedArticles = [];


    searchInput.addEventListener('input', function () {
    const searchQuery = searchInput.value.trim();
        fetch(`/articles/search?searchQuery=${searchQuery}`)
            .then(response => response.json())
            .then(data => {
                const articles = data.articles;
                updateArticleList(articles);
            })
            .catch(error => console.error('Error performing search:', error));
        });

    function updateArticleList(articles) {
        // Effacez le contenu actuel de la liste des articles
        articleListContainer.innerHTML = '';
        addedArticles.length = 0; // Réinitialiser le tableau des UUID ajoutés

        // Ajoutez les nouveaux articles à la liste
        articles.forEach(article => {
            // Vérifiez si l'article a déjà été ajouté
            if (!addedArticles.includes(article.uuid)) {
                const articleHtml = `
                    <div class="col content-product d-flex gx-3">
                        <a href="{{ route('admin.article.show', '') }}/${article.uuid}" class="text-decoration-none">
                            <div class="card">
                                <img src="{{ asset('files/') }}/${article.image}" class="card-img-top w-100 cover img-fluid" alt="article image" style="max-height: 200px; min-height: 200px; min-width: 280px">
                                <div class="position-absolute bg-info badge p-2 d-flex mt-1 end-0 text-uppercase">${article.numero_serie}</div>
                                <div class="card-body mt-2">
                                    <h6 class="card-title cursor-pointer text-uppercase" style="min-height: 50px !important; max-width: 200px;">
                                        ${article.familly ? article.familly.libelle : 'N/A'}
                                    </h6>

                                    <div class="row pb-0 mb-0">
                                        <p class="text-muted col-6 mb-0" style="font-size: 11px">Model de vente</p>
                                        <p class="text-muted col-6 mb-0" style="font-size: 11px">Marque</p>
                                    </div>
                                    <div class="row py-0">
                                        <p class="mb-0 col-6 text-uppercase fw-bold" style="font-size: 12px">${article.model ? article.model.libelle : ''}</p>
                                        <p class="mb-0 fw-bold col-6 text-uppercase" style="font-size: 12px">${article.marque ? article.marque.libelle : ''}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;

                // Ajoutez l'article à la liste
                articleListContainer.insertAdjacentHTML('beforeend', articleHtml);

                // Ajoutez l'UUID de l'article au tableau des articles ajoutés
                addedArticles.push(article.uuid);
            }
        });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Récupérer les éléments du DOM
        var packagingSelect = document.getElementById('packaging');
        var typeContainerField = document.getElementById('typeContainerField');

        // Cacher le champ "Type Container" au chargement de la page
        typeContainerField.style.display = 'none';

        // Écouter les changements dans le champ "Packaging"
        packagingSelect.addEventListener('change', function() {
            if (packagingSelect.value === 'Container') {
                typeContainerField.style.display = 'block';
            } else {
                typeContainerField.style.display = 'none';
            }
        });
    });
</script>


</div>


@endsection
