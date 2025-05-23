@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Comptes</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.collaborateur.index') }}"><i
                                class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Collaborateurs</li>
                </ol>
            </nav>
        </div>
        {{-- <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                        href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
            </div>
        </div> --}}
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                {{-- <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" placeholder="Recherche  ..."> <span
                        class="position-absolute top-50 product-show translate-middle-y"><i
                            class="bx bx-search"></i></span>
                </div> --}}

                <div class="ms-auto">
                    <a data-bs-toggle="modal" data-bs-target="#addcollaborateur"
                    class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Ajouter
                    collaborateur</a>
                </div>
            </div>
            <div class="table-responsive text-center">
                <table class="table mb-0 table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Code</th>
                            <th>Nom & Prénom</th>
                            <th>Email</th>
                            <th>Télephone</th>
                            <th>Role</th>
                            <th>Statut</th>
                            <th>Dernière connexion</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allcollaborateurs as $collaborateur)

                        <tr>
                            <td><img src='{{ asset("avatars/".$collaborateur->avatar) }}' class="product-img-2"
                                    alt="product img"></td>
                            <td>
                                <div class="d-flex align-items-center">

                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14">{{$collaborateur->code}}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $collaborateur->name.' '.$collaborateur->lastname }}</td>
                            <td>{{ $collaborateur->email }}</td>
                            <td>{{ $collaborateur->phone }}</td>
                            <td>{{ $collaborateur->role->name ?? 'N/A' }}</td>
                            <td>
                                <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i
                                        class='bx bxs-circle me-1'></i>{{ $collaborateur->etat }}</div>
                            </td>
                            <td>{{ $collaborateur->last_connection }}</td>
                            <td class="text-center mx-auto">
                                <div class="d-flex order-actions px-auto justify-content-center text-center">

                                    <a data-bs-toggle="modal"
                                        data-bs-target="#editcollaborateur{{ $collaborateur->uuid }}" class=""><i
                                            class='bx bxs-edit'></i></a>

                                    <a class="ms-3 deleteConfirmation" data-uuid="{{$collaborateur->uuid}}"
                                        data-type="confirmation_redirect" data-placement="top"
                                        data-token="{{ csrf_token() }}"
                                        data-url="{{route('admin.collaborateur.destroy')}}"
                                        data-title="Vous êtes sur le point de supprimer {{$collaborateur->name}} "
                                        data-id="{{$collaborateur->uuid}}" data-param="0"
                                        data-route="{{route('admin.collaborateur.destroy')}}"><i
                                            class='bx bxs-trash'></i></a>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal edit  --}}

                        <div class="modal fade" id="editcollaborateur{{ $collaborateur->uuid }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modification du collaborateur</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="post"
                                        action="{{ route('admin.collaborateur.update',$collaborateur->uuid) }}"
                                        class="submitForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">


                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Nom:</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $collaborateur->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname" class="col-form-label">Prénom:</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname"
                                                    value="{{ $collaborateur->lastname }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-form-label">Email:</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="jhondoe@gmail.com" name="email"
                                                    value="{{ $collaborateur->email }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="col-form-label">Télephone:</label>
                                                <input type="phone" class="form-control" id="phone"
                                                    placeholder="+123456789" name="phone"
                                                    value="{{ $collaborateur->phone }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="id_role" class="col-form-label">Role:</label>
                                                <select name="id_role" id="roe" class="form-control">
                                                    {{-- <option value="{{ $collaborateur->role->id ?? '' }}">{{ $collaborateur->role->name ?? 'N/A' }}</option> --}}
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        @empty

                        <tr>
                            <td colspan="8" class="text-center">Aucun collaborateur</td>
                        </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{-- Modal add collaborateur--> --}}
    <div class="col">
        <div class="modal fade" id="addcollaborateur" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" >
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter collaborateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" id="collaborateurForm" action="{{ route('admin.collaborateur.store') }}"
                        enctype="multipart/form-data" >
                        @csrf
                        <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">

                            <div class="form-group">
                                <label for="name" class="col-form-label">Nom:</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="col-form-label">Prénom:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="email" placeholder="jhondoe@gmail.com"
                                    name="email">
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Télephone:</label>
                                <input type="phone" class="form-control" id="phone" placeholder="+123456789" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="id_role" class="col-form-label">Role:</label>
                                <select name="id_role" id="role" class="form-control">
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--<div class="form-group">
                                <label for="password" class="col-form-label">Mot de passe:</label>
                                <input type="password" class="form-control" id="password" placeholder="********"
                                    name="password">
                            </div>-->
                                <div class="form-group position-relative">
                                    <label for="password" class="col-form-label">Mot de passe :</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="********" oninput="checkPasswordStrength()">
                                        <span class="input-group-text" onclick="togglePassword('password', this)" style="cursor: pointer;">
                                            <i class="fa-solid fa-eye"></i>
                                        </span>
                                    </div>
                                    <small id="passwordHelp" class="form-text text-muted">Minimum 12 caractères.</small>
                                    <div id="password-strength" class="mt-1"></div>
                                </div>
                                
                                <div class="form-group position-relative mt-3">
                                    <label for="password_confirmation" class="col-form-label">Confirmer le mot de passe :</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="********" oninput="checkPasswordMatch()">
                                        <span class="input-group-text" onclick="togglePassword('password_confirmation', this)" style="cursor: pointer;">
                                            <i class="fa-solid fa-eye"></i>
                                        </span>
                                    </div>
                                    <div id="password-match-status" class="mt-1"></div>
                                </div>


                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 <!-- Modal add collaborateur-->
</div>
<!-- SweetAlert2 CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function checkPasswordStrength() {
        const password = document.getElementById("password").value;
        const strengthDiv = document.getElementById("password-strength");

        let strength = 0;
        if (password.length >= 12) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[\W]/.test(password)) strength++;

        let strengthText = '';
        let strengthColor = '';

        if (strength <= 2) {
            strengthText = 'Faible';
            strengthColor = 'text-danger';
        } else if (strength === 3) {
            strengthText = 'Moyenne';
            strengthColor = 'text-warning';
        } else if (strength >= 4) {
            strengthText = 'Forte';
            strengthColor = 'text-success';
        }

        strengthDiv.innerHTML = `<span class="${strengthColor}">Force : ${strengthText}</span>`;
    }

    function checkPasswordMatch() {
        const password = document.getElementById("password").value;
        const confirmation = document.getElementById("password_confirmation").value;
        const status = document.getElementById("password-match-status");

        if (confirmation === "") {
            status.innerHTML = "";
            return;
        }

        if (password === confirmation) {
            status.innerHTML = `<span class="text-success">Les mots de passe correspondent.</span>`;
        } else {
            status.innerHTML = `<span class="text-danger">Les mots de passe ne correspondent pas.</span>`;
        }
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('collaborateurForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("{{ route('admin.collaborateur.store') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.type === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });

                // Réinitialiser le formulaire ou fermer le modal
                setTimeout(() => {
                    location.reload();
                }, 2000);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: data.message,
                });
            }
        })
        .catch(error => {
            console.error("Erreur réseau :", error);
            Swal.fire({
                icon: 'error',
                title: 'Erreur serveur',
                text: "Une erreur est survenue, veuillez réessayer.",
            });
        });
    });
});
</script>

<script>
function togglePassword(fieldId, iconElement) {
    const field = document.getElementById(fieldId);
    const icon = iconElement.querySelector('i');

    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

@endsection
