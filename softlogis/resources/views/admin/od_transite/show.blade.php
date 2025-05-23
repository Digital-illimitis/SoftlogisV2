@extends('admin.layouts.admin')
@section('section')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3 row">
            <div class="breadcrumb-title pe-3 text-uppercase size_14 col-2">Ordre de transit</div>
            <div class="ps-3 col-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:history.back();"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active size_14" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group float-lg-end">
                    <button type="button" class="btn btn-primary btn-sm rounded my-auto text-white">
                        <a href="{{route('admin.downloadOtPDF', $odretransite->id)}}"
                            class="text-center text-decoration-none text-white"><i class="bx bxs-file-pdf"></i> Export PDF</a>
                    </button>
                    @if($odretransite->transitaire)
                    <button class="btn btn-primary btn-sm rounded  ms-2 my-auto text-white" data-bs-toggle="modal" data-bs-target="#addSendMail{{ $odretransite->id }}"><i class="bx bxs-envelope"></i>Envoyer un email</button>
                    @else
                    <button class="btn btn-primary btn-sm rounded  ms-2 my-auto text-white disabled" title="Ce transitaitre n'a pas renseigné son mail"><i class="bx bxs-envelope"></i>Envoyer un email</button>
                    @endif
                    <form action="{{ route('admin.od_transite_doc.receive') }}" method="post" class="submitForm">
                        @csrf
                        <input type="hidden" value="{{ $odretransite->uuid }}" name="transite_uuid">
                        <input type="hidden" value="On" name="receive_doc">
                        <button type="submit" class="btn btn-outline-primary">Confirmer reception des documents</button>
                    </form>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="container">
            <div class="main-body mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-title d-flex align-items-center justify-content-between px-2 py-auto pe-0">
                                <div class="col-12">
                                    <h5 class="d-flex align-items-center text-uppercase px-2 my-2 size_16">Informations sur l'ordre de transit</h5>
                                </div>
                            </div>
                            <hr class="mb-2">

                            <div class="card-body size_14">
                                <div class="content">
                                    <div class="">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">N°:</h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ ($odretransite->code) ? $odretransite->code : '--' }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-6">
                                                            <h6 class="mb-0 text-end size_14">Nombre de colis</h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->totalProduct  ?? 0 }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-6">
                                                            <h6 class="mb-0 text-end size_14">N° Connaissement</h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->numConnaissement  ?? '--' }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row my-2">
                                                        <div class="col-6">
                                                            <h6 class="mb-0 text-end size_14">N° Connaissement Original</h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->numConnaiOriginal ?? '--' }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Nom du Navire </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->navireName  ?? '--' }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row my-2">
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Port de Debarquement</h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->portDembarquement 	 ?? '--' }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_13">Montant Facture Fournisseur </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            {{ $odretransite->factFounisseur  ?? 0 }}
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Colisage</h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->colisage ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">N° Certificat d'assurance </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->assurCertifNum ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Montant Facture fret et frais</h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->factFret  ?? 0 }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Fiche Déclaration Import </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->frie ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">SGSN </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->sgsn ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">N°Licence </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->numLicense ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Exonération </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->exoneration ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Marché </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->marche ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Les Marchandises sont à </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->marchandiseAction ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Réexpedié à </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->expediteTo ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" >
                                                        <div class="col-md-6">
                                                            <h6 class="mb-0 text-end size_14">Droit de taxe de douane à acquitter  </h6>
                                                        </div>:
                                                        <div class="col-md-5 text-secondary">
                                                            <div class="text-muted size_13">{{ $odretransite->droitCredit ?? "--" }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <hr class="my-2">
                                            <div class="col-12">
                                                <div class="col-12">
                                                    <h6 class="mb-0 size_14">Note <span class="text-muted">(interne)</span></h6>
                                                </div>
                                                <div class="col-12 text-secondary">
                                                    <p class="form-control disabled text-start" style="min-height: 100px">
                                                        {{ $odretransite->note ?? '--' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <hr class="my-2">
                                            <div class="col-12 row">
                                                <div class="col-8 row">
                                                    <div class="col text-end">Créé par</div>:
                                                    <div class="col">{{ $odretransite->user_uuid ?? '--' }}</div>
                                                </div>
                                                <div class="col row">
                                                    <div class="col text-end">Le</div>:
                                                    <div class="col">{{ $odretransite->created_at->format('d/m/Y') ?? '--' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>


                        <div class="content">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="d-flex align-items-center text-uppercase size_16">Marchandises à transiter</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead class="table-light">
                                                    <tr class="text-uppercase size_14">
                                                        <th>N° Serie</th>
                                                        <th>Famille du produit</th>
                                                        <th>Long (m)</th>
                                                        <th>larg (m)</th>
                                                        <th>HAUT (m)</th>
                                                        <th>POIDS (t)</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                

                                                <tbody style="font-size: 12px !important">
                                                    @if ($odretransite->products->count() > 0)
                                                        @forelse ($odretransite->products as $otProduct)
                                                            <tr>
                                                                <td>
                                                                    {{ $otProduct->numero_serie ?? '--' }}
                                                                </td>
                                                                <td>
                                                                    <h6 class="mb-0 font-14">
                                                                        {{ $otProduct->familly->libelle ?? '--' }}
                                                                    </h6>
                                                                </td>
                                                                <td>{{ $otProduct->longueur ?? '--' }}</td>
                                                                <td>{{ $otProduct->largeur ?? '--' }}</td>
                                                                <td>{{ $otProduct->hauteur ?? '--' }}</td>
                                                                <td>{{ $otProduct->poid_tonne ?? '--' }}</td>
                                                                <td class="d-flex justify-content-end text-end">
                                                                    <button type="button" class="btn btn-sm radius-30 px-2 size_10">
                                                                        <a href="{{ route('admin.article.show', ['uuid' => $otProduct->uuid]) }}" class="text-uppercase tex-none  py-1 text-primary"><i class=" size_10 bx bx-show"></i></a>
                                                                    </button>
                                                                </td>

                                                            </tr>
                                                        @empty
                                                            <tr>Aucun produit pour ce sourcing</tr>
                                                        @endforelse
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    @if($odretransite->transitaire)
                                    <img src="{{ asset('files/' . $odretransite->transitaire->logo) }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="75 " height="75">
                                    @else
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOsAAADWCAMAAAAHMIWUAAAAilBMVEX////l5eXk5OTm5uZMTEzz8/Pj4+P19fXw8PDr6+v6+vru7u74+Pjp6emAgIBDQ0NAQEBGRkZ6enqgoKB0dHQ6OjqDg4OysrLNzc27u7urq6s2NjaZmZnd3d2kpKSSkpLDw8NtbW2Tk5NRUVFZWVlgYGDLy8vV1dVubm4sLCxlZWUoKCgWFhYdHR3JY5ibAAAQ5ElEQVR4nO1di3ayvBINIJcAkYsCgii2taXtf877v94ZINxBgqI1x5+1vjVf63Y6Q5KZXHYShOARJYmA0AVJMECqIGWQGkgTJJYkUQcpgeQYLqFnsuaRvoojeGFYPWfwwldBknDxbqQcD7/P8SDpuxEoXuAYLiFRFPPvKKKYfcdUREUDKYNUQRqiqGRYApLCuIWXhQt1IH8/JpR9jgeZ44XivZC6ynALB18FihdyvNjD5/WdCKV6fuGIEIKRrusgDZAqSA3pSAapgtRAmrqOMEhA8QzXEa3veSwDmbdvqO95+4Z6nrdvWt+FupnwCC/K9lky4EPyqyAUOUoo8CALvCAWOUoo8CA5hgtZddcxxgYIE6QGUgUpg9RAqlSaBQzzDEfgd5GjBJqjBDGPZaJAc5RAc5SgUBi38JfKr1CPJVrvixwlCPTdiAVeoDmqaB4Kx3BkwGOapgpCo1IGKYNUQWoNCcLkGY5ofS9ylCDSWCYWOUqgOaqo71AFFI7hedN+mgz4iPyq9HJU+W6qHJXBpOpVcgkXkAqPBg+VMgh5QHZgXMKrOFzmKLHKUWIrR9WvkVv4S+ZXpcpR3XcjDr9K/uBIfp0HtWNZN0eVsUyhsUzhGP66+bXf9xCbfY/uq+QMLiCGPDWSzriDD4xzxJGxQiv08Qh/tfw6MrZv9z2qqQB+4YiOA7WJcSAIPRsu6hzDEa3vg2MFYXhowSn8BfNrb+5cnDfVzgVcRHSe1aTzrCqdZ5U786tGPR3LLfzCOp04b2ns+eEvlV/76+rivKVsfuDZo0vZOiZgpWz9Eto3ISRv34RI+XdA5t8ByTGcIFrvR7gk4jD1hEv46/GbxtamlXlL2U8OFxtxWJgX+viDM/gqzlP/vPCX8pV13l9sTwXwCM+fun0r88IBV/AX5Pw8SbZ/RF9CorxUaZSXKtE2LnEN/5dTy8cgbTlO7fMPvueO1UuuG6HzGASTfB4DZD6PAZJy3AiFcQtHtL4/Bev1X07tvTm1Y/PJIzRWLuAtTm055zjGS21MVS4JN+6qvQH/M05tng1URTkUs0LS/y2nFt5+egritetu4XGTTZAKy2mfwakdW68dobHOhGfWGKd3F551/cBPm0MOu6MxOYcgX8urZb6mpxUSRLG2R6VxG1yTVemUbJtuVs/W38nyPY1BtL6z8FJrOsaVcCjTQzzsaFG6vnJHYx66JolJ6G873lUPLdsg2wz4GE7tHdlWCIedJrr1j+HXId3tvnanyC/K200k6W5crgk+6gjVZj5c3zU9BT+DgwyJD1qZLMt5BvzaZO66viHfyZgHcWpxmrgNR5NQwXofbkYZyOecU7vZNupupJlkGE6U2F27cbmB936c2vuVa1pXX9cN9QtwyTht125I7lOuWWXOCKdUTEjtCrh63NaefunmZbipQDRW7mHMAzi1Ul2okFGmtUtKVou55NSGVaFu43wUPamdKO72cMf8ereuyqYsVHe9w91dJSPayW6b3MWYvD9ME5DZz1c0jZlNyQzXsV+6uj3KOrN2PfqG5LuwMXfm1Ip1+N0Zc7ST9VFb2hh01/y6K5uqmyhk1uKxdPrWFjYme+42L5FlSlp/Q3jz87TjdbqoMUW55hy3jJ+azdUYdM7GyOdsZJDFnI1RzNkYBmaGo6By9Uudr/0UaAsao9+XU1vnmhRfo93HvHBqa1d9ldQraflcE8ishmnSRe0b/FjOz9VT7bhyNdH1w+GgZLUKpJDVJpBZ7SMH4ZL2XSotPu/fX8/p8lInllAG4FWp+q6z33vw7PctmYmfGF3STr7QMsY01nPusU63q1xdjT/Wpq9dqLVrXzxwatGBxdXS16Z2NdU0TLUbyiM4tTcuZUuk6kJccrXwtaXd+MdbvcU7OWOFClhafl09L1tCIyWhkZJQzgGhnIMWjXUCrrpMroKvRls7DuzVyrE872MdpNC4MLndmCb8DpzapMyrl10FX3FbOz5a9CPH9va/72EeSJ+ZUxvRYvU/pn1ta8cbq/m5Y+/P8S5rbXfKr7dSxeoQfJ5wFXwlbe2k7WuO8X7WoWSo1xnTy6/LjumU0tXPKVdpHG5qP/Z8zYvX83caWXhMtwS106eufjuMvja1D/qaueudg2I6+Zk4tWVjnQjBM32Fx16Fi/i6XL+p7ESsp+JSz1dhwtfVyjsfbu43LRibJJe5sa7YYlPr+XlHN8YmWhcWyDkqnTP0t9ONdTWUc+KJ79m/+rNwaqsazOLpUF8imXpHzsfNfYly75Je7l3q9LNGtjp14WUMPrP6arS1a/6Ir45TfmDHrMYM2E4W20+HyxjMVoOH+v6DvjrQPU62nysv/3CfMhlzX06tpMyrwUNjuiFfrd8D/DUY6qW+l/2Yx6c/5tQa8ZwY3PC1oX2gRlh+9nFG/TJRuodf2IjBmClOLePeYDJCjSsDE0svovK1rX3I10+zNgZFkJM8BU0aM7qvmdb3G7eI6/G8wLQayK+437H00oYxUgq12IrI9fvVab2/Lb+SdDsvMK0G8qvx1vuy1TJGhu6Yk+BHcWpHpp9xwjhobfva1m78diGO3zIGQ/Bytvj6ufDs3BBcnMGhgtR0U8/P3gBJz97QNcPA9OwNrA/BtSuKFXyV29rVvq8JahqjhTb80pwwZtR248La1cgWtiH4Zn6x0vza1N4L4c47bhlzgAbrTRozvp9uifxqfM8v1oH82vfVxy1jNAjEe/0RnNrxqQDaZZoRhFdD8xL91HyWW8aYUMv30vXzEkschVWO0OcUK/iqt7Xr/Vfl4ZYx5ruzslP96nO5aH2fd8RZC26G7swuE/UVt7Xjfmu3dy2yB4LgZAeEkRvSP2+N1vsb8qtOBzjrWcU6kF/7vkLS0bMFqMwo6CQh6E1kr+jvOLVikXD8t1muNvNroX3A15XtxptjFAVBEEWbOIE/4ayNq7lcN50kmT1m4M5POLmvZkfRkALHyh7btjNRVBz9WksZuJeDcbiG4/U1kanKrw3tbC8Lev/s3MtlOT8kpcXa6/Ww+NrSzvY96Ez9FaeWXFmF2/2mXLvN9sXPmzi1DHzy0XSGrqzC4Kva1q4y+rpSGXNrjwPPFstaQ4sWXL0uCg+MczCjr97MOLwc52d3Tf+Q+tqZH/YYfT2gMWOW49QOHqlf9oXnutqYlyj7Tay+7kaNuWi7gC6cGykPX5XQgqv+lc01i01t7eqe7Yt7bcyYCdtv3TtYEkFmN9fuOEdEOqOv9tV7B2/Lr3p6Vb+/9rWhndXXVcEC7BtzZ06tHl4bmvrzEqy+nm/h1LLugx6YSlZLX2c3V/BVa8/iEkZfP7QRYybvRaL1fWouTkeD2+FVOtPkenbrKe0quu7Fi7DakH0jv+balU4cdoqn76wxYsyE7bfmV5lOlia73e4UhuEJJIiwsNA+b4IwiI5rx4Ku3fF0OqU17PRFBLqSlrOstHa5Wmc/SeLk6H90V6Ad/DecWo32EDeoWA7MGRyS9p7ZZ7+dgq0FBe6sowjKx/7wo5SgbEiWNx5IBTrSjfQUBsExjv3mWN85H/2zBaVqfybHj3bZeuKIMZOc2qG7+7I1kezuvqy+X7zqr+whro9GA16sMnlBWAw6nZVjn4NsUt+xvP3eW33+vn1/v/1+nld2TrG1LYqrHttPPCer8/mXjn6r9+hpxoV7B8dtv8SpZbrCsfDVjXAT/gsmeuHas/dufHx392CqF7uNujjcDmtX41/LO2/CUxCfoRHb67jprIfxlfdJ3pZfZeprQJqc2n3m6pu3ClF+hAUKsxocM88eW++/9mfWEdQJVtNPe2Wtm/QCT7k2v97GqTUqX2s4iq2V48f7bQ3X36yVF7H6+ubvE82gxsgo9lZ2dG74esCj6+oMnFrmc7yENpzQeTU3bMB1GLXbXz+uRhpwKNTzFM+FPvZxnzSNkRNrZQV1LbZPaNAYpiPLLnBJRq5ILuGSVJZrA655KydJnEa1z+BQNRl9fXPPbWO088o61gVrh2jQGLb7mq/Or5JRxuEGHPoE9unn1IGfPHCCxVkn/vlqG0N23up8rL7b9fVBnFrRoMsbcQOu7MGcfQ/OWrBO4sgdYxBkp6AK44Wv1/DWbuP8lLNNa6OCizqUQuTjDhz7Dpuv1vt71xgzdqyoarD2bjw2sXJ+rjkGt2S8bxtw9Am9niPuwHFkOfFlwiEt102AOsaYkdXw1dsZzDzTJc/k1Y+075/WcBTY52PU9ZUEtvPOVq5h11c1sO3a1x+pn1/n8YfrIx2kFl6q3k15dXsTXo5fs2MSajjk0gh34DiwrKQzGspHPnQNo+gowuPFEeoYA+VqB/usGwkdRy/JL4gfMGbKdtQNNpfbd6/vj7dV57+CS2l8SnrwjWV9hTDUgZ5+kA2FMpn9J4jytangeDxuIvgXh67WMUaHyn8Ijpv3JDmGgsG0n+4enNqSFdKEwyDt3IOfrXU+Ha3nw4N8kZFkWrNdbxkMU0nkT7ljDPqw3qG/WAz9/pBTWw7W0xYcRWkHftjvU4lJOwmCtjHk5O2xvMD+HL0YE8HYCJn0LvbiPoDiLvbsTvZ8CIX0gsbahe+qDNuGv2VDqRqO3mxXZtSuvumoYQzWPux3NmMuar+dU1s22G1qNuHSV9KEG7FnsWs3tkbTGN8+Y3EWwfdOnFpMs8461ltwHMY1HG321oFdO0pdXJ5DoCJ/fxaf5JzakmG6FVtwAadbhW7Zw98/n3kPjlW7dPjN2yzB8unjHx8GL0ueU9u8i53xeh4Kl2l0Wieoc8ykHn/Gp69T8PafVaDO1K6Gn24UHNfefyHqsRvDwKntrP8oI+s/4uByUdli3Qh3louwkW78rX9M5fnakXEINscolTUyx5gL2hfh/AQl0/9EhuCQNzvaFRbt0K1kOhbosZxaUm55dXf6ALxze7R5SP/qzjbGu/jU+ur2Hlwj1VbmA5qA6+ruoM3SPtOYC/Bl7lgk9dEvhngBrovBSZ6tfbE7FpfZs1LtuXLjfIV/eAioBYFA7nBK3yM5tdBMDuvqVKrsoLwuXCAYp0kkE+kv70RdglObHVOnVUcguttIkU1VLj/OUpwSJttA0//4rlv6fuZxagfhu6poXXe9OR0OCrx13SSnIHbfkhSq0l/fYUzr/RJ7QnG4bh76uIUfioOj/UC7WfuznVOLySHabpv+gsNQwvTgkz+/c/xGRm3ngW7o4RRsEnDTT+Lo9CVBN1Vd9m9c/TS4l8OxbJRTOwbPm4Vm5GVZjqKW034L/KXuWXnM+cNPAZ/i1D4u+90fjtqxrHvi6ASnliv4C95NfQOnlh94zqk1GMZ/DRort/CBcY4wh1PLE/zF8uvf3J/zB/Amp7Y5z8rAqeUOjoq60F7rEkfWuurpdh7hy5+j97zwWzm1PMHFYnVJRxVJlq5jynT9siDJ1pxaiV+43uPBTHJq+YW/VH59pftf84bbIFOiRiyrT/QWaCwTOIa3cw4zp5ZLOFt+HVHPGfy18utUbFLmhYNnhr9UzmHl1I6kb57gma95fZfou5EoL1UqbpIwpGIfBKZtW+AYjmh9v5JTyxP8dk4tP/B5nNqR4TEn8CanVjfpPsOcl0r3Gao65aXS/YaIZ/hS59RyAH+p/ErnwnXG+WSRYzgLp1adR2N9Wnju722cWl7gr7cmOcZLHVne5RQ+yKmVp5cCuYQvw6nlA/6K+XWUlzpCn+IRji5wZibP0OMMjuj7uQ+N9angr5dfp3ipI6+SM/jSnNqnfpbn1D4v/CXz6xQvVey+Sv7g/3Jq+SDJ/supHc+v/wMOU4Bdiq46XgAAAABJRU5ErkJggg==" alt="Admin" class="rounded-circle p-1 bg-primary" width="75 " height="75">
                                    @endif
                                    <div class="mt-3">
                                        <h4>{{ $odretransite->transitaire->raison_sociale ?? '--' }}</h4>
                                        
                                        <button class="btn btn-primary size_12 p-1 mt-2">
                                            @if ($odretransite->transitaire !== null)
                                            <a href="{{ route('admin.company.show', $odretransite->transitaire->uuid) }}" class="btn btn-primary p-0 px-3">Info</a>
                                            @endif
                                        </button>
                                        {{-- <button class="btn btn-outline-primary">Message</button> --}}
                                    </div>
                                </div>
                                <hr class="my-4" />
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">
                                            <i class="fadeIn animated bx bx-map"></i>{{  $odretransite->transitaire->localisation ?? '--' }}
                                        </h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="lni lni-phone"></i>
                                            {{ $odretransite->transitaire->phone ?? '--' }}
                                        </h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">
                                            <i class="fadeIn animated bx bx-envelope-open"></i>
                                            {{  $odretransite->transitaire->email ?? '--' }}
                                        </h6>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h5 class="d-flex align-items-center mb-3 text-uppercase">Documents</h5>
                                <hr class="my-2">
                                <div class="ms-auto">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#CreateTransiteFile{{ $odretransite->id }}">
                                        <i class="bx bxs-plus-square"></i> Ajouter
                                    </button>
                                    
                                </div>
                                <hr class="my-2">
                                <div class="content mx-0 px-0">
                                    @if(count($transite_files) > 0)
                                    <ul class="list-group px-0 mx-0">
                                        @foreach ($odretransite->files as $transiteFile)
                                            @if($transiteFile->etat == 'actif')
                                                <li class="list-group-item d-flex align-items-center align-self-center row col-12 px-0 mx-0 my-2 w-100 mb-2" style="font-size: 12px;">
                                                    <div class="row col-12 w-100" style="font-size: 12px;">
                                                        <div class="col-8 overflow-x-scroll text-start align-self-center">
                                                            <span class="text-uppercase">{{ $transiteFile->name }}</span>
                                                        </div>
                                                        <div class="col-3 d-flex row">
                                                            <button class="col-6 text-primary btn bg-transparent" data-bs-toggle="modal" data-bs-target="#pdfViewModal{{$transiteFile->id}}" title="Voir">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                            @include('admin.od_transite.files.viewDoc')

                                                            <a class="deleteConfirmation col-6 bg-transparent text-decoration-none" data-uuid="{{ $transiteFile->uuid }}"
                                                                data-type="confirmation_redirect" data-placement="top"
                                                                data-token="{{ csrf_token() }}"
                                                                data-url="{{ route('admin.od_transite.delette_doc',$transiteFile->uuid) }}"
                                                                data-title="Vous êtes sur le point de supprimer"
                                                                data-id="{{ $transiteFile->uuid }}" data-param="0"
                                                                data-route="{{ route('admin.od_transite.delette_doc',$transiteFile->uuid) }}">
                                                                <button class="border-0 col-6 text-primary btn bg-transparent" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="Supprimer">
                                                                    <i class='bx bxs-trash bg-transparent'></i>
                                                                </button>
                                                            </a>

                                                        </div>
                                                    </div>
                                                </li>
                                            @endif

                                        @endforeach
                                    </ul>
                                    @else
                                    <p>Aucun document associé à cet ordre de transit.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        @include('admin.od_transite.files.addModal')
        @include('admin.od_transite.sendMail')

        <script>
            $(function () {
                $('[data-bs-toggle="popover"]').popover();
                $('[data-bs-toggle="tooltip"]').tooltip();
            })
        </script>
    </div>

@endsection
