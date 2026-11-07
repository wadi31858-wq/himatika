<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalStructure;

class OrganizationController extends Controller
{
    public function index()
    {
        $structures = OrganizationalStructure::with('children')->whereNull('parent_id')->get();
        $members = OrganizationalStructure::all();
        return view('struktur-organisasi', compact('structures', 'members'));
    }

    public function show($id)
    {
        $jabatan = OrganizationalStructure::with(['children', 'parent'])->findOrFail($id);
        
        // Ambil beberapa jabatan terkait (misalnya anak-anaknya atau saudara-saudaranya)
        $terkait = collect();
        if ($jabatan->children->count() > 0) {
            $terkait = $jabatan->children;
        } elseif ($jabatan->parent_id) {
            $terkait = OrganizationalStructure::where('parent_id', $jabatan->parent_id)->where('id', '!=', $jabatan->id)->get();
        }

        return view('struktur-detail', compact('jabatan', 'terkait'));
    }
}
