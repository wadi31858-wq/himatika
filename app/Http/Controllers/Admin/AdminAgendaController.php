<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AdminAgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        $agendas = $query->latest('date')->paginate(10)->withQueryString();
        return view('admin.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        Agenda::create($validated);
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        $agenda->update($validated);
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
