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

        <!-- Поле ввода Method -->
        <div class="row mb-3 align-items-center">
            <div class="col-2">
                <label class="form-label" for="method">Method</label>
            </div>
            <div class="col-10">
                <input id="method" class="form-control" type="text" wire:model="method"/>
            </div>
        </div>

        <!-- Поля выбора и связанные с ними текстовые поля -->
        @foreach ($selects as $index => $select)
            <div class="row mb-3 align-items-center">
                <div class="col-2">
                    <label class="form-label">Field {{ $index + 1 }}</label>
                </div>
                <div class="col-8">
                    <select class="form-control px-1" wire:model.live="selects.{{ $index }}">
                        <option value="">Select a field type</option>
                        @foreach(\App\Helpers\FakerHelper::fieldTypes() as $type)
                            <option value="{{$type}}">{{Str::ucfirst($type)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <div class="btn btn-danger w-100" wire:click="removeSelect({{ $index }})">
                        Delete
                    </div>
                </div>
            </div>

            <!-- Если выбрана опция 'b', отображаем два текстовых поля -->
            @if (isset($inputs[$index]))
                <div class="row mb-3 align-items-center">
                    <div class="col-1">
                        <label class="form-label">Name</label>
                    </div>
                    <div class="col-5">
                        <input type="text" class="form-control mb-2" wire:model="inputs.{{ $index }}.0" placeholder="name">
                    </div>
                    <div class="col-1">
                        <label class="form-label">Data</label>
                    </div>
                    <div class="col-5">
                        <input type="text" class="form-control mb-2" wire:model="inputs.{{ $index }}.1" placeholder="data">
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Кнопка для добавления нового выбора -->
        <div class="mb-3 row">
            <div class="btn btn-primary offset-4 col-4" wire:click="addSelect">
                Add new field
            </div>
        </div>

        <!-- Кнопка отправки формы -->
        <button type="submit" class="btn btn-success w-100">Save endpoint</button>
    </form>
</div>
