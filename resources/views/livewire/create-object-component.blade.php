<div class="container-fluid">
    <form wire:submit.prevent="submit">
        <!-- Поле ввода Name -->
        <div class="row mb-3 align-items-center">
            <div class="col-2">
                <label class="form-label" for="name">Name</label>
            </div>
            <div class="col-10">
                <input id="name" class="form-control" type="text" wire:model="name"/>
            </div>
        </div>

        <!-- Поля выбора и связанные с ними текстовые поля -->
        @foreach ($selects as $index => $select)
            <div class="row mb-3 align-items-center">
                <div class="col-2">
                    <label class="form-label">Field {{ $index + 1 }}</label>
                </div>
                <div class="col-8">
                    <select class="form-control" wire:model.live="selects.{{ $index }}">
                        <option value="">Select a field type</option>
                        @foreach(['object', 'value', 'pattern'] as $type)
                            <option value="{{$type}}">{{Str::ucfirst($type)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger w-100" wire:click="removeSelect({{ $index }})">
                        Delete
                    </button>
                </div>
            </div>

            <!-- Отображаем дополнительные поля в зависимости от выбранного типа -->
            @if (explode('_', $select)[0] == 'object')
                <!-- Поля для опции 'object' -->
                <div class="row mb-3 align-items-center">
                    <div class="col-2">
                        <label class="form-label">Object name</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control mb-2" wire:model.live="inputs.{{ $index }}.0"
                               placeholder="Enter object name">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Object type</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" wire:model.live="inputs.{{ $index }}.1">
                            <option value="">Select an object type</option>
                            @foreach(auth()->user()->endpointObjects as $object)
                                @if($object->name != $name)
                                    <option value="{{ $object->id }}">{{ Str::ucfirst($object->name) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            @elseif (explode('_', $select)[0] == 'value')
                <!-- Поля для опции 'value' -->
                <div class="row mb-3 align-items-center">
                    <div class="col-2">
                        <label class="form-label">Name</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control mb-2" wire:model="inputs.{{ $index }}.0"
                               placeholder="Enter name">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Value</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control mb-2" wire:model="inputs.{{ $index }}.1"
                               placeholder="Enter value">
                    </div>
                </div>
            @elseif (explode('_', $select)[0] == 'pattern')
                <!-- Поля для опции 'mask' -->
                <div class="row mb-3 align-items-center">
                    <div class="col-2">
                        <label class="form-label">Field name</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control mb-2" wire:model.live="inputs.{{ $index }}.0"
                               placeholder="Enter field name">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Pattern</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" wire:model.live="inputs.{{ $index }}.1">
                            <option value="">Select a pattern</option>
                            @foreach(\App\Helpers\FakerHelper::patterns() as $pattern)
                                <option value="{{$pattern}}">{{Str::ucfirst($pattern)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Кнопка для добавления нового выбора -->
        <div class="mb-3 row">
            <div class="offset-4 col-4">
                <button type="button" class="btn btn-primary w-100" wire:click="addSelect">
                    Add new field
                </button>
            </div>
        </div>

        <!-- Кнопка отправки формы -->
        <button type="submit" class="btn btn-success w-100">Save object</button>
    </form>
</div>
