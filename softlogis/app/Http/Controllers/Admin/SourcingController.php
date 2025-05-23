<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Regime;
use App\Models\Article;
use App\Models\Company;
use App\Models\Document;
use App\Models\Entrepot;
use App\Models\Sourcing;
use App\Models\OdTransite;
use App\Mail\LogisticaMail;
use App\Models\OdLivraison;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleFamily;
use App\Models\Sourcing_file;
use App\Models\DocumentRequis;
use App\Models\Sourcing_product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\TransportDestination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Notifications\MyLogNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SourcingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        $products = Article::where('etat', 'actif')->whereNotIn('status', ['stocked', 'expEnCours', 'delivered'])->where('is_AddSourcing', 'false')->get();
        // dd($products->first());
        // $sourcings = Sourcing::where('etat', 'actif')->get();
        $sourcings = Sourcing::where('etat', 'actif')
                     //->latest()
                     ->orderBy('created_at', 'desc')
                     ->get();

   
        $families = ArticleFamily::where('etat', 'actif')->get();

        $regimes = Regime::where('etat', 'actif')->get();

        $documentRequises = DocumentRequis::where('etat', 'actif')->get();

        $destinations = TransportDestination::where('etat', 'actif')->get();

        return view('admin.sourcing.index', compact('products', 'sourcings', 'families', 'regimes', 'documentRequises', 'destinations'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $products = Article::where('etat', 'actif')->whereNotIn('status', ['stocked', 'expEnCours', 'delivered'])->where('is_AddSourcing', 'false')->get();

        $families = ArticleFamily::where('etat', 'actif')->get();

        $regimes = Regime::where('etat', 'actif')->get();

        $documentRequises = DocumentRequis::where('etat', 'actif')->get();

        $destinations = TransportDestination::where('etat', 'actif')->get();

        return view('admin.sourcing.create', compact('products', 'families', 'regimes', 'documentRequises', 'destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->date_arriver < $request->date_depart) {
            return response()->json([
                'type' => 'error',
                'urlback' => '',
                'message' => 'La date d\'arriver doit être inferieur ou egale a la date de depart.',
                'code' => 400,
            ]);
        }
        $uuid = Str::uuid();
        $code = Refgenerate(Sourcing::class, 'S', 'code');
        // dd($request->all());
        DB::beginTransaction();
        try {
            $sourcing = Sourcing::create([
                'uuid' => $uuid,
                'statut' => 'draft',
                'id_navire' => $request->id_navire,
                'packaging' => $request->packaging,
                'info_navire' => $request->info_navire,
                'date_arriver' => $request->date_arriver,
                'date_depart' => $request->date_depart,
                'numDossier' => $request->numDossier,
                'num_bl' => $request->num_bl,
                'regime_uuid' => $request->regime_uuid,
                'note' => $request->note,
                'created_by' => Auth::user()->name . ' ' . Auth::user()->lastname,

                'etat' => 'actif',
                'code' => $code,


            ]);

            if ($sourcing) {
                
                $users = User::all();
                $user = auth()->user()->name." ".auth()->user()->lastname;
                $details_log = [
                    // 'url' => url()->current(),
                    'url' => route('admin.sourcing.show', $uuid),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "Enregistrement",
                    'action' => "Création d'une nouvelle compagnie ".$request->raison_sociale, 
                ];

                // Assurez-vous que $users est une collection d'instances de User
                foreach ($users as $user) {
                    $user->notify(new MyLogNotification($details_log));
                }

                DB::commit();
            }

            if ($request->has('files')) {
                $names = $request->input('name');
                $doc_requis_uuid = $request->input('doc_requis_uuid');
            
                foreach ($request->file('files') as $key => $file) {
                    $imageName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('documents/files');
                    $file->move($destinationPath, $imageName);
                    $filePath = $destinationPath . '/' . $imageName;
            
                    // Initialisation de $fileLibelle par défaut
                    $fileLibelle = "..."; // Valeur par défaut si rien n'est fourni
            
                    // Vérification si le document requis est défini
                    if (!empty($doc_requis_uuid[$key])) {
                        $documentRequis = DocumentRequis::where('uuid', $doc_requis_uuid[$key])->first();
                        if ($documentRequis) {
                            $fileLibelle = $documentRequis->libelle;
                        }
                    }
            
                    // Si $fileLibelle n'est toujours pas défini, utiliser le nom fourni
                    if (empty($fileLibelle) && !empty($names[$key])) {
                        $fileLibelle = $names[$key];
                    }
            
                    // Création du fichier de sourcing
                    $sourcing_file = Sourcing_file::create([
                        'uuid' => Str::uuid(),
                        'name' => $fileLibelle,
                        'doc_requis_uuid' => $doc_requis_uuid[$key] ?? "",
                        'sourcing_id' => $sourcing->id,
                        'files' => $imageName,
                        'filePath' => $filePath,
                    ]);
            
                    // Notification en cas de succès
                    if ($sourcing_file) {
                        $users = User::all();
                        $user = auth()->user()->name . " " . auth()->user()->lastname;
                        $details_log = [
                            'url' => route('admin.sourcing.show', $uuid),
                            'user' => $user,
                            'date' => now(),
                            'title' => "Document ajouté Sourcing : " . $sourcing->code,
                            'action' => "Nouveau document ajouté: " . $fileLibelle,
                        ];
            
                        // Envoi des notifications à tous les utilisateurs
                        foreach ($users as $user) {
                            $user->notify(new MyLogNotification($details_log));
                        }
            
                        DB::commit();
                    }
                }
            }
            
            $sourcing->save();

            $productIds = $request->input('product_uuid');

            if (!empty($productIds)) {
                foreach ($productIds as $productId) {
                    
                    $product = Article::where('uuid', $productId)->first();

                    if ($product) {

                        $existingSourcingProduct = $sourcing->products()
                            ->where('product_uuid', $productId)
                            ->first();

                        if ($existingSourcingProduct) {
                            // Vous pouvez ajouter des actions spécifiques si le produit existe déjà dans le sourcing
                        } else {
                            $sourcing->products()->create([
                                'famille_uuid' => $product->famille_uuid,
                                'uuid' => Str::uuid(),
                                'etat' => 'actif',

                                'product_uuid' => $product->uuid,
                                'product_id' => $product->id,
                            ]);

                            $productAddSourcing = Article::where('uuid', $productId)->update([
                                'is_AddSourcing' => 'true',
                                'date_Eta' => $request->date_arriver,
                            ]);
                        }
                    }
                }
            }

            $sourcingFirst = Sourcing::where('uuid', $uuid)->first();

            if ($sourcing) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>route('admin.sourcing.show', $sourcingFirst->uuid),
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
     * Store a newly created resource in storage.
     */
    public function add_documents(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();

        try {
            $user = Auth::user()->name . ' ' . Auth::user()->lastname;

            if($request->has('files')){
                $names = $request->input('name');
                foreach($request->file('files') as $key => $file){
                 $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                //  $imageName = $file->getClientOriginalName();
                 $destinationPath = public_path('documents/files');
                 $file->move($destinationPath, $imageName);
                 $filePath = $destinationPath . '/' . $imageName;

                 $sourcing_file = Sourcing_file::create([
                    'uuid' => Str::uuid(),
                    'name' => $names[$key],
                    // 'name' => $request->name,
                    'sourcing_id' => $request->sourcing_id,
                    'files' => $imageName,
                    'filePath' => $filePath,
                 ]);

                 $sourcingUuid = Sourcing::where('id', $request->sourcing_id)->first();

                $sourcing_file->filePath = $filePath;

                }

                if ($sourcing_file) {

                    $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.sourcing.show', $sourcingUuid->uuid),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Document ajouté Sourcing",
                        'action' => "Un nouveau document ajouté au sourcing : ".$sourcingUuid->code, 
                    ];
    
                    // Assurez-vous que $users est une collection d'instances de User
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }

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

        $sourcing = Sourcing::where(['uuid'=>$id])->firstOrFail();

        $otBySourcing = OdLivraison::where(['sourcing_id' => $sourcing->uuid, 'etat' => 'actif'])->get();

        $transporteurs = Company::where(['type'=>'transporteur', 'etat'=>'actif','voie_transport'=>'terrestre'])->get();

        $transitaires = Company::where(['etat'=> 'actif', 'type' => 'transitaire'])->get();

        $sourcing_files = Sourcing_file::where(['sourcing_id'=>$sourcing->id])->where('etat', 'actif')->get();

        $transit = OdTransite::where(['sourcing_uuid' => $sourcing->uuid, 'etat' => 'actif'])->first();
        $transport = OdLivraison::where(['sourcing_id' => $sourcing->uuid, 'etat' => 'actif'])->first();

        $entrepots = Entrepot::where('etat', 'actif')->get();

        $products = Article::where('etat', 'actif')->get();
        
        $destinations = TransportDestination::where('etat', 'actif')->get();

        return view('admin.sourcing.show', compact('sourcing', 'sourcing_files', 'transporteurs', 'transitaires','transit', 'transport', 'entrepots', 'products', 'destinations', 'otBySourcing'));
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
        

        DB::beginTransaction();
        try {
            $sourcing = Sourcing::where('uuid', $id)->update([
                'id_navire' => $request->id_navire,
                'packaging' => $request->packaging,
                'info_navire' => $request->info_navire,
                'date_arriver' => $request->date_arriver,
                'date_reel_arriver' => $request->date_reel_arriver,
                'date_depart' => $request->date_depart,
                'numDossier' => $request->numDossier,
                'num_bl' => $request->num_bl,
                'regime_uuid' => $request->regime_uuid,
                'note' => $request->note,
            ]);
            if ($sourcing) {

                $sourcingUuid = Sourcing::where('uuid', $id)->firstOrFail();

                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.sourcing.show', $id),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Modification Sourcing",
                        'action' => "Le sourcing  : ".$sourcingUuid->code. " a ete modifié", 
                    ];
    
                    // Assurez-vous que $users est une collection d'instances de User
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }

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



    public function updateProductSourcing(Request $request, string $id)
    {
        $sourcingProduct = Sourcing_product::where([
            'sourcing_id' => $request->sourcing_id,
            'product_id' => $request->product_id
        ])->first();

        $updateProductSourcing = Article::where('id', $request->product_id)->update([
            'is_AddSourcing' => 'false',
        ]);

        if ($sourcingProduct) {
            $sourcingProduct->delete();

            // $sourcingUuid = Sourcing::where('id', $id)->firstOrFail();

            //     $users = User::all();
            //         $user = auth()->user()->name." ".auth()->user()->lastname;
            //         $details_log = [
            //             // 'url' => url()->current(),
            //             'url' => route('admin.sourcing.index'),
            //             'user' => $user,
            //             'date' => date('Y-m-d H:i:s'),
            //             'title' => "Modification Sourcing",
            //             'action' => "Le sourcing  : ".$sourcingUuid->code. " a ete supprimé", 
            //         ];
    
            //         // Assurez-vous que $users est une collection d'instances de User
            //         foreach ($users as $user) {
            //             $user->notify(new MyLogNotification($details_log));
            //         }

            return response()->json([
                'type' => 'success',
                'urlback' => 'back',
                'message' => 'Produit Supprimé avec succès',
            ]);
        }
    }
    public function editProductSourcing(Request $request, string $id)
    {
        $productIds = $request->input('product_uuid');
        $sourcing = Sourcing::where('uuid', $request->sourcing_uuid)->first();

        if (!empty($productIds)) {
            foreach ($productIds as $productId) {
                $product = Article::where('uuid', $productId)->first();
                if ($product) {
                    $sourcing->products()->create([
                        'famille_uuid' => $product->famille_uuid,
                        'uuid' => Str::uuid(),
                        'etat' => 'actif',
                        'product_uuid' => $product->uuid,
                        'product_id' => $product->id,
                    ])->save();

                }
            }
        }

        return response()->json([
            'type' => 'success',
            'urlback' => 'back',
            'message' => 'Produit ajouté avec succès',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {

        DB::beginTransaction();
        try {

            $saving= Sourcing::where(['uuid'=>$request->id])->update(['etat'=>"inactif"]);

            if ($saving) {

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

    function ToStartedSourcing(Request $request, string $id) // btn soumettre change statut to demarrer 'started'
    {
        DB::beginTransaction();
        try {

            $saving= Sourcing::where('uuid', $id)->update([
                'statut' => 'started',
                'tostarted_by' => auth()->user()->uuid,
                'tostarted_date' => Now(),
            ]);

            if ($saving) {

                $sourcingUuid = Sourcing::where('uuid', $id)->firstOrFail();

                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.sourcing.show', $id),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Démarrage Sourcing",
                        'action' => "Le sourcing  : ".$sourcingUuid->code. " a ete demarré", 
                    ];
    
                    // Assurez-vous que $users est une collection d'instances de User
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Sourcing soumis à validation Documentaire!",
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
    function TostartValidateDoc(Request $request, string $id) // btn Demarrer validation documentaire
    {
        DB::beginTransaction();
        try {

            $saving= Sourcing::where('uuid', $id)->update([
                'statut' => 'validateDoc',
                'startValidate_by' => auth()->user()->uuid,
                'startValidate_date' => now(),
            ]);

            if ($saving) {

                $sourcingUuid = Sourcing::where('uuid', $id)->firstOrFail();

                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.sourcing.show', $id),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Mise a jour de sourcing",
                        'action' => "Le sourcing  : ".$sourcingUuid->code. " est passé en attente de validation des documents le :".now(), 
                    ];
    
                    // Assurez-vous que $users est une collection d'instances de User
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Operation reussie!",
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



    public function validate_sourcing($id)
    {
        DB::beginTransaction();
        try {
            $validate = Sourcing_file::findOrFail($id);
            $validate->statut = "validate";
            $validate->save();

            if ($validate) {

                $sourcingUuid = Sourcing::where('id', $validate->sourcing_id)->firstOrFail();

                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.sourcing.show', $sourcingUuid->uuid),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Mise a jour de sourcing",
                        'action' => "Le document $validate->name du sourcing  : ".$sourcingUuid->code. " a été validé le :".now(), 
                    ];
    
                    // Assurez-vous que $users est une collection d'instances de User
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Document Validé !",
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

    public function refused_sourcing($id)
    {
        DB::beginTransaction();
        try {
            $validate = Sourcing_file::findOrFail($id);
            $validate->statut = "refused";
            $validate->save();

            if ($validate) {

                $sourcingUuid = Sourcing::where('id', $validate->sourcing_id)->firstOrFail();

                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.sourcing.show', $sourcingUuid->uuid),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Mise a jour de sourcing",
                        'action' => "Le document $validate->name du sourcing  : ".$sourcingUuid->code. " a été rejeté le :".now(),  
                    ];
    
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Document refusé !",
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

    public function edit_documents(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            if($request->has('files')){
                $names = $request->input('name');
                foreach($request->file('files') as $key => $file){
                 $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                //  $imageName = $file->getClientOriginalName();
                 $destinationPath = public_path('documents/files');
                 $file->move($destinationPath, $imageName);
                 $filePath = $destinationPath . '/' . $imageName;

                $validate = Sourcing_file::findOrFail($id);
                $validate->name = $names[$key];
                $validate->files = $imageName;
                $validate->filePath = $filePath;
                $validate->save();
                //$validate->filePath = $filePath;
                }

                if ($validate) {

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

    public function receptCommercialFact(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = Sourcing::where('uuid', $request->sourcing_uuid)->first();
            $validate->date_receivFactCom = Carbon::Now();
            $validate->is_receivFactCom = 'true';
            $validate->save();

            if ($validate) {

                $sourcingUuid = Sourcing::where('uuid', $request->sourcing_uuid)->firstOrFail();

                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.sourcing.show', $request->sourcing_uuid),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Mise a jour de sourcing",
                        'action' => "Facture commerciale reçue :".$sourcingUuid->code." Le ".now(), 
                    ];
    
                    // Assurez-vous que $users est une collection d'instances de User
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Réception confirmée !",
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

    public function sendEmail(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $recipientEmail = $request->input('destinataire');
            $emailSubject = $request->input('objet');
            $message = $request->input('message');

            $mailData = [
                'title' => $emailSubject,
                'body' => $message,
            ];

            $mail = new LogisticaMail($mailData, $emailSubject);

            $mailSending = Mail::to($recipientEmail)->send($mail);

            if ($mailSending) {

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

    // script de mis a jour de la declaration de fournisseur
   
    public function updateDeclaration(Request $request, string $uuid)
    {
        DB::beginTransaction();
        try {
            // Récupérer l'enregistrement du sourcing
            $sourcing = Sourcing::where('uuid', $uuid)->firstOrFail();

            // Si un fichier est fourni, gérer son enregistrement
            if ($request->hasFile('declarationFile')) {
                $file = $request->file('declarationFile');
                $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('documents/files'), $imageName);

                // Mettre à jour les informations du fichier et la date de déclaration
                
            }else{
                $imageName = $sourcing->declarationFile ?? '';
            }

            $sourcing->update([
                'declarationFile' => $imageName, // Sauvegarder juste le nom du fichier
                'declarationDate' => $request->declarationDate,
                'declarationNum' => $request->declarationNum,
            ]);

            // Créer un log pour les notifications
            $user = auth()->user();
            $details_log = [
                'url' => route('admin.sourcing.show', $uuid),
                'user' => "{$user->name} {$user->lastname}",
                'date' => now(),
                'title' => "Ajout de la déclaration d'import",
                'action' => "Mr/Mme: {$user->name} {$user->lastname} a rajouté la déclaration d'import pour le sourcing : {$sourcing->code} le " . now(),
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