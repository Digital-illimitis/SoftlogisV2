<?php

namespace App\Http\Controllers\Admin;

use App\Models\Arret;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TransportDestination;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $destinations = TransportDestination::where('etat', 'actif')->get();
        $arrets = Arret::where('etat', 'actif')->get();
        return view('admin.config.destination', compact('destinations', 'arrets'));
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
        // Valider les données du formulaire (libelle)
        $request->validate([
            'libelle' => 'required|string|max:255'
        ]);

        DB::beginTransaction();
        try {

            $saving= TransportDestination::create([
                'uuid'=>Str::uuid(),
                'libelle' => $request->libelle,
                'description' => $request->description,
                'etat' => 'actif',
                'code' => Refgenerate(TransportDestination::class, 'DEST', 'code'),
            ]);

            if ($request->has('arret_ids')) {
                $saving->arrets()->attach($request->arret_ids);
            }

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

        // Valider les données du formulaire (libelle)
        $request->validate([
            'libelle' => 'required|string|max:255'
        ]);

        DB::beginTransaction();
        try {

            try {
                $destination = TransportDestination::where('uuid', $id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return redirect()->back()->with('error', 'Destination introuvable.');
            }

            $destination->update([
                'libelle' => $request->libelle,
                'description' => $request->description,
            ]);

            if ($request->has('arret_ids')) {
                $destination->arrets()->syncWithoutDetaching($request->arret_ids);
            }

            

            if ($destination) {

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

            $saving= TransportDestination::where('uuid', $id)->update([
                'etat' => 'inactif',
            ]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Supprimé avec succès!",
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