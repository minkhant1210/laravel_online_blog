<div>
    <p {{ $attributes->merge(['class' => 'alert '.$class]) }}>
        {{ $slot }}
        @if($removeBtn())
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @endif
        {{ $showDateTime() }}
    </p>
</div>
