<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth()->user();

        $cityIds = City::where('admin_id', $admin->id)->pluck('id');

        $query = User::with('city')
            ->withCount('helps')
            ->withCount('partnerReports')
            ->withAvg('ratings as average_rating', 'rating')
            ->whereIn('city_id', $cityIds);

        // Search by name or email
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($role = $request->get('role')) {
            if ($role !== 'all') {
                $query->where('role', $role);
            }
        }

        // Filter by account status
        if ($status = $request->get('account_status')) {
            if ($status === 'blocked') {
                $query->where('status', 'blocked');
            } elseif ($status === 'inactive') {
                $query->where('status', 'inactive');
            } elseif ($status === 'active') {
                $query->where('status', 'active');
            }
        }

        // Filter by KTP status
        if ($ktpStatus = $request->get('ktp_status')) {
            if ($ktpStatus === 'uploaded') {
                $query->whereNotNull('ktp_path');
            } elseif ($ktpStatus === 'missing') {
                $query->whereNull('ktp_path');
            }
        }

        $users = $query->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $admin = auth()->user();

        $cityIds = City::where('admin_id', $admin->id)->pluck('id');

        abort_unless($cityIds->contains($user->city_id), 404);

        $user->load('city');

        return view('admin.users.show', compact('user'));
    }
}
