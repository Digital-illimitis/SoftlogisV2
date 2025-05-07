<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Company;
use App\Models\Entrepot;
use App\Models\Expedition;
use App\Mail\LogisticaMail;
use App\Models\stockUpdate;
use Illuminate\Support\Str;
use App\Models\ExpTransport;
use Illuminate\Http\Request;
use App\Models\ExTransportFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ExTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->organisation == 'transporteur'){
            $ordreTransports = ExpTransport::where(['etat' => 'actif', 'transporteur_uuid' => Auth::user()->uuid])->get();
            
        }else{
            $ordreTransports = ExpTransport::where(['etat' => 'actif'])->get();
        }
        $transporteurs = Company::where(['type' => 'transporteur', 'etat' => 'actif', 'voie_transport' => 'terrestre'])->get();
        $transpormarines = Company::where(['type' => 'transporteur', 'etat' => 'actif', 'voie_transport' => 'maritime'])->get();

        return view('admin.expTransport.index', compact('ordreTransports', 'transporteurs', 'transpormarines'));
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
        $user = auth()->user()->name.' '.auth()->user()->lastname;
        try {
            $transport = ExpTransport::create([
                'uuid' => Str::uuid(),
                'transporteur_uuid' => $request->transporteur_uuid,
                'expedition_uuid' => $request->expedition_uuid,
                'note' => $request->note,

                'destination'=> $request->destination,
                'date_transport'=> $request->date_transport,
                'voie_exp'=> $request->voie_exp,
                'user_uuid' => $user,
                'etat' => 'actif',
                'code' => Refgenerate(ExpTransport::class, 'EXT', 'code'),
            ]);

            if($request->has('expedition_uuid')){
                $expedition = Expedition::where('uuid', $request->expedition_uuid)->update([
                    'statut' => 'odTransport',
                    'date_transport' => now(),
                ]);
            }

            if($request->has('files')){
                $names = $request->input('name');
                foreach($request->file('files') as $key => $file){
                    $imageName = 'Ext_' . date('YmdHis') . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('documents/files');
                    $file->move($destinationPath, $imageName);
                    $filePath = $destinationPath . '/' . $imageName;

                    $expedition_file = ExTransportFile::create([
                        'uuid' => Str::uuid(),
                        'name' => $names[$key],
                        'transport_uuid' => $transport->uuid,
                        'files' => $imageName,
                        'filePath' => $filePath,
                        'user_uuid' => $user,
                    ]);
                $expedition_file->filePath = $filePath;
                }
            }
            $transport->save();

            if ($transport) {

                $transporteurName = Company::where('uuid', $request->transporteur_uuid)->first();

                $mailData = [
                    'title' => 'ORDRE DE TRANSPORT JALO Logistics',
                    'body' => 'Bonjour Chers '.$transporteurName->raison_sociale.' Je vous transmet en P.J l\'ensemble des documents relatif  <br><br> En attente de votre retour , je reste disponible au besoin <br><br>
                        <strong>Date de creation : </strong>'.$transport->created_at.'<br>',
                ];

                $emailSubject = 'Jalo Logistics - ORDRE DE TRANSPORT';

                $mail = new LogisticaMail($mailData, $emailSubject);

                // Attache les fichiers au message
                foreach ($transport->files as $file) {
                    $mail->attach($file->filePath);
                }

                Mail::to($transporteurName->email)->send($mail);

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
        $extransport = ExpTransport::where('uuid', $id)->firstOrFail();

        $ordreTransportFile = ExTransportFile::where(['etat' => 'actif', 'transport_uuid' => $id])->get();

        $entrepots = Entrepot::where(['etat' => 'actif'])->get();

        return view('admin.expTransport.show', compact('extransport', 'ordreTransportFile', 'entrepots'));
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
        $user = auth()->user()->name.' '.auth()->user()->lastname;
        try {
            $transport = ExpTransport::create([
                'transporteur_uuid' => $request->transporteur_uuid,
                'note' => $request->note,
                'destination'=> $request->destination,
                'date_transport'=> $request->date_transport,
                'voie_exp'=> $request->voie_exp,
                'user_uuid' => $user,
            ]);

            if ($transport) {
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

                $saving= ExpTransport::where(['uuid'=>$id])->update(['etat'=>"inactif"]);

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


    public function destockage(Request $request) {

        try {
            DB::beginTransaction();
            $productId = $request->input('product_id');


            if ($productId) {
                $userId = auth()->user()->id;

                $expedition = Expedition::where('uuid', $request->input('expedition_uuid'))->firstOrFail();

                $expedition->update([
                    'statut' => 'outStock',
                    'date_destockage' => now(),
                ]);


                $file = $request->file('file');

                if ($file !== null) {
                    $filename = 'InStock_' . date('YmdHis') . '_' . Str::uuid().'.'.$file->getClientOriginalExtension();
                    $file->move('documents/files', $filename);
                }else {
                    $filename = 'destockage.pdf';
                }

                Article::where('id', $productId)->update([
                    'is_destock' => 'true',
                    'date_outStock' => now(),
                ]);

                stockUpdate::create([
                    'uuid' => Str::uuid(),
                    'product_id' => $productId,
                    'mouvement' => 'Out',
                    'file' => $filename,
                    'noteOut'=>$request->input('noteOut'),
                    'conformityOut'=> $request->input('conformityOut'),
                    'updated_at' => now(),
                    'user_id' => $userId,
                ]);

                // return redirect()->back()->with('success', 'Produit réceptionné avec succès');
                $dataResponse = [
                    'type' => 'success',
                    'urlback' => 'back',
                    'message' => "Enregistré avec succès!",
                    'code' => 200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur lors du destockage!",
                    'code' => 500,
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse = [
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système! $th",
                'code' => 500,
            ];
        }


        return response()->json($dataResponse);
    }

}