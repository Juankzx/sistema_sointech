<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ClientSignature extends Component
{
    public $token;
    public $status;
    public $orderData;
    
    // Form fields
    public $terms_accepted = false;
    public $signature_base64;

    public function mount($token)
    {
        $this->token = $token;
        $this->loadData();
    }

    public function loadData()
    {
        $data = Cache::get($this->token);
        
        if (!$data) {
            $this->status = 'expired';
            return;
        }

        if ($data['status'] === 'signed') {
            $this->status = 'signed';
            return;
        }

        $this->status = 'pending';
        $this->orderData = $data;
    }

    public function submitSignature()
    {
        $this->validate([
            'terms_accepted' => 'accepted',
            'signature_base64' => 'required|string'
        ]);

        $data = Cache::get($this->token);
        
        if (!$data) {
            $this->status = 'expired';
            return;
        }

        // Update cache with signature
        $data['status'] = 'signed';
        $data['signature_base64'] = $this->signature_base64;
        
        Cache::put($this->token, $data, now()->addMinutes(30));
        
        $this->status = 'signed';
    }

    public function render()
    {
        return view('livewire.public.client-signature')->layout('layouts.app');
    }
}
