@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Compagnie</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Plus d'info</li>
                </ol>
            </nav>
        </div>
        {{-- <div class="ms-auto">

            @if($company->isActive === 'true')
            <form action="{{ route('admin.company.block', $company->id) }}" method="post" class="submitForm">
                @csrf

                <input type="hidden" name="company_uuid" value="{{ $company->uuid }}">
                <button type="submit" class="btn btn-primary">BLOQUER</button>
            </form>
            @elseif ($company->isActive === 'false')
            <form action="{{ route('admin.company.active', $company->uuid) }}" method="post" class="submitForm">
                @csrf

                <input type="hidden" name="company_uuid" value="{{ $company->uuid }}">
                <button type="submit" class="btn btn-primary text-uppercase">Debloquer</button>
            </form>
            @endif

        </div> --}}
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            {{-- <div class="d-flex flex-column align-items-center text-center gy-2">
                                <img src="{{ asset('files/' . $company->logo) }}" class="rounded-circle') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4 class="text-uppercase">{{ $company->raison_sociale }}</h4>
                                    <p class="text-secondary mb-2 text-capitalize">{{ $company->type }}</p>
                                </div>

                            </div> --}}

                            <div class="d-flex flex-column align-items-center text-center gy-2 position-relative">
                                {{-- @if ($company->isActive == 'false')
                                  <div class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger text-uppercase" style="transform: skew(-20deg);">Inactive</div>
                                @else
                                  <div class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-success text-uppercase" style="transform: skew(-20deg);">Active</div>
                                @endif --}}

                                @if ($company->logo == 'default_logo.jpg')
                               
                                    <img src="https://cdn.pixabay.com/photo/2017/08/30/11/45/building-2696768_640.png" class="rounded-circle" alt="Admin" width="110">
                                @else
                                    <img src="{{ asset('files/' . $company->logo) }}" class="rounded-circle" alt="Admin" width="110">
                                @endif
                                
                                
                                <div class="mt-3">
                                  <h4 class="text-uppercase">{{ $company->raison_sociale ?? "--"}}</h4>
                                  <p class="text-secondary mb-2 text-capitalize">{{ $company->type ?? "--" }}</p>
                                </div>
                            </div>
                            <hr class=""/>
                            <ul class="list-group list-group-flush">
                                @if ($company->type === 'transporteur')
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Voie d'expedition :</h6>
                                    <span class="text-uppercase">{{ $company->voie_transport ?? "--"}}</span>
                                </li>
                                @endif
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Registre de commerce :</h6>
                                    <span class="text-secondary">{{ $company->identification ?? '--'}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Email :</h6>
                                    <span class="text-secondary">{{ $company->email ?? '--'}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Télephone :</h6>
                                    <span class="text-secondary">{{ $company->phone ?? '--'}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Localisation :</h6>
                                    <span class="text-secondary">{{ $company->localisation ?? '--'}}</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header py-0 pe-0">
                            {{-- <div class="d-flex justify-content-end align-item-center my-0 py-0" >
                                <div class="d-flex justify-content-end align-item-center my-0 py-0 row" style="max-width: 300px">
                                    
                                    <button type="button" class="btn col" class="text-uppercase size_12">Mail</span>
                                    </button>

                                    <button type="button" class="btn col" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-html="true" 
                                        data-bs-content='
                                        <div class="card my-0">
                                            <div class="card-body">
                                                {{ $company->contact_one_name. ' ' .$company->contact_one_lastName }}
                                                <a href = "mailto: {{ $company->contact_one_email ?? '--'}}">{{ $company->contact_one_email ?? '--'}}</a>
                                            </div>
                                        </div>
                                        <div class="card mt-1">
                                            <div class="card-body">
                                                {{ $company->contact_two_name. ' ' .$company->contact_two_lastName }} 
                                                <br>
                                                <a href = "mailto: {{ $company->contact_two_email ?? '--'}}">{{ $company->contact_two_email ?? '--'}}</a>
                                                
                                            </div>
                                        </div>
                                        '>&#128240;<span class="text-uppercase size_12">Contact</span>
                                    </button>
                                </div>
                            </div> --}}
                            <div class="ms-auto d-flex justify-content-end align-item-center my-0 py-0">

                                <div class="btn-group">

                                    <button class="btn btn-sm rounded text-primary ms-2 my-auto"data-bs-toggle="modal" data-bs-target="#addSendMail"><i class="bx bxs-envelope"></i>Envoyer Message</button>

                                    <button type="button" class="btn col btn-sm rounded border" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-html="true" 
                                        data-bs-content='
                                        <div class="card my-0">
                                            <div class="card-body">
                                                {{ $company->contact_one_name. ' ' .$company->contact_one_lastName }}
                                                <a href = "mailto: {{ $company->contact_one_email ?? '--'}}">{{ $company->contact_one_email ?? '--'}}</a>
                                            </div>
                                        </div>
                                        <div class="card mt-1">
                                            <div class="card-body">
                                                {{ $company->contact_two_name. ' ' .$company->contact_two_lastName }} 
                                                <br>
                                                <a href = "mailto: {{ $company->contact_two_email ?? '--'}}">{{ $company->contact_two_email ?? '--'}}</a>
                                                
                                            </div>
                                        </div>
                                        '>&#128240;<span class="text-uppercase size_12">Contact</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            

                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card">
                @if ($company->type === 'transporteur')
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="card-title">GRILLE TARIFAIRE <span class="text-uppercase">{{   $company->raison_sociale }}</span></h5>
                        </div>
                        <div class="ms-auto col-2 text-end">
                            <button class="btn btn-primary p-1 text-center" data-bs-toggle="modal" data-bs-target="#addTransportGrille">
                                <i class="bx bxs-plus-square mx-auto"></i>
                            </button>
                        </div>
                    </div>
                    <hr />
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Grille Tarifaire
                                </button>

                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example2" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Destination</th>
                                                            <th>PorteChar</th>
                                                            <th>Montant</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($grilleTarifaires->groupBy('destination.libelle') as $libelle => $items)
                                                            <tr>
                                                                <td rowspan="{{ count($items) }}">{{ $libelle }}</td>
                                                                <td>{{ $items[0]->porteChar->libelle }}</td>
                                                                <td>{{ $items[0]->cout }}</td>
                                                                <td>
                                                                    <button class="btn btn-primary p-1 text-center" data-bs-toggle="modal" data-bs-target="#editTransportGrille">
                                                                        <i class="bx bxs-edit mx-auto"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @for ($i = 1; $i < count($items); $i++)
                                                                <tr>
                                                                    <td>{{ $items[$i]->porteChar->libelle }}</td>
                                                                    <td>{{ $items[$i]->cout }}</td>
                                                                </tr>
                                                            @endfor
                                                            @include('admin.company.grilleTarif.editTransportModal')
                                                        @endforeach
                                                    </tbody>

                                                    <tfoot>
                                                        <tr>
                                                            <th>Destination</th>
                                                            <th>PorteChar</th>
                                                            <th>Montant</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @endif

                @if ($company->type === 'transitaire')
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="card-title">GRILLE TARIFAIRE <span class="text-uppercase">{{   $company->raison_sociale }}</span></h5>
                        </div>
                        <div class="ms-auto col-2 text-end">
                            <button class="btn btn-primary p-1 text-center" data-bs-toggle="modal" data-bs-target="#addTransitGrille">
                                <i class="bx bxs-plus-square mx-auto"></i>
                            </button>
                        </div>
                    </div>
                    <hr />
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Grille Tarifaire
                                </button>

                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example2" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Regime </th>
                                                            <th>HAD </th>
                                                            <th>Cout HAD</th>
                                                            <th>Forfait</th>
                                                            <th>Commission</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($grilleTariftransits->groupBy('regime') as $libelle => $items)
                                                            @foreach ($items as $index => $item)
                                                                <tr>
                                                                    @if ($index === 0)
                                                                        <td rowspan="{{ count($items) }}">{{ $libelle }}</td>
                                                                    @endif
                                                                    <td>{{ $item->container }}</td>
                                                                    <td>{{ $item->cout }} <span>Fcfa</span></td>
                                                                    <td>{{ $item->forfait }} <span>Fcfa</span></td>
                                                                    <td>{{ $item->commission }} <span>%</span></td>
                                                                    <td>
                                                                    <button class="btn btn-primary p-1 text-center" data-bs-toggle="modal" data-bs-target="#editTransitGrille">
                                                                        <i class="bx bxs-edit mx-auto"></i>
                                                                    </button>
                                                                    </td>
                                                                </tr>
                                                                    @include('admin.company.grilleTarif.editTransitModal')
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
        </div>
    </div>
    @include('admin.company.grilleTarif.addTransportModal')
    @include('admin.company.grilleTarif.addTransitModal')

</div>

@endsection()
