<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\GrilleHad;
use App\Models\PorteChar;
use App\Mail\LogisticaMail;
use App\Models\Destination;
use App\Models\GrilleTarif;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GrilleTransit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Notifications\MyLogNotification;

use function Laravel\Prompts\alert;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::where('etat', 'actif')->get();
        return view('admin.company.index', compact('companies'));
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
//     public function store(Request $request)
// {

//     //  $exists = Company::where('email', $request->email)->exists() || User::where('email', $request->email)->exists();
    
//     // if ($exists) {
//     //     return redirect()->back()->with('error', 'Cet email existe déjà.');
        
//     // } else {
//     //     // Validation des données du formulaire
//     // }

//     // Validation des données du formulaire
//     $request->validate([
//         'raison_sociale' => 'required|string|max:255',
//         'email' => 'required|string|email|unique:companies,email|unique:users,email',
//     ]);

//     $verif_email = $request->email;

//     // Vérification si l'email existe déjà dans les compagnies
//     $companyverif = Company::where('email', $verif_email)->first();
//     if ($companyverif) {
//         return redirect()->back()->with(['error' => 'Cet email existe déjà pour une compagnie.']);
//     }

//     // Gestion du logo (utilisation d'un logo par défaut si non fourni)
//     $logo = $request->file('logo') ? Str::uuid() . '.' . $request->file('logo')->getClientOriginalExtension() : 'default_logo.jpg';
//     if ($request->file('logo')) {
//         $request->file('logo')->move('files/', $logo);
//     }

//     // Génération d'un UUID et d'un code pour la compagnie
//     $uuid_company = Str::uuid();
//     $code = Refgenerate(Company::class, 'ORG', 'code');

//     // Création de la compagnie
//     $company = Company::create([
//         'uuid' => $uuid_company,
//         'logo' => $logo,
//         'raison_sociale' => $request->raison_sociale,
//         'phone' => $request->phone,
//         'identification' => $request->identification,
//         'email' => $request->email,
//         'localisation' => $request->localisation,
//         'description' => $request->description,
//         'type' => $request->type,
//         'voie_transport' => $request->voie_transport,
//         'contact_one_name' => $request->contact_one_name,
//         'contact_one_lastName' => $request->contact_one_lastName,
//         'contact_one_email' => $request->contact_one_email,
//         'contact_two_name' => $request->contact_two_name,
//         'contact_two_lastName' => $request->contact_two_lastName,
//         'contact_two_email' => $request->contact_two_email,
//         'add_access' => $request->add_access,
//         'code' => $code,
//     ]);

//     // Vérification si la compagnie a bien été créée
//     if ($company) {
//         $userverif = User::where('email', $request->email)->first();
//         if ($userverif) {
//             return redirect()->back()->with(['error' => 'Cet email existe déjà pour un utilisateur.']);
//         }

//         if ($request->add_access == "on") {
//             User::create([
//                 'code' => $code,
//                 'avatar' => $logo,
//                 'organisation' => $request->type,
//                 'phone' => $request->phone,
//                 'name' => $code,
//                 'lastname' => $request->raison_sociale,
//                 'type' => '0',
//                 'email' => $request->email,
//                 'password' => bcrypt('123456'),
//                 'uuid' => $uuid_company,
//             ]);

//             $mailData = [
//                 'title' => 'Vos identifiants de connexion - ERP JALO LOFISTIQUE',
//                 'body' => 'Vos accès à la plateforme Softlogis ont été créés avec succès. Vous pouvez vous connecter avec les identifiants suivants :<br><br>
//                             <strong>Nom d\'utilisateur : </strong>' . $request->email . '<br>
//                             <strong>Mot de passe : </strong>123456<br>',
//                 'btnText' => 'Se connecter',
//                 'btnLink' => route('login'),
//             ];

//             Mail::to($request->email)->send(new LogisticaMail($mailData, 'Identifiants - ERP JALO LOFISTIQUE'));
//         }

//         return redirect()->back()->with(['success' => "La compagnie a été ajoutée avec succes."]);
//     }

//     return redirect()->back()->with(['error' => 'Erreur lors de la création de la compagnie.']);
// }

