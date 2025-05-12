<div class="item-content mb-2">
    <div class="content">
        @if (!empty($id))
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="item[]" value="{{ $id }}">
        </div>
        @endif
        <img src="{{ $image }}" class="img-product" alt="{{ $product }}" />
        <div class="title">{{ $product }}</div>
        <div class="color">
            <div class="title-color">Cor</div>
            <div class="show-color" style="background-color: {{ $color }}"></div>
        </div>
        <div class="size">
            <div class="title-size">Tamanho</div>
            <div class="show-size">{{ $size }}</div>
        </div>
        <div class="grid">
            <div class="title-grid">Grade</div>
            <div class="show-grid">{{ $grid }}</div>
        </div>
    </div>

    @if (!empty($id))
    <div class="dados">
        <input type="text" placeholder="DIGITE A QUANTIDADE" class="form-control" />
        <a href="#" class="btn btn-sm">Remover</a>
    </div>
    @endif

</div>