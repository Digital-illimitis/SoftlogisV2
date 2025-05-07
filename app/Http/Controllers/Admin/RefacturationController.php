<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Mail\Facture;
use App\Models\Device;
use App\Mail\LogisticaMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Refacturation;
// use Mail;
use App\Models\FacturePrestation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// use Barryvdh\DomPDF\Facade as PDF;

class RefacturationController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $taux = Device::select('valeur')->firstOrFail();
        $exchangeRate = $taux->valeur;
        $refacturations = Refacturation::where('etat', 'actif')->get();
        $facture_count = $refacturations->count();
        $valeur_global_facture = $refacturations->sum(function ($facture) {
            return $facture->prestations->where('etat', 'actif')->sum('total');
        });

        $refacturationSend = Refacturation::where(['etat' => 'actif', 'statut' => 'sendToClient'])->get();
        $totalFactSend = $refacturationSend->count();
        $valeur_totalFactSend = $refacturationSend->sum(function ($facture) {
            return $facture->prestations->where('etat', 'actif')->sum('total');
        });

        $refacturationPay = Refacturation::where(['etat' => 'actif', 'statut' => 'payed'])->get();
        $totalFactPay= $refacturationPay->count();
        $valeur_totalFactPay= $refacturationPay->sum(function ($facture) {
            return $facture->prestations->where('etat', 'actif')->sum('total');
        });
        
        // facture echue date echeance < now();
        $factureEchu =  Refacturation::where('etat', 'actif')
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
      
        // dd($allprestation);
        return view('admin.refacturation.index', 
        compact('exchangeRate','refacturations', 'facture_count', 'valeur_global_facture',
                'totalFactSend','valeur_totalFactSend',
            'totalFactPay','valeur_totalFactPay',
            'factureEchuCount','valeur_factureEchu',
            'totalFactDebou', 'valeurTotalDebou', 'totalFactPrestation', 'valeurTotalPrestation'));
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
                $uuid = Str::uuid();
            $refacturation = Refacturation::create([
                'uuid' => $uuid,
                'refClient' => $request->refClient,
                'doit' => $request->doit,
                'adresseComplete' => $request->adresseComplete,
                'num_cc' => $request->num_cc,
                'pol' => $request->pol,
                'pod' => $request->pod,
                'regime' => $request->regime,
                'email' => $request->email,

                'designation' => $request->designation,
                'num_Commande' => $request->num_Commande,
                'num_Bl' => $request->num_Bl,
                'navire' => $request->navire,
                'destination' => $request->destination,
                'amateur' => $request->amateur,
                'num_Dossier' => $request->num_Dossier,
                'num_Ot' => $request->num_Ot,
                'volume' => $request->volume,
                'tva' => $request->tva,
                'nbr_product' => $request->nbr_product,

                // info facturier
                'facturier_uuid' => Auth::user()->uuid,
                'poste_occuper' => $request->poste_occuper,
                'num_facture' => $request->num_facture,
                'date_echeance' => $request->date_echeance,
                'condition_paiement' => $request->condition_paiement,
                'comment' => $request->comment,

                'etat' => 'actif',
                'code' => Refgenerate(Refacturation::class, 'Facture', 'code'),
            ])->save();


            $refacturation_FAC = Refacturation::OrderBy('id', 'desc')->first();

            //$prestation = $request->input('prestation');
            $type_prestation = $request->input('type_prestation');
            $qty = $request->input('qty');
            $description = $request->input('description');
            $prixunitaire = $request->input('prixunitaire');
            $total = $request->input('total');

                    for($i=0; $i < count($type_prestation); $i++){
                    $prestations = [
                        'uuid' => Str::uuid(),
                        'facture_uuid' => $refacturation_FAC->uuid,
                        'etat' => "actif",
                        //'prestation' => $prestation[$i],
                        'type_prestation' => $type_prestation[$i],
                        'qty' => $qty[$i],
                        'description' => $description[$i],
                        'prixunitaire' => $prixunitaire[$i],
                        'total' => $total[$i],
                         ];
                     if($type_prestation[$i] !== null){
                            DB::table('facture_prestations')->insert($prestations);

                        }
                    }

            if ($refacturation) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> Route('admin.facturation.show', $uuid),
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
    public function show(string $id)
    {
        //

        $taux = Device::select('valeur')->firstOrFail();
        $exchangeRate = $taux->valeur;

        $refacturation = Refacturation::where(['uuid'=>$id])->firstOrFail();

        $prestations = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'prestation'])->where(['etat'=>"actif"])->get();
        $prestations_debours = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'debours'])->where(['etat'=>"actif"])->get();
        $prestations_totals_debours = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'debours'])->where(['etat'=>"actif"])->sum('total');
        $com = 1.95;
        $comm_debours = $prestations_totals_debours * $com;
        $comm_sous_debours = ($comm_debours / 100);

        $tvaPerCent = $refacturation->tva;

        $prestations_totalsS = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'prestation'])->where(['etat'=>"actif"])->sum('total');

        $prestations_totals = $prestations_totalsS + $comm_sous_debours;

        $user = DB::table('users')->where(['uuid'=>$refacturation->facturier_uuid])->first();
        $total_ht = ($prestations_totals + $prestations_totals_debours);
        // $tva = "21175";

        // $tva = ($prestations_totalsS * $tvaPerCent) / 100;
        $tva = ($prestations_totals * $tvaPerCent) / 100;
        $total_xof = ($total_ht + $tva);



        return view('admin.refacturation.show', compact('exchangeRate','comm_sous_debours','total_ht','tva','total_xof','refacturation', 'prestations', 'prestations_totals', 'user', 'prestations_debours','prestations_totals_debours'));

    }



    public function sendInvoiceEmail(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $taux = Device::select('valeur')->firstOrFail();
            $exchangeRate = $taux->valeur;

            $refacturation = Refacturation::find($id);
            $prestations = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'prestation'])->where(['etat'=>"actif"])->get();
            $prestations_debours = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'debours'])->where(['etat'=>"actif"])->get();
            $prestations_totals_debours = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'debours'])->where(['etat'=>"actif"])->sum('total');
            $com = 1.95;
            $comm_debours = $prestations_totals_debours * $com;
            $comm_sous_debours = ($comm_debours / 100);
            $prestations_totalsS = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'prestation'])->where(['etat'=>"actif"])->sum('total');
            $prestations_totals = $prestations_totalsS + $comm_sous_debours;

            $user = DB::table('users')->where(['uuid'=>$refacturation->facturier_uuid])->first();
            $total_ht = ($prestations_totals + $prestations_totals_debours);
            $tvaPerCent = $refacturation->tva;
            $tva = ($prestations_totals * $tvaPerCent) / 100;
            $total_xof = ($total_ht + $tva);

            $pdf = PDF::loadView('admin.refacturation.facture', compact('exchangeRate','comm_sous_debours','total_ht','tva','total_xof','refacturation', 'prestations', 'prestations_totals', 'user', 'prestations_debours','prestations_totals_debours'));


            $pdfContent = $pdf->output();

            $recipientEmail = $request->input('destinataire');
            $emailSubject = $request->input('objet');
            $message = $request->input('message');

            $mailData = [
                'title' => $emailSubject,
                'body' => $message,
            ];

            $mail = new LogisticaMail($mailData, $emailSubject);
            $mail->attachData($pdfContent, 'refacturation.pdf', ['mime' => 'application/pdf']);

            $mailSending = Mail::to($recipientEmail)->send($mail);

            if ($mailSending) {

                Refacturation::where(['id'=>$id])->update(['statut' => 'sendToClient']);

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




    public function downloadPDF($id) {

        $taux = Device::select('valeur')->firstOrFail();
        $exchangeRate = $taux->valeur;

            $refacturation = Refacturation::find($id);
            $prestations = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'prestation'])->where(['etat'=>"actif"])->get();
            $prestations_debours = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'debours'])->where(['etat'=>"actif"])->get();
            $prestations_totals_debours = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'debours'])->where(['etat'=>"actif"])->sum('total');
            $com = 1.95;
            $comm_debours = $prestations_totals_debours * $com;
            $comm_sous_debours = ($comm_debours / 100);

            $prestations_totalsS = DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation->uuid])->where(['type_prestation'=>'prestation'])->where(['etat'=>"actif"])->sum('total');

            $prestations_totals = $prestations_totalsS + $comm_sous_debours;

            $user = DB::table('users')->where(['uuid'=>$refacturation->facturier_uuid])->first();
            $total_ht = ($prestations_totals + $prestations_totals_debours);
            $tvaPerCent = $refacturation->tva;
            $tva = ($prestations_totals * $tvaPerCent) / 100;
            $total_xof = ($total_ht + $tva);

            $pdf = PDF::loadView('admin.refacturation.facture', compact('exchangeRate','comm_sous_debours','total_ht','tva','total_xof','refacturation', 'prestations', 'prestations_totals', 'user', 'prestations_debours','prestations_totals_debours'));

            return $pdf->download('refacturation.pdf');


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $item = Refacturation::where(['uuid'=>$id])->firstOrFail();

        return view('admin.refacturation.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd($request);

        DB::beginTransaction();

        try {

                $refacturation= Refacturation::where('uuid', $id)->update([
               // 'uuid' => Str::uuid(),
                'refClient' => $request->refClient,
                'doit' => $request->doit,
                'adresseComplete' => $request->adresseComplete,
                'num_cc' => $request->num_cc,
                'pol' => $request->pol,
                'pod' => $request->pod,
                'regime' => $request->regime,
                'email' => $request->email,

                'designation' => $request->designation,
                'num_Commande' => $request->num_Commande,
                'num_Bl' => $request->num_Bl,
                'navire' => $request->navire,
                'destination' => $request->destination,
                'amateur' => $request->amateur,
                'num_Dossier' => $request->num_Dossier,
                'num_Ot' => $request->num_Ot,
                'volume' => $request->volume,
                'tva' => $request->tva,
                'nbr_product' => $request->nbr_product,

                // info facturier
                'facturier_uuid' => Auth::user()->uuid,
                'poste_occuper' => $request->poste_occuper,
                'num_facture' => $request->num_facture,
                'date_echeance' => $request->date_echeance,
                'condition_paiement' => $request->condition_paiement,
                'comment' => $request->comment,

               // 'etat' => 'actif',
               // 'code' => Refgenerate(Refacturation::class, 'Facture', 'code'),
                ]);


                // $refacturation_FAC = Refacturation::orderBy('updated_at', 'desc')->first();


                // DB::table('facture_prestations')->where(['facture_uuid'=>$refacturation_FAC->uuid])->update(['etat'=>"inactif"]);


                    $prestation = $request->input('prestation');
                    $type_prestation = $request->input('type_prestation');
                    $qty = $request->input('qty');
                    $description = $request->input('description');
                    $prixunitaire = $request->input('prixunitaire');
                    $total = $request->input('total');

                    for($i=0; $i < count($type_prestation); $i++){
                    $prestations = [
                        'uuid' => Str::uuid(),
                        'facture_uuid' => $id,
                        'etat' => "actif",
                        //'prestation' => $prestation[$i],
                        'type_prestation' => $type_prestation[$i],
                        'qty' => $qty[$i],
                        'description' => $description[$i],
                        'prixunitaire' => $prixunitaire[$i],
                        'total' => $total[$i],
                        ];
                     if($type_prestation[$i] !== null){
                            DB::table('facture_prestations')->insert($prestations);

                        }
                    }

            if ($refacturation) {

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
    public function destroy(string $id)
    {
        //
        {

            DB::beginTransaction();
            try {
                $fact= Refacturation::where(['uuid'=>$id])->first();
                $saving= Refacturation::where(['uuid'=>$id])->update(['etat'=>"inactif"]);
                DB::table('facture_prestations')->where(['facture_uuid'=>$fact->uuid])->update(['etat'=>"inactif"]);


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

    public function marckToSend(string $id)
    {

        DB::beginTransaction();
        try {
            $sending = Refacturation::where(['uuid'=>$id])->update(['statut' => 'sendToClient']);


            if ($sending) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Facture envoyée avec succes!",
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
    public function marckToPayed(string $id)
    {

        DB::beginTransaction();
        try {
            $sending = Refacturation::where(['uuid'=>$id])->update(['statut' => 'payed']);


            if ($sending) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Facture Marqué comme payé avec succes!",
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
    public function marckToConceled(string $id)
    {

        DB::beginTransaction();
        try {
            $sending = Refacturation::where(['uuid'=>$id])->update(['statut' => 'canceled']);


            if ($sending) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Facture Marqué comme annullé avec succes!",
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


    public function delettePrestationLine(Request $request, string $id)
    {
        // $prestation = FacturePrestation::where(['facture_uuid'=> $request->facture_uuid])->firstOrFail();
        $prestation = FacturePrestation::where(['uuid'=> $request->prestation_uuid])->firstOrFail();

        if ($prestation) {
            $prestation->delete();

            return response()->json([
                'type' => 'success',
                'urlback' => 'back',
                'message' => 'Ligne supprimé avec succes',
            ]);
        }
    }
}
