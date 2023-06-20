@php
    $status = $status ?? false;
    $link = $link ?? false;
    $tag = $link ? 'a' : 'span';
    $fill = $status ? 'fill-red-500' : 'fill-green-500';
@endphp
<{{ $tag }} @if($link) href="{{ $link }}" title="Toggle" @endif class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-900 ring-1 ring-inset ring-gray-200">
    <svg class="h-1.5 w-1.5 {{ $fill }}" viewBox="0 0 6 6" aria-hidden="true">
        <circle cx="3" cy="3" r="3" />
    </svg>
    {{ $trueLabel ?? 'Active' }}
</{{ $tag }}>
