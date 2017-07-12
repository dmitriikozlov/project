{{ round($price) }}.<i>
    @if(($price - round($price)) == 0)
        00
    @elseif(($price - round($price)) < 10)
        0{{ $price - round($price) }}
    @else
        {{ $price - round($price) }}
    @endif
</i>