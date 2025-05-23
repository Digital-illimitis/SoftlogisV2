@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Rapport expedition</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Filiale</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="container-fluid">
    
        {{-- Widgets pour chaque filiale --}}
        <div class="row">
            @foreach($widgets as $widget)

                <div class="col-3">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">{{ $widget->client->raison_sociale ?? 'N/A'}}</p>
                                    <p class="mb-0 font-13 text-info"><i class='bx bxs-down-arrow align-middle'></i>{{ $widget->total_expeditions }} Expeditions</p>
                            
                                </div>
                                <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-line-chart-down'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    
        <hr>
    
        {{-- Filtres --}}
        <form method="GET" action="{{ route('admin.rapportExpByFiliale') }}">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="filiale_id" class="form-label">Filiale</label>
                    <select name="filiale_id" id="filiale_id" class="form-control">
                        <option value="">-- Toutes les Filiales --</option>
                        @foreach($filiales as $filiale)
                            <option value="{{ $filiale->uuid }}">
                                {{ $filiale->raison_sociale }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="num_order" class="form-label">N° de Commande</label>
                    <input type="text" name="num_order" id="num_order" class="form-control" value="{{ $numOrder }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </div>
        </form>
    
        <hr  class="my-4">
    
        {{-- Tableau des expéditions --}}
        <div class="table-responsive">
            <table id="example2" class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>N° Commande</th>
                        <th>Filiale</th>
                        <th>Date de Départ</th>
                        <th>Date d'Arrivée</th>
                        <th>Nombre de Jours</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expeditions as $expedition)
                        <tr>
                            <td>{{ $expedition->num_order }}</td>
                            <td>{{ $expedition->client->raison_sociale ?? "N/A" }}</td>
                            <td>{{ $expedition->date_transport }}</td>
                            <td>{{ $expedition->orderDate }}</td>
                            <td>{{ $expedition->jours }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucune expédition trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</div>

@endsection