@props(['label', 'name', 'type' => 'text', 'required' => false, 'placeholder' => ''])

<label class="rd-field">
    <span>{{ $label }}</span>
    @if($type === 'textarea')
        <textarea name="{{ $name }}" @if($required) required @endif placeholder="{{ $placeholder }}" rows="5"></textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" @if($required) required @endif placeholder="{{ $placeholder }}">
    @endif
    <div class="form_error">
        @error($name)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</label>
