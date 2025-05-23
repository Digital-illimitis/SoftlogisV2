<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Article;
use App\Models\Company;
use App\Models\ExTransit;
use App\Models\OtProduct;
use App\Models\Expedition;
use App\Mail\LogisticaMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ExTransiteFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\MyLogNotification;

class ExpTransitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::user()->organisation == 'transitaire') {
            $transits = ExTransit::where('transitaire_uuid', Auth::user()->uuid)->where('etat', 'actif')->get();
            
        } else {
            $transits = ExTransit::where('etat', 'actif')->get();
        }

        $transitaires = Company::where(['etat' => 'actif', 'type' => 'transitaire'])->get();
        return view('admin.expTransit.index' ,compact('transits', 'transitaires'));
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

            $uuid = Str::uuid();
            $expTransit = ExTransit::create([
                'uuid' => $uuid,
                'note' => $request->note,
                'transitaire_uuid' => $request->transitaire_uuid,
                'expedition_uuid' => $request->expedition_uuid,
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
                'code' => Refgenerate(ExTransit::class, 'EXT', 'code'),
            ]);

            if($request->has('expedition_uuid')){
                $expedition = Expedition::where('uuid', $request->expedition_uuid)->update([
                    'statut' => 'odTransit',
                    'date_transit' => $request->date_transit,//now(),
                ]);
            }

            if($request->has('files')){
                foreach($request->file('files') as $key => $file){
                    $imageName = Str::uuid().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('documents/files');
                    $file->move($destinationPath, $imageName);
                    $filePath = $destinationPath . '/' . $imageName;

                    $odretransite_file = ExTransiteFile::create([
                        'uuid' => Str::uuid(),
                        'name' => $request->input('name')[$key],
                        'transite_uuid' => $expTransit->uuid,
                        'files' => $imageName,
                        'user_uuid' => $user,
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
            $expTransit->save();

            if ($expTransit) {

                $expedit = ExTransit::where('uuid', $uuid)->first();

                $transitaireName = Company::where('uuid', $request->transitaire_uuid)->first();

                $mailData = [
                    'title' => 'ORDRE DE TRANSIT JALO Logistics',
                    'body' => 'Bonjour Chers '.$transitaireName->raison_sociale.' Je vous transmet en P.J l\'ensemble des documents relatif  <br><br> En attente de votre retour , je reste disponible au besoin <br><br>
                        <strong>Date de creation : </strong>'.$expTransit->created_at.'<br>',
                ];

                $emailSubject = 'Jalo Logistics - ORDRE DE TRANSIT';

                $mail = new LogisticaMail($mailData, $emailSubject);

                // Attache les fichiers au message
                foreach ($expTransit->files as $file) {
                    $mail->attach($file->filePath);
                }

                Mail::to($transitaireName->email)->send($mail);


                $users = User::all();
                $user = auth()->user()->name." ".auth()->user()->lastname;
                $details_log = [
                    // 'url' => url()->current(),
                    'url' => route('admin.transit.to_expedition.show', $uuid),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "Enregistrement - Ordre de transit",
                    'action' => "Un ordre de transit a été crée pour l' Expedition : ".$expedit->code, 
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $expTransit = ExTransit::where('uuid', $id)->firstOrFail();
        $transite_files = ExTransiteFile::where(['transite_uuid'=>$expTransit->id])->where('etat', 'actif')->get();
        return view('admin.expTransit.show', compact('expTransit','transite_files'));
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
        $user = auth()->user()->name . ' ' . auth()->user()->lastname;
        try {

            $expTransit = ExTransit::where(['uuid'=>$id])->update([

                'note' => $request->note,
                'transitaire_uuid' => $request->transitaire_uuid,
                'user_uuid' => $user,
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
            ]);

            if ($expTransit) {

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

                $saving= ExTransit::where(['uuid'=>$id])->update(['etat'=>"inactif"]);

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

    public function delette_doc_transit(string $id)
    {
        DB::beginTransaction();
        try {

            $saving = ExTransiteFile::where(['uuid'=>$id])->update(['etat'=>"inactif"]);
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

    public function addTransitDoc(Request $request)
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

                 $odretransite_file = ExTransiteFile::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->input('name')[$key],
                    'transite_uuid' => $request->input('transite_uuid'),
                    'files' => $imageName,

                    'user_uuid' => $user,
                    'filePath' => $filePath,
                ]);
                $odretransite_file->filePath = $filePath;
                }
                if ($odretransite_file) {

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
}