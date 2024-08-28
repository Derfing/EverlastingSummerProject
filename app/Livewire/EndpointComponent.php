<?php

namespace App\Livewire;

use App\Models\Endpoint;
use Livewire\Component;

class EndpointComponent extends Component
{
    public Endpoint $endpoint;
    public function mount($endpoint)
    {
        $this->$endpoint = $endpoint;
    }

    public function delete()
    {
        $this->endpoint->delete();

        return view('livewire.endpoint-component');
    }
    public function edit()
    {
        return redirect()->route('endpoints.edit', $this->endpoint->id);
    }

    public function create()
    {
        return view('livewire.edit-endpoint-component');
    }
    public function render()
    {
        return view('livewire.endpoint-component');
    }
}
