<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Device;
use App\Models\Article;
use App\Models\Company;
use App\Models\Sourcing;
use App\Models\ExTransit;
use App\Models\Expedition;
use App\Models\OdTransite;
use App\Models\Facturation;
use App\Models\OdLivraison;
use App\Models\ExpTransport;
use Illuminate\Http\Request;
use App\Models\Refacturation;
use App\Models\PrestationLine;
use App\Models\FacturePrestation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RapportController extends Controller
{

    public function reportFacture(Request $request)
    {
        $prestatairesTransports = Company::where(['etat' => 'actif', 'type' => 'transporteur'])->get();
        $prestatairesTransits = Company::where(['etat' => 'actif', 'type' => 'transitaire'])->get();

        // $FilterPrestataire = Company::where('etat', 'actif')
        // ->where(function ($query) {
        //     $query->where('type', 'transitaire')->orWhere('type', 'transporteur');
        // })->get();

        $FilterPrestataire = Company::where('etat', 'actif')->whereIn('type',['transitaire', 'transporteur'])->get();


        // Get filter parameters
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $numBl = $request->input('num_bl');
        $typeFacture = $request->input('type_facture');
        $byPrestataire = $request->input('FilterPrestataire');


        // Base query for Facturation
        $query = Facturation::where('etat', 'actif');

        // Apply filters
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($status) {
            $query->where('statut', $status);
        }

        if ($numBl) {
            $query->where('num_bl', 'LIKE', '%' . $numBl . '%');
        }

        if ($typeFacture) {
            $query->where('typeFacture', $typeFacture);
        }
        if ($byPrestataire) {
            $query->where(function ($query) use ($byPrestataire) {
                $query->where('transporteur_uuid', $byPrestataire)
                    ->orWhere('transitaire_uuid', $byPrestataire);
            });
        }

        $factures = $query->get();

        $factuUiid = $factures->pluck('uuid');

        // $factures = Facturation::where('etat', 'actif')->get();
        // dd($factures);
        $facturesCount = $factures->count();
        $prestationLines = PrestationLine::where('etat', 'actif')->whereIn('facture_uuid', $factuUiid)->get();
        $totalGlobalLine = $prestationLines->sum('totalLigne');

        // Bon a Payer
        $facture_bon_a_payer = Facturation::where(['etat' => 'actif', 'statut' => 'good_pay'])->get();
        $factureGoodPayCount = $factures->where('statut', 'good_pay');
        $facture_bon_a_payer_count = $factureGoodPayCount->count();
        $valeur_bon_a_payer = $factureGoodPayCount->sum(function ($facture) {
            return $facture->prestationLines->sum('totalLigne');
        });

        // Payers
        $facture_payer = Facturation::where(['etat' => 'actif', 'statut' => 'payed'])->get();
        $factuPay = $factures->where('statut', 'payed');
        $facture_payer_count = $factuPay->count();
        $valeur_payer = $factuPay->sum(function ($facture) {
            return $facture->prestationLines->sum('totalLigne');
        });

        // Canceled
        $facture_cancel = Facturation::where(['etat' => 'actif', 'statut' => 'cancel'])->get();
        $factCancel = $factures->where('statut', 'cancel');
        $facture_canceled_count = $factCancel->count();
        $valeur_canceled = $factCancel->sum(function ($facture) {
            return $facture->prestationLines->sum('totalLigne');
        });


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

        $taux = Device::select('valeur')->where('etat', 'actif')->firstOrFail();


        return view('admin.rapports.factureRepport', compact(
            'taux',
            'totalGlobalLine',
            'facturesCount',
            'facture_bon_a_payer_count',
            'valeur_bon_a_payer',
            'facture_payer_count',
            'valeur_payer',
            'facture_canceled_count',
            'valeur_canceled',
            'prestatairesTransports',
            'FilterPrestataire',
            'factures',
            'total',
            'total_count',
            'facture_bon_a_payer',
            'total_bon_payer',
            'total_bon_count',
            'total_payed',
            'total_payed_count',
            'total_cancel',
            'total_cancel_count',
            'prestatairesTransits',
            'factureGoodPayCount',
            'factuPay',
            'factCancel'

        
        ));
    }

    public function reportFactureCustomer(Request $request)
    {
        $taux = Device::select('valeur')->where('etat', 'actif')->firstOrFail();
        $factCustomers = Company::where(['etat' => 'actif', 'type' => 'client'])->get();


        // Get filter parameters
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $echeanceDate = $request->input('date_echeance');
        $status = $request->input('status');
        $customer = $request->input('customer');

        // Base query for Facturation
        $query = Refacturation::where('etat', 'actif');

        // Apply filters
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        if ($echeanceDate) {
            $query->whereDate('date_echeance', '=', $echeanceDate);
        }
        if ($status) {
            $query->where('statut', $status);
        }
        if ($customer) {
            $query->where('doit', $customer);
        }
        $factures = $query->get();

        $facturesCount = $factures->count();

        $factuUiid = $factures->pluck('uuid')->toArray();
        $prestationLines = FacturePrestation::where('etat', 'actif')->whereIn('facture_uuid', $factuUiid)->get();
        // $prestationLines = FacturePrestation::where('etat', 'actif')->get();
        $totalGlobalLine = $prestationLines->sum('total') ?? 0;


        

        // Bon a Payer // enoyé au client
        $facture_bon_a_payer = Refacturation::where(['etat' => 'actif', 'statut' => 'sendToClient'])->get();
        $facGoodPay = $factures->where('statut', 'sendToClient');
        $facture_bon_a_payer_count = $facGoodPay->count();
        $valeur_bon_a_payer = $facGoodPay->sum(function ($facture) {
            return $facture->prestations->sum('total') ?? 0;
        });

        // Payers
        $facture_payer = Refacturation::where(['etat' => 'actif', 'statut' => 'payed'])->get();
        $factPayed = $factures->where('statut' , 'payed');
        $facture_payer_count = $factPayed->count();
        $valeur_payer = $factPayed->sum(function ($facture) {
            return $facture->prestations->sum('total') ?? 0;
        });

        // Canceled
        $facture_cancel = Refacturation::where(['etat' => 'actif', 'statut' => 'canceled'])->get();
        $factCancel = $factures->where('statut', 'canceled');
        $facture_canceled_count = $factCancel->count();
        $valeur_canceled = $factCancel->sum(function ($facture) {
            return $facture->prestations->sum('total') ?? 0;
        });

    
        // if ($numBl) {
        //     $query->where('num_bl', 'LIKE', '%' . $numBl . '%');
        // }


        return view('admin.rapports.factureCustomer', compact(
            'taux',
            'factures',
            'facturesCount',
            'totalGlobalLine',

            'valeur_bon_a_payer',
            'facture_bon_a_payer',
            'facture_bon_a_payer_count',

            'valeur_payer',
            'facture_payer',

            'valeur_canceled',
            'facture_cancel',
            'facture_canceled_count',
            'facGoodPay',
            'factPayed',
            'factCancel',
            'factCustomers'
            
            
            
        ));
    }

    public function reportSourcing(Request $request)
    {
        $query = Sourcing::where('etat', 'actif');

        // Filtrer par date estimative d'arrivée
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date_arriver', [
                Carbon::parse($request->input('start_date')),
                Carbon::parse($request->input('end_date'))
            ]);
        }

        // Filtrer par date de création
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->input('created_at'));
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('statut', $request->input('status'));
        }

        // Filtrer par numéro BL
        if ($request->filled('num_bl')) {
            $query->where('num_bl', 'LIKE', '%' . $request->input('num_bl') . '%');
        }

        // Filtrer par numéro de dossier
        if ($request->filled('numDossier')) {
            $query->where('numDossier', 'LIKE', '%' . $request->input('numDossier') . '%');
        }

        $sourcings = $query->get();

        // Chargement des autres articles en fonction de leurs états
        $allArticle = Article::where('etat', 'actif')
            ->whereNotIn('status', ['delivered'])
            ->get();

        $articleSource = Article::where('etat', 'actif')
            ->whereNotIn('status', ['delivered'])
            ->where('is_AddSourcing', 'true')
            ->get();

        $articleNonSource = Article::where('etat', 'actif')
            ->whereNotIn('status', ['delivered'])
            ->where('is_AddSourcing', 'false')
            ->get();

        return view('admin.rapports.sourcingReport', compact('allArticle', 'sourcings', 'articleSource', 'articleNonSource'));
    }
 

    // public function reportArticle(Request $request)
    // {
    //     $articles = Article::where('etat', 'actif')->get();
    //     return view('admin.rapports.articleReport', compact('articles'));
    // }
    public function reportExpedition(Request $request)
    {
        $num_dossier = $request->input('num_dossier');

        // Rechercher la commande
        $order = Order::where('etat', 'actif')
                    ->where('num_exp', $num_dossier)
                    ->first();

        // Rechercher l'expédition correspondante
        $expedition = Expedition::where('etat', 'actif')
                                ->where('num_order', $num_dossier)
                                ->first();

        // Calcul du temps de traitement
        $tempsTraitement = null;
        if ($order && $expedition) {
            $tempsTraitement = $expedition->created_at->diff($order->created_at);
        }

        $expeditions = Expedition::where('etat', 'actif')->get();

        $expeditionsForWeek = Expedition::where('etat', 'actif')
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->get();

        // $timeTransit = ExTransit::where('etat', 'actif')->whereIn('expedition_uuid',[$expeditions->pluck('uuid')])->first();
        // dd($timeTransit);

        $expeditionsAfterDelai = Expedition::where('etat', 'actif')
        ->where(function ($query) {
            $query->where('statut', '!=', 'orderRecu')
                ->whereDate('date_transit', '<=', Carbon::now()->subDays(15));
        })
        ->get();

        $expeditionsInDelais = Expedition::where('etat', 'actif')
        ->whereDate('date_transit', '>', Carbon::now()->subDays(15))
        ->get();

        $expeditionsLivreesSemaine = Expedition::where('etat', 'actif')
        ->whereBetween('dateLivraisonFinal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->get();

        
        $tauxLivraisonTotal = 0;
        if ($expeditions->count() > 0) {
            $tauxLivraisonTotal = ($expeditionsInDelais->count() / $expeditions->count()) * 100;
        }

        $tauxLivraisonSemaine = 0;
        if ($expeditionsForWeek->count() > 0) {
            $tauxLivraisonSemaine = ($expeditionsLivreesSemaine->count() / $expeditionsForWeek->count()) * 100;
        }
       


        return view('admin.rapports.expeditionReport', 
        compact('order', 
        'expedition', 'tempsTraitement',
        'expeditions','expeditionsForWeek',
        'expeditionsAfterDelai','expeditionsInDelais',
        'expeditionsLivreesSemaine',
        'tauxLivraisonTotal','tauxLivraisonSemaine'));
    }

    

    public function transportReport(Request $request)
    {
        // Récupérer les transporteurs
        $transporteurs = Company::where(['type' => 'transporteur', 'etat' => 'actif'])->get();

        // Récupérer les transports à l'import et à l'export
        $importTransport = OdLivraison::where('etat', 'actif')->get(); // à l'import
        $exportTransport = ExpTransport::where('etat', 'actif')->get(); // à l'export

        // Fusionner les deux collections
        $allTransport = $importTransport->merge($exportTransport);

        // Initialiser les compteurs
        $totalTransport = $allTransport->count();
        $transportsDansDelai = 0;
        $transportsHorsDelai = 0;
        $totalDelais = 0; // Cumul des jours pour calculer la moyenne

        // Parcourir tous les transports pour déterminer leur état
        foreach ($allTransport as $transport) {
            $delaiTransport = $this->getDelaiTransport($transport); // Fonction pour calculer le délai
            
            if ($delaiTransport !== null) {
                $totalDelais += $delaiTransport; // Ajouter au total des jours

                if ($this->isLivraisonDansDelai($transport)) {
                    $transportsDansDelai++;
                } else {
                    $transportsHorsDelai++;
                }
            }
        }

        // Calcul du temps moyen de transit
        $tempsMoyenTransit = $totalTransport > 0 ? round($totalDelais / $totalTransport, 2) : 0;

        // Passer les données à la vue
        return view('admin.rapports.transportReport', compact(
            'transporteurs',
            'totalTransport',
            'transportsDansDelai',
            'transportsHorsDelai',
            'tempsMoyenTransit'
        ));
    }

/**
 * Calculer le délai de transport (en jours).
 */
private function getDelaiTransport($transport)
{
    if ($transport instanceof OdLivraison && $transport->sourcing) {
        $dateDebut = Carbon::parse($transport->sourcing->date_arriver);
        $dateFin = Carbon::now();
    } elseif ($transport instanceof ExpTransport && $transport->expedition) {
        $dateDebut = Carbon::parse($transport->expedition->created_at);
        $dateFin = Carbon::now();
    } else {
        return null; // Pas de données valides pour le délai
    }

    return $dateDebut->diffInDays($dateFin);
}


    // public function getTransporteurDetails($uuid) // complement pour le calcule rapport transport detail sur le transporteur
    // {
    //     $transporteur = Company::where('uuid', $uuid)->first();

    //     if ($transporteur) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => [
    //                 'logo' => $transporteur->logo,
    //                 'name' => $transporteur->raison_sociale,
    //                 'email' => $transporteur->email,
    //                 'phone' => $transporteur->phone,
    //                 'identification' => $transporteur->identification,
    //                 'voie_transport' => $transporteur->voie_transport,
    //                 'localisation' => $transporteur->localisation,
    //             ],
    //         ]);
    //     } else {
    //         return response()->json(['success' => false, 'message' => 'Transporteur introuvable.']);
    //     }
    // }

    public function getTransporteurDetails($uuid)
{
    $transporteur = Company::where('uuid', $uuid)->first();

    if ($transporteur) {
        return response()->json([
            'success' => true,
            'data' => [
                'logo' => $transporteur->logo,
                'name' => $transporteur->raison_sociale,
                'email' => $transporteur->email,
                'phone' => $transporteur->phone,
                'identification' => $transporteur->identification,
            ],
        ]);
    } else {
        return response()->json(['success' => false, 'message' => 'Transporteur introuvable.']);
    }
}

// public function getTransporteurStats($uuid)
// {
//     // Récupérer les transports actifs pour ce transporteur
//     $importTransport = OdLivraison::where('etat', 'actif')->where('transporteur_uuid', $uuid)->get();
//     $exportTransport = ExpTransport::where('etat', 'actif')->where('transporteur_uuid', $uuid)->get();

//     // Fusionner les deux collections de transports
//     $allTransport = $importTransport->merge($exportTransport);

//     // Initialiser les compteurs
//     $totalTransport = $allTransport->count();
//     $transportsDansDelai = 0;
//     $transportsHorsDelai = 0;
//     $totalDelais = 0;  // Cumul des jours pour calculer le délai moyen

//     // Parcourir les transports pour calculer leur délai et les classer
//     foreach ($allTransport as $transport) {
//         $delaiTransport = $this->getDelaiTransport($transport);  // Calcul du délai en jours

//         if ($delaiTransport !== null) {
//             $totalDelais += $delaiTransport;  // Ajouter au total des jours
//             if ($this->isLivraisonDansDelai($transport)) {
//                 $transportsDansDelai++;
//             } else {
//                 $transportsHorsDelai++;
//             }
//         }
//     }

//     // Calcul du temps moyen de transit
//     $tempsMoyenTransit = $totalTransport > 0 ? round($totalDelais / $totalTransport, 2) : 0;

//     // Retourner les statistiques du transporteur
//     return response()->json([
//         'success' => true,
//         'data' => [
//             'totalTransport' => $totalTransport,
//             'transportsDansDelai' => $transportsDansDelai,
//             'transportsHorsDelai' => $transportsHorsDelai,
//             'tempsMoyenTransit' => $tempsMoyenTransit,
//         ],
//     ]);
// }

public function getTransporteurStats($uuid)
{
    // Récupérer les transports actifs pour ce transporteur
    $importTransport = OdLivraison::where('etat', 'actif')->where('transporteur_uuid', $uuid)->get();
    $exportTransport = ExpTransport::where('etat', 'actif')->where('transporteur_uuid', $uuid)->get();

    // Fusionner les deux collections de transports
    $allTransport = $importTransport->merge($exportTransport);

    // Initialiser les compteurs et listes
    $totalTransport = $allTransport->count();
    $transportsDansDelai = 0;
    $transportsHorsDelai = 0;
    $totalDelais = 0;  // Cumul des jours pour calculer le délai moyen

    $listeDansDelai = [];
    $listeHorsDelai = [];

    // Parcourir les transports pour calculer leur délai et les classer
    foreach ($allTransport as $transport) {
        $delaiTransport = $this->getDelaiTransport($transport);  // Calcul du délai en jours

        if ($delaiTransport !== null) {
            $totalDelais += $delaiTransport;  // Ajouter au total des jours
            if ($this->isLivraisonDansDelai($transport)) {
                $transportsDansDelai++;
                $listeDansDelai[] = [
                    'code' => $transport->code,
                    'created_at' => $transport->created_at->format('d/m/Y'),
                    'created_by' => $transport->user->name ?? 'N/A', // Relation user
                    'delai' => $delaiTransport, // Nombre de jours
                ];
            } else {
                $transportsHorsDelai++;
                $listeHorsDelai[] = [
                    'code' => $transport->code,
                    'created_at' => $transport->created_at->format('d/m/Y'),
                    'created_by' => $transport->user->name ?? 'N/A', // Relation user
                    'delai' => $delaiTransport, // Nombre de jours
                ];
            }
        }
    }

    // Calcul du temps moyen de transit
    $tempsMoyenTransit = $totalTransport > 0 ? round($totalDelais / $totalTransport, 2) : 0;

    // Retourner les statistiques et les listes
    return response()->json([
        'success' => true,
        'data' => [
            'totalTransport' => $totalTransport,
            'transportsDansDelai' => $transportsDansDelai,
            'transportsHorsDelai' => $transportsHorsDelai,
            'tempsMoyenTransit' => $tempsMoyenTransit,
            'listeDansDelai' => $listeDansDelai,
            'listeHorsDelai' => $listeHorsDelai,
        ],
    ]);
}


public function rapportExpByFiliale(request $request)
{
        // Récupérer les filiales actives
        $filiales = Company::where('etat', 'actif')->where('type', 'client')->get();

        // Filtrage dynamique
        $filialeId = $request->input('filiale_id');
        $numOrder = $request->input('num_order');

        // Base query
        $query = Expedition::where('etat', 'actif');

        if ($filialeId) {
            $query->where('client_uuid', $filialeId);
        }

        if ($numOrder) {
            $query->where('num_order', $numOrder);
        }

        // Récupérer les expéditions avec différence en jours
        $expeditions = $query->select(
            'uuid',
            'client_uuid',
            'num_order',
            'date_transport',
            'orderDate',
            DB::raw('DATEDIFF(orderDate, date_transport) as jours')
        )->get();

        // Calcul du nombre d'expéditions par filiale pour les widgets
        $widgets = Expedition::select('client_uuid', DB::raw('COUNT(*) as total_expeditions'))
            ->where('etat', 'actif')
            ->with('client')
            ->groupBy('client_uuid')
            ->get();




    return view('admin.rapports.expedByFiliale',compact('filiales', 'expeditions', 'widgets', 'filialeId', 'numOrder'));
}































    private function isLivraisonDansDelai($transport)
    {
        $sourcing = $transport->sourcing;

        if ($sourcing) {
            $dateArriver = \Carbon\Carbon::parse($sourcing->date_arriver);
            $delaiLimite = $dateArriver->addDays(2);

            return now()->lessThanOrEqualTo($delaiLimite) || 
                in_array($sourcing->status, ['received', 'stocked']);
        }

        return false;
    }

    private function calculTauxLivraison($delaisRespectes, $totalLivraisons)
    {
        return $totalLivraisons->count() > 0 ? 
            ($delaisRespectes->count() / $totalLivraisons->count()) * 100 : 0;
    }

    public function getLivraisons(Request $request)
    {

        $allTransport = OdLivraison::where('etat', 'actif')->get();

        // Récupérer les livraisons du mois
        $allTransportMonth = OdLivraison::where('etat', 'actif')
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get();

        // Récupérer les livraisons de la semaine
        $allTransportWeek = OdLivraison::where('etat', 'actif')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        // Calcul des livraisons dans le délai et en retard pour le mois
        $delaisRespectesMonth = $allTransportMonth->filter(function ($transport) {
            return $this->isLivraisonDansDelai($transport);
        });

        $delaisDepassesMonth = $allTransportMonth->filter(function ($transport) {
            return !$this->isLivraisonDansDelai($transport);
        });

        // Calcul des livraisons dans le délai et en retard pour la semaine
        $delaisRespectesWeek = $allTransportWeek->filter(function ($transport) {
            return $this->isLivraisonDansDelai($transport);
        });

        $delaisDepassesWeek = $allTransportWeek->filter(function ($transport) {
            return !$this->isLivraisonDansDelai($transport);
        });

        // Calcul des taux de livraison
        $tauxLivraisonMonth = $this->calculTauxLivraison($delaisRespectesMonth, $allTransportMonth);
        $tauxLivraisonSemaine = $this->calculTauxLivraison($delaisRespectesWeek, $allTransportWeek);

        
        $livraisons = OdLivraison::where('transporteur_uuid', $request->input('transporteur_uuid'))->get();

        // $livraisons = OdLivraison::where('transporteur_uuid', $request->input('transporteur_uuid'))->get();

        if ($livraisons->isEmpty()) {
            session()->flash('error', 'Aucune livraison trouvée pour ce transporteur.');
            return redirect()->back();
        }

        $nombreLivraison = $livraisons->count();
        $livraisonDansDelai = $livraisons->filter(function ($livraison) {
            return $livraison->sourcing && \Carbon\Carbon::parse($livraison->sourcing->date_arriver)->addDays(2)->isFuture();
        })->count();
        $livraisonEnRetard = $nombreLivraison - $livraisonDansDelai;

        // Calculez la performance de livraison ici
        $performanceLivraison = $this->calculatePerformance($livraisons, $nombreLivraison, $livraisonDansDelai);
        $transporteurs = Company::where(['type'=>'transporteur', 'etat'=>'actif'])->get();

        return view('admin.rapports.transportReport', 
        compact('livraisons', 'nombreLivraison', 'livraisonDansDelai', 
        'livraisonEnRetard', 'performanceLivraison', 'tauxLivraisonMonth', 'tauxLivraisonSemaine', 
        'delaisRespectesMonth', 'delaisDepassesMonth', 
        'delaisRespectesWeek', 'delaisDepassesWeek',
        'allTransport', 'allTransportMonth', 'allTransportWeek',
        'tauxLivraisonMonth', 'tauxLivraisonSemaine',
        'transporteurs'));
    }



    private function calculatePerformance($livraisons, $nombreLivraison, $livraisonDansDelai)
    {
        $totalTime = 0;
        foreach ($livraisons as $livraison) {
            // Calculez le temps depuis la date de création jusqu'à la date d'arrivée
            $totalTime += $livraison->created_at->diffInMinutes($livraison->date_arriver);
        }

        $averageTime = $totalTime / max(1, $livraisons->count()); // Évitez la division par zéro
        $jours = floor($averageTime / 1440); // 1440 minutes dans une journée
        $heures = floor(($averageTime % 1440) / 60);
        $minutes = $averageTime % 60;

        // Taux de livraison
        $tauxLivraison = ($livraisonDansDelai / max(1, $nombreLivraison)) * 100; // Évitez la division par zéro

        return [
            'jours' => $jours,
            'heures' => $heures,
            'minutes' => $minutes,
            'taux' => round($tauxLivraison, 2),
        ];
    }

// transit report 

    public function transitReport(Request $request)
    {

        $transitaires = Company::where(['type'=>'transitaire', 'etat'=>'actif'])->get();
        return view('admin.rapports.transitReport', compact('transitaires'));
    }










}
