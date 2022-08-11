@props(['tags','isUtilities'])

<ul class = "unordered-tags-list">
    @foreach($tags as $tag)
        <li class="tags-list-item">
            @if($isUtilities)
                <a href="/shop/all?type=all&utilities={{$tag}}">
                    {{$tag}}
                </a>
            @else
                <a href="/shop/all?type=all&tags={{$tag}}">
                    {{$tag}}
                </a>
            @endif
        </li>
    @endforeach
</ul> 