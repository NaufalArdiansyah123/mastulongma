<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class BlockedPartnerController extends Controller
{
    public function index()
    {
        $blocked = User::where('role', 'mitra')
            ->where('status', 'blocked')
            ->with('city')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.partners.blocked', compact('blocked'));
    }

    public function toggle($id)
    {
        $user = User::where('role', 'mitra')->findOrFail($id);
        // Toggle between 'blocked' and 'active' status for compatibility
        $user->status = $user->status === 'blocked' ? 'active' : 'blocked';
        $user->save();

        return back()->with('success', $user->status === 'blocked' ? 'Mitra diblokir.' : 'Mitra dibuka blokirnya.');
    }
}