public function store(Request $request)
{
    // Validation des données du formulaire
    $request->validate([
        'raison_sociale' => 'required|string|max:255',
        'email' => 'required|string|email|unique:companies,email|unique:users,email',
    ]);

     $exists = Company::where('email', $request->email)->exists() || User::where('email', $request->email)->exists();
    
    if ($exists) {
        return redirect()->back()->with('error', 'Cet email existe déjà.');
    } else {
        // Validation des données du formulaire
    }

    // Vérification de l'email dans les deux tables
    $verif_email = $request->email;

    // Gestion du logo (utilisation d'un logo par défaut si non fourni)
    $logo = $request->file('logo') ? Str::uuid() . '.' . $request->file('logo')->getClientOriginalExtension() : 'default_logo.jpg';
    if ($request->file('logo')) {
        $request->file('logo')->move('files/', $logo);
    }

    // Génération d'un UUID et d'un code pour la compagnie
    $uuid_company = Str::uuid();
    $code = Refgenerate(Company::class, 'ORG', 'code');

    // Création de la compagnie
    $company = Company::create([
        'uuid' => $uuid_company,
        'logo' => $logo,
        'raison_sociale' => $request->raison_sociale,
        'phone' => $request->phone,
        'identification' => $request->identification,
        'email' => $verif_email,
        'localisation' => $request->localisation,
        'description' => $request->description,
        'type' => $request->type,
        'voie_transport' => $request->voie_transport,
        'contact_one_name' => $request->contact_one_name,
        'contact_one_lastName' => $request->contact_one_lastName,
        'contact_one_email' => $request->contact_one_email,
        'contact_two_name' => $request->contact_two_name,
        'contact_two_lastName' => $request->contact_two_lastName,
        'contact_two_email' => $request->contact_two_email,
        'add_access' => $request->add_access,
        'code' => $code,
    ]);

    // Vérification si la compagnie a bien été créée
    if ($company) {
        // Création de l'utilisateur si "add_access" est activé
        if ($request->add_access == "on") {
            // Vérifiez l'existence de l'utilisateur
            if (User::where('email', $verif_email)->exists()) {
                return redirect()->back()->with(['error' => 'Cet email existe déjà pour un utilisateur.']);
            }

            // Création de l'utilisateur
            User::create([
                'code' => $code,
                'avatar' => $logo,
                'organisation' => $request->type,
                'phone' => $request->phone,
                'name' => $code,
                'lastname' => $request->raison_sociale,
                'type' => '0',
                'email' => $verif_email,
                'password' => bcrypt('123456'),
                'uuid' => $uuid_company,
            ]);

            // Envoi de l'email avec les identifiants
            $this->sendUserCredentialsEmail($verif_email, $request->raison_sociale);
        }

        return redirect()->back()->with(['success' => "La compagnie a été ajoutée avec succès."]);
    }

    return redirect()->back()->with(['error' => 'Erreur lors de la création de la compagnie.']);
}

/**
 * Méthode pour envoyer les identifiants par email
 *
 * @param string $email
 * @param string $raison_sociale
 * @return void
 */
private function sendUserCredentialsEmail($email, $raison_sociale)
{
    $mailData = [
        'title' => 'Vos identifiants de connexion - ERP JALO Logistics',
        'body' => 'Vos accès à la plateforme Softlogis ont été créés avec succès. Vous pouvez vous connecter avec les identifiants suivants :<br><br>
                    <strong>Nom d\'utilisateur : </strong>' . $email . '<br>
                    <strong>Mot de passe : </strong>123456<br>',
        'btnText' => 'Se connecter',
        'btnLink' => route('login'),
    ];

    Mail::to($email)->send(new LogisticaMail($mailData, 'Identifiants - ERP JALO Logistics'));
}




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::where(['uuid'=>$id])->firstOrFail();
        $destinations = Destination::where(['etat'=>'actif'])->get();
        $porteChars = PorteChar::where(['etat'=>'actif'])->get();
        $grilleTarifaires = GrilleTarif::where(['etat'=>'actif', 'transporteur_uuid'=>$company->uuid])->get();
        $grilleTariftransits = GrilleTransit::where(['etat'=>'actif', 'transitaire_uuid'=>$company->uuid])->get();

        $hads = GrilleHad::where(['etat'=>'actif'])->get();
        return view('admin.company.show', compact('company', 'destinations', 'porteChars','grilleTarifaires', 'hads', 'grilleTariftransits'));
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
            'email' => 'required|string|email',
        ]);

        DB::beginTransaction();
        try {

            $company = Company::where(['uuid'=>$id])->first();

            $logo = $company->logo; // Utilisez l'ancien logo par défaut

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $logo = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move('files/', $logo);
            }

            $saving= Company::where(['uuid'=>$id])->update([
                'logo' => $logo,
                'raison_sociale' => $request->raison_sociale,
                'phone' => $request->phone,
                'identification' => $request->identification,
                'email' => $request->email,
                'localisation' => $request->localisation,
                'description' => $request->description,
                'type' => $request->type,
                'voie_transport' => $request->voie_transport,
                'contact_one_name' => $request->contact_one_name,
                'contact_one_lastName' => $request->contact_one_lastName,
                'contact_one_email' => $request->contact_one_email,
                'contact_two_name' => $request->contact_two_name,
                'contact_two_lastName' => $request->contact_two_lastName,
                'contact_two_email' => $request->contact_two_email,
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
    public function toActive(Request $request)
    {

        // dd($request->company_uuid);
        DB::beginTransaction();
        try {

            $deleted = Company::where(['uuid'=>$request->company_uuid])->update(['isActive' => 'true']);

            // dd($deleted);

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
    public function toBlock(Request $request)
    {
        DB::beginTransaction();
        try {

            $deleted = Company::where(['uuid'=>$request->company_uuid])->update(['isActive' => 'false']);

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
