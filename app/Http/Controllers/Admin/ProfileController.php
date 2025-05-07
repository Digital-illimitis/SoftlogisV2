<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.collaborateur.profile');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        DB::beginTransaction();
        try {

            // add profil img
            $avatar= $request->avatar ?? "";
               if($avatar == null) {
                $avatar= auth()->user()->avatar;
               }else{
                   $file = $request->file('avatar');
                //    dd($avatar);
                   $avatar = Str::uuid().'.'.$file->getClientOriginalExtension();
                   $file->move('avatars/',$avatar);
               }
            $signature = $request->signature ?? "";
               if($signature == null) {
                $signature = auth()->user()->signature;
               }else{
                   $file = $request->file('signature');
                //    dd($avatar);
                   $signature = Str::uuid().'.'.$file->getClientOriginalExtension();
                   $file->move('avatars/',$signature);
               }
            $saving= User::where(['uuid'=>$id])->update([

                'name' => $request->name,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'avatar' => $avatar,
                'signature' => $signature,
            ]);

            if ($saving) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Modifié avec succes!",
                    'code'=>200,
                ];
                DB::commit();
           } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de la modification",
                    'code'=>500,
                ];
           }

        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme!",
                'code'=>500,
            ];
        }
        return response()->json($dataResponse);
    }

    public function updateMp(Request $request, string $id)
    {

        DB::beginTransaction();
        try {
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'nullable|string|min:6|confirmed',
                ]);

                if ($request->password !== $request->password_confirmation) {
                    DB::rollback();
                    $dataResponse = [
                        'type' => 'error',
                        'urlback' => '',
                        'message' => "Les mots de passe ne correspondent pas",
                        'code' => 400,
                    ];
                    return response()->json($dataResponse);
                }

                $mp = auth()->user()->update(['password' => bcrypt($request->password)]);

                if ($mp) {
                    // Déconnexion de l'utilisateur
                    auth()->logout();

                    $dataResponse = [
                        'type' => 'success',
                        'urlback' => "back",
                        'message' => "Modifié avec succès! Veuillez vous reconnecter avec votre nouveau mot de passe.",
                        'code' => 200,
                    ];
                    DB::commit();
                } else {
                    DB::rollback();
                    $dataResponse = [
                        'type' => 'error',
                        'urlback' => '',
                        'message' => "Erreur lors de la modification",
                        'code' => 500,
                    ];
                }
            } else {
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => 'back',
                    'message' => "Le mot de passe ne doit pas être vide",
                    'code' => 400,
                ];
            }


        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme!",
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
    }
}
