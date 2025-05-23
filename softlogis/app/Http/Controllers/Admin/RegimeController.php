<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Regime;
use App\Mail\LogisticaMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Notifications\MyLogNotification;

class RegimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $unreadNotifications = $user->unreadNotifications;
        $latestNotifications = $user->notifications()->latest()->take(10)->get();
        // dd($latestNotifications);


        $regimes = Regime::where('etat', 'actif')->get();
        return view('admin.config.regime', compact('regimes'));
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
        // Valider les données du formulaire (libelle, color, etc.)
        $request->validate([
            'regime' => 'required|string|max:255'
        ]);

        $users = User::all();
        $user = auth()->user()->name.' '.auth()->user()->lastname;

        DB::beginTransaction();
        try {

            $uuid = Str::uuid();

            $saving= Regime::create([
                'uuid'=>$uuid,
                'regime' => $request->regime,
                'description' => $request->description,
                'etat' => 'actif',
                'code' => Refgenerate(Regime::class, 'R', 'code'),
            ])->save();

            if ($saving) {
                // $emailSubject = 'Identifiants - ERP JALO LOFISTIQUE';
                // $emailTo = "ndouajm@gmail.com";
                // $mailData = [
                //     'title' => 'Identifiants - ERP JALO LOFISTIQUE',
                //     'body' => "Votre identifiants sont: <br> <br> Emai",
                // ];
                // Mail::to($emailTo)->send(new LogisticaMail($mailData,$emailSubject));

                $details_log = [
                    'url' => route('admin.regime'),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "Enregistrement",
                    'action' => "Création d'un nouveau regime",
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {

        DB::beginTransaction();
        try {

            $saving= Regime::where(['uuid'=>$request->id])->update(['etat'=>"inactif"]);

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
