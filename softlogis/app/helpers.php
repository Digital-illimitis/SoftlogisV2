<?php

use App\Models\DocAssigned;

function dateFormat($date,$format){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($format);
}

function trimString($string, $repl, $limit)
{
  if(strlen($string) > $limit)
  {
    return substr($string, 0, $limit) . $repl;
  }
  else
  {
    return $string;
  }
}

function truncate($string, $length)
{
    if (strlen($string) > $length) {
        return substr($string, 0, $length - 3) . '...';
    }
    return $string;
}

function Refgenerate($table,$init,$key)
{
    $latest = $table::latest()->first();
    if (! $latest) {
        return $init.'-00001';
    }

    $string = preg_replace("/[^0-9\.]/", '', $latest->$key);

    return $init.'-' . sprintf('%05d',$string+1);
}

function countFolderByAgent($uuid)
{
    $folderByAgentCount = DocAssigned::where('etat', 'actif')->where('userUuid', $uuid)->groupBy('userUuid')->count();
      
    return $folderByAgentCount;
}
function countFolderByAgentStatus($uuid,$status)
{
    $folderByAgentCount = DocAssigned::where('etat', 'actif')->whereStatus($status)->where('userUuid', $uuid)->groupBy('userUuid')->count();
      
    return $folderByAgentCount;
}
function countFolderByBackup($uuid)
{
    $folderByBackupCount = DocAssigned::where('etat', 'actif')->where('backupUuid', $uuid)->groupBy('backupUuid')->count();
      
    return $folderByBackupCount;
}

/**
 * Check if a document is assigned to a folder.
 *
 * @param datatype $uuid_sourcing description
 * @param datatype $uuid_doc description
 * @return bool
 */
function isfolderCheck($uuid_sourcing,$uuid_doc)
{
    $is_assign = DocAssigned::where('etat', 'actif')->where(['folderUuid'=>$uuid_sourcing])->first();
    if ($is_assign) {
        $isfolderCheck = DocAssigned::where('etat', 'actif')->where(['folderUuid'=>$uuid_sourcing])
        ->whereRaw("JSON_EXTRACT(datasfile, '$.\"$uuid_doc\"') IS NOT NULL")
        ->whereRaw("JSON_EXTRACT(datasfile, '$.\"$uuid_doc\".status') = true")
        ->exists();
          
        return $isfolderCheck;
    } else {
        return false;
    }
    
}

function isMyfolderCheck($uuid_sourcing,$uuid_doc)
{
    $is_assign = DocAssigned::where('etat', 'actif')->where(['folderUuid'=>$uuid_sourcing])->first();
    if ($is_assign) {
        $isfolderCheck = DocAssigned::where('etat', 'actif')->where(['folderUuid'=>$uuid_sourcing])
        ->whereRaw("JSON_EXTRACT(datasfile, '$.\"$uuid_doc\"') IS NOT NULL")
        // ->whereRaw("JSON_EXTRACT(datasfile, '$.\"$uuid_doc\".status') = true")
        ->first();
        //   dd($isfolderCheck->userUuid);
        return $isfolderCheck;

    } else {
        return false;
    }
    
}



function updateStatusFolder($uuidSourcing, $uuidDoc, $newStatus)
{
    $docAssigned = DocAssigned::where('etat', 'actif')
        ->where('folderUuid', $uuidSourcing)
        ->first();

    if ($docAssigned) {
        $datasfile = json_decode($docAssigned->datasfile, true);

        if (isset($datasfile[$uuidDoc])) {
            $datasfile[$uuidDoc]['status'] = $newStatus;

            // Mettez à jour la colonne datasfile avec les données modifiées
            $docAssigned->datasfile = json_encode($datasfile);
            $docAssigned->save();

            return true; // La mise à jour a réussi
        }
    }

    return false; // La mise à jour a échoué
}


?>
