<!doctype html>
<html lang="fr">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png"/>
	<!--plugins-->
	<link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
	<link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet"/>
	<!-- loader-->
	<link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet"/>
	<script src="{{ asset('assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}"/>
	<link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}"/>
	<link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<title>SOFTLOGIS | Authentication</title>
</head>

<body class="">


	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-cover">
			<div class="">
				<div class="row g-0">

                    <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">

                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
							<div class="card-body">
                                 {{-- <img src="{{ asset('assets/images/login-images/login-cover.svg') }}" class="img-fluid auth-img-cover-login" width="650" alt=""/> --}}
                                 <img src="{{ asset('assets/images/cargo.jpg') }}" class="img-fluid auth-img-cov-login" width="650" alt=""/>
							</div>

						</div>

					</div>
                    <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">

                        <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">

                            <div class="card-body p-sm-5">
                                <div class="">
                                    {{-- <div class="mb-3 text-center">
                                        <img src="{{ asset('assets/images/logo_jalo.jpg') }}" width="60" alt="" />
                                    </div> --}}
                                    <div class="text-center mb-4">
                                        <h5 class="text-uppercase">SOFTLOGIS</h5>
                                        <p class="mb-0">Veuillez saisir vos identifiants</p>
                                    </div>
                                    <div class="form-body">

                                        <form class="row g-3" method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="col-12">
                                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>

                                            <div class="col-12">
                                                <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                                                <div class="position-relative">
                                                <!--<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">-->
                                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror pe-5" 
                                                       name="password" required autocomplete="current-password">
                                                <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" 
                                                   id="togglePassword" style="cursor: pointer;"></i>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-end">
                                                <div class="form-check form-switch">
													@if (Route::has('password.request'))
													<a class="btn btn-link" href="{{ route('password.request') }}">
														{{ __('Mot de passe oublié?') }}
													</a>
													@endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Connexion') }}
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>


                                </div>
                            </div>

                        </div>

                    </div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->


	<!-- Bootstrap JS -->
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ asset('assets/plugins/chartjs/js/chart.js') }}"></script>
	<script src="{{ asset('assets/js/index.js') }}"></script>
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<script>
	    document.getElementById("togglePassword").addEventListener("click", function() {
    var passwordField = document.getElementById("password");
    var icon = this;
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});

	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>

</html>