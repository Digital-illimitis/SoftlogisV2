<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Comment;
use App\Models\Sourcing;
use App\Mail\LogisticaMail;
use App\Models\DocAssigned;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DocumentRequis;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\MyLogNotification;

class ManageDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // $allAgents = User::where('etat', 'actif')->get();
        $allAgents = User::where('etat', 'actif')->where('id_role',5)->get();

        $sourcingByBlist = Sourcing::where('etat', 'actif')->get();

        
        $folderAssign = DocAssigned::where('etat', 'actif')->get();

        $mesDossiers = DocAssigned::where('etat', 'actif')->get();

        // $mesDossiers = $folderAssign->filter(function ($item) {
        //     return $item->userUuid === auth()->user()->uuid || $item->backupUuid === auth()->user()->uuid;
        // });
        // $documentRequises = DocumentRequis::where('etat', 'actif')->get();

            // dd($folderAssign->count());
        $countUserAssignFolder = DocAssigned::where('etat', 'actif')->distinct('userUuid')->count();
        $UserAssignFolder = DocAssigned::where('etat', 'actif')->distinct('userUuid')->get();
        // dd($UserAssignFolder);

        $docs = DocumentRequis::where('etat', 'actif')->get();

        // dd(isfolderCheck($uuid_sourcing,$uuid_folder));

        $totalDossiers = $sourcingByBlist->count();

        // Compter le nombre de dossiers avec un agent assigné (userUuid non nul)
        $nombreDossiersAssignes = Sourcing::has('folderAssign')->count();
        $perCentdocAssign = 0;
        if($nombreDossiersAssignes > 0 && $totalDossiers > 0){
            $perCentdocAssign = ($nombreDossiersAssignes / $totalDossiers) * 100;
        }
        

        // Calculer le nombre de dossiers en attente d'assignation
        $nombreDossiersEnAttente = $totalDossiers - $nombreDossiersAssignes;
        $perCentdocNotAssign = 0;
        if($totalDossiers > 0 && $nombreDossiersEnAttente > 0){
            $perCentdocNotAssign = ($nombreDossiersEnAttente / $totalDossiers) * 100;
        }

        // commentaire d'un docssier
        $allComments = Comment::where('etat', 'actif')->get();
        

        $query = DocAssigned::query();

        // Filtrer par agent
        if ($request->filled('agent')) {
            $query->where('userUuid', $request->agent);
        }

        // Filtrer par date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Obtenez les résultats filtrés
        $sourcingByBl = $query->get();

        
    
        return view('admin.manageFolder.gestionDocument',
        compact('allAgents', 'sourcingByBl', 'docs', 'nombreDossiersAssignes', 'nombreDossiersEnAttente', 'perCentdocAssign','perCentdocNotAssign', 'folderAssign', 'allComments', 'countUserAssignFolder', 'mesDossiers','UserAssignFolder','sourcingByBlist'));
    }

    public function checkEtaAndSendMail()
{
    // Récupérer les éléments où l'état est actif
    $sourcingByBlist = Sourcing::where('etat', 'actif')->get();

    // Parcourir chaque élément
    foreach ($sourcingByBlist as $item) {
        $date_eta = Carbon::parse($item->date_arriver);
        $date_alerte = $date_eta->subDays(10);

            $emailSubject = 'Alerte ETA -10 jours';
            $recipientEmail = "ndouajm@gmail.com";

            $mailData = [
                'title' => $emailSubject,
                'body' => "L'ETA pour l'élément avec le numéro Dossier ".$item->code." est à -10 jours.",
            ];

            $mail = new LogisticaMail($mailData, $emailSubject);

        // Vérifier si la date d'alerte est égale à aujourd'hui
        if ($date_alerte->isToday()) {
            // Envoyer un e-mail
            $mailSending = Mail::to($recipientEmail)->send($mail);
        }
    }
}

    public function statistique(){
        $AgentAsign = DocAssigned::select('userUuid')->where('etat', 'actif')->distinct('userUuid')->get();
        foreach ($AgentAsign as $key => $value) {
            $nb_dossiers[] =countFolderByAgent($value->userUuid);
            $nb_dossiers_in_progress[] =countFolderByAgentStatus($value->userUuid,"En cours");
            $nb_dossiers_finish[] =countFolderByAgentStatus($value->userUuid,"Terminé");
            $agents[] = User::whereUuid($value->userUuid)->first()->name ;
        }
        $datas = array(
            'nb_dossiers' => $nb_dossiers,
            'nb_dossiers_in_progress' => $nb_dossiers_in_progress,
            'nb_dossiers_finish' => $nb_dossiers_finish,
            'agents' => $agents
        );
        return $datas;
    }

    public function apiFolderByUser($uuid)
    {
        $folderByAgentCount = DocAssigned::where('etat', 'actif')->where('userUuid', $uuid)->groupBy('userUuid')->count();


        $folderByBackupCount = DocAssigned::where('etat', 'actif')->where('backupUuid', $uuid)->groupBy('backupUuid')->count();

        $array = array(
            'count' => $folderByAgentCount,
            'count' => $folderByBackupCount,
        );


        return response()->json($array);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function  updateStatusFolder(request $request)
    {
    $docAssigned = DocAssigned::where('etat', 'actif')
        ->where('folderUuid', $request->sourcing)
        ->first();
        // dd($docAssigned);

    if ($docAssigned) {
        $datasfile = json_decode($docAssigned->datasfile, true);

        if (isset($datasfile[$request->docuuid])) {
            $datasfile[$request->docuuid]['status'] = true;

            // Mettez à jour la colonne datasfile avec les données modifiées
            $docAssigned->datasfile = json_encode($datasfile);
            $docAssigned->save();

            return true; // La mise à jour a réussi
        }
    }

    return "pas d'assignation"; // La mise à jour a échoué
}

    /**
     * Store a newly created resource in storage.
     */
    public function assign(Request $request, string $id)
    {

        DB::beginTransaction();
        try {
            $userAssigned = Auth::user()->uuid;
            $documentRequises = DocumentRequis::where('etat', 'actif')->get();
            foreach ($documentRequises as $key => $documentRequise) {
                $datas[$documentRequise->uuid] = array(
                    'status' => false,
                    'date'=> null,
                    'file'=>$documentRequise->uuid
                );
            }
            $datasfile=json_encode($datas);
            $uuid = Str::uuid();
            $saving= DocAssigned::create([
                'uuid'=> $uuid,
                'folderUuid' => $request->folderUuid,
                'userUuid' => $request->userUuid,
                'backupUuid' => $request->backupUuid,
                'assignedByUuid' => $userAssigned,
                'status'=>"En cours",
                'datasfile' =>$datasfile ,
                'etat' => 'actif',
                'code' => Refgenerate(DocAssigned::class, 'DA', 'code'),
            ])->save();

            if ($saving) {
                // $users = User::all();
                $users = User::whereIn('uuid', [$request->userUuid, $request->backupUuid])->get();
                $user = auth()->user()->name." ".auth()->user()->lastname;
                $details_log = [
                    // 'url' => url()->current(),
                    'url' => route('admin.manager_dossier.index'),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "GESTION DOCUMENTAIRES",
                    'action' => "Un dossier vous a été assigné  le : ".date('Y-m-d H:i:s'),
                ];

                // Assurez-vous que $users est une collection d'instances de User
                foreach ($users as $user) {
                    $user->notify(new MyLogNotification($details_log));
                }

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Assigné avec succes!",
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
     * Update the specifieflowchartAgentd resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        DB::beginTransaction();
        try {

            $saving= DocAssigned::where('uuid', $request->folderUuid)->update([
                'folderUuid' => $request->folderUuid,
                'userUuid' => $request->userUuid,
                'backupUuid' => $request->backupUuid,
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
    public function flowchartAgent()
    {
        $agents = DocAssigned::where('etat', 'actif')->distinct('userUuid')->get();
        // ['Feb', 'Mar', 'Apr', 'May']

     // liste des agents ayant au moins un dossier
        foreach ($agents as $agent) {
            $array[]=$agent->user->name;
             //Nombre de dossier assigné par un agent
             $folderAssign[]= countFolderByAgent($agent->user->uuid);
        }
        $datas = [
            'liste'=>json_encode($array),
            'folderAssign'=>json_encode($folderAssign),
        ];
        return $datas;
      
    
       
        
    }
}
