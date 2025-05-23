@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Comptes</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.company') }}"><i
                                class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Organisation</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->
   
    <div class="card">
        <div class="card-header">
            @if (session()->has('error'))
                <span class="error-message badge bg-danger text-light p-2">{{ session('error') }}</span>
            @endif
        </div>
        <div class="card-header">
            @if (session()->has('success'))
                <span class="success-message badge bg-success text-light p-2">{{ session('success') }}</span>
            @endif
        </div>
        

        {{-- </div> --}}
        
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                @can('Create Partner')
                <div class="ms-auto">
                    <a data-bs-toggle="modal" data-bs-target="#addcompany"
                        class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>
                        Ajouter compagnie
                    </a>
                </div>
                @endcan
            </div>

            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead class="table-light mt-3">
                        <tr>
                            <th>Logo</th>
                            <th>Code</th>
                            <th>Registre de commerce</th>
                            <th>Raison sociale</th>
                            <th>Email</th>
                            <th>Télephone</th>
                            <th>Etiquette</th>
                            {{-- <th>Etat</th> --}}
                            <th>Actions</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        @forelse ($companies as $company)
                        <tr>
                            <td>
                                @if ($company->logo == 'default_logo.jpg')
                                <img src='https://cdn.pixabay.com/photo/2017/08/30/11/45/building-2696768_640.png' class="product-img-2"
                                alt="logo company">
                                @else
                                    <img src='{{ asset('files/' . $company->logo) }}' class="product-img-2"
                                alt="logo company">
                                @endif
                            </td>
                            <td>{{ $company->code }}</td>
                            <td>
                                <div class="d-flex align-items-center">

                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14">{{ $company->identification }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $company->raison_sociale }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->phone }}</td>
                            <td class="text-capitalize">
                                {{ $company->type }}
                                @if ($company->type === 'transporteur')
                                    <p class="size_12 text-muted"> {{ $company->voie_transport }}</p>
                                @endif
                            </td>
                            {{-- <td>

                                @if ($company->isActive === 'true')
                                <span class="badge bg-success p-2 text-light-danger p-2"><i class='bx bxs-circle me-1'></i>Actif</span>
                                @else
                                <span class="badge bg-danger p-2 text-light-danger p-2"><i class='bx bxs-circle me-1'></i>Inactif</span>
                                @endif

                            </td> --}}

                            <td>
                                <div class="d-flex order-actions text-center justify-content-center align-items-center">

                                    <a href="{{ route('admin.company.show', $company->uuid) }}"
                                        style="cursor: pointer"><i class="lni lni-eye"></i></a>

                                    @can('Edit Partner')
                                    <a class="mx-2" data-bs-toggle="modal"
                                    data-bs-target="#editcompany{{ $company->uuid }}" style="cursor: pointer"> <i
                                        class='bx bxs-edit'></i></a>
                                    @endcan

                                    @can('Delette Partner')

                                    <a class=" deleteConfirmation" data-uuid="{{ $company->uuid }}"
                                        data-type="confirmation_redirect" data-placement="top"
                                        data-token="{{ csrf_token() }}" data-url="{{ route('admin.company.destroy') }}"
                                        data-title="Vous êtes sur le point de supprimer {{ $company->name }} "
                                        data-id="{{ $company->uuid }}" data-param="0"
                                        data-route="{{ route('admin.company.destroy') }}"><i class='bx bxs-trash'
                                            style="cursor: pointer"></i></a>

                                    @endcan

                                </div>
                            </td>
                        </tr>
                        {{-- Modal edit  --}}

                        <div class="modal fade" id="editcompany{{ $company->uuid }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier Compagnie</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="{{ route('admin.company.update', $company->uuid) }}"
                                        class="submitForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">

                                            <div class="form-group">
                                                <label for="logo" class="col-form-label">logo:</label>
                                                <input type="file" name="logo" value="{{ $company->logo }}" class="form-control" >
                                            </div>
                                            <div class="form-group">
                                                <label for="identification" class="col-form-label">Regis de commerce:</label>
                                                <input type="text" class="form-control" value="{{ $company->identification }}" id="identification" name="identification"
                                                    placeholder="{{ $company->identification }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="raison_sociale" class="col-form-label">Raison Sociale:</label>
                                                <input type="text" class="form-control" value="{{ $company->raison_sociale }}" id="raison_sociale" name="raison_sociale" placeholder="{{ $company->raison_sociale }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="type" class="col-form-label">Type organisation:</label>
                                                <select name="type" value="{{ $company->type }}" id="typeEdit" class="form-select">
                                                    <option value="{{ $company->type }}" selected>{{ $company->type }}</option>
                                                    <option value="client">Client</option>
                                                    <option value="transitaire">Transitaire</option>
                                                    <option value="transporteur">Transporteur</option>
                                                    {{-- <option value="organisation">Organisation</option> --}}
                                                </select>
                                            </div>

                                            <div class="form-group row col-12 mx-auto my-3" id="voie-transport-block-edit" style="display: none;">
                                                <label class="col-form-label">Voie de transport :</label>
                                                <div class="form-check col-sm-6">
                                                    <input type="radio" class="form-check-input" name="voie_transport" id="terrestre" value="terrestre">
                                                    <label class="form-check-label" for="terrestre">Terrestre</label>
                                                </div>
                                                <div class="form-check col-sm-6">
                                                    <input type="radio" class="form-check-input" name="voie_transport" id="maritime" value="maritime">
                                                    <label class="form-check-label" for="maritime">Maritime</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="email" class="col-form-label">Email Entreprise:</label>
                                                    <input type="email" class="form-control" value="{{ $company->email }}" id="email" placeholder="{{ $company->email }}"
                                                        name="email" >
                                                </div>
                                                <div class="form-group col">
                                                    <label for="phone" class="col-form-label">Télephone Entreprise:</label>
                                                    <input type="phone" class="form-control" id="phone" placeholder="{{ $company->phone }}" value="{{ $company->phone }}" name="phone">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="localisation" class="col-form-label">Localisation:</label>
                                                <input type="text" class="form-control" id="localisation" name="localisation" value="{{ $company->localisation }}" placeholder="{{ $company->localisation }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="description" class="col-form-label">Description:</label>
                                                <textarea name="description" value="{{ $company->description }}" id="description" cols="30" rows="3"
                                                    class="form-control">{{ $company->description }}</textarea>
                                            </div>
                                            <hr class="my-3">

                                            <input type="text" class="form-control disabled" disabled placeholder="Contact 1">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label for="contact_one_email" class="col-form-label">Email Contact:</label>
                                                    <input type="email" class="form-control" id="contact_one_email" value="{{ $company->contact_one_email }}"
                                                        placeholder="{{ $company->contact_one_email }}" name="contact_one_email">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="contact_one_name" class="col-form-label">Nom du contact:</label>
                                                    <input type="text" class="form-control" id="phone" value="{{ $company->contact_one_name }}" placeholder="{{ $company->contact_one_name }}" name="contact_one_name">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="contact_one_lastName" class="col-form-label">Prénom du contact:</label>
                                                    <input type="text" class="form-control" id="contact_one_name" value="{{ $company->contact_one_lastName }}" placeholder="{{ $company->contact_one_lastName }}" name="contact_one_lastName" >
                                                </div>
                                            </div>
                                            <hr class="my-3">
                                            <input type="text" class="form-control disabled" disabled placeholder="Contact 2">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label for="contact_two_email" class="col-form-label">Email Contact:</label>
                                                    <input type="email" class="form-control" id="contact_two_email"
                                                        placeholder="{{ $company->contact_two_email }}" name="contact_two_email" value="{{ $company->contact_two_email }}">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="contact_two_name" class="col-form-label">Nom du contact:</label>
                                                    <input type="text" class="form-control" id="contact_two_name" name="contact_two_name" placeholder="{{ $company->contact_two_name }}" value="{{ $company->contact_two_name }}">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="contact_two_lastName" class="col-form-label">Prénom du contact:</label>
                                                    <input type="text" class="form-control" id="contact_two_lastName"
                                                        name="contact_two_lastName" placeholder="{{ $company->contact_two_lastName }}" value="{{ $company->contact_two_lastName }}">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Mettre a jour</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty

                        <tr>
                            <td colspan="10" class="text-center">Aucune compagnie</td>
                        </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal --> --}}

{{-- <div class="col"> --}}
<!-- Button trigger modal -->

@include('admin.company.addModal')

<script>
   $.ajax({
    url: 'admin/store/company', // Remplacez par l'URL de votre route
    type: 'POST',
    data: {
        email: $('#email').val(), // Remplacez par le champ de votre formulaire
    },
    success: function(response) {
        // Afficher le JSON dans la console
        console.log(JSON.stringify(response, null, 2)); // '2' pour l'indentation
        
        // Vérifier si l'email existe
        if (response.exists) {
            $('#message').text(response.message).removeClass('badge-success').addClass('badge-danger');
        } else {
            $('#message').text('L\'email est disponible.').removeClass('badge-danger').addClass('badge-success');
        }
    },
    error: function(xhr) {
        $('#message').text('Une erreur est survenue. Assurez-vous de renseigner un email valide.').removeClass('badge-success').addClass('badge-danger');
    }
});

</script>

@endsection
