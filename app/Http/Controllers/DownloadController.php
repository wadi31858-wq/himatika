<?php

namespace App\Http\Controllers;

use App\Models\Download;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->paginate(10);
        return view('download', compact('downloads'));
    }
}
