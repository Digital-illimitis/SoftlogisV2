<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransitaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transitaires = Company::where(['etat'=> 'actif', 'type' => 'transitaire'])->get();

        return view('admin.transitaire.index', compact('transitaires'));
    }

    public function getTransitaireInfo($id)
    {
        $transitaire = Company::where(['id' => $id, 'etat' => 'actif', 'type' => 'transitaire'])->first();

        if ($transitaire) {
            return response()->json($transitaire);
        } else {
            return response()->json(['message' => 'Transitaire non trouvé'], 404);
        }
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
        // Valider les données du formulaire (nom, email, etc.)
        $request->validate([
            'raison_sociale' => 'required|string|max:255',
            'email' => 'required|string|email|unique:companies,email',
        ]);

        DB::beginTransaction();
        try {

             // add profil img
             $logo= $request->logo ?? "";
             if($logo == null) {
              $logo = 'default_logo.jpg';
             }else{
                 $file = $request->file('logo');
              //    dd($logo);
                 $logo = Str::uuid().'.'.$file->getClientOriginalExtension();
                 $file->move('files/',$logo);
             }

            $uuid_company = Str::uuid();

            $saving= Company::create([
                'uuid'=>$uuid_company,
                'logo' => $logo,
                'raison_sociale' => $request->raison_sociale,
                'phone' => $request->phone,
                'identification' => $request->identification,
                'email' => $request->email,
                'localisation' => $request->localisation,
                'description' => $request->description,
                'type' => 'transitaire', // transitaire
                'code' => Refgenerate(Company::class, 'T', 'code'),
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transitaire = Company::where(['uuid'=>$id])->first();
        return view('admin.transitaire.show', compact('transitaire'));
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
        // Valider les données du formulaire (nom, email, etc.)
        $request->validate([
            'raison_sociale' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
        ]);

        DB::beginTransaction();
        try {

            $company = Company::where(['uuid'=>$id])->first();

            $logo = $company->logo; // Utilisez l'ancien logo par défaut

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $logo = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move('files/', $logo);
            }

            $saving= Company::where(['uuid'=>$id])->update([
                'logo' => $logo,
                'raison_sociale' => $request->raison_sociale,
                'phone' => $request->phone,
                'identification' => $request->identification,
                'email' => $request->email,
                'localisation' => $request->localisation,
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
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $deleted = Company::where(['uuid'=>$request->id])->update(['etat'=>"inactif"]);
            if ($deleted) {
                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Opération effectuée avec succès",
                    'code' => 200,
                ];
                DB::commit();
                return response()->json($dataResponse);
            }
            else{
                $dataResponse = [
                    'type' => 'warning',
                    'urlback' => "back",
                    'message' => "l'opération a échouée",
                    'code' => 500,
                ];
                DB::rollback();
                return response()->json($dataResponse);
            }
        } catch (\Exception $e) {

            $dataResponse = [
                'type' => 'warning',
                'urlback' => '',
                'message' => "l'Opération a échouée contactez l'administrateur".$e,
                'code' => 500,
            ];
            DB::rollback();
            return response()->json($dataResponse);
        }

    }
}