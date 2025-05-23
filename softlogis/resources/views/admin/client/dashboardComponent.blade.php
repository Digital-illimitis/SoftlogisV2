<div class="row">
    <div class="col-12 col-lg-12 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0"><span class="text-uppercase">Niveau de stock</span> /Unité</h6>
                    </div>
                    
                </div>
            </div>
            <div class="card-body pb-0 mb-0">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
                    
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center cursor-pointer" onclick="redirectToStocked()">
                                    <div>
                                        <p class="mb-0 text-secondary text-uppercase size_12">Reçu/Stocké</p>
                                        <h4 class="my-1">{{ $receivStock->count() }} </h4>
                                        <p class="mb-0 font-13 text-danger"><i
                                                class='bx bxs-down-arrow align-middle'></i>{{ number_format($receivStock->sum('price_unitaire')), 0, ',', ' ' }}
                                            <span>Fcfa</span></p>
                                    </div>
                                    <div class="widgets-icons bg-light-warning text-warning ms-auto"><i
                                            class='bx bx-line-chart-down'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center cursor-pointer"
                                    onclick="redirectToExpEnCours()">
                                    <div>
                                        <p class="mb-0 text-secondary text-uppercase size_12">Cours de Route export
                                        </p>
                                        <h4 class="my-1">{{ $inWaitExpediteExport->count() }} </h4>
                                        <p class="mb-0 font-13 text-danger"><i
                                                class='bx bxs-down-arrow align-middle'></i>{{ number_format($inWaitExpediteExport->sum('price_unitaire')), 0, ',', ' ' }}
                                            <span>Fcfa</span></p>
                                    </div>
                                    <div class="widgets-icons bg-light-warning text-warning ms-auto"><i
                                            class='bx bx-line-chart-down'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10 ">
                            <div class="card-body">
                                <div class="d-flex align-items-center cursor-pointer"
                                    onclick="redirectTodelivered()">
                                    <div>
                                        <p class="mb-0 text-secondary text-uppercase size_12">Livré</p>
                                        <h4 class="my-1">{{ $liverExpedite->count() }} </h4>
                                        <p class="mb-0 font-13 text-success"><i
                                                class="bx bxs-up-arrow align-middle"></i>{{ number_format($liverExpedite->sum('price_unitaire')), 0, ',', ' ' }}
                                            <span>Fcfa</span></p>
                                    </div>
                                    <div class="widgets-icons bg-light-success text-success ms-auto"><i
                                            class="bx bxs-wallet"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>