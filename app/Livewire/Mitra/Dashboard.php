<?php

namespace App\Livewire\Mitra;

use App\Models\Help;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.mitra')]
class Dashboard extends Component
{
    use WithPagination;

    public $activeTab = 'tersedia'; // tersedia, semua, diproses, selesai

    public function mount()
    {
        // Check if tab parameter is in the query string
        $tab = request()->query('tab');
        if ($tab && in_array($tab, ['tersedia', 'semua', 'diproses', 'selesai'])) {
            $this->activeTab = $tab;
        }
    }

    #[On('balance-updated')]
    public function refreshBalance()
    {
        $this->dispatch('$refresh');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function takeHelp($helpId)
    {
        $help = Help::findOrFail($helpId);

        if ($help->mitra_id) {
            session()->flash('error', 'Bantuan ini sudah diambil oleh mitra lain.');
            return;
        }

        $help->update([
            'mitra_id' => auth()->id(),
            'status' => 'memperoleh_mitra',
            'taken_at' => now(),
        ]);

        session()->flash('message', 'Bantuan berhasil diambil! Segera hubungi yang membutuhkan.');
        $this->setTab('diproses');
    }

    public function completeHelp($helpId)
    {
        $help = Help::where('id', $helpId)
            ->where('mitra_id', auth()->id())
            ->firstOrFail();

        $help->update([
            'status' => 'selesai',
            'completed_at' => now(),
        ]);

        session()->flash('message', 'Bantuan berhasil diselesaikan! Terima kasih atas kebaikan Anda.');
        $this->setTab('selesai');
    }

    public function render()
    {
        $user = auth()->user();
        $userBalance = UserBalance::where('user_id', $user->id)->first();
        $balance = $userBalance ? $userBalance->balance : 0;

        // Statistik bantuan
        $availableHelpsCount = Help::where('status', 'menunggu_mitra')
            ->whereNull('mitra_id')
            ->count();

        $inProgressCount = Help::where('mitra_id', $user->id)
            ->where('status', 'memperoleh_mitra')
            ->count();

        $completedCount = Help::where('mitra_id', $user->id)
            ->where('status', 'selesai')
            ->count();

        // Data berdasarkan tab
        if ($this->activeTab === 'tersedia') {
            $helps = Help::where('status', 'menunggu_mitra')
                ->whereNull('mitra_id')
                ->with(['user', 'city'])
                ->latest()
                ->paginate(10);
        } elseif ($this->activeTab === 'semua') {
            // Tampilkan SEMUA bantuan dari semua customer (status menunggu_mitra yang belum diambil)
            $helps = Help::where('status', 'menunggu_mitra')
                ->whereNull('mitra_id')
                ->with(['user', 'city'])
                ->latest()
                ->paginate(10);
        } elseif ($this->activeTab === 'diproses') {
            $helps = Help::where('mitra_id', $user->id)
                ->where('status', 'memperoleh_mitra')
                ->with(['user', 'city'])
                ->latest()
                ->paginate(10);
        } else { // selesai
            $helps = Help::where('mitra_id', $user->id)
                ->where('status', 'selesai')
                ->with(['user', 'city'])
                ->latest()
                ->paginate(10);
        }

        // Additional curated lists for dashboard sections
        // Rekomendasi: prefer `priority` then `rating` when column exists,
        // otherwise fallback to `rating` then `created_at`.
        $relations = ['user', 'city'];
        if (Schema::hasColumn('helps', 'category_id')) {
            $relations[] = 'category';
        }

        $recommendedQuery = Help::where('status', 'menunggu_mitra')
            ->whereNull('mitra_id')
            ->with($relations);

        // Determine safe ordering depending on which columns exist
        if (Schema::hasColumn('helps', 'priority')) {
            if (Schema::hasColumn('helps', 'rating')) {
                $recommendedQuery->orderByDesc('priority')->orderByDesc('rating');
            } else {
                $recommendedQuery->orderByDesc('priority')->orderByDesc('created_at');
            }
        } elseif (Schema::hasColumn('helps', 'rating')) {
            $recommendedQuery->orderByDesc('rating')->orderByDesc('created_at');
        } else {
            $recommendedQuery->orderByDesc('created_at');
        }

        $recommendedHelps = $recommendedQuery->take(6)->get();

        // Terbaru: order by created_at desc
        $latestHelps = Help::where('status', 'menunggu_mitra')
            ->whereNull('mitra_id')
            ->with($relations)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // Terdekat: simple city match fallback to latest if no city
        $nearbyQuery = Help::where('status', 'menunggu_mitra')
            ->whereNull('mitra_id')
            ->with($relations);

        if ($user && !empty($user->city_id)) {
            $nearbyQuery->where('city_id', $user->city_id);
        }

        $nearbyHelps = $nearbyQuery->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('livewire.mitra.dashboard.index', [
            'helps' => $helps,
            'balance' => $balance,
            'availableHelpsCount' => $availableHelpsCount,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
            'user' => $user,
            'recommendedHelps' => $recommendedHelps,
            'latestHelps' => $latestHelps,
            'nearbyHelps' => $nearbyHelps,
        ]);
    }
}
