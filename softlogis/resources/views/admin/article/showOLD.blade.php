@extends('admin.layouts.admin')
@section('section')


<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $article->familly->libelle ?? 'N/A' }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="/admin/home"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Détail</li>
                </ol>
            </nav>
        </div>

        <div class="ms-auto">
            <div class="btn-group gx-2">
                @if (in_array($article->status, ['enFabrication', 'sortiUsine']))
                <div class="btn-to-usine-out">
                    <form action="{{ route('admin.local_machine.add', $article->uuid) }}" method="post" class="submitForm">
                        @csrf
                        <input type="hidden" value="enFabrication" name="status" id="status">
                        <button type="submit" class="size_12 px-1 btn btn-outline-primary @if($article->status == 'enFabrication') bg-primary text-white text-uppercase @endif" onclick="return confirmSubmission(event)">En Fabrication</button>
                    </form>
                </div>
                @endif

                @if (in_array($article->status, ['enFabrication', 'sortiUsine','enExpedition']))
                <div class="btn-to-usine-out mx-1">
                    <form action="{{ route('admin.local_machine.markToOutUsine', $article->uuid) }}" method="post" class="submitForm">
                        @csrf
                        <input type="hidden" value="sortiUsine" name="status">
                        <input type="hidden" value="{{ $article->uuid }}" name="product">
                        <button type="submit" class="btn btn-outline-primary size_12 px-1 @if($article->status == 'sortiUsine') bg-primary text-white text-uppercase text-uppercase @endif" onclick="return confirmSubmission(event)">Sortie d'usine</button>
                    </form>
                </div>
                @endif

                <div class="btn-to-usine-out ms-2">
                    <form action="{{ route('admin.local_machine.markToWaitExpedit', $article->uuid) }}" method="post" class="submitForm">
                        @csrf
                        <input type="hidden" value="enExpedition" name="status">
                        <button type="submit" class="btn btn-outline-primary size_12 px-1 @if($article->status == 'enExpedition') bg-primary text-white text-uppercase @endif" onclick="return confirmSubmission(event)">En Expedition Import</button>
                    </form>
                </div>

                <div class="btn-to-usine-out ms-2">
                    <form action="{{ route('admin.local_machine.markToarrivedPod', $article->uuid) }}" method="post" class="submitForm">
                        @csrf
                        <input type="hidden" value="arriverAuPod" name="status">
                        <button type="submit" class="btn btn-outline-primary size_12 px-1 @if($article->status == 'arriverAuPod') bg-primary text-white text-uppercase @endif" onclick="return confirmSubmission(event)">Arrivé au PoD</button>
                    </form>
                </div>
                @if (in_array($article->status, ['arriverAuPod', 'stocked', 'expEnCours', 'delivered']))
                <div class="btn-to-usine-out ms-2">
                    <button type="submit" class="btn btn-outline-primary size_12 px-1 @if($article->status == 'stocked') bg-primary text-white text-uppercase @endif">Reçu/Stocké</button>
                </div>

                <div class="btn-to-usine-out ms-2">
                    <button type="submit" class="btn btn-outline-primary size_12 px-1 @if($article->status == 'expEnCours') bg-primary text-white text-uppercase @endif">En Cours d'Expedition Export</button>
                </div>
                <div class="btn-to-usine-out ms-2">
                    <button type="submit" class="btn btn-outline-primary size_12 px-1 @if($article->status == 'delivered') bg-primary text-white text-uppercase @endif">Livré au client</button>
                </div>

                @endif
            </div>
        </div>

    </div>
    <!--end breadcrumb-->

    @if($article)
    <div class="card">
        <div class="row g-0">
            <div class="col-md-4 p-3">

            @if ($article->image)
            <img src="{{ asset('files/' . $article->image) }}" class="img-fluid" alt="..." style="max-height: 460px; min-height: 460px">
            @else
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMwAAADACAMAAAB/Pny7AAAAOVBMVEX///+hoaGampqdnZ2srKy0tLSoqKjZ2dnq6ur39/fAwMDt7e3g4OC7u7vw8PD6+vqTk5PS0tLIyMhAQKZNAAACjElEQVR4nO3a2XKqQBRAUXsCZGz4/4+9EhCQsS50FYeqvV41hm17Gkh8vQAAAAAAAAAAAAAAAAAAAAAAAAAACCIvXFB1dWNMo01I2iY3xqRGGR2KUcrmt8aYOksCyZ2+OUaH+/VlQUwwxGwRFJM3aXNtYxUTk7hIfRTvCy8mJSZxpm1Rxl2okRKTdi1K6QsXJEJiEvuNUfb80giJiaNvi9Ll6RcTElOrMSY7/WJCYnI7xJjHr0zpvjNzZTsTEjN+zvzueTPVqtl+VErM5y5Nt+vi472dufisnyk2HxYT8/rcjHjtdgcm9n+LV289Lifm9aoOTpel7z+KW/udpJgjw4YXbTzhQTGpHnbvjbF5Tkzu1Wh9bJ4TM21RanWjeExMZH5iVsfmKTHjwPTSlSc9JCbxsxZl4uWzHhKzaFFGLa/hZMZks9PibGA6bvFjImOs99H0fa/nA9NZXHJKjGlvoY0ar22WA9Ob/6TAmObvQLUbatbXpd2fZ2cbeTFxf6T+e5Z3awPTbQKzyxpxMeXwpw3fve/11odsOTbiYsZ16MYm22sx6ue+VFpMMzlUXVST6/71Gju9BxIWk6vpgPh4Z2D6munYyIqp7O+xm+agRf3cDciKKebHvrkrj73RODaiYurDQ1+rGU9IkmKS1Uuw45rhbkBQzPto2LdE37sBQTHpyZbP/tyPjZyYyX81/rumHxsxMYk9uzCtRlRMdXZguqXpxkZKTHN8xLs1LpMTE5/blSc17XWcjJjEHp/qD2LasZER00T2qsglMmKqMguglBATv0NJbo9RLg2liMy9MTrgdzS1uTemjsIqzn+L4Loqj4M6//UOAAAAAAAAAAAAAAAAAAAAAAAAAMBl/wCSoC7OdsS5KwAAAABJRU5ErkJggg==" class="img-fluid" alt="..." style="max-height: 460px; min-height: 460px">
            @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title text-uppercase fw-bold">{{ $article->familly->libelle ?? 'N/A' }} | <span class="text-light-info">{{ $article->numero_serie ?? "N/A" }}</span></h4>
                    <div class="row">
                        <div class="col-8">
                            <span>Code :</span><div class="ms-3">#{{ $article->code }}</div>

                            <div> <span class="badge bg-success py-1 px-2 text-light-success mt-2 ms-3">Entrepot</span><span class="ms-3">{{ $article->entrepot->nom ?? "N/A" }}</span></div>
                        </div>
                        <div class="col-4 my-auto g-3">
                            <div class="badge text-success bold px-2 py-1 size_16 text-end">{{ number_format($article->price_unitaire, 0, ',', ' ') }} </div> <span> Fcfa</span> <br>

                            <div class="badge text-success px-2 py-1 size_16 text-end my-2">{{ number_format($article->price_dollars, 0, ',', ' ') }} </div><span> $</span> <br>

                            <div class="badge text-success px-2 py-1 size_16  text-end">{{ number_format($article->price_euro, 0, ',', ' ') }} </div> <span> €</span>
                        </div>
                    </div>

                    <hr class="my-3">
                    <div class="row gap-2 d-flex" style="min-height: 90px">
                        <div class="col">
                            <dl class="row col-12">
                                <dt class="col-sm-6">Family Group</dt>
                                <dd class="col-sm-6">{{ $article->famillyGroup->libelle ?? $article->familyGroup }}</dd>
                            </dl>


                            <dl class="row col-12">
                                <dt class="col-sm-6">N° Bill Of Lading</dt>
                                <dd class="col-sm-6">{{ $article->num_billOfLading ?? "N/A" }}</dd>
                            </dl>
                            <dl class="row col-12 my-2">
                                <dt class="col-sm-6">N°Matérie</dt>
                                <dd class="col-sm-6">{{ $article->numero_bon_commande ?? "N/A" }}</dd>
                            </dl>
                            <dl class="row col-12">
                                <dt class="col-sm-6">N° De Serie</dt>
                                <dd class="col-sm-6">{{ $article->numero_serie ?? "N/A" }}</dd>
                            </dl>
                        </div>
                        <div class="col">
                            <dl class="row col-12">
                                <dt class="col-sm-6">Model du Materiel</dt>
                                <dd class="col-sm-6">{{ $article->model_Materiel ?? "N/A" }}</dd>
                            </dl>
                            <dl class="row col-12 my-2">
                                <dt class="col-sm-6">Categorie</dt>
                                <dd class="col-sm-6">{{ $article->category->libelle ?? "" }}</dd>
                            </dl>
                            <dl class="row col-12 ">
                                <dt class="col-sm-6">Marque</dt>
                                <dd class="col-sm-6">{{ $article->marque->libelle ?? ""}}</dd>
                            </dl>
                        </div>
                    </div>
                    <hr class="mb-3">
                    <div class="row gap-2 d-flex" style="min-height: 100px">
                        <div class="col">
                            <dl class="row col-12">
                                <dt class="col-sm-6">Hauteur</dt>
                                <dd class="col-sm-6">{{ $article->hauteur ?? '--' }} Mètre</dd>
                            </dl>
                            <dl class="row col-12 my-2">
                                <dt class="col-sm-6">Largeur</dt>
                                <dd class="col-sm-6">{{ $article->largeur ?? '--' }} Mètre</dd>
                            </dl>
                            <dl class="row col-12">
                                <dt class="col-sm-6">Pays d'Origine</dt>
                                <dd class="col-sm-6">{{ $article->ship_source->libelle ?? "--" }}</dd>
                            </dl>
                        </div>
                        <div class="col">
                            <dl class="row col-12">
                                <dt class="col-sm-6">Volume</dt>
                                <dd class="col-sm-6">{{ $article->volume }} Mètre<sup>3</sup></dd>
                            </dl>
                            <dl class="row col-12 my-2">
                                <dt class="col-sm-6">Longueur</dt>
                                <dd class="col-sm-6">{{ $article->longueur }} Mètre</dd>
                            </dl>
                            <dl class="row col-12">
                                <dt class="col-sm-6">Poids</dt>
                                <dd class="col-sm-6">{{ $article->poid_tonne }} Tonne</dd>
                            </dl>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row gap-2 d-flex" style="min-height: 100px">
                        <div class="col">
                            <dl class="row col-12">
                                <dt class="col-sm-6">ETA</dt>
                                <dd class="col-sm-6">
                                    {{ Carbon\Carbon::parse($article->date_Eta)->format('d/m/Y') ?? '--' }}
                                    
                                </dd>
                            </dl>
                            <dl class="row col-12 my-2">
                                <dt class="col-sm-6">Date Reception</dt>
                                <dd class="col-sm-6">
                                    {{ Carbon\Carbon::parse($article->date_reception)->format('d/m/Y') ?? '--' }}
                                </dd>
                            </dl>

                        </div>
                        <div class="col">
                            <dl class="row col-12">
                                <dt class="col-sm-6">Date d'entrée en stock</dt>
                                <dd class="col-sm-6">
                                    {{ Carbon\Carbon::parse($article->date_stockage)->format('d/m/Y') ?? '--' }}
                                </dd>
                            </dl>
                            <dl class="row col-12 my-2">
                                <dt class="col-sm-6">Date de Sortie du Stock</dt>
                                <dd class="col-sm-6">
                                    {{ Carbon\Carbon::parse($article->date_outStock)->format('d/m/Y') ?? '--' }}
                                </dd>
                            </dl>

                        </div>
                    </div>
                    <div class="row gap-2 d-flex" style="min-height: 100px">
                        <div class="col">
                            
                            <dl class="row col-12 my-2">
                                <dt class="col-sm-6">Packaging</dt>
                                <dd class="col-sm-6">
                                    {{$article->packaging ?? '--'}}
                                </dd>
                            </dl>

                        </div>
                        <div class="col">
                            @if($article->packaging == "Container")
                            <dl class="row col-12 my-2">
                                <dt class="col-sm-6">Type de container</dt>
                                <dd class="col-sm-6">
                                    {{ $article->type_container ?? '--' }}
                                </dd>
                            </dl>
                            @endif()
                        </div>
                    </div>
                   

                    <div class="d-flex gap-2 my-2">
                        @can('Edit Articles')
                        <a class="deleteConfirmation btn btn-primary text-light-primary size_12 py-2 align-items-center align-self-center" data-uuid="{{$article->uuid}}"
                            data-type="confirmation_redirect" data-placement="top"
                            data-token="{{ csrf_token() }}"
                            data-url="{{route('admin.article.destroy',$article->uuid)}}"
                            data-title="Vous êtes sur le point de supprimer {{$article->libelle}} "
                            data-id="{{$article->uuid}}" data-param="0"
                            data-route="{{route('admin.article.destroy',$article->uuid)}}" style="min-width: 120px">Supprimer</a>
                        @endcan
                        @can('Delette Articles')
                        <button type="button" class="btn py-0 btn-sm  size_12 btn-primary text-light-primary" data-bs-toggle="modal" data-bs-target="#editProduct" style="min-width: 120px; border-radius: 5px">
                            <i class="text-primary" data-feather="edit" ></i>Modifier</button>
                        @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="card-body mb-4">
            <ul class="nav nav-tabs nav-primary mb-0" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab"
                        aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                            </div>
                            <div class="tab-title"> Product Description </div>
                        </div>
                    </a>
                </li>

            </ul>
            <div class="tab-content pt-3">
                <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                    <div class="content px-3">{{ $article->description }}
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Edit product-->
        <div class="modal fade " id="editProduct" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl" style="margin-top:0; margin-right: 0">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier Produit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body p-4">

                                <div class="form-body mt-4">
                                    <form method="post" action="{{ route('admin.article.update', $article->uuid) }}" class="submitForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="border border-3 p-4 rounded">

                                                    <div class="col-sm-12 col-md-12 mb-3">
                                                        <label for="famille_uuid" class="form-label">Designation d'article</label>
                                                        <select name="famille_uuid" class="form-select"
                                                            id="famille_uuid" value="{{ $article->famille_uuid }}">
                                                            <option value="{{ $article->famille_uuid }}" selected>{{ $article->familly->libelle ?? "--" }}</option>
                                                            @foreach ($articleFamilys as $articleFamily)
                                                            <option value="{{ $articleFamily->uuid }}">
                                                                {{ $articleFamily->libelle ?? "--" }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                                        <label for="model_uuid" class="form-label">Model d'article</label>
                                                        <select name="model_uuid" class="form-select"
                                                            id="model_uuid" value="{{ $article->model_uuid }}">
                                                            @if ($article->model_uuid != null)
                                                            <option value="{{ $article->model_uuid }}" selected>{{ $article->model->libelle }}</option>
                                                            @endif
                                                            @foreach ($articleModels as $articleModel)
                                                            <option value="{{ $articleModel->uuid }}">
                                                                {{ $articleModel->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                                   <div class="row col-12 d-flex wrap mx-auto mt-3">
                                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                            <label for="model_Materiel" class="form-label">Model d'article</label>
                                                            <input type="text" class="form-control" id="model_Materiel" name="model_Materiel" value="{{ $article->model_Materiel }}">
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                                                            <label for="num_billOfLading" class="form-label">N° Bill Of Lading</label>
                                                            <input type="text" class="form-control" id="num_billOfLading" name="num_billOfLading" value="{{ $article->num_billOfLading }}">
                                                        </div>
                                                   </div>

                                                    <div class="row col-12 d-flex wrap mx-auto">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <label id="numero_serie" class="form-label">N° de serie</label>
                                                            <input class="form-control" type="text" name="numero_serie" id="numero_serie" placeholder="{{ $article->numero_serie }}" value="{{ $article->numero_serie }}"/>
                                                        </div>
                                                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6">
                                                            <label for="inputProductTitle" class="form-label">N° Matériel</label>
                                                            <input type="text" class="form-control" id="inputProductTitle"
                                                                placeholder="{{ $article->numero_bon_commande }}" name="numero_bon_commande"
                                                                value="{{ $article->numero_bon_commande }}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row col-12 d-flex wrap mx-auto">
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <label id="date_reception" class="form-label">Date de Reception</label>
                                                            <input class="form-control" type="date" name="date_reception" id="date_reception" placeholder="{{ $article->date_reception }}" value="{{ $article->date_reception }}"/>
                                                        </div>
                                                        <div class="mb-3 col-sm-12 col-md-4 col-lg-4">
                                                            <label for="inputProductTitle" class="form-label">Date d'entrée en stock</label>
                                                            <input type="date" class="form-control" id="inputProductTitle"
                                                                placeholder="{{ $article->date_stockage }}" name="date_stockage"
                                                                value="{{ $article->date_stockage }}">
                                                        </div>
                                                        <div class="mb-3 col-sm-12 col-md-4 col-lg-4">
                                                            <label for="inputProductTitle" class="form-label">Date de Sortie du Stock</label>
                                                            <input type="date" class="form-control" id="inputProductTitle"
                                                                placeholder="{{ $article->date_outStock }}" name="date_outStock"
                                                                value="{{ $article->date_outStock }}">
                                                            <span class="text-danger" id="resultat"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="product_description"
                                                            class="form-label">Description</label>
                                                        <textarea class="form-control" value="{{ $article->description }}" rows="3" name="description"
                                                            id="product_description">{{ $article->description }}</textarea>
                                                    </div>

                                                    <div class="file-upload">
                                                        <button class="file-upload-btn" type="button"
                                                            onclick="$('.file-upload-input').trigger( 'click' )">Ajouter
                                                            Image de l'article</button>

                                                        <div class="image-upload-wrap">
                                                            <input class="file-upload-input" type='file'
                                                                onchange="readURL(this);" accept="image/*"
                                                                name="image" value="{{ $article->image }}" value="{{ $article->image }}"/>
                                                            <div class="drag-text">
                                                                <h4>Faites glisser et déposez un fichier ou sélectionnez
                                                                    Ajouter une image</h4>
                                                            </div>
                                                        </div>
                                                        <div class="file-upload-content">
                                                            <img class="file-upload-image" src="#" alt="your image" />
                                                            <div class="image-title-wrap">
                                                                <button type="button" onclick="removeUpload()"
                                                                    class="remove-image">Remove <span
                                                                        class="image-title">Uploaded
                                                                        Image</span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="border border-3 p-4 rounded">
                                                    <div class="row g-3">

                                                        <div class="col-md-6">
                                                            <label id="hauteur" class="form-label">Hauteur(m)</label>
                                                            <input class="form-control" type="number" name="hauteur" id="hauteur" placeholder="{{ $article->hauteur }}" value="{{ $article->hauteur }}"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label id="poid_tonne" class="form-label">Poids/Tonnes</label>
                                                            <input class="form-control" type="number" name="poid_tonne" id="poid_tonne" placeholder="{{ $article->poid_tonne }}" value="{{ $article->poid_tonne }}"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label id="volume" class="form-label">Volume(en m3)</label>
                                                            <input class="form-control" type="number" name="volume" id="volume" placeholder="{{ $article->volume }}" value="{{ $article->volume }}"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="longueur" class="form-label">Longueur(m)</label>
                                                            <input type="number" class="form-control" id="longueur"
                                                                placeholder="{{ $article->longueur }}" name="longueur" value="{{ $article->longueur }}">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="largeur" class="form-label">Largeur</label>
                                                            <input type="number" class="form-control" id="largeur"
                                                                placeholder="{{ $article->largeur }}" name="largeur" value="{{ $article->largeur }}">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="familyGroup" class="form-label">Family Group</label>

                                                            <select class="form-select" name="familyGroup" id="familyGroup">

                                                                @if (!empty($article->famillyGroup))
                                                                    <option value="{{ $article->famillyGroup->uuid}}" selected>{{ $article->famillyGroup->libelle ?? "--"}}</option>
                                                                @else
                                                                    <option value="">Choisir...</option>
                                                                @endif
                                                                
                                                            
                                                                @foreach ($famillyGroups as $item)
                                                                    <option value="{{$item->uuid}}" class="form-option">{{ $item->libelle ?? ''}}</option>
                                                                @endforeach
                                                                {{-- <option value="JALO">JALO</option>
                                                                <option value="NEEMBA CI">NEEMBA CI</option>
                                                                <option value="NEEMBA INTERNATIONAL">NEEMBA INTERNATIONAL</option> --}}
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="inputProductMarque" class="form-label">Marque</label>
                                                            <select class="form-select" id="inputProductMarque" name="marque_uuid" >
                                                                <option value="{{ $article->marque->uuid ?? "" }}">{{ $article->marque->libelle ?? ""}}</option>
                                                                @foreach ($marques as $marque)
                                                                    @if ($marque->uuid != $article->marque->uuid)
                                                                    <option value="{{ $marque->uuid }}">{{ $marque->libelle ?? "--" }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="inputCategory" class="form-label">Categorie</label>
                                                            <select class="form-select" id="inputCategory" name="categorie_uuid" autocomplete="off">
                                                                <option value="{{ $article->category->uuid ?? "" }}">{{ $article->category->libelle ?? "" }}</option>
                                                                @foreach ($categories as $categorie)
                                                                    @if ($categorie->uuid != $article->category->uuid )
                                                                    <option value="{{ $categorie->uuid }}">{{ $categorie->libelle ?? '--' }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{-- <div class="col-md-12">
                                                            <label for="price_unitaire" class="form-label">Prix (FCFA)</label>
                                                            <input type="number" class="form-control" id="price_unitaire"
                                                                placeholder="{{ $article->price_unitaire ?? ""}}" name="price_unitaire" value="{{ $article->price_unitaire}}">
                                                        </div>
                                                        <div class="col-sm-12 col-md-12">
                                                            <label for="price_dollars" class="form-label">Prix (Dollars)</label>
                                                            <input type="number" class="form-control" id="price_dollars"
                                                                 name="price_dollars" value="{{ $article->price_dollars }}">
                                                        </div>
                                                        <div class="col-sm-12 col-md-12">
                                                            <label for="price_euro" class="form-label">Prix (Euro)</label>
                                                            <input type="number" class="form-control" id="price_euro"
                                                                 name="price_euro" value="{{ $article->price_euro }}">
                                                        </div> --}}

                                                        <div class="col-md-12">
                                                            <label for="source_uuid" class="form-label">Ship Source</label>
                                                            <select name="source_uuid" class="form-select" id="source_uuid" autocomplete="off">
                                                                <option value="{{ $article->source_uuid ?? "" }}">{{ $article->ship_source->libelle ?? "" }}</option>
                                                                @foreach ($sources as $source)
                                                                    @if ($source->uuid != $article->source_uuid)
                                                                    <option value="{{ $source->uuid }}">{{ $source->libelle }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>



                                                        <div class="col-12">
                                                            <div class="d-grid">
                                                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    @endif
</div>
<script>
    function confirmSubmission(event) {
        let confirmation = confirm("Êtes-vous certain(e) de vouloir procéder à cette étape ?");
        
        if (!confirmation) {
            event.preventDefault(); // Bloque la soumission
            return false;
        }
        
        return true; // Continue la soumission si "OK"
    }
</script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
        const dateEntree = document.querySelector('input[name="date_stockage"]');
        const dateSortie = document.querySelector('input[name="date_outStock"]');
        const resultat = document.getElementById('resultat');

        function validateDates() {
            if (dateEntree.value && dateSortie.value) {
                const entree = new Date(dateEntree.value);
                const sortie = new Date(dateSortie.value);
                
                if (sortie <= entree) {
                    resultat.innerHTML = 'La date de sortie doit être strictement supérieure à la date d\'entrée en stock';

                    dateSortie.value = '';
                    dateSortie.focus();
                    return false;
                }
            }
            return true;
        }

        if (dateSortie) {
            dateSortie.addEventListener('blur', validateDates);
        }
        
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateDates()) {
                    e.preventDefault();
                }
            });
        }
    });
    </script>
@endsection