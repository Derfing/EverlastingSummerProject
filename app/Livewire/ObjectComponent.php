<?php

namespace App\Livewire;

use App\Models\Endpoint;
use App\Models\EndpointObject;
use Livewire\Component;

class ObjectComponent extends Component
{
    public EndpointObject $object;
    public function mount($object)
    {
        $this->object = $object;
    }

    public function delete()
    {
        $this->object->delete();

        return redirect()->route('objects');
    }
    public function edit()
    {
        return redirect()->route('objects.edit', $this->object->id);
    }

    public function create()
    {
        return view('objects_create');
    }
    public function render()
    {
        return view('livewire.object-component');
    }
}
