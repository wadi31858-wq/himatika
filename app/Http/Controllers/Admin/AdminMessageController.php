<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = Message::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%");
            });
        }
        $messages = $query->latest()->paginate(10)->withQueryString();
        return view('admin.pesan.index', compact('messages'));
    }

    public function show(Message $pesan)
    {
        $pesan->update(['is_read' => true]);
        return view('admin.pesan.show', ['message' => $pesan]);
    }

    public function destroy(Message $pesan)
    {
        $pesan->delete();
        return redirect()->route('admin.pesan.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
