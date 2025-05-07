<?php

namespace App\Http\Controllers\Admin;

use App\Models\Document;
use App\Models\GrilleHad;
use App\Models\PorteChar;
use App\Models\Destination;
use App\Models\GrilleTarif;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GrilleTransit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Dollars;
use App\Models\FamillyGroup;
use App\Models\Sign;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function indexGrille()
     {
        $destinations = Destination::where('etat','actif')->get();
        $porteChars = PorteChar::where('etat','actif')->get();
        $grilleHads = GrilleHad::where('etat','actif')->get();
        $grilleTarifaires = GrilleTarif::where('etat','actif')->get();
        $grilleTariftransits = GrilleTransit::with('had')->where(['etat'=>'actif'])->get();

        return view('admin.config.grille', compact('destinations', 'porteChars', 'grilleTarifaires', 'grilleHads', 'grilleTariftransits'));
     }


    public function index()
    {
        $docs = Document::where('etat','actif')->get();
        return view('admin.config.index', compact('docs'));
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
                'nom' => 'string|max:255',
                'type' => 'string|max:255',
            ]);

            DB::beginTransaction();
            try {

                $saving= Document::create([
                    'uuid'=>Str::uuid(),
                    'name' => $request->name,
                    'type' => $request->type,
                    'note' => $request->note,
                    'etat' => 'actif',
                    'code' => Refgenerate(Document::class, 'Doc', 'code'),
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
            'nom' => 'string|max:255',
            'type' => 'string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $saving= Document::where(['uuid'=>$request->id])->update([

                'name' => $request->name,
                'type' => $request->type,
                'note' => $request->note,

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        {

            DB::beginTransaction();
            try {

                $saving= Document::where(['uuid'=>$request->id])->update(['etat'=>"inactif"]);

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

    public function indexDevice()
    {
        $devices = Device::all(); // euro valeur
        $dollar = Dollars::all(); // dollar value
        return view('admin.config.device', compact('devices','dollar'));
    }

    public function addDevice(Request $request)
    {
        {
            $request->validate([
                'valeur' => 'string|max:255',
            ]);

            DB::beginTransaction();
            try {

                $saving= Device::create([
                    'uuid'=>Str::uuid(),
                    'valeur' => $request->valeur,
                    'etat' => 'actif',
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
    public function editDevice(Request $request, $uuid)
    {
        {
            
            DB::beginTransaction();
            try {

                $saving= Device::where(['uuid'=>$uuid])->update([
                    'valeur' => $request->valeur,
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

    public function editDollars(Request $request, $uuid)
    {
            
        DB::beginTransaction();
        try {

            $saving= Dollars::where(['uuid'=>$uuid])->update([
                'value' => $request->value,
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

    public function indexSign()
    {
        $signs = Sign::all();
        return view('admin.config.sign', compact('signs'));
    }
    public function editSign(Request $request, $uuid)
    {
        DB::beginTransaction();
        try {

            $signFile = request()->file('sign');

            $imageName = Str::uuid() . '.' . $signFile->getClientOriginalExtension();
            
            $destinationPath = public_path('documents/files');
            $signFile->move($destinationPath, $imageName);
            $filePath = $destinationPath . '/' . $imageName;

            $sign = Sign::where(['uuid'=>$uuid])->update([
                'sign' => $imageName,
            ]);

            if ($sign) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Modifié avec succes!",
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
    public function addSign(Request $request)
    {
        DB::beginTransaction();
        try {

            $signFile = request()->file('sign');

            $imageName = Str::uuid() . '.' . $signFile->getClientOriginalExtension();
            
            $destinationPath = public_path('documents/files');
            $signFile->move($destinationPath, $imageName);
            $filePath = $destinationPath . '/' . $imageName;

            $sign = Sign::create([
                'uuid'=>Str::uuid(),
                'sign' => $imageName,
                'etat' => 'actif',
            ]);

            if ($sign) {

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

    public function destroySign(Request $request, string $uuid)
    {
        {

            DB::beginTransaction();
            try {

                $saving= Sign::where(['uuid'=>$uuid])->update(['etat'=>"inactif"]);

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


    // Familly group paramettrage

    public function indexFamillyGroup()
    {
        $groups = FamillyGroup::where('etat','actif')->get();

        return view('admin.config.famillyGroup',compact('groups'));
    }

    public function addFamillyGroup(Request $request)
    {
        DB::beginTransaction();
        try {

            $code = Refgenerate(FamillyGroup::class, 'FG', 'code');

            $familly = FamillyGroup::create([
                'uuid'=>Str::uuid(),
                'code'=>$code,
                'libelle'=>$request->libelle,
                'description'=>$request->description,
                'etat' => 'actif',
            ]);

            if ($familly) {

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

    public function destroyFamillyGroup(Request $request, string $uuid)
    {

        DB::beginTransaction();
        try {

            $deleted = FamillyGroup::where(['uuid'=>$uuid])->update(['etat'=>"inactif"]);

            if ($deleted) {

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
