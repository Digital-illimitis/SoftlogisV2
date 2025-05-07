@extends('admin.layouts.admin')
@section('section')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">DOCUMENTATION</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Gestion documentaire</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs nav-success" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#successhome" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                            </div>
                            <div class="tab-title text-capitalize">Voir en tant qu'agent</div>
                        </div>
                    </a>
                </li>
                @can('Assigned folder')
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#successprofile" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                </div>
                                <div class="tab-title text-capitalize">Voir en tant qu'administrateur</div>
                            </div>
                        </a>
                    </li>
                @endcan
                
            </ul>
            <div class="tab-content py-3">
                <div class="tab-pane fade show active" id="successhome" role="tabpanel">
                    @include('admin.manageFolder.userManageFolder')
                </div>
                <div class="tab-pane fade" id="successprofile" role="tabpanel">
                    @include('admin.manageFolder.adminManageFolder')
                </div>
                
            </div>
        </div>
    </div>
    <!--end row-->

    
</div>
@endsection