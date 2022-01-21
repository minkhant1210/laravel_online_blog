<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $inputTitle }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"

        @isset($value)
            value="{{ old($name,$value) }}"
        @else
            value="{{ old($name) }}"
        @endisset

        @isset($form)
            form = "{{ $form }}"
        @endisset

        class="form-control @error($name) is-invalid @enderror"
        required autofocus>
    @error($name)
    <small class="text-danger fw-bold"> {{ $message }}</small>
    @enderror
</div>
