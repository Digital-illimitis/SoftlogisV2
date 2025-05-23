<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleFamily;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familys = ArticleFamily::where('etat', 'actif')->get();
        return view('admin.articleFamily.index', compact('familys'));
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
        {
            // Valider les données du formulaire (libelle, color, etc.)
            $request->validate([
                'libelle' => 'required|string|max:255',
            ]);

            DB::beginTransaction();
            try {

                $saving= ArticleFamily::create([
                    'uuid'=>Str::uuid(),
                    'libelle' => $request->libelle,
                    'color' => $request->color,
                    'description' => $request->description,
                    'etat' => 'actif',
                    'code' => Refgenerate(ArticleFamily::class, 'AF', 'code'),
                ])->save();

                if ($saving) {

                    $dataResponse =[
                        'type'=>'success',
                        'urlback'=>"back",
                        'message'=>"Enregistré avec succes!",
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
        {
            {
                // Valider les données du formulaire (libelle, color, etc.)
                $request->validate([
                    'libelle' => 'string|max:255',
                    'color' => 'string|max:255',
                ]);

                DB::beginTransaction();
                try {

                    $saving= ArticleFamily::where('uuid', $id)->update([
                        'libelle' => $request->libelle,
                        'color' => $request->color,
                        'description' => $request->description,
                    ]);

                    if ($saving) {

                        $dataResponse =[
                            'type'=>'success',
                            'urlback'=>"back",
                            'message'=>"Enregistré avec succes!",
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        {
            DB::beginTransaction();
            try {

                $saving= ArticleFamily::where(['uuid'=> $id])->update(['etat'=>"inactif"]);

                if ($saving) {

                    $dataResponse =[
                        'type'=>'success',
                        'urlback'=>"back",
                        'message'=>"Supprimé avec succes!",
                        'code'=>200,
                    ];
                    DB::commit();
                } else {
                    DB::rollback();
                    $dataResponse =[
                        'type'=>'error',
                        'urlback'=>'',
                        'message'=>"Erreur lors de la suppression!",
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
}
