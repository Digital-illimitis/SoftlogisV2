@extends('admin.layouts.admin')
@section('section')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div id="stepper3" class="bs-stepper gap-4 vertical">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#test-vl-1">
                            <div class="step-trigger" role="tab" id="stepper3trigger1"
                                aria-controls="test-vl-1">
                                <div class="bs-stepper-circle"><i class='bx bx-user fs-4'></i></div>
                                <div class>
                                    <h5 class="mb-0 steper-title">Personal Info</h5>
                                    <p class="mb-0 steper-sub-title">Enter Your Details</p>
                                </div>
                            </div>
                        </div>
        
                        <div class="step" data-target="#test-vl-2">
                            <div class="step-trigger" role="tab" id="stepper3trigger2"
                                aria-controls="test-vl-2">
                                <div class="bs-stepper-circle"><i class='bx bx-file fs-4'></i></div>
                                <div class>
                                    <h5 class="mb-0 steper-title">Account Details</h5>
                                    <p class="mb-0 steper-sub-title">Setup Account Details</p>
                                </div>
                            </div>
                        </div>
        
                        <div class="step" data-target="#test-vl-3">
                            <div class="step-trigger" role="tab" id="stepper3trigger3"
                                aria-controls="test-vl-3">
                                <div class="bs-stepper-circle"><i class='bx bxs-graduation fs-4'></i></div>
                                <div class>
                                    <h5 class="mb-0 steper-title">Education</h5>
                                    <p class="mb-0 steper-sub-title">Education Details</p>
                                </div>
                            </div>
                        </div>
        
                        <div class="step" data-target="#test-vl-4">
                            <div class="step-trigger" role="tab" id="stepper3trigger4"
                                aria-controls="test-vl-4">
                                <div class="bs-stepper-circle"><i class='bx bx-briefcase fs-4'></i></div>
                                <div class>
                                    <h5 class="mb-0 steper-title">Work Experience</h5>
                                    <p class="mb-0 steper-sub-title">Experience Details</p>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="bs-stepper-content">
                        <form onSubmit="return false">
                            <div id="test-vl-1" role="tabpane3" class="bs-stepper-pane content fade"
                                aria-labelledby="stepper3trigger1">
                                <h5 class="mb-1">Your Personal Information</h5>
                                <p class="mb-4">Enter your personal information to get closer to
                                    copanies</p>
        
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="FisrtName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="FisrtName"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="LastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="LastName"
                                            placeholder="Last Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="PhoneNumber" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="PhoneNumber"
                                            placeholder="Phone Number">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="InputEmail" class="form-label">E-mail Address</label>
                                        <input type="text" class="form-control" id="InputEmail"
                                            placeholder="Enter Email Address">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="InputCountry" class="form-label">Country</label>
                                        <select class="form-select" id="InputCountry"
                                            aria-label="Default select example">
                                            <option selected>---</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="InputLanguage" class="form-label">Language</label>
                                        <select class="form-select" id="InputLanguage"
                                            aria-label="Default select example">
                                            <option selected>---</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <button class="btn btn-primary px-4" onclick="stepper3.next()">Next<i
                                                class='bx bx-right-arrow-alt ms-2'></i></button>
                                    </div>
                                </div>
                                <!---end row-->
        
                            </div>
        
                            <div id="test-vl-2" role="tabpane3" class="bs-stepper-pane content fade"
                                aria-labelledby="stepper3trigger2">
        
                                <h5 class="mb-1">Account Details</h5>
                                <p class="mb-4">Enter Your Account Details.</p>
        
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="InputUsername" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="InputUsername"
                                            placeholder="jhon@123">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="InputEmail2" class="form-label">E-mail Address</label>
                                        <input type="text" class="form-control" id="InputEmail2"
                                            placeholder="example@xyz.com">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="InputPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="InputPassword"
                                            value="12345678">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="InputConfirmPassword" class="form-label">Confirm
                                            Password</label>
                                        <input type="password" class="form-control" id="InputConfirmPassword"
                                            value="12345678">
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-3">
                                            <button class="btn btn-outline-secondary px-4"
                                                onclick="stepper3.previous()"><i
                                                    class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                            <button class="btn btn-primary px-4"
                                                onclick="stepper3.next()">Next<i
                                                    class='bx bx-right-arrow-alt ms-2'></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!---end row-->
        
                            </div>
        
                            <div id="test-vl-3" role="tabpane3" class="bs-stepper-pane content fade"
                                aria-labelledby="stepper3trigger3">
                                <h5 class="mb-1">Your Education Information</h5>
                                <p class="mb-4">Inform companies about your education life</p>
        
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="SchoolName" class="form-label">School Name</label>
                                        <input type="text" class="form-control" id="SchoolName"
                                            placeholder="School Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="BoardName" class="form-label">Board Name</label>
                                        <input type="text" class="form-control" id="BoardName"
                                            placeholder="Board Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="UniversityName" class="form-label">University
                                            Name</label>
                                        <input type="text" class="form-control" id="UniversityName"
                                            placeholder="University Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="InputCountry" class="form-label">Course Name</label>
                                        <select class="form-select" id="InputCountry"
                                            aria-label="Default select example">
                                            <option selected>---</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-3">
                                            <button class="btn btn-outline-secondary px-4"
                                                onclick="stepper3.previous()"><i
                                                    class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                            <button class="btn btn-primary px-4"
                                                onclick="stepper3.next()">Next<i
                                                    class='bx bx-right-arrow-alt ms-2'></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!---end row-->
        
                            </div>
        
                            <div id="test-vl-4" role="tabpane3" class="bs-stepper-pane content fade"
                                aria-labelledby="stepper3trigger4">
                                <h5 class="mb-1">Work Experiences</h5>
                                <p class="mb-4">Can you talk about your past work experience?</p>
        
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="Experience1" class="form-label">Experience 1</label>
                                        <input type="text" class="form-control" id="Experience1"
                                            placeholder="Experience 1">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="Position1" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="Position1"
                                            placeholder="Position">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="Experience2" class="form-label">Experience 2</label>
                                        <input type="text" class="form-control" id="Experience2"
                                            placeholder="Experience 2">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="PhoneNumber" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="PhoneNumber"
                                            placeholder="Position">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="Experience3" class="form-label">Experience 3</label>
                                        <input type="text" class="form-control" id="Experience3"
                                            placeholder="Experience 3">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="PhoneNumber" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="PhoneNumber"
                                            placeholder="Position">
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-3">
                                            <button class="btn btn-primary px-4"
                                                onclick="stepper3.previous()"><i
                                                    class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                            <button class="btn btn-success px-4"
                                                onclick="stepper3.next()">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <!---end row-->
        
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection