<?php

namespace App\Livewire\Helps;

use App\Models\Category;
use App\Models\City;
use App\Models\Help;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $category_id = '';
    public $city_id = '';
    public $location = '';
    public $photo;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'city_id' => 'required|exists:cities,id',
        'location' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048',
    ];

    public function save()
    {
        $this->validate();

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('helps', 'public');
        }

        Help::create([
            'user_id' => auth()->id(),
            'category_id' => $this->category_id,
            'city_id' => $this->city_id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'photo' => $photoPath,
            'status' => 'pending',
        ]);

        session()->flash('message', 'Permintaan bantuan berhasil dibuat! Menunggu verifikasi admin.');

        return redirect()->route('helps.index');
    }

    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();

        return view('livewire.helps.create', [
            'categories' => $categories,
            'cities' => $cities,
        ]);
    }
}
