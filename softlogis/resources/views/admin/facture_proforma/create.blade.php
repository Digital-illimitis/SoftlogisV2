@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Facturation</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Proforma</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row">
        <div class="col-8 card p-3">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0">Nouveau Proforma</h5>
                </div>
            </div>
            <div class="bs-stepper-cotent card-body">
                <form action="{{ route('admin.proforma.store') }}" method="post" class="submitForm">
                    @csrf
                    <div id="tst-l-1" class="bs-steper-pane"
                        aria-labelledby="stepper2tger1">

                        <div class="row g-3">
                            <div class="col-12 col-lg-6">
                                <label for="transporteur_uuid" class="form-label">Transporteur</label>
                                <select class="form-select" name="transporteur_uuid" id="transporteur_uuid">
                                    @foreach ($transports as $transport)
                                        <option class="form-control" value="{{ $transport->uuid }}">
                                            {{ $transport->raison_sociale }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="destination_uuid" class="form-label">Destination</label>
                                <select class="form-select" id="destination_uuid" name="destination_uuid"
                                aria-label="Default select destination">
                                <option selected>---</option>
                                @foreach ($destinations as $item)
                                    <option class="form-control" value="{{ $item->uuid }}">{{ $item->libelle }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="porteChar_uuid" class="form-label">PorteChar</label>
                                <select class="form-select" id="porteChar_uuid" name="porteChar_uuid"
                                    aria-label="Default select porteChar">
                                    <option selected>---</option>
                                    @foreach ($porteChars as $item)
                                        <option class="form-control" value="{{ $item->uuid }}">{{   $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="cout_prestation" class="form-label">Cout Prestation</label>
                                <input type="text" class="form-control" id="cout_prestation" name="cout_prestation"
                                    placeholder="0.00">
                            </div>


                            <div class="col-12 col-lg-6">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer<i
                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                            </div>
                        </div>
                        <!---end row-->

                    </div>

                </form>
            </div>
        </div>
        
    </div>

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
                                            <th>Transporteur</th>
                                            <th>Destination</th>
                                            <th>PorteChar</th>
                                            <th>Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grilleTarifaires->groupBy('destination.libelle') as $libelle => $items)
                                            <tr>
                                                <td>{{ $items[0]->transporteur->raison_sociale }}</td>
                                                <td rowspan="{{ count($items) }}">{{ $libelle }}</td>
                                                <td>{{ $items[0]->porteChar->libelle }}</td>
                                                <td>{{ $items[0]->cout }}</td>
                                            </tr>
                                            @for ($i = 1; $i < count($items); $i++)
                                                <tr>
                                                    <td>{{ $items[0]->transporteur->raison_sociale }}</td>
                                                    <td>{{ $items[$i]->porteChar->libelle }}</td>
                                                    <td>{{ $items[$i]->cout }}</td>
                                                </tr>
                                            @endfor
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Transporteur</th>
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
@endSection()



