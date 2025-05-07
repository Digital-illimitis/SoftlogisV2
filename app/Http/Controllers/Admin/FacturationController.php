<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Device;
use App\Models\Company;
use App\Models\FactureDoc;
use App\Models\Facturation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PrestationLine;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FacturationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestatairesTransports = Company::where(['etat' => 'actif', 'type'=> 'transporteur'])->get();
        $prestatairesTransits = Company::where(['etat' => 'actif', 'type' =>'transitaire'])->get();

        $factures = Facturation::where('etat', 'actif')->get();
        // dd($factures);
        $facturesCount = $factures->count();
        $prestationLines = PrestationLine::where('etat', 'actif')->get();
        $totalGlobalLine = $prestationLines->sum('totalLigne');

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
        

        return view('admin.facturation.index', compact('taux','totalGlobalLine', 'facturesCount','facture_bon_a_payer_count', 'valeur_bon_a_payer','facture_payer_count', 'valeur_payer','facture_canceled_count', 'valeur_canceled',
         'prestatairesTransports','factures','total', 'total_count', 'facture_bon_a_payer', 'total_bon_payer', 'total_bon_count', 'total_payed', 'total_payed_count', 'total_cancel', 'total_cancel_count', 'prestatairesTransits'));
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
                'numFacture' => 'required|string|max:255',
            ]);

            DB::beginTransaction();
            try {

                $user = auth()->user();

                $saving= Facturation::create([
                    'uuid'=> Str::uuid(),
                    'code' => Refgenerate(Facturation::class, 'Fa', 'code'),
                    'statut' => 'reccording',

                    'numFacture' => $request->numFacture,
                    'date_echeance' => $request->date_echeance,
                    'typeFacture' => $request->typeFacture,

                    'transitaire_uuid' => $request->transitaire_uuid,
                    'transporteur_uuid' => $request->transporteur_uuid,

                    'num_bl' => $request->num_bl,
                    'file_Bl' => $request->file_Bl,

                    // 'facture_original' => $image,
                    'note' => $request->note,
                    // 'date_paiement' => $request->date_paiement,
                    'user_create' => Auth::id(),

                    'etat' => 'actif',
                ])->save();
                // dd($saving->id);
                $facture_uuid = Facturation::OrderBy('id', 'desc')->first();

                $rubriques = $request->input('rubrique');
                $prixUnitaires = $request->input('prixUnitaire');
                $qtys = $request->input('qty');
                $totalLignes = $request->input('totalLigne');

                foreach ($rubriques as $index => $rubrique) {
                $FacturePrestation = PrestationLine::create([
                    'uuid' => Str::uuid(),
                    'facture_uuid' => $facture_uuid->uuid,
                    'etat' => 'actif',
                    'rubrique' => $rubrique,
                    'prixUnitaire' => $prixUnitaires[$index],
                    'qty' => $qtys[$index],
                    // 'totalLigne' => $totalLignes[$index],
                    'totalLigne' => array_key_exists($index, $totalLignes) ? $totalLignes[$index] : 0,
                ]);
                }

                $images = $request->file('facture_original');
                $facture_originals = [];

                foreach ($images as $indexx => $image) {
                    if ($image == null) {
                        $image = 'default_fact.pdf';
                    } else {
                        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                        $image->move('files/', $filename);
                        $facture_originals[] = $filename;
                    }
                }
                if (!empty($images)) {
                    // $facture_originals = implode(',', $facture_originals);

                    foreach ($facture_originals as $indexx => $facture_original) {
                        $facture_original = FactureDoc::create([
                            'uuid' => Str::uuid(),
                            'facture_uuid' => $facture_uuid->uuid,
                            'etat' => 'actif',
                            'facture_original' => $facture_original,
                            'file_path' => $facture_original,
                        ]);
                    }
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        $facture = Facturation::where('uuid', $id)->firstOrFail();

        $facture_docs = FactureDoc::where('facture_uuid', $id)->firstOrFail();

        $taux = Device::select('valeur')->where('etat', 'actif')->firstOrFail();
        // dd($facture_docs);

        return view('admin.facturation.show', compact('facture', 'facture_docs','taux'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $facture = Facturation::where('uuid', $id)->firstOrFail();
        $prestatairesTransports = Company::where(['etat' => 'actif', 'type'=> 'transporteur'])->get();
        $prestatairesTransits = Company::where(['etat' => 'actif', 'type' =>'transitaire'])->get();

        return view('admin.facturation.editModal', compact('facture', 'prestatairesTransports', 'prestatairesTransits'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            $user = auth()->user();

            $saving= Facturation::where(['uuid'=>$id])->update([
                'numFacture' => $request->numFacture,
                'date_echeance' => $request->date_echeance,

                'num_bl' => $request->num_bl,
                'file_Bl' => $request->file_Bl,

                // 'facture_original' => $image,
                'note' => $request->note,
                'date_paiement' => $request->date_paiement,
            ]);
            // dd($saving->id);
            $facture_uuid = Facturation::OrderBy('id', 'desc')->first();

            $rubriques = $request->input('rubrique');
            $prixUnitaires = $request->input('prixUnitaire');
            $qtys = $request->input('qty');
            $totalLignes = $request->input('totalLigne');

            foreach ($rubriques as $index => $rubrique) {
            $FacturePrestation = PrestationLine::create([
                'uuid' => Str::uuid(),
                'facture_uuid' => $facture_uuid->uuid,
                'etat' => 'actif',
                'rubrique' => $rubrique,
                'prixUnitaire' => $prixUnitaires[$index],
                'qty' => $qtys[$index],
                // 'totalLigne' => $totalLignes[$index],

                'totalLigne' => array_key_exists($index, $totalLignes) ? $totalLignes[$index] : 0,
            ]);
            }

            $images = $request->file('facture_original');
            $facture_originals = [];

            if (!empty($images)) {
                foreach ($images as $indexx => $image) {
                    if ($image == null) {
                        $file_default = 'default_fact.pdf';
                        $facture_originals = $file_default;
                    } else {
                        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                        $image->move('files/', $filename);
                        $facture_originals[] = $filename;
                    }
                }
            }
            if (!empty($images)) {
                // $facture_originals = implode(',', $facture_originals);

                foreach ($facture_originals as $indexx => $facture_original) {
                    $facture_original = FactureDoc::create([
                        'uuid' => Str::uuid(),
                        'facture_uuid' => $facture_uuid->uuid,
                        'etat' => 'actif',
                        'facture_original' => $facture_original,
                        'file_path' => $facture_original,
                    ]);
                }
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        {

            DB::beginTransaction();
            try {

                $saving= Facturation::where(['uuid'=>$id])->update(['etat'=>"inactif"]);

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

    }
    public function marck_to_good_pay(string $id)
    {
        {
            DB::beginTransaction();
            try {
                $saving= Facturation::where(['uuid'=>$id])->update(['statut'=>"good_pay"]);

                if ($saving) {

                    $dataResponse =[
                        'type'=>'success',
                        'urlback'=>"back",
                        'message'=>"Marqué comme Bon a Payer avec succès!",
                        'code'=>200,
                    ];
                    DB::commit();
                } else {
                    DB::rollback();
                    $dataResponse =[
                        'type'=>'error',
                        'urlback'=>'',
                        'message'=>"Une erreur ces produite!",
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
    public function marck_payed(string $id)
    {

        {

            DB::beginTransaction();
            try {

                $saving= Facturation::where(['uuid'=>$id])->update([
                    'statut'=>"payed",
                    'date_paiement'=> now(),
                    'user_payed'=> auth::user()->id,
                ]);

                if ($saving) {

                    $dataResponse =[
                        'type'=>'success',
                        'urlback'=>"back",
                        'message'=>"Paiement effectué avec succès!",
                        'code'=>200,
                    ];
                    DB::commit();
                } else {
                    DB::rollback();
                    $dataResponse =[
                        'type'=>'error',
                        'urlback'=>'',
                        'message'=>"Une erreur ces produite!",
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
    public function marck_canceled(string $id)
    {

        {

            DB::beginTransaction();
            try {

                $saving= Facturation::where(['uuid'=>$id])->update(['statut'=>"cancel"]);

                if ($saving) {

                    $dataResponse =[
                        'type'=>'success',
                        'urlback'=>"back",
                        'message'=>"Paiement effectué avec succès!",
                        'code'=>200,
                    ];
                    DB::commit();
                } else {
                    DB::rollback();
                    $dataResponse =[
                        'type'=>'error',
                        'urlback'=>'',
                        'message'=>"Une erreur ces produite!",
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

    public function destroyPrestationLines(string $id)
    {

        DB::beginTransaction();
        try {

            $saving= PrestationLine::where(['uuid'=>$id])->update(['etat'=>"inactif"]);

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

}