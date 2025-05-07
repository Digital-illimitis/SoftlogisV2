<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\MyLogNotification;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Company::where(['etat'=> 'actif', 'type' => 'client'])->get();
        return view('admin.client.index', compact('clients'));
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
        // Valider les données du formulaire (nom, email, etc.)
        $request->validate([
            'raison_sociale' => 'required|string|max:255',
            'email' => 'required|string|email|unique:companies,email',
        ]);

        DB::beginTransaction();
        try {

             // add profil img
             $logo= $request->logo ?? "";
             if($logo == null) {
              $logo = 'default_logo.jpg';
             }else{
                 $file = $request->file('logo');
              //    dd($logo);
                 $logo = Str::uuid().'.'.$file->getClientOriginalExtension();
                 $file->move('files/',$logo);
             }

            $uuid_company = Str::uuid();

            $saving= Company::create([
                'uuid'=>$uuid_company,
                'logo' => $logo,
                'raison_sociale' => $request->raison_sociale,
                'phone' => $request->phone,
                'identification' => $request->identification,
                'email' => $request->email,
                'localisation' => $request->localisation,
                'description' => $request->description,
                'type' => 'client', // client
                'code' => Refgenerate(Company::class, 'C', 'code'),
            ])->save();

            if ($saving) {

                $users = User::all();
                $user = auth()->user()->name." ".auth()->user()->lastname;
                $details_log = [
                    // 'url' => url()->current(),
                    'url' => route('admin.client.show',$uuid_company),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "Enregistrement",
                    'action' => "Création d'un nouveau client ".$request->raison_sociale, 
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
    public function show(string $id)
    {
        $client = Company::where(['uuid'=>$id])->first();
        return view('admin.client.show', compact('client'));
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
        // Valider les données du formulaire (nom, email, etc.)
        $request->validate([
            'raison_sociale' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
        ]);

        DB::beginTransaction();
        try {

             // add profil img
             $logo= $request->logo ?? "";
             if($logo == null) {
              $logo = 'default_logo.jpg';
             }else{
                 $file = $request->file('logo');
              //    dd($logo);
                 $logo = Str::uuid().'.'.$file->getClientOriginalExtension();
                 $file->move('files/',$logo);
             }

            $saving= Company::where(['uuid'=>$id])->update([
                'logo' => $logo,
                'raison_sociale' => $request->raison_sociale,
                'phone' => $request->phone,
                'identification' => $request->identification,
                'email' => $request->email,
                'localisation' => $request->localisation,
                'description' => $request->description,
            ]);

            if ($saving) {

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
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $deleted = Company::where(['uuid'=>$request->id])->update(['etat'=>"inactif"]);
            if ($deleted) {
                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Opération effectuée avec succes",
                    'code' => 200,
                ];
                DB::commit();
                return response()->json($dataResponse);
            }
            else{
                $dataResponse = [
                    'type' => 'warning',
                    'urlback' => "back",
                    'message' => "l'opération a échouée",
                    'code' => 500,
                ];
                DB::rollback();
                return response()->json($dataResponse);
            }
        } catch (\Exception $e) {

            $dataResponse = [
                'type' => 'warning',
                'urlback' => '',
                'message' => "l'Opération a échouée contactez l'administrateur".$e,
                'code' => 500,
            ];
            DB::rollback();
            return response()->json($dataResponse);
        }

    }
}
