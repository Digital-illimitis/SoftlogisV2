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
                    <li class="breadcrumb-item active" aria-current="page">Transporteur</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div >

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
                      @foreach ($grilleTarifs->groupBy('destination.libelle') as $libelle => $items)
                          <tr>
                              <td>{{ $items[0]->transporteur->raison_sociale ?? '--'}}</td>
                              <td rowspan="{{ count($items) }}">{{ $libelle ?? '--' }}</td>
                              <td>{{ $items[0]->porteChar->libelle ?? '--' }}</td>
                              <td>{{ $items[0]->cout ?? '--' }}</td>
                          </tr>
                          @for ($i = 1; $i < count($items); $i++)
                              <tr>
                                  <td>{{ $items[0]->transporteur->raison_sociale ?? '--' }}</td>
                                  <td>{{ $items[$i]->porteChar->libelle ?? '--' }}</td>
                                  <td>{{ $items[$i]->cout ?? '--' }}</td>
                              </tr>
                          @endfor
                      @endforeach
                  </tbody>

                
              </table>
          </div>
    </div>
</div>

@endsection
