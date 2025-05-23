<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Marque;
use App\Models\Source;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ArticleModel;
use Illuminate\Http\Request;
use App\Models\ArticleFamily;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\MyLogNotification;
use App\Mail\LogisticaMail;
use App\Models\FamillyGroup;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::where('etat', 'actif')->get();
        $marques = Marque::where('etat', 'actif')->get();
        $sources = Source::where('etat', 'actif')->get();
        $articleModels = ArticleModel::where('etat', 'actif')->get();
        $articleFamilys = ArticleFamily::where('etat', 'actif')->get();
        $famillyGroups = FamillyGroup::where('etat', 'actif')->get();

        $articles = Article::where('etat', 'actif')->with('familly', 'model')->orderBy('created_at', 'desc')->get();

        $familleId = $request->input('famille_id');
        $modelId = $request->input('model_id');

        if ($request->has('famille_id')) {
            if ($familleId != "all") {
                $articles = $articles->filter(function ($article) use ($request) {
                    return $article->familly && $article->familly->uuid == $request->input('famille_id');
                });
            }
        }

        if ($request->has('model_id')) {
            if ($modelId != "all") {
                $articles = $articles->filter(function ($article) use ($request) {
                    return $article->model && $article->model->uuid == $request->input('model_id');
                });
            }
        }

        // dd($famillyGroups);

        $allArticles = Article::where('etat', 'actif')->get();

        return view('admin.article.index', compact('categories', 'marques', 'articles', 'sources', 'articleModels', 'articleFamilys','allArticles','famillyGroups'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            $image= $request->image ?? "";
               if($image == null) {
                $image= 'default_logo.jpg';
               }else{
                   $file = $request->file('image');
                //    dd($image);
                   $image = Str::uuid().'.'.$file->getClientOriginalExtension();
                   $file->move('files/',$image);
               }
               $code = Refgenerate(Article::class, 'Article', 'code');
               $uuid = Str::uuid();

            $saving= Article::create([
                'uuid'=> $uuid,
                // 'model_uuid' => $request->model_uuid,
                'model_Materiel' => $request->model_Materiel,
                'numero_bon_commande' => $request->numero_bon_commande,
                'numero_serie' => $request->numero_serie,
                'famille_uuid' => $request->famille_uuid,
                'description' => $request->description, 
                'packaging' => $request->packaging,
                'type_container' => $request->type_container,
                'image' => $image,
                'status' => $request->status,
                'familyGroup' => $request->familyGroup,
                'num_billOfLading' => $request->num_billOfLading,
                'marque_uuid' => $request->marque_uuid,
                //'date_reception' => $request->date_reception,
                //'date_stockage' => $request->date_stockage,
                //'date_outStock' => $request->date_outStock, 
                'categorie_uuid' => $request->categorie_uuid,
                'poid_tonne' => $request->poid_tonne,
                'hauteur' => $request->hauteur,
                'largeur' => $request->largeur,
                'volume' => $request->volume,
                'longueur' => $request->longueur,
                'price_unitaire' => $request->price_unitaire,
                'price_dollars' => $request->price_dollars,
                'price_euro' => $request->price_euro,
                'source_uuid' => $request->source_uuid,
                'etat' => 'actif',
                'code' => $code,
            ])->save();

            // dd($saving);

            if ($saving) {
                $users = User::all();
                $user = auth()->user()->name." ".auth()->user()->lastname;
                $details_log = [
                    // 'url' => url()->current(),
                    'url' => route('admin.article.show',$uuid),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "Enregistrement",
                    'action' => "Création d'un nouveau produit ".$code." avec l'N°serie ".$request->numero_serie, 
                ];
                
                
                $transitaireNames = DB::table('users')->where('id', Auth::user()->id)->first();
                $transitaireName = $transitaireNames->name." ".$transitaireNames->lastname;
                $vient_dajouter = "vient d'ajouter un article.";
                $mailData = [
                                'title' => "Ajout de l'article",
                        'body' => 'Bonjour JALÔ,<br><br>'.$transitaireName." ".$vient_dajouter." ".'<br><br>
                                   Vous pouvez le consulter en vous connectant.<br><br>
                                   <a href="https://dev.soft-logis.com" style="display:inline-block;padding:5px 10px;background-color:#007bff;color:white;text-decoration:none;border-radius:5px;">
                                   Connectez-vous!</a><br><br>
                                   Cordialement.'
                    ];


                $jalo = "exploitation@jalo-logistics.com";
                //$jalo = "margareth.o@illimitis.com";
                $emailSubject = "Jalo Logistics - Ajout d'un article par".":"." ".$transitaireName;

                $mail = new LogisticaMail($mailData, $emailSubject);
                Mail::to($jalo)->send($mail);

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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categories = Category::where('etat', 'actif')->get();
        $marques = Marque::where('etat', 'actif')->get();
        $sources = Source::where('etat', 'actif')->get();

        $articleModels = ArticleModel::where('etat', 'actif')->get();
        $articleFamilys = ArticleFamily::where('etat', 'actif')->get();

        $article = Article::where(['uuid'=>$id, 'etat'=>'actif'])->firstOrFail();

        $famillyGroups = FamillyGroup::where('etat', 'actif')->get();
        // dd($article);
        return view('admin.article.show', compact('article', 'categories', 'marques', 'sources', 'articleModels', 'articleFamilys','famillyGroups'));
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



            DB::beginTransaction();
            try {
                $article = Article::where(['uuid' => $id])->first();
                $imageExisting = $article->image;

                $image= $request->image ?? "";
                   if($image == null) {
                    $image= $imageExisting;
                   }else{
                       $file = $request->file('image');
                    //    dd($image);
                       $image = Str::uuid().'.'.$file->getClientOriginalExtension();
                       $file->move('files/',$image);
                   }


                $saving= Article::where(['uuid'=>$id])->update([

                    'famille_uuid' => $request->famille_uuid,
                    'description' => $request->description,
                    // 'model_uuid' => $request->model_uuid,
                    'model_Materiel' => $request->model_Materiel,
                    'numero_bon_commande' => $request->numero_bon_commande,
                    'numero_serie' => $request->numero_serie,
                    'marque_uuid' => $request->marque_uuid,
                    'date_reception' => $request->date_reception,
                    'date_stockage' => $request->date_stockage,
                    'date_outStock' => $request->date_outStock,
                    'categorie_uuid' => $request->categorie_uuid,
                    'poid_tonne' => $request->poid_tonne,
                    'familyGroup' => $request->familyGroup,
                    'num_billOfLading' => $request->num_billOfLading,
                    'hauteur' => $request->hauteur,
                    'largeur' => $request->largeur,
                    'volume' => $request->volume,
                    'longueur' => $request->longueur,
                    'price_unitaire' => $request->price_unitaire,
                    'price_dollars' => $request->price_dollars,
                    'price_euro' => $request->price_euro,
                    'source_uuid' => $request->source_uuid,
                    'image' => $image,

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {

        {

            DB::beginTransaction();
            try {

                $saving= Article::where(['uuid'=>$request->id])->update(['etat'=>"inactif"]);

                if ($saving) {

                    $dataResponse =[
                        'type'=>'success',
                        'urlback'=> route('admin.article.index'),
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

    }

    public function markToFabrication(Request $request, string $id){

        DB::beginTransaction();
        try {
            $saving= Article::where(['uuid'=>$id])->update(['status'=>"enFabrication"]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> "back",
                    'message'=>"Modifié avec succès!",
                    'code'=>200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de la modification!",
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
    public function markToOutUsine(Request $request, string $id){

        DB::beginTransaction();
        try {
            $saving= Article::where(['uuid'=>$request->product])->update(['status'=>"sortiUsine"]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> 'back',
                    'message'=>"Modifié avec succès!",
                    'code'=>200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de la modification!",
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
    public function markToWaitExpedit(Request $request, string $id){

        DB::beginTransaction();
        try {
            $saving= Article::where(['uuid'=>$id])->update(['status'=>"enExpedition"]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> 'back',
                    'message'=>"Modifié avec succès!",
                    'code'=>200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de la modification!",
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
    public function markToarrivedPod(Request $request, string $id){

        DB::beginTransaction();
        try {
            $saving= Article::where(['uuid'=>$id])->update(['status'=>"arriverAuPod"]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> 'back',
                    'message'=>"Modifié avec succès!",
                    'code'=>200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de la modification!",
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
    public function markToExpedite(Request $request, string $id){

        DB::beginTransaction();
        try {
            $saving= Article::where(['uuid'=>$id])->update(['status'=>"expedier"]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> 'back',
                    'message'=>"Modifié avec succès!",
                    'code'=>200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de la modification!",
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
    public function searchByNumeroSerie($input) {
        // Logique de recherche des produits en fonction du numéro de série
        $products = Article::where('numero_serie', 'LIKE', '%' . $input . '%')
        ->whereNotIn('status', ['received', 'stocked', 'expEnCours', 'delivered'])
        ->get();

        return response()->json(['products' => $products]);
    }
    public function tagproductByNumSeri($input) {
        // Logique de recherche des produits en fonction du numéro de série
        $products = Article::where('uuid', 'LIKE', '%' . $input . '%')
        ->where('etat', 'actif')
        ->firstOrfail();

        $productByfamilly = $products->familly->libelle;

        $data = [
            'products' => $products,
            'productByfamilly' => $productByfamilly
        ];

        return response()->json($data);
    }
    public function search(Request $request)
    {
        $searchQuery = $request->input('searchQuery');

        if($request->input('searchQuery')){
            $articles = Article::where('numero_serie', 'like', '%' . $searchQuery . '%')->get();
        }else{
            $articles = Article::where('etat', 'actif')
            ->get();
        }
        return response()->json(['articles' => $articles]);
    }
    public function searchByBonCommand($input) {
        // Logique de recherche des produits en fonction du Bon commande
        $products = Article::where('numero_bon_commande', 'LIKE', '%' . $input . '%')
        ->where('is_AddSourcing', 'false')
        ->whereNotIn('status', ['received', 'stocked', 'expEnCours', 'delivered'])
        ->get();

        return response()->json(['products' => $products]);
    }
}