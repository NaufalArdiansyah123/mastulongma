<?php

namespace App\Livewire\Mitra;

use App\Models\Help;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.mitra')]
class HelpDetail extends Component
{
    public Help $help;
    public $isLoading = false;

    public function mount($id)
    {
        $this->help = Help::findOrFail($id);
    }

    public function takeHelp()
    {
        $this->isLoading = true;

        try {
            $this->help->update([
                'mitra_id' => auth()->id(),
                'status' => 'memperoleh_mitra'
            ]);

            // Dispatch an event so the frontend can show a success modal
            $this->dispatch('help-taken');
            session()->flash('success', 'Bantuan berhasil diambil!');
            // Do not redirect here; let the frontend show confirmation and then navigate.
            // This keeps UX consistent (confirmation modal -> success modal -> redirect).
        } finally {
            $this->isLoading = false;
        }
    }

    public function completeHelp()
    {
        $this->isLoading = true;

        try {
            $this->help->update([
                'status' => 'selesai',
                'completed_at' => now()
            ]);

            $this->dispatch('help-completed');
            session()->flash('success', 'Bantuan berhasil diselesaikan!');

            return redirect()->route('mitra.dashboard');
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.mitra.helps.help-detail');
    }
}
