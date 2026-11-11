<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\SiteSetting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminAspirationController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspiration::where('is_archived', false);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('title', 'like', "%{$s}%")
                  ->orWhere('nim', 'like', "%{$s}%")
                  ->orWhere('message', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirations = $query->latest()->paginate(12)->withQueryString();

        $counts = [
            'total' => Aspiration::where('is_archived', false)->count(),
            'baru' => Aspiration::where('is_archived', false)->where('status', 'Baru')->count(),
            'diproses' => Aspiration::where('is_archived', false)->where('status', 'Diproses')->count(),
            'selesai' => Aspiration::where('is_archived', false)->where('status', 'Selesai')->count(),
            'arsip' => Aspiration::where('is_archived', true)->count(),
        ];

        return view('admin.aspirasi.index', compact('aspirations', 'counts'));
    }

    public function archiveList(Request $request)
    {
        $query = Aspiration::where('is_archived', true);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('title', 'like', "%{$s}%")
                  ->orWhere('nim', 'like', "%{$s}%")
                  ->orWhere('message', 'like', "%{$s}%");
            });
        }

        $aspirations = $query->latest()->paginate(12)->withQueryString();
        $totalArchived = Aspiration::where('is_archived', true)->count();

        return view('admin.aspirasi.arsip', compact('aspirations', 'totalArchived'));
    }

    public function show(Aspiration $aspirasi)
    {
        return view('admin.aspirasi.show', compact('aspirasi'));
    }

    public function update(Request $request, Aspiration $aspirasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:Baru,Dibaca,Diproses,Selesai',
            'admin_reply' => 'nullable|string|max:2000',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $oldStatus = $aspirasi->status;
        $aspirasi->update($validated);

        ActivityLog::record(
            'update',
            "Memperbarui status aspirasi #{$aspirasi->id} dari '{$oldStatus}' ke '{$aspirasi->status}'",
            $aspirasi
        );

        return redirect()->route('admin.aspirasi.show', $aspirasi)->with('success', 'Status dan tanggapan aspirasi berhasil diperbarui.');
    }

    public function archive(Aspiration $aspirasi)
    {
        $aspirasi->update(['is_archived' => true]);

        ActivityLog::record(
            'archive',
            "Mengarsipkan aspirasi #{$aspirasi->id}: \"{$aspirasi->title}\"",
            $aspirasi
        );

        return back()->with('success', 'Aspirasi berhasil dipindahkan ke Arsip.');
    }

    public function restore(Aspiration $aspirasi)
    {
        $aspirasi->update(['is_archived' => false]);

        ActivityLog::record(
            'restore',
            "Mengembalikan aspirasi #{$aspirasi->id}: \"{$aspirasi->title}\" ke Kotak Masuk",
            $aspirasi
        );

        return back()->with('success', 'Aspirasi berhasil dikembalikan ke Kotak Masuk aktif.');
    }

    public function destroy(Aspiration $aspirasi)
    {
        $title = $aspirasi->title;
        $id = $aspirasi->id;
        $aspirasi->delete();

        ActivityLog::record(
            'delete',
            "Menghapus permanen aspirasi #{$id}: \"{$title}\"",
            null
        );

        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil dihapus.');
    }

    public function settings()
    {
        $introTitle = SiteSetting::get('aspiration_intro_title', 'Ruang Terbuka Menyampaikan Aspirasi');
        $introDesc = SiteSetting::get('aspiration_intro_desc', 'Sampaikan kritik konstruktif, saran, masukan program, maupun pertanyaan untuk kemajuan HIMATIKA UNUJA.');
        $buttonText = SiteSetting::get('aspiration_btn_text', 'Kirim Aspirasi Sekarang');
        $successMsg = SiteSetting::get('aspiration_success_msg', 'Terima kasih, aspirasi Anda telah berhasil kami terima dan akan segera ditinjau oleh pengurus himpunan.');

        return view('admin.aspirasi.pengaturan', compact('introTitle', 'introDesc', 'buttonText', 'successMsg'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'aspiration_intro_title' => 'required|string|max:255',
            'aspiration_intro_desc' => 'nullable|string|max:1000',
            'aspiration_btn_text' => 'required|string|max:100',
            'aspiration_success_msg' => 'required|string|max:500',
        ]);

        foreach ($validated as $key => $val) {
            SiteSetting::set($key, $val, 'aspirasi');
        }

        ActivityLog::record('update', 'Memperbarui pengaturan formulir aspirasi publik', null);

        return back()->with('success', 'Pengaturan formulir aspirasi berhasil disimpan.');
    }
}
