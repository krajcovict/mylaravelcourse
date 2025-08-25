@php
    $year = date('Y');
@endphp

<select name="year">
    <option value="">Year</option>
    @for ($i = $year; $i >= 1970; $i--)
        <option value="{{ $i }}">{{ $i }}
            @if ($i == 1970)
                 or older
            @endif
        </option>
    @endfor
</select>
