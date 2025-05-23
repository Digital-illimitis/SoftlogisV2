<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Article;
use App\Models\Company;
use App\Models\Sourcing;
use App\Models\Expedition;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleFamily;
use App\Models\Expedition_File;
use App\Models\Expedition_product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MyLogNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        
        // stock en cours
        $stockGlobals = Article::where('etat', 'actif')->get();

        $inFabrication = Article::where(['etat' => 'actif', 'status' => 'enFabrication'])->get();
        $inUsineOut = Article::where(['etat' => 'actif', 'status' => 'sortiUsine'])->get();
        $inWaitExpediteImport = Article::where(['etat' => 'actif', 'status' => 'enExpedition'])->get();
        $arrivagePod = Article::where(['etat' => 'actif', 'status' => 'arriverAuPod'])->get();
        $receivStock = Article::where(['etat' => 'actif', 'status' => 'stocked'])->get();
        $inWaitExpediteExport = Article::where(['etat' => 'actif', 'status' => 'expEnCours'])->get();
        $liverExpedite = Article::where(['etat' => 'actif', 'status' => 'delivered'])->get();

       

        
        // Calcul du pourcentage par statut

        if ($inFabrication->count() > 0 && $stockGlobals->count() > 0) {
            $percentageInFabrication = round(($inFabrication->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageInFabrication = 0;
        }

        if ($inUsineOut->count() > 0 && $stockGlobals->count() > 0) {   
            $percentageinUsineOut = round(($inUsineOut->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinUsineOut = 0;
        }

        if ($inWaitExpediteImport->count() > 0 && $stockGlobals->count() > 0) {
            $percentageinWaitExpediteImport = round(($inWaitExpediteImport->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinWaitExpediteImport = 0;
        }

        if ($arrivagePod->count() > 0 && $stockGlobals->count() > 0) {
            $percentagearrivagePod = round(($arrivagePod->count() / $stockGlobals->count()) * 100);
        } else {
            $percentagearrivagePod = 0;
        }

        if ($receivStock->count() > 0 && $stockGlobals->count() > 0) {
            $percentagereceivStock = round(($receivStock->count() / $stockGlobals->count()) * 100);
        } else {
            $percentagereceivStock = 0;
        }

        if ($inWaitExpediteExport->count() > 0 && $stockGlobals->count() > 0) {
            $percentageinWaitExpediteExport = round(($inWaitExpediteExport->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinWaitExpediteExport = 0;
        }

        if ($liverExpedite->count() > 0 && $stockGlobals->count() > 0) {
            $percentageliverExpedite = round(($liverExpedite->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageliverExpedite = 0;
        }

        // qty stock previsionnel

        $stockPreview = $inFabrication->count() + $inUsineOut->count() + $inWaitExpediteImport->count() + $arrivagePod->count();
        $stockPreviewValue = $inFabrication->sum('price_unitaire') + $inUsineOut->sum('price_unitaire') + $inWaitExpediteImport->sum('price_unitaire') + $arrivagePod->sum('price_unitaire');

        // Date recente du prochain arriver de produit

        $nextArrive = Sourcing::where('etat', 'actif')
        ->whereNotIn('statut', ['stocked'])
        ->orderBy('date_arriver', 'ASC')
        ->get();

        $firstNextArrivage = Sourcing::where('etat', 'actif')
        ->whereNotIn('statut', ['stocked'])
        ->orderByRaw('ABS(DATEDIFF(NOW(), date_arriver))')
        ->first();

        $totalProductsCount = Article::where('etat', 'actif')->count();
        $familyNemba = Article::where('etat', 'actif')->where('familyGroup', 'NEEMBA CI')->get();
        $familyNembaCount = $familyNemba->count();
        $percenfamilyNembaCount = ($familyNembaCount / $totalProductsCount) * 100;

        $familyNembaInter = Article::where(['etat'=> 'actif','familyGroup'=> 'NEEMBA INTERNATIONAL' ])->get();
        $familyNembaInterCount = $familyNembaInter->count();
        $percenfamilyNembaInter = ($familyNembaInterCount / $totalProductsCount) * 100;

        // Interface central d'achat

        $orderByCentrals = Sourcing::where(['etat' => 'actif'])->orderBy('created_at', 'desc')->limit(10)->get();
        $allOrderByCentrals = Sourcing::where(['etat' => 'actif'])->get();
        $orderOnDocument = Sourcing::where(['etat' => 'actif', 'statut' => 'validateDoc'])->orderBy('created_at', 'desc')->get();

        $orderCount = $orderOnDocument->count();
        $centralCount = $allOrderByCentrals->count();


        if ($centralCount > 0) {
            $orderOnDocumentPercent = ($orderCount / $centralCount) * 100;
        } else {
            $orderOnDocumentPercent = 0; // Ou une autre valeur par défaut
        }

        
        // en transit
        $orderOnTransit = Sourcing::where(['etat' => 'actif', 'statut' => 'odTransit'])->orderBy('created_at', 'desc')->get();
        $orderOnTransitPercent = ($orderOnTransit->count() / $allOrderByCentrals->count()) * 100;
        // en livraison
        $orderOnDelivery = Sourcing::where(['etat' => 'actif', 'statut' => 'odlivraison'])->orderBy('created_at', 'desc')->get();
        $orderOnDeliveryPercent = ($orderOnDelivery->count() / $allOrderByCentrals->count()) * 100;
        // livrer
        $orderReceiv = Sourcing::where(['etat' => 'actif', 'statut' => 'received'])->orderBy('created_at', 'desc')->get();
        $orderReceivPercent = ($orderReceiv->count() / $allOrderByCentrals->count()) * 100;

        $clients = Company::where(['etat'=> 'actif'])->get();
        $families = ArticleFamily::where('etat', 'actif')->get();
        $products = Article::where('etat', 'actif')->get();
        $orders = Order::where('etat', 'actif')->get();
        $orderByCient = Order::where(['etat'=> 'actif', 'client_uuid' => auth()->user()->uuid])->get();
    

        return view('admin.orders.index', 
        compact('stockGlobals', 'inFabrication', 'inUsineOut', 'inWaitExpediteImport', 'arrivagePod', 'receivStock', 'inWaitExpediteExport', 'liverExpedite','stockPreview','stockPreviewValue', 'firstNextArrivage', 'nextArrive', 'percentageInFabrication','percentageinWaitExpediteImport', 'percentageinWaitExpediteExport', 'percentageliverExpedite', 'totalProductsCount', 'percentagearrivagePod', 'percentagereceivStock', 'familyNembaCount', 'familyNembaInterCount', 'percenfamilyNembaCount','familyNemba', 'familyNembaInter', 'percenfamilyNembaInter', 'orderByCentrals', 'orderOnDocument','orderOnDocumentPercent','orderOnTransit','orderOnTransitPercent','orderOnDelivery','orderOnDeliveryPercent','orderReceiv','orderReceivPercent','percentageinUsineOut','clients','families','products','orders' ));
    }

    public function index_client()
    {

        // stock en cours
        $stockGlobals = Article::whereIn('status', [ 'stocked', 'expEnCours', 'delivered'])->get();

        $inFabrication = Article::where(['etat' => 'actif', 'status' => 'enFabrication'])->get();
        $inUsineOut = Article::where(['etat' => 'actif', 'status' => 'sortiUsine'])->get();
        $inWaitExpediteImport = Article::where(['etat' => 'actif', 'status' => 'enExpedition'])->get();
        $arrivagePod = Article::where(['etat' => 'actif', 'status' => 'arriverAuPod'])->get();
        $receivStock = Article::where(['etat' => 'actif', 'status' => 'stocked'])->get();
        $inWaitExpediteExport = Article::where(['etat' => 'actif', 'status' => 'expEnCours'])->get();
        $liverExpedite = Article::where(['etat' => 'actif', 'status' => 'delivered'])->get();

        //dd($stockGlobals);
        // Calcul du pourcentage par statut

        //$allProduction = Article::whereIn('status', [ 'stocked', 'expEnCours', 'delivered'])->get();

        if ($inFabrication->count() > 0 && $stockGlobals->count() > 0) {
            $percentageInFabrication = round(($inFabrication->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageInFabrication = 0;
        }

        if ($inUsineOut->count() > 0 && $stockGlobals->count() > 0) {
            $percentageinUsineOut = round(($inUsineOut->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinUsineOut = 0;
        }

        if ($inWaitExpediteImport->count() > 0 && $stockGlobals->count() > 0) {
            $percentageinWaitExpediteImport = round(($inWaitExpediteImport->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinWaitExpediteImport = 0;
        }

        if ($arrivagePod->count() > 0 && $stockGlobals->count() > 0) {
            $percentagearrivagePod = round(($arrivagePod->count() / $stockGlobals->count()) * 100);
        } else {
            $percentagearrivagePod = 0;
        }

        if ($receivStock->count() > 0 && $stockGlobals->count() > 0) {
            $percentagereceivStock = round(($receivStock->count() / $stockGlobals->count()) * 100);
        } else {
            $percentagereceivStock = 0;
        }

        if ($inWaitExpediteExport->count() > 0 && $stockGlobals->count() > 0) {
            $percentageinWaitExpediteExport = round(($inWaitExpediteExport->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinWaitExpediteExport = 0;
        }

        if ($liverExpedite->count() > 0 && $stockGlobals->count() > 0) {
            $percentageliverExpedite = round(($liverExpedite->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageliverExpedite = 0;
        }

        // qty stock previsionnel

        $stockPreview = $inFabrication->count() + $inUsineOut->count() + $inWaitExpediteImport->count() + $arrivagePod->count();
        $stockPreviewValue = $inFabrication->sum('price_unitaire') + $inUsineOut->sum('price_unitaire') + $inWaitExpediteImport->sum('price_unitaire') + $arrivagePod->sum('price_unitaire');

        // Date recente du prochain arriver de produit

        $nextArrive = Sourcing::where('etat', 'actif')
        ->whereNotIn('statut', ['stocked'])
        ->orderBy('date_arriver', 'ASC')
        ->get();

        $firstNextArrivage = Sourcing::where('etat', 'actif')
        ->whereNotIn('statut', ['stocked'])
        ->orderByRaw('ABS(DATEDIFF(NOW(), date_arriver))')
        ->first();

        $totalProductsCount = Article::where('etat', 'actif')->count();
        $familyNemba = Article::where('etat', 'actif')->where('familyGroup', 'NEEMBA CI')->get();
        $familyNembaCount = $familyNemba->count();
        $percenfamilyNembaCount = ($familyNembaCount / $totalProductsCount) * 100;

        $familyNembaInter = Article::where(['etat'=> 'actif','familyGroup'=> 'NEEMBA INTERNATIONAL' ])->get();
        $familyNembaInterCount = $familyNembaInter->count();
        $percenfamilyNembaInter = ($familyNembaInterCount / $totalProductsCount) * 100;

        // Interface central d'achat

        $orderByCentrals = Expedition::where(['etat' => 'actif'])->orderBy('created_at', 'desc')->limit(10)->get();
        $allOrderByCentrals = Expedition::where(['etat' => 'actif', 'client_uuid' => Auth::user()->uuid])
        ->orderBy('created_at', 'desc')
        ->get();
        $allOrder = Expedition::where(['etat' => 'actif', 'client_uuid' => Auth::user()->uuid])
        ->orderBy('created_at', 'desc')
        ->get();
        $orderOnDocument = Expedition::where(['etat' => 'actif', 'statut' => 'startedDoc'])->orderBy('created_at', 'desc')->get();
        // $orderOnDocumentPercent = ($orderOnDocument->count() / $allOrderByCentrals->count()) * 100;

        $orderCount = $orderOnDocument->count();
        $centralCount = $allOrderByCentrals->count();


        if ($centralCount > 0) {
            $orderOnDocumentPercent = ($orderCount / $centralCount) * 100;
        } else {
            $orderOnDocumentPercent = 0; // Ou une autre valeur par défaut
        }

        // en transit
        $orderOnTransit = Expedition::where(['etat' => 'actif', 'statut' => 'odTransit'])->orderBy('created_at', 'desc')->get();
        if ($allOrderByCentrals->count() > 0) {
        $orderOnTransitPercent = ($orderOnTransit->count() / $allOrderByCentrals->count()) * 100;
        } else {
            $orderOnTransitPercent = 0;
        }
        // en livraison
        
        $orderOnDelivery = Expedition::where(['etat' => 'actif', 'statut' => 'odTransport'])->orderBy('created_at', 'desc')->get();
        if ($allOrderByCentrals->count() > 0) {
        $orderOnDeliveryPercent = ($orderOnDelivery->count() / $allOrderByCentrals->count()) * 100;
        } else {
            $orderOnDeliveryPercent = 0;
        }
        // livrer
        $orderReceiv = Expedition::where(['etat' => 'actif', 'statut' => 'livered'])->orderBy('created_at', 'desc')->get();
        if ($allOrderByCentrals->count() > 0) {
        $orderReceivPercent = ($orderReceiv->count() / $allOrderByCentrals->count()) * 100;
        } else {
            $orderReceivPercent = 0;
        }
        // $orderReceivPercent = ($orderReceiv->count() / $allOrderByCentrals->count()) * 100;


        return view('admin.orders.index_client', 
        compact('stockGlobals', 'inFabrication', 'inUsineOut', 'inWaitExpediteImport', 'arrivagePod', 'receivStock', 'inWaitExpediteExport', 'liverExpedite','stockPreview','stockPreviewValue', 'firstNextArrivage', 'nextArrive', 'percentageInFabrication','percentageinWaitExpediteImport', 'percentageinWaitExpediteExport', 'percentageliverExpedite', 'totalProductsCount', 'percentagearrivagePod', 'percentagereceivStock', 'familyNembaCount', 'familyNembaInterCount', 'percenfamilyNembaCount','familyNemba', 'familyNembaInter', 'percenfamilyNembaInter', 'orderByCentrals', 'orderOnDocument','orderOnDocumentPercent','orderOnTransit','orderOnTransitPercent','orderOnDelivery','orderOnDeliveryPercent','orderReceiv','orderReceivPercent','percentageinUsineOut','allOrderByCentrals','allOrder' ));
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

        $order_uuid = Str::uuid();

        try {
            $instruction = Order::create([
                'uuid' => $order_uuid,
                'num_cmd' => 'CMD' . date('dmY') . '_' . Str::random(5),
                'lieu_liv' => $request->lieu_liv,
                'date_liv' => $request->date_liv,
                'num_exp' => $request->num_exp,
                'client_uuid' => $request->client_uuid,
                'incoterm'=> $request->incoterm,
                'etat' => 'actif',
                'statut' => 'send',
                'created_by' => Auth::user()->name . ' ' . Auth::user()->lastname,
                'code' => 'CMD_' . Str::random(5),
            ]);

            if($request->has('files')){
                $names = $request->input('name');
                foreach($request->file('files') as $key => $file){
                    $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('documents/files');
                    $file->move($destinationPath, $imageName);
                    $filePath = $destinationPath . '/' . $imageName;

                    $expedition_file = Expedition_File::create([
                        'uuid' => $order_uuid,
                        'name' => $names[$key],
                        'expedition_id' => $instruction->id,
                        'files' => $imageName,
                        'filePath' => $filePath,
                ]);
                $expedition_file->filePath = $filePath;
                }
            }
            
            
            $instruction->save();

            $productIds = $request->input('product_id');

            foreach ($productIds as $productId) {
                $product = Article::find($productId);
        
                if ($product) {
                    Expedition_product::create([
                        'uuid' => Str::uuid(),
                        'expedition_id' => $instruction->id,
                        'famille_uuid' => $product->famille_uuid,
                        'product_id' => $productId,
                    ]);
                }
            }

            if ($instruction) {

                $users = User::all();
                $user = auth()->user()->name." ".auth()->user()->lastname;
                $details_log = [
                    // 'url' => url()->current(),
                    'url' => route('admin.orders.show',$order_uuid),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "Instruction de commande",
                    'action' => "Une nouvelle instruction de commande a ete ajouter par la central d'achat : ".$user." le ".date('d-m-Y H:i:s'),
                ];

                // Assurez-vous que $users est une collection d'instances de User
                foreach ($users as $user) {
                    $user->notify(new MyLogNotification($details_log));
                }

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
     * Display the specified resource.
     */
    public function show(string $uuid)
    {

        $order = Order::where('uuid', $uuid)->first();
        return view('admin.orders.show', compact('order'));
    }


    public function updateStatus(string $uuid)
    {
        $order = Order::where('uuid', $uuid)->update(
            ['statut' => 'received']
        );
        return redirect()->back()->with('success', 'Statut mis a jour avec succes');
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

    // Reception de la commande client

    public function receivOrder(Request $request, string $uuid)
    {
        DB::beginTransaction();
        try {

            $order = Expedition::where('uuid', $uuid)->update(
                [
                    'statut' => 'orderRecu',
                    'orderDate' => $request->orderDate,
                    'orderContent' => $request->orderContent,
                ]
            );
            
            if ($order) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> 'back',
                    'message'=>"Modifié avec succes!",
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

}
