<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Entrepot;
use App\Models\stockUpdate;
use App\Models\Sourcing_product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EntrepotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $entrepots = Entrepot::where('etat', 'actif')->get();
        return view('admin.entrepot.index', compact('entrepots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire (libelle, color, etc.)
        $request->validate([
            'nom' => 'required|string|max:255',
            'emplacement' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $saving= Entrepot::create([
                'uuid'=>Str::uuid(),
                'nom' => $request->nom,
                'emplacement' => $request->emplacement,
                'capacity' => $request->capacity,
                'color' => $request->color,
                'description' => $request->description,
                'etat' => 'actif',
                'code' => Refgenerate(Entrepot::class, 'ENT', 'code'),
            ])->save();

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Enregistré avec succès!",
                    'code'=>200,
                ];
                DB::commit();
           } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de l'enregistrement!",
                    'code'=>500,
                ];
           }

        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme! $th",
                'code'=>500,
            ];
        }
        return response()->json($dataResponse);
    }
    public function show(string $id)
    {

            $entrepot = Entrepot::where('uuid', $id)->first();


            if ($entrepot) {

                $productsGroupedByFamily = Article::where(['entrepot_uuid'=> $id, 'status' => 'stocked'])
                ->with('familly')
                ->get()
                ->groupBy('familly.libelle');

                // Comptez le nombre total de familles de produits dans cet entrepôt
                $totalFamiliesInEntrepot = $productsGroupedByFamily->count();

                // Récupérez le nombre de produits distincts dans cet entrepôt
                $totalDistinctProductsInEntrepot = Article::where(['entrepot_uuid'=> $id, 'status' => 'stocked'])
                ->distinct('numero_serie')
                ->count();

                $totalAmountInEntrepot = Article::where(['entrepot_uuid'=> $id, 'status' => 'stocked'])->sum('price_unitaire');

                // dd($totalDistinctProductsInEntrepot);
                // Récupérez tous les produits dans cet entrepôt
                $productsInEntrepot = Article::where(['entrepot_uuid'=> $id, 'status' => 'stocked'])->get();

                return view('admin.entrepot.show', compact('productsInEntrepot', 'totalDistinctProductsInEntrepot', 'totalFamiliesInEntrepot', 'totalAmountInEntrepot', 'entrepot'));
            }
    }


    // EntrepotController.php

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
        // Valider les données du formulaire (libelle, color, etc.)
        $request->validate([
            'nom' => 'required|string|max:255',
            'emplacement' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $saving= Entrepot::where('uuid', $id)->update([
                'nom' => $request->nom,
                'emplacement' => $request->emplacement,
                'capacity' => $request->capacity,
                'color' => $request->color,
                'description' => $request->description,
            ]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Enregistré avec succès!",
                    'code'=>200,
                ];
                DB::commit();
           } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de l'enregistrement!",
                    'code'=>500,
                ];
           }

        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme! $th",
                'code'=>500,
            ];
        }
        return response()->json($dataResponse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();
        try {

            $saving= Entrepot::where('uuid', $id)->update([
                'etat' => 'inactif'
            ]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Enregistré avec succès!",
                    'code'=>200,
                ];
                DB::commit();
           } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de l'enregistrement!",
                    'code'=>500,
                ];
           }

        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme! $th",
                'code'=>500,
            ];
        }
        return response()->json($dataResponse);
    }
}