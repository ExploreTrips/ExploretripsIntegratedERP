@if($customFields)
    @foreach($customFields as $customField)
        @php
            $inputName = "customField[{$customField->id}]";
            $inputId = "customField-{$customField->id}";
        @endphp

        @if($customField->type == 'text')
            <div class="form-group">
                <label for="{{ $inputId }}" class="form-label">{{ __($customField->name) }}</label>
                <div class="input-group">
                    <input type="text" name="{{ $inputName }}" id="{{ $inputId }}" class="form-control">
                </div>
            </div>
        @elseif($customField->type == 'email')
            <div class="form-group">
                <label for="{{ $inputId }}" class="form-label">{{ __($customField->name) }}</label>
                <div class="input-group">
                    <input type="email" name="{{ $inputName }}" id="{{ $inputId }}" class="form-control">
                </div>
            </div>
        @elseif($customField->type == 'number')
            <div class="form-group">
                <label for="{{ $inputId }}" class="form-label">{{ __($customField->name) }}</label>
                <div class="input-group">
                    <input type="number" name="{{ $inputName }}" id="{{ $inputId }}" class="form-control">
                </div>
            </div>
        @elseif($customField->type == 'date')
            <div class="form-group">
                <label for="{{ $inputId }}" class="form-label">{{ __($customField->name) }}</label>
                <div class="input-group">
                    <input type="date" name="{{ $inputName }}" id="{{ $inputId }}" class="form-control">
                </div>
            </div>
        @elseif($customField->type == 'textarea')
            <div class="form-group">
                <label for="{{ $inputId }}" class="form-label">{{ __($customField->name) }}</label>
                <div class="input-group">
                    <textarea name="{{ $inputName }}" id="{{ $inputId }}" class="form-control"></textarea>
                </div>
            </div>
        @endif
    @endforeach
@endif
