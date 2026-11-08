<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminAgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('location', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('pub_status')) {
            $query->where('pub_status', $request->pub_status);
        }

        $agendas = $query->latest('date')->paginate(10)->withQueryString();

        $counts = [
            'total' => Agenda::count(),
            'published' => Agenda::where('pub_status', 'published')->count(),
            'draft' => Agenda::where('pub_status', 'draft')->count(),
        ];

        return view('admin.agenda.index', compact('agendas', 'counts'));
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
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|in:Akan Datang,Berlangsung,Selesai',
            'pub_status' => 'required|string|in:published,draft',
            'registration_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'end_time.after_or_equal' => 'Waktu selesai tidak boleh lebih awal dari waktu mulai.',
            'registration_link.url' => 'Format tautan pendaftaran harus berupa URL yang valid (misal: https://...).',
        ]);

        if (empty($validated['time']) && !empty($validated['start_time'])) {
            $validated['time'] = $validated['start_time'] . (!empty($validated['end_time']) ? ' - ' . $validated['end_time'] . ' WIB' : ' WIB');
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'agenda_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/agenda');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['image'] = 'agenda/' . $filename;
        }

        $agenda = Agenda::create($validated);

        ActivityLog::record(
            'create',
            'Menambahkan agenda: "' . $agenda->title . '" [' . strtoupper($agenda->pub_status) . ']',
            $agenda
        );

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
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|in:Akan Datang,Berlangsung,Selesai',
            'pub_status' => 'required|string|in:published,draft',
            'registration_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'end_time.after_or_equal' => 'Waktu selesai tidak boleh lebih awal dari waktu mulai.',
            'registration_link.url' => 'Format tautan pendaftaran harus berupa URL yang valid (misal: https://...).',
        ]);

        if (empty($validated['time']) && !empty($validated['start_time'])) {
            $validated['time'] = $validated['start_time'] . (!empty($validated['end_time']) ? ' - ' . $validated['end_time'] . ' WIB' : ' WIB');
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'agenda_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/agenda');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($agenda->image && file_exists(storage_path('app/public/' . $agenda->image))) {
                @unlink(storage_path('app/public/' . $agenda->image));
            }
            $file->move($destination, $filename);
            $validated['image'] = 'agenda/' . $filename;
        }

        $agenda->update($validated);

        ActivityLog::record(
            'update',
            'Memperbarui agenda: "' . $agenda->title . '" [' . strtoupper($agenda->pub_status) . ']',
            $agenda
        );

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $title = $agenda->title;

        if ($agenda->image && file_exists(storage_path('app/public/' . $agenda->image))) {
            @unlink(storage_path('app/public/' . $agenda->image));
        }

        $agenda->delete();

        ActivityLog::record(
            'delete',
            'Menghapus agenda: "' . $title . '"',
            null
        );

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
