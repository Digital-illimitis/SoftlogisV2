@extends('admin.layouts.admin')
@section('section')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Grille Tarifaire</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Transitaire</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="table-responsive">
            <table id="example2" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Transitaire</th>
                        <th>Regime</th>
                        <th>HAD</th>
                        <th>Cout HAD</th>
                        <th>Forfait</th>
                        <th>Commission</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grillesTaransit as $item)
                    <tr>
                        <td>{{ $item->transitaire->raison_sociale }}</td>
                        <td>{{ $item->regime }}</td>
                        <td>{{ $item->container }}</td>
                        <td>{{ $item->cout }} <span>Fcfa</span></td>
                        <td>{{ $item->forfait }} <span>Fcfa</span></td>
                        <td>{{ $item->commission }} <span>%</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

</div>

@endsection
