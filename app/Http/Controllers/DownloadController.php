<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{

    public function Download($path, $past, $file){

        return response()->download("storage/" . $path."/".$past."/".$file, $file);
    }
}
