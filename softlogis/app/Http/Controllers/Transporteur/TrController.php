<?php

namespace App\Http\Controllers\Transporteur;

use App\Models\Company;
use App\Models\OdLivraison;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transporteur.dashboardComponent');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ordreTrIndex()
    {
        $transporteurs = Company::where(['type'=>'transporteur', 'etat'=>'actif'])->get();
        $oDLivraisons = OdLivraison::where(['etat'=>'actif'])->get();
        return view('admin.od_livraison.index', compact('transporteurs', 'oDLivraisons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
