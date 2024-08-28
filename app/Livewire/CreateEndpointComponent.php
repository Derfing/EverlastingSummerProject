<?php

namespace App\Livewire;

use App\Models\Endpoint;
use Livewire\Component;

class CreateEndpointComponent extends Component
{
    public $name;
    public $method;
    public $selects = []; // Массив для хранения значений полей выбора
    public $inputs = [];  // Массив для хранения значений текстовых полей

    public function mount()
    {
        // Инициализируем первый выбор и связанные поля
        $this->addSelect();
    }

    public function addSelect()
    {
        // Добавляем новое поле выбора с пустым значением
        $this->selects[] = '';
    }

    public function removeSelect($index)
    {
        // Удаляем поле выбора и связанные с ним текстовые поля
        unset($this->selects[$index]);
        unset($this->inputs[$index]);
    }

    public function updatedSelects($value, $key)
    {
        // Если выбран 'b', добавляем два текстовых поля для этого выбора
        if ($value == 'Number' || $value == 'String') {
            $this->inputs[$key] = ['', '']; // Два текстовых поля для конкретного выбора
        } else {
            // Если выбран не 'b', очищаем текстовые поля
            unset($this->inputs[$key]);
        }
        $this->render();
    }

    public function submit()
    {
        // Логика обработки формы, например, валидация и сохранение
        $this->validate([
            'name' => 'required|string|max:255',
            'method' => 'required|string|max:255',
            'selects.*' => 'required|string', // Валидация для каждого выбора
            'inputs.*.*' => 'nullable|string', // Валидация для текстовых полей
        ]);

        $result = [];

        foreach ($this->selects as $index => $select) {
            $result[$select] = data_get($this->inputs, $index);
        }

        $endpoint = new Endpoint();

        $endpoint->name = $this->name;
        $endpoint->method = $this->method;
        $endpoint->url = config('app.url') . '/api/v0/' . auth()->user()->name . '/' . $this->name;
        $endpoint->data = json_encode($result);
        $endpoint->user_id = auth()->user()->id;

        $endpoint->save();

        return redirect()->route('endpoints');
    }

    public function render()
    {
        return view('livewire.create-endpoint-component');
    }
}
