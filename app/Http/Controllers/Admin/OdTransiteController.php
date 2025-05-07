<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Article;
use App\Models\Company;
use App\Models\Od_files;
use App\Models\Sourcing;
use PDF;
use App\Models\OtProduct;
use App\Models\OdTransite;
use App\Mail\LogisticaMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Sourcing_file;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\alert;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\MyLogNotification;

class OdTransiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::user()->organisation == 'transitaire') {
            $odretransites = OdTransite::where('transitaire_uuid', Auth::user()->uuid)->where('etat', 'actif')->orderBy('id', 'desc')->get();
        } else {
            $odretransites = OdTransite::where('etat', 'actif')->orderBy('id', 'desc')->get();
        }
        $transitaires = Company::where(['etat'=> 'actif', 'type' => 'transitaire'])->get();
        return view('admin.od_transite.index', compact('transitaires','odretransites'));
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
        $user = auth()->user()->name . ' ' . auth()->user()->lastname;
        try {

            if(!$request->transitaire_uuid){
                alert('Attention', 'Veuillez selectionner le transitaire');
                return back();
            }

            if($request->has('sourcing_uuid')){
                $sourcing = Sourcing::where('uuid', $request->sourcing_uuid)->update([
                    'statut' => 'odTransit',
                ]);
            }
            $uuid = Str::uuid();
            $odretransite = OdTransite::create([
                'uuid' => $uuid,
                'transitaire_uuid' => $request->transitaire_uuid,
                'sourcing_uuid' => $request->sourcing_uuid,
                'user_uuid' => $user,
                'etat' => 'actif',
                'typeOp' => $request->typeOp,
                'numConnaiOriginal' => $request->numConnaiOriginal,
                'navireName' => $request->navireName,
                'numConnaissement' => $request->numConnaissement,
                'portDembarquement' => $request->portDembarquement,
                'factFounisseur' => $request->factFounisseur,
                'factFret' => $request->factFret,
                'colisage' => $request->colisage,
                'assurCertifNum' => $request->assurCertifNum,
                'frie' => $request->frie,
                'sgsn' => $request->sgsn,
                'totalProduct' => $request->totalProduct,
                'numLicense' => $request->numLicense,
                'exoneration' => $request->exoneration,
                'marche' => $request->marche,
                'marchandiseAction' => $request->marchandiseAction,
                'expediteTo' => $request->expediteTo,
                'droitCredit' => $request->droitCredit,
                'exoneration' => $request->exoneration,
                'factAlibelle' => $request->factAlibelle,
                'adresseLivraison' => $request->adresseLivraison,
                'divers' => $request->divers,
                'garantieBancaire' => $request->garantieBancaire,
                'note' => $request->note,
                'code' => Refgenerate(OdTransite::class, 'ODT', 'code'),
            ]);

            if($request->has('files')){
                foreach($request->file('files') as $key => $file){
                    $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('documents/files');
                    $file->move($destinationPath, $imageName);
                    $filePath = $destinationPath . '/' . $imageName;

                    $odretransite_file = Od_files::create([
                        'uuid' => Str::uuid(),
                        'name' => $request->input('name')[$key],
                        'od_transite_id' => $odretransite->id,
                        'files' => $imageName,
                        'filePath' => $filePath,
                    ]);
                    $odretransite_file->filePath = $filePath;
                }
            }

            $productIds = $request->input('product_uuid');

            if (!empty($productIds)) {
                foreach ($productIds as $key => $productId) {
                    
                    $product = Article::where('uuid', $productId)->first();

                    if ($product) {
                       
                            $saveProduct = OtProduct::create([
                                'qty' => $request->qty[$key],
                                'ot_uuid'=> $uuid,
                                'product_uuid' => $productId,
                            ]);
                        
                    }
                }
            }
            $odretransite->save();

            if ($odretransite) {
               
                    
                $transitaireName = Company::where('uuid', $request->transitaire_uuid)->first();

                $mailData = [
                        'title' => 'ORDRE DE TRANSIT JALO Logistics',
                        'body' => 'Bonjour '.$transitaireName->raison_sociale.',<br><br>Veuillez trouver en pièce jointe l’ensemble des documents relatifs à l’ordre de transit créé le '.$odretransite->created_at.'.<br><br> 
                                   Nous restons à votre disposition pour toute question ou besoin complémentaire et attendons votre retour.<br><br>
                                   <a href="'.route('admin.downloadOtPDF', $odretransite->id).'" style="display:inline-block;padding:5px 10px;background-color:#007bff;color:white;text-decoration:none;border-radius:5px;">
                                   <i class="bx bxs-file-pdf"></i> Export PDF</a><br><br>
                                   Cordialement.'
                    ];



                $emailSubject = 'Jalo Logistics - ORDRE DE TRANSIT';

                $mail = new LogisticaMail($mailData, $emailSubject);

                // Attache les fichiers au message
                foreach ($odretransite->files as $file) {
                    $mail->attach($file->filePath);
                }

                Mail::to($transitaireName->email)->send($mail);

                $sourcing = Sourcing::where('uuid', $request->sourcing_uuid)->firstorfail();

                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.od_transite.show', $uuid),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Enregistrement - Ordre de transit",
                        'action' => "Un ordre de transit a été crée pour le sourcing : ".$sourcing->code, 
                    ];
    
                    // Assurez-vous que $users est une collection d'instances de User
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }

                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Enregistré avec succès!",
                    'code' => 200,
                ];

                DB::commit();
            } else {
                DB::rollback();
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur lors de l'enregistrement!",
                    'code' => 500,
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

    public function addTransiteDoc(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();

        try {

            if($request->has('files')){

                foreach($request->file('files') as $key => $file){
                    $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('documents/files');
                    $file->move($destinationPath, $imageName);
                    $filePath = $destinationPath . '/' . $imageName;

                    $odretransite_file = Od_files::create([
                        'uuid' => Str::uuid(),
                        'name' => $request->input('name')[$key],
                        'od_transite_id' => $request->od_transite_id,
                        'files' => $imageName,
                        'filePath' => $filePath,
                    ]);
                    $odretransite_file->filePath = $filePath;
                }

                if ($odretransite_file) {

                    $odretransite = OdTransite::where(['id'=>$request->od_transite_id])->firstOrFail();
                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.od_transite.show', $odretransite->uuid),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Ajout de Document - Ordre de transit",
                        'action' => "Un document a été ajouté a un l'ordre de transit clique pour en savoir plus ",  
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
        
        $transitaireNames = DB::table('users')->where('id', Auth::user()->id)->first();
        $transitaireName = $transitaireNames->name." ".$transitaireNames->lastname;
        $mailData = [
                        'title' => 'Ajout du document',
                        'body' => 'Bonjour JALÔ,<br><br>'.$transitaireName.'" ".vient jout un Document - Ordre de transit.<br><br>
                                   Vous pouvez regarder le document et de valider..<br><br>
                                   <a href="https://dev.soft-logis.com" style="display:inline-block;padding:5px 10px;background-color:#007bff;color:white;text-decoration:none;border-radius:5px;">
                                   Connectez-vous!</a><br><br>
                                   Cordialement.'
                    ];


                $jalo = "exploitation@jalo-logistics.com";
                $emailSubject = 'Jalo Logistics - Ajout de document ORDRE DE TRANSIT'.":"." ".$transitaireName;

                $mail = new LogisticaMail($mailData, $emailSubject);
                Mail::to($jalo)->send($mail);
                
        return response()->json($dataResponse);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $odretransite = OdTransite::where(['uuid'=>$id])->firstOrFail();
        $transite_files = Od_files::where(['od_transite_id'=>$odretransite->id])->where('etat', 'actif')->get();
        return view('admin.od_transite.show', compact('odretransite', 'transite_files'));
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

            $odretransite = OdTransite::where(['uuid'=>$id])->update([
                'note' => $request->note,
                'transitaire_uuid' => $request->transitaire_uuid,
                'numConnaiOriginal' => $request->numConnaiOriginal,
                'navireName' => $request->navireName,
                
                'numConnaissement' => $request->numConnaissement,
                'portDembarquement' => $request->portDembarquement,
                'factFounisseur' => $request->factFounisseur,
                'factFret' => $request->factFret,
                'colisage' => $request->colisage,
                'assurCertifNum' => $request->assurCertifNum,
                'frie' => $request->frie,
                'sgsn' => $request->sgsn,
                'totalProduct' => $request->totalProduct,
                'numLicense' => $request->numLicense,
                'exoneration' => $request->exoneration,
                'marche' => $request->marche,
                'marchandiseAction' => $request->marchandiseAction,
                'expediteTo' => $request->expediteTo,
                'droitCredit' => $request->droitCredit,
                'exoneration' => $request->exoneration,
                'factAlibelle' => $request->factAlibelle,
                'adresseLivraison' => $request->adresseLivraison,
                'divers' => $request->divers,
                'garantieBancaire' => $request->garantieBancaire,
            ]);

            if ($odretransite) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Modification réussie avec succès!",
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();
        try {

            $saving= OdTransite::where(['uuid'=>$id])->update(['etat'=>"inactif"]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> route('admin.od_transite.index'),
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

    // delette document for od_transite
    public function delette_doc_transite(string $id)
    {
        DB::beginTransaction();
        try {

            $saving = Od_files::where(['uuid'=>$id])->update(['etat'=>"inactif"]);
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
    public function receive_doc_transite(request $request)
    {
        DB::beginTransaction();
        try {
            $saving = OdTransite::where(['uuid'=> $request->transite_uuid])->update(
                [
                    'receive_doc'=> $request->receive_doc,
                    'receive_date'=> now(),
                ]);
            if ($saving) {

                $odretransite = OdTransite::where(['uuid'=>$request->transite_uuid])->firstOrFail();
                $users = User::all();
                    $user = auth()->user()->name." ".auth()->user()->lastname;
                    $details_log = [
                        // 'url' => url()->current(),
                        'url' => route('admin.od_transite.show', $request->transite_uuid),
                        'user' => $user,
                        'date' => date('Y-m-d H:i:s'),
                        'title' => "Reception de Document - Ordre de transit",
                        'action' => $user." a marque la reception des documents pour l'ordre de transit ".$odretransite->code,  
                    ];
    
                    // Assurez-vous que $users est une collection d'instances de User
                    foreach ($users as $user) {
                        $user->notify(new MyLogNotification($details_log));
                    }


                $dataResponse =[
                    'type'=>'success',
                    'urlback'=> 'back',
                    'message'=>"Réception effectuée avec succès!",
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

    public function downloadOtPDF($id) {

        $transitPdf = OdTransite::find($id);
        
        $pdf = PDF::loadView('admin.od_transite.pdf', compact('transitPdf'));

        return $pdf->download('ordre_de_transit.pdf');

    }
}