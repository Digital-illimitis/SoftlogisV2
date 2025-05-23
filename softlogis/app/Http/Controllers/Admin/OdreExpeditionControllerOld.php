<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Regime;
use App\Models\Article;
use App\Models\Company;
use App\Models\Entrepot;
use App\Models\ExTransit;
use App\Models\Expedition;
use App\Models\OdTransite;
use Illuminate\Support\Str;
use App\Models\ExpTransport;
use Illuminate\Http\Request;
use App\Models\ArticleFamily;
use App\Models\Expedition_File;
use App\Models\Expedition_product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MyLogNotification;

class OdreExpeditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Article::where(['etat' => 'actif', 'status' => 'stocked'])->get();
        $clients = Company::where(['etat' => 'actif', 'type' => 'client'])->get();

        $families = ArticleFamily::where('etat', 'actif')->get();

        $expeditions = Expedition::where('etat', 'actif')->orderBy('created_at', 'desc')->get();

        $entrepots = Entrepot::where('etat', 'actif')->get();

        $regimes = Regime::where('etat', 'actif')->get();
        return view('admin.expedition.index', 
        compact('products','clients','expeditions', 'families', 'entrepots','regimes'));
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

        // dd($request->all());
        DB::beginTransaction();

        try {
            $expeditions = Expedition::create([
                'uuid' => Str::uuid(),
                'num_exp' => 'EXP_' . date('dmY') . '_' . Str::random(5),
                'lieu_liv' => $request->lieu_liv,
                'date_liv' => $request->date_liv,
                'num_order' => $request->num_order,
                'client_uuid' => $request->client_uuid,
                'regime_uuid' => $request->regime_uuid,
                'incoterm'=> $request->incoterm,
                'etat' => 'actif',
                'created_by' => Auth::user()->name . ' ' . Auth::user()->lastname,
                'code' => 'EXP_' . Str::random(5),
            ]);

            if($request->has('files')){
                $names = $request->input('name');
                foreach($request->file('files') as $key => $file){
                    $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('documents/files');
                    $file->move($destinationPath, $imageName);
                    $filePath = $destinationPath . '/' . $imageName;

                    $expedition_file = Expedition_File::create([
                        'uuid' => Str::uuid(),
                        'name' => $names[$key],
                        'expedition_id' => $expeditions->id,
                        'files' => $imageName,
                        'filePath' => $filePath,
                ]);
                $expedition_file->filePath = $filePath;
                }
            }
            $expeditions->save();

            $productIds = $request->input('product_id');


            // foreach ($productIds as $key => $productId) {
            //     $product = Article::find($productId);

            //     if ($product) {
            //         $expeditions= Expedition_product::create([
            //             'uuid' => Str::uuid(),
            //             'expedition_id' => $expeditions->id,
            //             'famille_uuid' => $product->famille_uuid,
            //             'product_id' => $productId,
            //         ]);
            //     }
            // }

            foreach ($productIds as $productId) {
                $product = Article::find($productId);
        
                if ($product) {
                    Expedition_product::create([
                        'uuid' => Str::uuid(),
                        'expedition_id' => $expeditions->id,
                        'famille_uuid' => $product->famille_uuid,
                        'product_id' => $productId,
                    ]);
                }
            }

            if ($expeditions) {

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
        $expedition = Expedition::where(['uuid'=>$id])->firstOrFail();
        $transitaires = Company::where(['type' => 'transitaire', 'etat' => 'actif'])->get();

        $transporteurs = Company::where(['type' => 'transporteur', 'etat' => 'actif', 'voie_transport' => 'terrestre'])->get();
        $transpormarines = Company::where(['type' => 'transporteur', 'etat' => 'actif', 'voie_transport' => 'maritime'])->get();

        $transit = ExTransit::where('expedition_uuid', $expedition->uuid)->first();
        $transport = ExpTransport::where('expedition_uuid', $expedition->uuid)->first();

        $products = Article::where(['etat' => 'actif', 'status' => 'stocked'])->get();
        $clients = Company::where(['etat' => 'actif', 'type' => 'client'])->get();

        $families = ArticleFamily::where('etat', 'actif')->get();

        $expeditions = Expedition::where('etat', 'actif')->orderBy('created_at', 'desc')->get();

        // dd($transit);

        $entrepots = Entrepot::where(['etat' => 'actif'])->get();

        return view('admin.expedition.show', compact('expedition', 'transitaires', 'transporteurs','transpormarines', 'transit', 'transport', 'products', 'families'));
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
        // dd($request->all());
        DB::beginTransaction();
        try {
            $expeditions = Expedition::where('uuid', $id)->update([
                // 'num_exp' => 'num_exp' => 'EXP_' . date('dmY') . '_' . Str::random(5),
                'lieu_liv' => $request->lieu_liv,
                'date_liv' => $request->date_liv,
                'num_order' => $request->num_order,
                'regime_uuid' => $request->regime_uuid,
                'client_uuid' => $request->client_uuid,
                'incoterm'=> $request->incoterm,
            ]);

            if ($expeditions) {

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

            $saving= Expedition::where(['uuid'=> $id])->update([
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

    public function destroy_file(string $id)
    {
        DB::beginTransaction();
        try {

            $delette = Expedition_File::where(['uuid'=>$id])->update(['etat'=>"inactif"]);
            if ($delette) {
                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> 'back',
                    'message'=>"Supprimé avec succès!",
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

    public function updateProductExpedition(Request $request, string $id)
    {
        $expeditionProduct = Expedition_product::where([
            'expedition_id' => $request->expedition_id,
            'product_id' => $request->product_id
        ])->first();



        if ($expeditionProduct) {

            Article::where('id', $request->product_id)->update(['is_destock' => 'false']);

            $expeditionProduct->delete();

            return response()->json([
                'type' => 'success',
                'urlback' => 'back',
                'message' => 'Produit supprimé avec succès',
            ]);
        }
    }
    public function editProductExpedition(Request $request, string $id)
    {

        $expedition = Expedition::where('uuid', $request->expedition_uuid)->first();

        $productIds = $request->input('product_id');


        foreach ($productIds as $key => $productId) {
            $product = Article::find($productId);

            if ($product) {
                $expeditions= Expedition_product::create([
                    'uuid' => Str::uuid(),
                    'expedition_id' => $expedition->id,
                    'famille_uuid' => $product->famille_uuid,
                    'product_id' => $productId,
                ]);
            }
        }

        return response()->json([
            'type' => 'success',
            'urlback' => 'back',
            'message' => 'Produit ajouté avec succès',
        ]);

    }

    // public function addExpDoc(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {

    //         if($request->has('files')){


    //             foreach($request->file('files') as $key => $file){
    //                 $imageName = 'Exp_' . date('YmdHis') . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
    //                 $destinationPath = public_path('documents/files');
    //                 $file->move($destinationPath, $imageName);
    //                 $filePath = $destinationPath . '/' . $imageName;

    //                 $expedition_file = Expedition_File::create([
    //                     'uuid' => Str::uuid(),
    //                     'name' => $request->input('name')[$key],
    //                     'expedition_id' => $request->expedition_id,
    //                     'files' => $imageName,
    //                     'filePath' => $filePath,
    //                 ]);
    //                 $expedition_file->filePath = $filePath;
    //                 // $expedition_file->save();
    //             }

    //             if ($expedition_file) {

    //                 $dataResponse =[
    //                     'type'=>'success',
    //                     'urlback'=>"back",
    //                     'message'=>"Enregistré avec succès!",
    //                     'code'=>200,
    //                 ];
    //                 DB::commit();

    //            } else {
    //                 DB::rollback();
    //                 $dataResponse =[
    //                     'type'=>'error',
    //                     'urlback'=>'',
    //                     'message'=>"Erreur lors de l'enregistrement!",
    //                     'code'=>500,
    //                 ];
    //            }
    //          }

    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         $dataResponse =[
    //             'type'=>'error',
    //             'urlback'=>'',
    //             'message'=>"Erreur systeme! $th",
    //             'code'=>500,
    //         ];
    //     }
    //     return response()->json($dataResponse);
    // }

    public function addExpDoc(Request $request, $id)
    {

        DB::beginTransaction();
        try {

            if($request->has('files')){
                $names = $request->input('name');
                foreach($request->file('files') as $key => $file){
                    $imageName = 'Exp_' . date('YmdHis') . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('documents/files');
                    $file->move($destinationPath, $imageName);
                    $filePath = $destinationPath . '/' . $imageName;

                    $expedition_file = Expedition_File::create([
                        'uuid' => Str::uuid(),
                        'name' => $names[$key],
                        'expedition_id' => $request->input('expedition_id'),
                        'files' => $imageName,
                        'filePath' => $filePath,
                ]);
                $expedition_file->filePath = $filePath;
                }

                if ($expedition_file) {

                    $dataResponse =[
                        'type'=>'success',
                        'urlback'=>"back",
                        'message'=>"Document modifié avec succès !",
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

    public function ToStarted(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            $saving= Expedition::where('uuid', $id)->update([
                'statut' => 'started',
                'date_started' => Carbon::now(),
            ]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Expedition soumis à validation!",
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

    function ToValidate(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            $saving= Expedition::where('uuid', $id)->update([
                'statut' => 'startedDoc',
                'date_validate_doc' => Carbon::now(),
            ]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Operation reussie !",
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
    // function ToTransit(Request $request, string $id)
    // {
    //     DB::beginTransaction();
    //     try {

    //         $saving= Expedition::where('uuid', $id)->update([
    //             'statut' => 'odTransit',
    //             'date_transit' => Carbon::now(),
    //         ]);
    //         $odExpedition = Expedition::where(['uuid'=>$request->input('expedition_uuid')])->first();

    //         if ($saving) {

    //             $dataResponse =[
    //                 'type'=>'success',
    //                 'urlback'=>"back",
    //                 'message'=>"Expedition Demarré !",
    //                 'code'=>200,
    //             ];
    //             DB::commit();
    //        } else {
    //             DB::rollback();
    //             $dataResponse =[
    //                 'type'=>'error',
    //                 'urlback'=>'',
    //                 'message'=>"Erreur lors de l'enregistrement!",
    //                 'code'=>500,
    //             ];
    //        }

    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         $dataResponse =[
    //             'type'=>'error',
    //             'urlback'=>'',
    //             'message'=>"Erreur systeme! $th",
    //             'code'=>500,
    //         ];
    //     }
    //     return response()->json($dataResponse);
    // }
    function ToWaitExpedite(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            $odExpedition = Expedition::where('uuid', $id)->first();

            $saving= Expedition::where('uuid', $id)->update([
                'statut' => 'wait_exp',
                'dateExpedition' => Carbon::now(),
            ]);

            $product_expedites = $odExpedition->products;

                foreach ($product_expedites as $product_expedite) {
                    $product = $product_expedite->product;
                    if ($product) {
                        $product->update([
                            'status' => 'expEnCours',
                        ]);
                    }
                }

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Expedition en cours de livraison !",
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
    function ToReady(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            $saving= Expedition::where('uuid', $id)->update([
                'statut' => 'livered',
                'dateLivraisonFinal' => Carbon::now(),
            ]);

            $odExpedition = Expedition::where('uuid', $id)->first();

            $productExpedite = $odExpedition->products;

                foreach ($productExpedite as $productUnique) {
                    $product = $productUnique->product;
                    if ($product) {
                        $product->update([
                            'status' => 'delivered',
                        ]);
                    }
                }

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Expedition livré !",
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

    function marckToFactured(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            $saving = Expedition::where('uuid', $id)->update([
                'statut' => 'facturer',
                'dateFacturation' => Carbon::now(),
            ]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Expedition Facturé !",
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

    public function updateDeclaration(Request $request, string $uuid)
    {
        DB::beginTransaction();
        try {
            // Récupérer l'enregistrement du sourcing
            $sourcing = Expedition::where('uuid', $uuid)->firstOrFail();

            // Si un fichier est fourni, gérer son enregistrement
            if ($request->hasFile('declarationFile')) {
                $file = $request->file('declarationFile');
                $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('documents/files'), $imageName);

                // Mettre à jour les informations du fichier et la date de déclaration
                $sourcing->update([
                    'declarationFile' => $imageName, // Sauvegarder juste le nom du fichier
                    'declarationDate' => $request->declarationDate,
                    'declarationNum' => $request->declarationNum,
                ]);
            }

            // Créer un log pour les notifications
            $user = auth()->user();
            $details_log = [
                'url' => route('admin.odre_expedition.show', $uuid),
                'user' => "{$user->name} {$user->lastname}",
                'date' => now(),
                'title' => "Ajout de la déclaration d'import",
                'action' => "Mr/Mme: {$user->name} {$user->lastname} a rajouté la déclaration d'export pour le expedition : {$sourcing->code} le " . now(),
            ];

            // Notifier tous les utilisateurs
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new MyLogNotification($details_log));
            }

            DB::commit();

            // Réponse réussie
            return response()->json([
                'type' => 'success',
                'urlback' => 'back',
                'message' => 'Enregistré avec succès!',
                'code' => 200,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Réponse en cas d'erreur
            return response()->json([
                'type' => 'error',
                'urlback' => '',
                'message' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    

}