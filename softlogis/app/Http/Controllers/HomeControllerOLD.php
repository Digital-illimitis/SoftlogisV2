<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\Sourcing;
use Illuminate\View\View;
use App\Models\Expedition;
use App\Models\OdTransite;
use App\Mail\LogisticaMail;
use App\Models\ExpTransport;
use App\Models\ExTransit;
use App\Models\Facturation;
use App\Models\OdLivraison;
use App\Models\stockUpdate;
use Illuminate\Http\Request;
use App\Models\Refacturation;
use App\Models\PrestationLine;
use App\Models\FacturePrestation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }



    public function login()
    {
        return view('auth.login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('home');
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function adminHome(): View
    {

        


        // Date actuel
        $today = Carbon::now();

        $firstDayOfMonth = $today->firstOfMonth()->format('Y-m-d H:i:s');
        $lastDayOfMonth = $today->lastOfMonth()->format('Y-m-d H:i:s');

        $firstDayOfWeek = $today->startOfWeek()->format('Y-m-d H:i:s'); // semaine
        $lastDayOfWeek = $today->endOfWeek()->format('Y-m-d H:i:s');

        $currentWeek = date('W'); // semaine en cours

        $stockGlobals = Article::where('etat', 'actif')->get();

        $inFabrication = Article::where(['etat' => 'actif', 'status' => 'enFabrication'])->get();
        $inUsineOut = Article::where(['etat' => 'actif', 'status' => 'sortiUsine'])->get();
        $inWaitExpediteImport = Article::where(['etat' => 'actif', 'status' => 'enExpedition'])->get();
        $arrivagePod = Article::where(['etat' => 'actif', 'status' => 'arriverAuPod'])->get();
        $receivStock = Article::where(['etat' => 'actif', 'status' => 'stocked'])->get();
        $inWaitExpediteExport = Article::where(['etat' => 'actif', 'status' => 'expEnCours'])->get();
        $liverExpedite = Article::where(['etat' => 'actif', 'status' => 'delivered'])->get();

        // Calcul du pourcentage par statut

        if ($inFabrication->count() > 0) {
            $percentageInFabrication = round(($inFabrication->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageInFabrication = 0;
        }

        if ($inUsineOut->count() > 0) {
            $percentageinUsineOut = round(($inUsineOut->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinUsineOut = 0;
        }

        if ($inWaitExpediteImport->count() > 0) {
            $percentageinWaitExpediteImport = round(($inWaitExpediteImport->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinWaitExpediteImport = 0;
        }

        if ($arrivagePod->count() > 0) {
            $percentagearrivagePod = round(($arrivagePod->count() / $stockGlobals->count()) * 100);
        } else {
            $percentagearrivagePod = 0;
        }

        if ($receivStock->count() > 0) {
            $percentagereceivStock = round(($receivStock->count() / $stockGlobals->count()) * 100);
        } else {
            $percentagereceivStock = 0;
        }

        if ($inWaitExpediteExport->count() > 0) {
            $percentageinWaitExpediteExport = round(($inWaitExpediteExport->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageinWaitExpediteExport = 0;
        }

        if ($liverExpedite->count() > 0) {
            $percentageliverExpedite = round(($liverExpedite->count() / $stockGlobals->count()) * 100);
        } else {
            $percentageliverExpedite = 0;
        }

        // $percentageInFabrication = round(($inFabrication->count() / $stockGlobals->count()) * 100);
        // $percentageinUsineOut = round(($inUsineOut->count() / $stockGlobals->count()) * 100);
        // $percentageinWaitExpediteImport = round(($inWaitExpediteImport->count() / $stockGlobals->count()) * 100);
        // $percentagearrivagePod = round(($arrivagePod->count() / $stockGlobals->count()) * 100);
        // $percentagereceivStock = round(($receivStock->count() / $stockGlobals->count()) * 100);
        // $percentageinWaitExpediteExport = round(($inWaitExpediteExport->count() / $stockGlobals->count()) * 100);
        // $percentageliverExpedite = round(($liverExpedite->count() / $stockGlobals->count()) * 100);

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

        // $firstNextArrivage = Sourcing::where(['etat' => 'actif'])
        // ->whereNotIn('statut', ['stocked'])
        // ->orderBy('date_arriver', 'desc')->first();

        // dd($firstNextArrivage);

        $avgPerExpedite = Sourcing::where(['etat' => 'actif'])
            ->with('products') // Charger les produits associés à chaque expédition
            ->get();

        // Calculer la moyenne du nombre de produits par expédition
        $nbrProdPerExpedition = $avgPerExpedite->avg(function ($expedition) {
            return $expedition->products->count();
        });




        // Reporting sur les entré de stock pour le mois And Semaine Conformity integré

        $InStock = stockUpdate::where(['mouvement' => 'In'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get(); // Requête pour obtenir les produits en stock pour le mois

        $conformInStockPerMonth = stockUpdate::where([
            'mouvement' => 'In',
            'conformity' => 'on',
        ])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get(); // Requête pour obtenir les produits conform entre en stock pour le mois

        $noConformInStockPerMonth = stockUpdate::where([
            'mouvement' => 'In',
            'conformity' => 'off'
        ])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

        $noConformInStock = stockUpdate::where([
            'mouvement' => 'In',
            'conformity' => 'off'
        ])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

        // Produit conform per Month
        $nbrTotalInStock = $InStock->count();
        $nbrConformInStock = $conformInStockPerMonth->count();
        $nbrNoConformInStock = $noConformInStockPerMonth->count();
        // In
        $nbrTotalInPerMonth = $InStock->count();
        $nbrTotalInConform = $conformInStockPerMonth->count();
        $nbrTotalInNoConfrom = $noConformInStockPerMonth->count();

        // hebdomadaire

         // Requête pour obtenir les produits en stock pour la semaine en cours
        $InStockWekly = stockUpdate::where(['mouvement' => 'In'])
        ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
        ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
        ->get();
        // ->whereBetween('created_at', [$firstDayOfWeek, $lastDayOfWeek])->get();
        // ->whereRaw('WEEK(created_at) = ?', [$currentWeek])
        // ->get();

        $conformInStock = stockUpdate::where([
            'mouvement' => 'In',
            'conformity' => 'on'
        ])->get();

        $conformInStockWeekly = stockUpdate::where(['mouvement' => 'In','conformity' => 'on'])
        ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
        ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
        ->get();

        $noConformInStockWeekly = stockUpdate::where([
                'mouvement' => 'In',
                'conformity' => 'off'])
        ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
        ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
        ->get();


        //out
        $nbrTotalOut = $InStockWekly->count();
        $nbrTotalOutConform = $conformInStockWeekly->count();
        $nbrTotalOutNoConfrom = $noConformInStockWeekly->count();


        $listInStock = stockUpdate::where(['mouvement' => 'In'])
        ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();

        // Produit sortie du stock par mois et semaine

        $outStockMonth = stockUpdate::where(['mouvement' => 'Out'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

        $totalValue = $outStockMonth->sum(function($item) {
            if ($item->product != null) {
                return $item->product->price_unitaire;
            }
        });


        $outStockWekly = stockUpdate::where(['mouvement' => 'Out'])
        ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
        ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
        ->get();

        $totalValueWeekly = $outStockWekly->sum(function($item) {
            return $item->product->price_unitaire;
        });


        // Import
        $sourcings = Sourcing::where(['etat' => 'actif'])->orderBy('created_at', 'desc')->get();


        $sourcingInValidation = Sourcing::where(['etat' => 'actif', 'statut' => 'validateDoc'])->get();

        $sourcingPerMonths = Sourcing::where(['etat' => 'actif'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

        // dd($lastDayOfMonth);

        $sourcingInValidatPerMonth = Sourcing::where(['etat' => 'actif', 'statut' => 'validateDoc'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();
        $sourcingReceive = Sourcing::where(['etat' => 'actif', 'statut' => 'stocked'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

        $sourcingReceivePerWekly = Sourcing::where(['etat' => 'actif', 'statut' => 'stocked'])
        ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
        ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
        ->get();

        // $sourcingPerWekly = Sourcing::where(['etat' => 'actif'])
        // ->whereBetween('created_at', [$firstDayOfWeek, $lastDayOfWeek])->get();
        // ->whereRaw('WEEK(created_at) = ?', [$currentWeek])->get();

        $sourcingPerWekly = Sourcing::where('etat', 'actif')
        ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
        ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
        ->get();

        $countSourcingPerWeekly = $sourcingPerWekly->count();


          // Récupérer le nombre total de sourcings
    $nbrTotalSourcings = $sourcings->count();
    // $nbrSourcingsPerWekly = $sourcingPerWekly->count();
    $percentageSourcingsPerWekly = ($nbrTotalSourcings !== 0) ? ($countSourcingPerWeekly / $nbrTotalSourcings) * 100 : 0;
    // recu par weekly
    $nbrSourcReceivPerWekly = $sourcingReceivePerWekly->count();
    $percentagereceivPerWekly = ($nbrTotalSourcings !== 0) ? ($nbrSourcReceivPerWekly / $nbrTotalSourcings) * 100 : 0;

    $allSourcing = Sourcing::where(['etat' => 'actif'])->get();


    $totalDelaySourcing = 0;

    foreach ($allSourcing as $sourcing) {
        $transitBySourcing = OdTransite::where(['etat' => 'actif', 'sourcing_uuid' => $sourcing->uuid])->first();

        if ($transitBySourcing) {
            $createDateTrSourcing = $transitBySourcing->created_at;
            $totalDelaySourcing += Carbon::parse($sourcing->receive_date)->diffInDays($createDateTrSourcing);
        } else {
            $totalDelaySourcing += 0; // Ajouter 0 si aucune autre mesure
        }
    }

    if ($allSourcing->count() > 0) {
        $averageDelaySourcing = $totalDelaySourcing / $allSourcing->count();
    } else {
        $averageDelaySourcing = 0;
    }



    // Calculer le pourcentage de produits conformes par rapport au total des produits reçus
    $percentageConform = ($nbrTotalInStock !== 0) ? ($nbrConformInStock / $nbrTotalInStock) * 100 : 0;

    // Récupérer le nombre total de sourcings
    $nbrTotalSourcings = $sourcings->count();
    $nbrSourcingsPerMonth = $sourcingPerMonths->count();
    $percentageSourcingsPerMonth = ($nbrTotalSourcings !== 0) ? ($nbrSourcingsPerMonth / $nbrTotalSourcings) * 100 : 0;

    $sourcInWaitLivrPerMonth = Sourcing::where(['etat' => 'actif', 'statut' => 'odlivraison'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

    $sourcInWaitLivrPerWekly = Sourcing::where(['etat' => 'actif', 'statut' => 'odlivraison'])
    ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
    ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
    ->get();

    // Récupérer le nombre total de sourcings
    // $nbrTotalSourcings = $sourcings->count();
    $nbrWaitSourcingsPerWekly = $sourcInWaitLivrPerWekly->count();
    $percWaitSourPerWekly = ($nbrTotalSourcings !== 0) ? ($nbrWaitSourcingsPerWekly / $nbrTotalSourcings) * 100 : 0;

    $nbrSourcWaitLivr = $sourcInWaitLivrPerMonth->count();

    $percenSourcWaitLivrPerMonth = ($nbrSourcingsPerMonth !== 0) ? ($nbrSourcWaitLivr / $nbrSourcingsPerMonth) * 100 : 0;

    $sourcingReceivPerMonth = $sourcingReceive->count();
    $percenReceivMonth = ($nbrSourcingsPerMonth !== 0) ? ($sourcingReceivPerMonth / $nbrSourcingsPerMonth) * 100 : 0;
    // Ordre transite per Month

    $allTransitPerMonth = OdTransite::where(['etat' => 'actif'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

    $allTransitPerWekly = OdTransite::where(['etat' => 'actif'])
    ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
    ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
    ->get();

    $mostUsedTransitaire = OdTransite::where(['etat' => 'actif'])
    ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
    ->groupBy('transitaire_uuid')
    ->selectRaw('transitaire_uuid, count(*) as count')
    ->orderByDesc('count')
    ->first();


    $allTransit = OdTransite::where(['etat' => 'actif'])->get();
    $totalDelayTransit = 0;

    foreach ($allTransit as $transit) {
        $sourcing = Sourcing::where('uuid', $transit->sourcing_uuid)->first();

        if($sourcing != null) {
            $livraisonBySourcing = OdLivraison::where(['etat' => 'actif', 'sourcing_id' => $sourcing->uuid])->first();

            if ($livraisonBySourcing) {
                $createDateLivSourcing = $livraisonBySourcing->created_at;
                $totalDelayTransit += Carbon::parse($transit->created_at)->diffInDays($createDateLivSourcing);
            } else {
                $totalDelayTransit += 0; // Ajouter 0 si aucune autre mesure
            }

        }
    }

    if ($allTransit->count() > 0) {
        $averageDelayTransit = $totalDelayTransit / $allTransit->count();
    } else {
        $averageDelayTransit = 0;
    }



    $conformInStockGlobal = stockUpdate::where([
        'mouvement' => 'In',
        'conformity' => 'on'
    ])->get();
    $noConformInStockGlobal = stockUpdate::where([
        'mouvement' => 'In',
        'conformity' => 'off'
    ])->get();

    // Export Block Start
    // firstDayOfMonth
    // lastDayOfMonth
    // firstDayOfWeek
    // lastDayOfWeek

    $nbrTotalExpedition = Expedition::where(['etat' => 'actif'])->get();
    $recentExpedition = Expedition::where(['etat' => 'actif'])->orderBy('created_at', 'desc')->limit(5)->get();
    $nbrTotalExpeditionActif = Expedition::where('etat', 'actif')
    ->where('statut', '!=', 'livered')
    ->get();

    $nbrExpeditionToDocValidate = Expedition::where(['etat' => 'actif', 'statut' => 'startedDoc'])->get();
    $nbrExpeditionStarted = Expedition::where(['etat' => 'actif', 'statut' => 'odTransit'])->get(); //To transit
    $nbrExpeditionLivraison = Expedition::where(['etat' => 'actif', 'statut' => 'odTransport'])->get(); //To livraison

     //To transit
    $nbrExpeditionWaitExpedite = Expedition::where(['etat' => 'actif', 'statut' => 'wait_exp'])->get();
    $nbrExpeditionExpedier = Expedition::where(['etat' => 'actif', 'statut' => 'livered'])->get();

    $nbrTotalExpActif = $nbrTotalExpeditionActif->count();
    $countExpWaitDoc = $nbrExpeditionToDocValidate->count();

    if ($nbrTotalExpeditionActif->count() > 0) {
        $percentageExpGlobal = ($nbrTotalExpActif !== 0) ? ($countExpWaitDoc / $nbrTotalExpActif) * 100 : 0;
    } else {
        $percentageExpGlobal = 0;
    }

    if ($nbrTotalExpeditionActif->count() > 0) {
        $percentageExpGlobal = ($nbrTotalExpActif !== 0) ? ($countExpWaitDoc / $nbrTotalExpActif) * 100 : 0;
    } else {
        $percentageExpGlobal = 0;
    }

    // To Started
    $countExpTransit = $nbrExpeditionStarted->count();
    if ($nbrTotalExpeditionActif->count() > 0) {
        $percentageExpTransit = ($nbrTotalExpActif !== 0) ? ($countExpTransit / $nbrTotalExpActif) * 100 : 0;
    } else {
        $percentageExpTransit = 0;
    }
    // To Wait Expedite
    $countExpWaitExpedite = $nbrExpeditionWaitExpedite->count();
    if ($nbrTotalExpeditionActif->count() > 0) {
        $percentageExpWaitExp = ($nbrTotalExpActif !== 0) ? ($countExpWaitExpedite / $nbrTotalExpActif) * 100 : 0;
    } else {
        $percentageExpWaitExp = 0;
    }
    // To Expedition Ready
    // dd($nbrExpeditionExpedier);
    $countExpDelivered = $nbrExpeditionExpedier->count();
    if ($nbrTotalExpeditionActif->count() > 0) {
        $percentageExpDelivered = ($nbrTotalExpActif !== 0) ? ($countExpDelivered / $nbrTotalExpActif) * 100 : 0;
    } else {
        $percentageExpDelivered = 0;
    }
    // Export Temps moyen de transit
    $totalDelayExpedite = 0;

    foreach ($nbrTotalExpeditionActif as $expedite) {
        $totalDelayExpedite += Carbon::parse($expedite->date_transit)->diffInDays($expedite->date_transport);
    }
    $averageDelayExpedite = ($nbrTotalExpeditionActif->count() !== 0) ? $totalDelayExpedite / $nbrTotalExpeditionActif->count() : 0;
    //Le plus recent expedition create ...
    $latestExpedition = Expedition::where('etat', 'actif')
    ->where('statut', '!=', 'livered')
    ->orderBy('date_liv', 'DESC')
    ->first();



    if ($latestExpedition) {
        $date = Carbon::parse($latestExpedition->date_liv)->diffInDays();
        $firstLatestExpedition = $latestExpedition->date_liv;
    } else {
        $date = 0;
        $firstLatestExpedition = 0;
    }



    // Construire un libellé personnalisé
    $customLabel = sprintf(
        '%d jours avant livraison',
        $date
    );
    $resultDate = $customLabel;


    // Export Temps moyen de transit
    $totalDelayTransport = 0;

    foreach ($nbrTotalExpeditionActif as $expedite) {
        $totalDelayTransport += Carbon::parse($expedite->date_transport)->diffInDays($expedite->date_destockage);
    }
    $averageDelayTransport = ($nbrTotalExpeditionActif->count() !== 0) ? $totalDelayTransport / $nbrTotalExpeditionActif->count() : 0;

    // Per Month Expedition
    $allExpPerMonth = Expedition::where('etat', 'actif')->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();
    $allExpPerMonthActif = Expedition::where(['etat'=> 'actif'])->where('statut', '!=', 'livered')->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

    $allExpWaitValidatePerMonth = Expedition::where(['etat'=> 'actif', 'statut' => 'startedDoc'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

    $allExpDemarrerPerMonth = Expedition::where(['etat'=> 'actif', 'statut' => 'odTransit'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

    $allExpWaitingPerMonth = Expedition::where(['etat'=> 'actif', 'statut' => 'wait_exp'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

    $allExpReadyPerMonth = Expedition::where(['etat'=> 'actif', 'statut' => 'livered'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

    $countallExpPerMonthActif = $allExpPerMonthActif->count();

    $countExpWaitDocPerMonth = $allExpWaitValidatePerMonth->count();
    if ($allExpPerMonthActif->count() > 0) {
        $percentageExpWaitDocMensuel = ($countallExpPerMonthActif !== 0) ? ($countExpWaitDocPerMonth / $countallExpPerMonthActif) * 100 : 0;
    } else {
        $percentageExpWaitDocMensuel = 0;
    }

    $countExpDemarrerPerMonth = $allExpDemarrerPerMonth->count();

    if ($allExpPerMonthActif->count() > 0) {
        $percentageExpDemarrerMensuel = ($countallExpPerMonthActif !== 0) ? ($countExpDemarrerPerMonth / $countallExpPerMonthActif) * 100 : 0;
    } else {
        $percentageExpDemarrerMensuel = 0;
    }

    $countExpWaitingPerMonth = $allExpWaitingPerMonth->count();

    if ($allExpPerMonthActif->count() > 0) {
        $percentageExpWaitingMensuel = ($countallExpPerMonthActif !== 0) ? ($countExpWaitingPerMonth / $countallExpPerMonthActif) * 100 : 0;
    } else {
        $percentageExpWaitingMensuel = 0;
    }

    $countExpReadyPerMonth = $allExpReadyPerMonth->count();

    if ($allExpPerMonthActif->count() > 0) {
        $percentageExpReadyMensuel = ($countallExpPerMonthActif !== 0) ? ($countExpReadyPerMonth / $countallExpPerMonthActif) * 100 : 0;
    } else {
        $percentageExpReadyMensuel = 0;
    }


    // block finance a jour
        $allfacturPrestataire = Facturation::where('etat', 'actif')->get();
        $facturPresUUIDs = $allfacturPrestataire->pluck('uuid')->toArray();
        $allFactByPrestationActif = PrestationLine::whereIn('facture_uuid', $facturPresUUIDs)->get();
        $valeurallFactByPrestationActif = $allFactByPrestationActif->sum('totalLigne');
        $totalallFactByPrestationActifCount = $allfacturPrestataire->count();

        $factures = Facturation::where('etat', 'actif')->get();
        $facturesRecent = Facturation::where('etat', 'actif')->limit(10)->OrderBy('created_at', 'desc')->get();

        // facture prestataire echue date echeance < now();
        $facturePrestataireEchu =  Facturation::where('etat', 'actif')->whereNotIn('statut', ['payed', 'cancel'])
        ->where('date_echeance', '<', now())->get();
        $facturePrestataireEchuCount = $facturePrestataireEchu->count();
        $valeur_facturePrestataireEchu = $facturePrestataireEchu->sum(function ($facture) {
        return $facture->prestationLines->where('etat', 'actif')->sum('totalLigne');
        });

        // Bon a Payer
        $facture_bon_a_payer = Facturation::where(['etat' => 'actif', 'statut' => 'good_pay'])->get();
        $facture_bon_a_payer_count = $facture_bon_a_payer->count();
        $valeur_bon_a_payer = $facture_bon_a_payer->sum(function ($facture) {
            return $facture->prestationLines->sum('totalLigne');
        });

        // Payers
        $facture_payer = Facturation::where(['etat' => 'actif', 'statut' => 'payed'])->get();
        $facture_payer_count = $facture_payer->count();
        $valeur_payer = $facture_payer->sum(function ($facture) {
            return $facture->prestationLines->sum('totalLigne');
        });

        // Canceled
        $facture_cancel = Facturation::where(['etat' => 'actif', 'statut' => 'cancel'])->get();
        $facture_canceled_count = $facture_cancel->count();
        $valeur_canceled = $facture_cancel->sum(function ($facture) {
            return $facture->prestationLines->sum('totalLigne');
        });

    // Block Finance facture
    // $factures = Facturation::where('etat', 'actif')->get();
    // $facture_bon_a_payer = Facturation::where(['etat' => 'actif', 'statut' => 'good_pay'])->get();
    // $facture_payer = Facturation::where(['etat' => 'actif', 'statut' => 'payed'])->get();
    // $facture_cancel = Facturation::where(['etat' => 'actif', 'statut' => 'cancel'])->get();

    $factureTransport = $factures->sum('montantTotalTtcTransport');
    $factureTransit = $factures->sum('montantTotalTtcTransit');
    $total = $factureTransport + $factureTransit;
    $total_count = $factures->count();

    $factureBonAPayerTransport = $facture_bon_a_payer->sum('montantTotalTtcTransport');
    $factureBonAPayerTransit = $facture_bon_a_payer->sum('montantTotalTtcTransit');
    $total_bon_payer = $factureBonAPayerTransport + $factureBonAPayerTransit;
    $total_bon_count = $facture_bon_a_payer->count();

    $facturePayerTransport = $facture_payer->sum('montantTotalTtcTransport');
    $facturePayerTransit = $facture_payer->sum('montantTotalTtcTransit');
    $total_payed = $facturePayerTransport + $facturePayerTransit;
    $total_payed_count = $facture_payer->count();

    $factureCancelTransport = $facture_cancel->sum('montantTotalTtcTransport');
    $factureCancelTransit = $facture_cancel->sum('montantTotalTtcTransit');
    $total_cancel = $factureCancelTransport + $factureCancelTransit;
    $total_cancel_count = $facture_cancel->count();

    // Block Finance refacturation

    $allRefacturations = Refacturation::where('etat', 'actif')->get();

    $lastFacts = Refacturation::where('etat', 'actif')->limit(10)->OrderBy('created_at', 'desc')->get();

    $lastFactsUUIDs = $allRefacturations->pluck('uuid')->toArray();
    $factureByPres = FacturePrestation::where('etat', 'actif')->whereIn('facture_uuid', $lastFactsUUIDs)->get();
    $valeurTotals = $factureByPres->sum('total');
    $totalRefacturcount = $allRefacturations->count();

    // Send to paye
    $refacturation_send = Refacturation::where(['etat' => 'actif', 'statut' => 'sendToClient'])->get();
    $lastSendFactsUUIDs = $refacturation_send->pluck('uuid')->toArray();
    $factureByPresSend = FacturePrestation::where('etat', 'actif')->whereIn('facture_uuid', $lastSendFactsUUIDs)->get();
    $valeurTotalsSending = $factureByPresSend->sum('total');
    $totalSendingCount = $refacturation_send->count();

    // facture payer
    $refacturation_payer = Refacturation::where(['etat' => 'actif', 'statut' => 'payed'])->get();
    $lastPayedFactsUUIDs = $refacturation_payer->pluck('uuid')->toArray();
    $factureByPresPayed = FacturePrestation::where('etat', 'actif')->whereIn('facture_uuid', $lastPayedFactsUUIDs)->get();
    $valeurTotalsPayed = $factureByPresPayed->sum('total');
    $totalPayedCount = $refacturation_payer->count();
    // facture rejeter
    $refacturation_rejeter = Refacturation::where(['etat' => 'actif', 'statut' => 'canceled'])->get();
    $lastRejetedFactsUUIDs = $refacturation_rejeter->pluck('uuid')->toArray();
    $factureByPresRejeter = FacturePrestation::where('etat', 'actif')->whereIn('facture_uuid', $lastRejetedFactsUUIDs)->get();
    $valeurTotalsRejeter = $factureByPresRejeter->sum('total');
    $totalRejetedCount = $refacturation_rejeter->count();

    // facture echue date echeance < now();
    $factureEchu =  Refacturation::where('etat', 'actif')->whereNotIn('statut', ['payed', 'cancel'])
    ->where('date_echeance', '<', now())->get();
    $factureEchuCount = $factureEchu->count();
    $valeur_factureEchu = $factureEchu->sum(function ($facture) {
    return $facture->prestations->where('etat', 'actif')->sum('total');
    });

    // count& value all debou & prest 
    $totalFactDebou = FacturePrestation::where(['etat'=> 'actif', 'type_prestation'=>'debours'])->count();
    $valeurTotalDebou = FacturePrestation::where(['etat'=> 'actif', 'type_prestation'=>'debours'])->sum('total');

    $totalFactPrestation = FacturePrestation::where(['etat'=> 'actif', 'type_prestation'=>'prestation'])->count();
    $valeurTotalPrestation = FacturePrestation::where(['etat'=> 'actif', 'type_prestation'=>'prestation'])->sum('total');

    $nbrTotalIn = $InStock->count();
    $nbrTotalInConform = $conformInStock->count();
    $nbrTotalInNoConfrom = $noConformInStock->count();

    $facturesFournisseurActives = FacturePrestation::where('etat', 'actif')->get();
    $facturesFournisseurDebours = FacturePrestation::where(['etat' => 'actif', 'type_prestation' => 'debours'])->get();
    $facturesFournisseurPrestation = FacturePrestation::where(['etat' => 'actif', 'type_prestation' => 'prestation'])->get();

    $currentYear = Carbon::now()->year;

        //factures fournisseur pour l'année en cours
        $facturesFournisseurActives = $facturesFournisseurActives->filter(function ($facture) use ($currentYear) {
            return Carbon::parse($facture->created_at)->year == $currentYear;
        });
        $facturesFournisseurDebours = $facturesFournisseurDebours->filter(function ($facture) use ($currentYear) {
            return Carbon::parse($facture->created_at)->year == $currentYear;
        });
        $facturesFournisseurPrestation = $facturesFournisseurPrestation->filter(function ($facture) use ($currentYear) {
            return Carbon::parse($facture->created_at)->year == $currentYear;
        });

        // totaux des factures fournisseur pour chaque mois de l'année en cours
        $totauxFournisseurParMois = $facturesFournisseurActives
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            })
            ->map(function($month) {
                return $month->sum('total');
            });

        // total debours per month
        $totauxFournisseurDeboursParMois = $facturesFournisseurDebours
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            })
            ->map(function($month) {
                return $month->sum('total');
            });

        // total debours per month
        $totauxFournisseurPrestationParMois = $facturesFournisseurPrestation
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            })
            ->map(function($month) {
                return $month->sum('total');
            });

        $facturesPrestataireActives = PrestationLine::where('etat', 'actif')->get();

        $lignesDePrestationPayees = PrestationLine::where('etat', 'actif')->whereHas('facture', function ($query) {
            $query->where('statut', 'payed')->where('etat', 'actif');
        })->whereIn('uuid', $facturesPrestataireActives->pluck('uuid'))->get();


        //factures prestataire pour l'année en cours
        $facturesPrestataireActives = $facturesPrestataireActives->filter(function ($facture) use ($currentYear) {
            return Carbon::parse($facture->created_at)->year == $currentYear;
        });
        $facturesPrestatairePayed = $lignesDePrestationPayees->filter(function ($facture) use ($currentYear) {
            return Carbon::parse($facture->created_at)->year == $currentYear;
        });

        // totaux des factures prestataire pour chaque mois de l'année en cours
        $totauxPrestataireParMois = $facturesPrestataireActives
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            })
            ->map(function($month) {
                return $month->sum('totalLigne');
            });
        $totauxPrestatairePayedParMois = $facturesPrestatairePayed
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            })
            ->map(function($month) {
                return $month->sum('totalLigne');
            });


        // stocker les totaux pour chaque mois

        $montantsFournisseurParMois = [];
        $montantFournisseurDeboursParMois = [];
        $montantFournisseurPrestationParMois = [];
        $montantsPrestataireParMois = [];
        $montantsPrestatairePayedParMois = [];
        for ($i = 1; $i <= 12; $i++) {
            $mois = str_pad($i, 2, '0', STR_PAD_LEFT); // zéro initial si nécessaire pour le format de mois
            $montantsFournisseurParMois[] = $totauxFournisseurParMois->get($mois, 0);
            $montantFournisseurDeboursParMois[] = $totauxFournisseurDeboursParMois->get($mois, 0);
            $montantFournisseurPrestationParMois[] = $totauxFournisseurPrestationParMois->get($mois, 0);
            $montantsPrestataireParMois[] = $totauxPrestataireParMois->get($mois, 0);
            $montantsPrestatairePayedParMois[] = $totauxPrestatairePayedParMois->get($mois, 0);
        }

        $totalProductsCount = Article::where('etat', 'actif')->count();
        $familyNemba = Article::where('etat', 'actif')->where('familyGroup', 'NEEMBA CI')->get();
        $familyNembaCount = $familyNemba->count();
        $percenfamilyNembaCount = ($familyNembaCount / $totalProductsCount) * 100;

        $familyNembaInter = Article::where(['etat'=> 'actif','familyGroup'=> 'NEEMBA INTERNATIONAL' ])->get();
        $familyNembaInterCount = $familyNembaInter->count();
        $percenfamilyNembaInter = ($familyNembaInterCount / $totalProductsCount) * 100;

        // Interface central d'achat
        $sourcingsForCentral = Sourcing::where(['etat' => 'actif'])->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();

        $orderByCentrals = Sourcing::where(['etat' => 'actif'])->orderBy('created_at', 'desc')->limit(10)->get();
        $allOrderByCentrals = Sourcing::where(['etat' => 'actif'])->get();
        $orderOnDocument = Sourcing::where(['etat' => 'actif', 'statut' => 'validateDoc'])->orderBy('created_at', 'desc')->get();
        $orderOnDocumentPercent = 0;
        if ($orderOnDocument->count() > 0 && $allOrderByCentrals->count() > 0) {
            $orderOnDocumentPercent = ($orderOnDocument->count() / $allOrderByCentrals->count()) * 100;
        }
        // en transit
        $orderOnTransit = Sourcing::where(['etat' => 'actif', 'statut' => 'odTransit'])->orderBy('created_at', 'desc')->get();
        $orderOnTransitPercent = 0;
        if($orderOnTransit->count() > 0 && $allOrderByCentrals->count() > 0){
            $orderOnTransitPercent = ($orderOnTransit->count() / $allOrderByCentrals->count()) * 100;
        }
        // $orderOnTransitPercent = ($orderOnTransit->count() / $allOrderByCentrals->count()) * 100;
        // en livraison
        $orderOnDelivery = Sourcing::where(['etat' => 'actif', 'statut' => 'odlivraison'])->orderBy('created_at', 'desc')->get();
        $orderOnDeliveryPercent = 0;
        if($orderOnDelivery->count() > 0 && $allOrderByCentrals->count() > 0){
            $orderOnDeliveryPercent = ($orderOnDelivery->count() / $allOrderByCentrals->count()) * 100;
        }
        // $orderOnDeliveryPercent = ($orderOnDelivery->count() / $allOrderByCentrals->count()) * 100;
        // livrer
        $orderReceiv = Sourcing::where(['etat' => 'actif', 'statut' => 'received'])->orderBy('created_at', 'desc')->get();
        $orderReceivPercent = 0;
        if($orderReceiv->count() > 0 && $allOrderByCentrals->count() > 0){
            $orderReceivPercent = ($orderReceiv->count() / $allOrderByCentrals->count()) * 100;
        }
        // $orderReceivPercent = ($orderReceiv->count() / $allOrderByCentrals->count()) * 100;

        // Interface transitaire 
        $odtransit = OdTransite::where(['etat' => 'actif','transitaire_uuid' => Auth::user()->uuid])->orderBy('created_at', 'desc')->get();
        $expedite = ExTransit::where(['etat' => 'actif','transitaire_uuid' => Auth::user()->uuid])->orderBy('created_at', 'desc')->get();

        $allTransitAssigned = $odtransit->concat($expedite);

        $allTransitReceiv = $allTransitAssigned->whereNotNull('receive_date');

        $totalTransitTime = 0;
        $count = 0;

        foreach ($allTransitReceiv as $transit) {
            // Calculer la différence en jours entre la date de création et la date de réception de la facture
            $transitTime = Carbon::parse($transit->created_at)->diffInDays(Carbon::parse($transit->receive_date));
            $totalTransitTime += $transitTime;
            $count++;
        }

        // Calcul du temps moyen de transit
        $averageTransitTime = $count > 0 ? $totalTransitTime / $count : 0;

        $factures = Facturation::where(['etat'=> 'actif', 'transitaire_uuid' => Auth::user()->uuid])->get();
        $factureAccepte = Facturation::where(['etat'=> 'actif', 'transitaire_uuid' => Auth::user()->uuid, 'statut' => 'good_pay'])->get();


        $factureUuid = $factures->pluck('uuid');
        $factureAccepteUuid = $factureAccepte->pluck('uuid');

        $prestationLigne = PrestationLine::where(['etat' => 'actif'])->whereIn('facture_uuid', $factureUuid)->orderBy('created_at', 'desc')->get();
        $prestationLignefactureAccepteUuid = PrestationLine::where(['etat' => 'actif'])->whereIn('facture_uuid', $factureAccepteUuid)->orderBy('created_at', 'desc')->get();

        // Interface transporteur 
        $odtransport = OdLivraison::where(['etat' => 'actif','transporteur_uuid' => Auth::user()->uuid])->orderBy('created_at', 'desc')->get();
        $exTransport = ExpTransport::where(['etat' => 'actif','transporteur_uuid' => Auth::user()->uuid])->orderBy('created_at', 'desc')->get();

        $allTransports = $odtransport->concat($exTransport);

        $allTransportsReceiv = $allTransports->whereNotNull('receive_date');

        $totalTransportTime = 0;
        $count = 0;

        foreach ($allTransportsReceiv as $transit) {
            // Calculer la différence en jours entre la date de création et la date de réception de la facture
            $transportTime = Carbon::parse($transit->created_at)->diffInDays(Carbon::parse($transit->receive_date));
            $totalTransportTime += $transportTime;
            $count++;
        }

        // Calcul du temps moyen de transit
        $averageTransportTime = $count > 0 ? $totalTransportTime / $count : 0;

        $facturesTRansport = Facturation::where(['etat'=> 'actif', 'transporteur_uuid' => Auth::user()->uuid])->get();
        $factureAccepteTr = Facturation::where(['etat'=> 'actif', 'transporteur_uuid' => Auth::user()->uuid, 'statut' => 'good_pay'])->get();

        $factureTrUuid = $facturesTRansport->pluck('uuid');
        $factureTRAccepteUuid = $factureAccepteTr->pluck('uuid');

        $prestationTotalTr = PrestationLine::where(['etat' => 'actif'])->whereIn('facture_uuid', $factureTrUuid)->orderBy('created_at', 'desc')->get();
        $prestationTotalTrAccepter = PrestationLine::where(['etat' => 'actif'])->whereIn('facture_uuid', $factureTRAccepteUuid)->orderBy('created_at', 'desc')->get();


        
       
        return view('admin.dashbord',
        compact('stockGlobals', 'inFabrication', 'inUsineOut', 'inWaitExpediteImport', 'arrivagePod', 'receivStock', 'inWaitExpediteExport', 'liverExpedite','stockPreview','stockPreviewValue', 'firstNextArrivage',
        'nbrTotalIn', 'nbrTotalInConform', 'nbrTotalInNoConfrom',
        'InStock', 'conformInStockPerMonth', 'noConformInStockPerMonth','nbrTotalInPerMonth', 'nbrTotalInConform', 'nbrTotalInNoConfrom',
        'percentageInFabrication','percentageinUsineOut','percentageinWaitExpediteImport', 'percentagearrivagePod', 'percentagereceivStock', 'percentageinWaitExpediteExport', 'percentageliverExpedite',
         'conformInStock', 'noConformInStock', 'conformInStockWeekly', 'noConformInStockWeekly', 'InStockWekly', 'firstDayOfWeek', 'lastDayOfWeek', 'listInStock', 'outStockMonth', 'outStockWekly', 'totalValue', 'totalValueWeekly', 'nextArrive', 'nbrProdPerExpedition', 'sourcings', 'averageDelaySourcing', 'sourcingInValidation', 'sourcingInValidatPerMonth', 'sourcingPerMonths', 'sourcingReceive','percentageConform', 'percentageSourcingsPerMonth','percenSourcWaitLivrPerMonth','percenReceivMonth','nbrTotalOut','nbrTotalOutConform','nbrTotalOutNoConfrom','allTransitPerMonth','mostUsedTransitaire','allTransitPerWekly','nbrExpeditionLivraison', 'averageDelayTransit', 'averageDelayTransport', 'conformInStockGlobal', 'noConformInStockGlobal','sourcingPerWekly','percentageSourcingsPerWekly', 'percWaitSourPerWekly', 'percentagereceivPerWekly', 'sourcingReceivePerWekly', 'nbrExpeditionToDocValidate', 'nbrTotalExpedition', 'nbrExpeditionStarted', 'nbrExpeditionWaitExpedite', 'nbrExpeditionExpedier', 'nbrTotalExpeditionActif', 'percentageExpGlobal', 'percentageExpTransit','percentageExpWaitExp', 'percentageExpDelivered', 'averageDelayExpedite', 'latestExpedition', 'resultDate', 'recentExpedition', 'allExpWaitValidatePerMonth', 'percentageExpWaitDocMensuel', 'percentageExpDemarrerMensuel', 'countExpDemarrerPerMonth', 'countExpWaitingPerMonth', 'percentageExpWaitingMensuel','countExpReadyPerMonth', 'percentageExpReadyMensuel', 'total', 'total_count', 'total_bon_payer', 'total_bon_count', 'total_payed', 'total_payed_count', 'total_cancel', 'total_cancel_count', 'factures', 'countSourcingPerWeekly', 'lastFacts' ,'valeurTotals' , 'totalRefacturcount', 'valeurTotalsPayed','valeurTotalsSending', 'totalSendingCount', 'totalPayedCount', 'valeurTotalsRejeter', 'totalRejetedCount' ,    'valeurallFactByPrestationActif', 'totalallFactByPrestationActifCount' , 'valeur_bon_a_payer', 'facture_bon_a_payer_count', 'facture_payer_count', 'valeur_payer', 'facture_canceled_count', 'valeur_canceled', 'firstLatestExpedition', 'factureEchuCount', 'valeur_factureEchu', 'totalFactDebou', 'valeurTotalDebou', 'totalFactPrestation', 'valeurTotalPrestation', 'montantsFournisseurParMois','montantsPrestataireParMois','montantsPrestatairePayedParMois', 'montantFournisseurDeboursParMois', 'montantFournisseurPrestationParMois', 'facturesFournisseurActives', 'facturesFournisseurDebours', 'facturesFournisseurPrestation',
        'facturePrestataireEchuCount', 'valeur_facturePrestataireEchu', 'facturesPrestataireActives', 'familyNemba', 'familyNembaInter', 'percenfamilyNembaCount', 'percenfamilyNembaInter', 'sourcingsForCentral','facturesRecent', 'orderByCentrals', 'orderOnDocument','orderOnDocumentPercent','orderOnTransit','orderOnTransitPercent','orderOnDelivery','orderOnDeliveryPercent','orderReceiv','orderReceivPercent','allTransitAssigned','averageTransitTime','factures','prestationLigne','factureAccepte','prestationLignefactureAccepteUuid','allTransports','averageTransportTime','factureAccepteTr','facturesTRansport','prestationTotalTr','prestationTotalTrAccepter'));
        // return view('adminHome');
    }

    public function sendEmail(Request $request)
    {
        DB::beginTransaction();

        try {


            $recipientEmail = $request->input('destinataire');
            $emailSubject = $request->input('objet');
            $message = $request->input('message');
            $attachments = $request->file('attachments', []);

            $mailData = [
                'title' => $emailSubject,
                'body' => $message,
            ];

             // Filtrer les fichiers valides
        $validAttachments = array_filter($attachments, function($attachment) {
            return $attachment && $attachment->isValid();
        });

            $mail = new LogisticaMail($mailData, $emailSubject, $validAttachments);

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
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome(): View
    {
        return view('managerHome');
    }

    public function getCurrentDateTime()
    {
        $currentDateTime = Carbon::now();
        return response()->json(['datetime' => $currentDateTime->format('d/M/Y H:i:s')]);
    }



}
