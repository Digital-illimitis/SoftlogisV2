@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="ms-auto">
                    <a data-bs-toggle="modalzz" data-bs-target="#addcollaborateurz"
                    class="btn btn-primary radius-30 mt-2 mt-lg-0">Journaux des Tentatives de Connexion</a>
                </div>
            </div>
            @if ($attempts->count())
            <div class="table-responsive text-center">
                <table id="example2" class="table mb-0 table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Adresse IP</th>
                            <th>Succès</th>
                            <th>Date</th>
                            </tr>
                    </thead>
                    <tbody>
                       @foreach ($attempts as $index => $attempt)
                        <tr class="{{ $attempt->successful ? 'table-success' : 'table-danger' }}">
                            <td>{{ $attempts->firstItem() + $index }}</td>
                            <td>{{ $attempt->email ?? 'Non renseigné' }}</td>
                            <td>{{ $attempt->ip_address }}</td>
                            <td>
                                @if($attempt->successful)
                                    <span class="badge bg-success">Réussie</span>
                                @else
                                    <span class="badge bg-danger">Échouée</span>
                                @endif
                            </td>
                            <td>{{ $attempt->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
            {{ $attempts->links() }}
        </div>
    @else
        <div class="alert alert-info">
            Aucun journal de tentative de connexion disponible.
        </div>
    @endif
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
