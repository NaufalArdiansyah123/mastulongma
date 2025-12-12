<?php

namespace App\Livewire\Customer\Helps;

use App\Models\Help;
use App\Models\City;
use App\Models\Rating;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $queryString = [
        'statusFilter' => ['except' => 'menunggu_mitra'],
    ];

    public $statusFilter = 'menunggu_mitra';
    public $selectedHelpData = null;
    // Rating flow
    public $ratingComment = null;
    public $pendingRating = null;
    public $pendingHelpForRating = null;
    // Confirmation modal for completion
    public $showConfirmModal = false;
    public $confirmingHelpId = null;
    // Confirmation modal for deletion (cancel help)
    public $showDeleteConfirm = false;
    public $deletingHelpId = null;
    // Edit modal state
    public $editingHelp = null;
    public $editTitle;
    public $editDescription;
    public $editAmount;
    public $editLocation;
    public $editFullAddress;
    public $editEquipmentProvided;
    public $editCityId;
    public $editLatitude;
    public $editLongitude;
    public $editPhoto;
    public $editExistingPhoto;
    public $cities = [];

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
    }

    /**
     * Confirm completion from the customer's side when the partner already finished the task.
     */
    /** Open confirmation modal for completion (customer) */
    public function confirmCompletion($helpId)
    {
        $help = Help::findOrFail($helpId);

        // Only the owner (customer) can open confirmation
        if ($help->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk mengonfirmasi penyelesaian ini.');
            return;
        }

        // Require that a mitra was assigned and status is in progress
        if (!$help->mitra_id || $help->status !== 'memperoleh_mitra') {
            session()->flash('error', 'Permintaan belum dalam status yang dapat dikonfirmasi.');
            return;
        }

        $this->confirmingHelpId = $helpId;
        $this->showConfirmModal = true;
    }

    /** Called when customer confirms completion in modal */
    public function completeConfirmed()
    {
        if (!$this->confirmingHelpId) {
            $this->showConfirmModal = false;
            return;
        }

        $help = Help::findOrFail($this->confirmingHelpId);

        if ($help->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk mengonfirmasi penyelesaian ini.');
            $this->showConfirmModal = false;
            $this->confirmingHelpId = null;
            return;
        }

        if (!$help->mitra_id || $help->status !== 'memperoleh_mitra') {
            session()->flash('error', 'Permintaan belum dalam status yang dapat dikonfirmasi.');
            $this->showConfirmModal = false;
            $this->confirmingHelpId = null;
            return;
        }

        $help->update([
            'status' => 'selesai',
            'completed_at' => now(),
        ]);

        session()->flash('message', 'Terima kasih, permintaan telah ditandai sebagai selesai.');

        // reset modal state
        $this->showConfirmModal = false;
        $this->confirmingHelpId = null;
    }

    public function deleteHelp($helpId)
    {
        $help = Help::findOrFail($helpId);

        // Pastikan user adalah pemilik bantuan
        if ($help->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk menghapus bantuan ini.');
            return;
        }

        $help->delete();
        // Clear any open selection so modal closes if it was showing this help
        if ($this->selectedHelpData && $this->selectedHelpData['id'] === $helpId) {
            $this->selectedHelpData = null;
        }

        session()->flash('message', 'Bantuan berhasil dihapus.');
    }

    /**
     * Open delete confirmation modal (so user must confirm before delete)
     */
    public function confirmDelete($helpId)
    {
        $help = Help::find($helpId);
        if (!$help) {
            session()->flash('error', 'Bantuan tidak ditemukan.');
            return;
        }

        // Only owner can request deletion
        if ($help->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk menghapus bantuan ini.');
            return;
        }

        $this->deletingHelpId = $helpId;
        $this->showDeleteConfirm = true;
    }

    /**
     * Called when user confirms deletion in the modal
     */
    public function deleteConfirmed()
    {
        if (!$this->deletingHelpId) {
            $this->showDeleteConfirm = false;
            return;
        }

        // Reuse existing delete logic
        $this->deleteHelp($this->deletingHelpId);

        // reset modal state
        $this->deletingHelpId = null;
        $this->showDeleteConfirm = false;
    }

    public function cancelDelete()
    {
        $this->deletingHelpId = null;
        $this->showDeleteConfirm = false;
    }

    public function showHelp($id)
    {
        // Load help details into `selectedHelpData` so the index view can
        // render a detail modal inline when a card is clicked.
        $help = Help::with(['city', 'mitra', 'category'])->find($id);
        if (!$help) {
            session()->flash('error', 'Bantuan tidak ditemukan.');
            return;
        }

        // Only the owner (customer) may open the detail modal here
        if ($help->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk melihat detail ini.');
            return;
        }

        $this->selectedHelpData = [
            'id' => $help->id,
            'title' => $help->title,
            'description' => $help->description,
            'amount' => $help->amount,
            'photo' => $help->photo,
            'location' => $help->location,
            'user_name' => optional($help->user)->name ?? auth()->user()->name,
            'city_name' => optional($help->city)->name,
            'full_address' => $help->full_address,
            'equipment_provided' => $help->equipment_provided,
            'latitude' => $help->latitude,
            'longitude' => $help->longitude,
            'admin_notes' => $help->admin_notes,
            'admin_fee' => $help->admin_fee,
            'total_amount' => $help->total_amount,
            'category_name' => optional($help->category)->name,
            'mitra_name' => optional($help->mitra)->name,
            'status' => $help->status,
            'created_at_human' => optional($help->created_at)->diffForHumans(),
            'updated_at' => optional($help->updated_at)->format('d M Y • H:i'),
            'taken_at' => optional($help->taken_at)->format('d M Y • H:i'),
        ];
        // Dispatch browser event so client-side can initialize the detail map
        $this->dispatch('open-detail', id: $help->id, latitude: $help->latitude, longitude: $help->longitude, full_address: $help->full_address);
    }

    public function closeHelp()
    {
        $this->selectedHelpData = null;
    }

    // Temporary debug helper to confirm Livewire connectivity from browser
    public function testPing()
    {
        Log::info('Customer\Helps\Index::testPing invoked', ['user_id' => auth()->id()]);
        $this->selectedHelpData = [
            'id' => 0,
            'title' => 'Debug: Modal Test',
            'description' => 'This is a test modal opened from testPing().',
            'amount' => 0,
            'photo' => null,
            'location' => null,
            'user_name' => auth()->user()->name ?? null,
            'city_name' => null,
            'status' => 'test',
            'created_at_human' => now()->diffForHumans(),
        ];
    }

    // --- Edit flow ---
    public function editHelp($id)
    {
        $help = Help::findOrFail($id);

        // Only owner can edit
        if ($help->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk mengedit bantuan ini.');
            return;
        }

        $this->editingHelp = $help->id;
        $this->editTitle = $help->title;
        $this->editDescription = $help->description;
        $this->editAmount = $help->amount;
        $this->editLocation = $help->location;
        $this->editFullAddress = $help->full_address;
        $this->editEquipmentProvided = $help->equipment_provided;
        $this->editCityId = $help->city_id;
        $this->editLatitude = $help->latitude;
        $this->editLongitude = $help->longitude;
        $this->editExistingPhoto = $help->photo;
        Log::info('Customer\\Helps\\Index::editHelp called', ['id' => $id, 'user_id' => auth()->id()]);

        // Dispatch a browser event with the help data so client-side listeners (and fallbacks) can react.
        $this->dispatch('open-edit', id: $help->id, title: $help->title, description: $help->description, amount: $help->amount, location: $help->location, city_id: $help->city_id, latitude: $help->latitude, longitude: $help->longitude);
    }

    /**
     * Called when a customer clicks a rating star.
     * Stores the pending rating value and which help is being rated.
     */
    public function setRating($helpId, $value)
    {
        $this->pendingHelpForRating = $helpId;
        $this->pendingRating = (int) $value;
    }

    /**
     * Submit rating and optional comment for a help.
     */
    public function submitRating($helpId)
    {
        $this->validate([
            'pendingRating' => 'required|integer|min:1|max:5',
            'ratingComment' => 'nullable|string|max:1000',
        ]);

        $help = Help::findOrFail($helpId);

        // Only the owner (customer) may submit rating for this help
        if ($help->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk memberi rating pada bantuan ini.');
            return;
        }

        Rating::updateOrCreate(
            ['help_id' => $helpId, 'user_id' => auth()->id()],
            [
                'mitra_id' => $help->mitra_id,
                'rating' => $this->pendingRating,
                'review' => $this->ratingComment,
            ]
        );

        session()->flash('message', 'Terima kasih — rating Anda telah disimpan.');

        // reset rating state
        $this->pendingHelpForRating = null;
        $this->pendingRating = null;
        $this->ratingComment = null;
    }

    public function saveEdit()
    {
        $this->validate([
            'editTitle' => 'required|string|max:255',
            'editDescription' => 'required|string',
            'editAmount' => 'required|numeric|min:10000|max:100000000',
            'editLocation' => 'nullable|string|max:255',
            'editFullAddress' => 'nullable|string|max:500',
            'editEquipmentProvided' => 'nullable|string|max:1000',
            'editCityId' => 'required|exists:cities,id',
            'editPhoto' => 'nullable|image|max:2048', // 2MB max
        ]);

        $help = Help::findOrFail($this->editingHelp);

        if ($help->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk mengedit bantuan ini.');
            return;
        }

        $updateData = [
            'title' => $this->editTitle,
            'description' => $this->editDescription,
            'amount' => $this->editAmount,
            'location' => $this->editLocation,
            'full_address' => $this->editFullAddress,
            'equipment_provided' => $this->editEquipmentProvided,
            'city_id' => $this->editCityId,
            'latitude' => $this->editLatitude,
            'longitude' => $this->editLongitude,
        ];

        // Handle photo upload
        if ($this->editPhoto) {
            // Delete old photo if exists
            if ($help->photo) {
                Storage::disk('public')->delete($help->photo);
            }
            $updateData['photo'] = $this->editPhoto->store('helps', 'public');
        }

        $help->update($updateData);

        session()->flash('message', 'Perubahan bantuan berhasil disimpan.');
        $this->closeEdit();
    }

    public function closeEdit()
    {
        $this->editingHelp = null;
        $this->editTitle = null;
        $this->editDescription = null;
        $this->editAmount = null;
        $this->editLocation = null;
        $this->editFullAddress = null;
        $this->editEquipmentProvided = null;
        $this->editCityId = null;
        $this->editLatitude = null;
        $this->editLongitude = null;
        $this->editPhoto = null;
        $this->editExistingPhoto = null;
    }

    public function render()
    {
        $user = auth()->user();

        if ($user->isCustomer()) {
            $helps = Help::where('user_id', $user->id)
                ->with([
                    'city',
                    'mitra',
                    'rating' => function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    },
                ])
                ->withCount('chatMessages')
                ->when($this->statusFilter !== '', function ($query) {
                    $query->where('status', $this->statusFilter);
                })
                ->latest()
                ->paginate(10);
        } elseif ($user->isMitra()) {
                if (request()->routeIs('helps.available')) {
                // Mitra melihat bantuan yang available
                $helps = Help::where('status', 'approved')
                    ->whereNull('mitra_id')
                    ->with(['user', 'city'])
                        ->withCount('chatMessages')
                    ->latest()
                    ->paginate(10);
            } else {
                // Mitra melihat bantuan yang sudah diambil
                $helps = Help::where('mitra_id', $user->id)
                    ->with(['user', 'city'])
                        ->withCount('chatMessages')
                    ->when($this->statusFilter !== '', function ($query) {
                        $query->where('status', $this->statusFilter);
                    })
                    ->latest()
                    ->paginate(10);
            }
        } else {
            $helps = collect();
        }

        // Safe debug: render the view with the component's essential public
        // properties passed in so we can capture the actual HTML Livewire sees
        // (helps, statusFilter, editingHelp). This helps locate stray top-level
        // elements that trigger Livewire's multiple-root detection.
        try {
            $debugHtml = view('livewire.customer.helps.index', [
                'helps' => $helps,
                'statusFilter' => $this->statusFilter,
                'editingHelp' => $this->editingHelp,
            ])->render();

            // Use DOMDocument to count top-level element children inside the
            // rendered fragment. If count > 1, Livewire will complain about
            // multiple root elements.
            libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadHTML('<!doctype html><html><body>' . $debugHtml . '</body></html>');
            $body = $dom->getElementsByTagName('body')->item(0);

            $rootTags = [];
            $rootCount = 0;
            if ($body) {
                foreach ($body->childNodes as $child) {
                    if ($child->nodeType === XML_ELEMENT_NODE) {
                        $rootCount++;
                        $rootTags[] = $child->nodeName;
                    }
                }
            }

            \Illuminate\Support\Facades\Log::info('Debug rendered customer.helps roots', ['count' => $rootCount, 'tags' => $rootTags]);
            \Illuminate\Support\Facades\Log::info('Debug rendered customer.helps HTML (first 3000 chars)', ['html_snippet' => substr($debugHtml, 0, 3000)]);
            libxml_clear_errors();
            // Additionally, write the full rendered HTML to storage for inspection when
            // running locally. This helps examining the exact markup Livewire received.
            try {
                if (app()->environment('local') || app()->environment('development') || app()->runningUnitTests()) {
                    $path = storage_path('debug_customer_helps.html');
                    file_put_contents($path, $debugHtml);
                    \Illuminate\Support\Facades\Log::info('Wrote debug_customer_helps.html for inspection', ['path' => $path]);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Failed writing debug HTML file', ['exception' => $e->getMessage()]);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Debug render error for customer.helps', ['exception' => $e->getMessage()]);
        }

        // load active cities for the edit form
        $this->cities = City::where('is_active', true)->orderBy('name')->get();

        return view('livewire.customer.helps.index', [
            'helps' => $helps,
            'cities' => $this->cities,
        ]);
    }
}
