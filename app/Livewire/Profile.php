<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $user;
    public $activeTab = 'general';

    public function mount($nick)
    {
        if (!is_string($nick) || strlen($nick) > 50) {
            abort(404, 'Perfil não encontrado.');
        }

        $this->user = User::where('name', $nick)->firstOrFail();
    }

    public function tabs($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
