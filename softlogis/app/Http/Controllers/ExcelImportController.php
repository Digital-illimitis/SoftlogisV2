<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ArticleImport;
use Excel;
use DB;

class ExcelImportController extends Controller
{
    //
    
    public function index()
    {
        return view('excel_import');
    }

    
     public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
 
        // Get the uploaded file
        $file = $request->file('file');
 
        // Process the Excel file
        Excel::import(new ArticleImport, $file);
 
        return redirect()->back()->with('success', 'Excel file imported successfully!');
    }
    
}
