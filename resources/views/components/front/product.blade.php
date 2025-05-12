<div class="product position-relative shadow-sm bg-white p-3 rounded-3" data-id="{{ $id }}"
    data-slug="{{ $slug }}">

    <style>

    </style>

    <div class="product-card">
        <div class="product-image">
            @if ($images)
                <img src="{{ $images[0] }}" alt="{{ $title }}">
            @else
                <img src="{{ asset('/images/logo.png') }}" alt="Logo Casarão" class="logo">
            @endif

        </div>


        <div class="product-name">
            {{ $title }}
        </div>
        <!--<div class="product-title">
            {{ $description }}
        </div>-->
        <div class="product-title">
            {{ "R$ " . number_format($price, 2, ',', '.') . ' / ' . strtolower($unidade) }}
        </div>


        <div class="d-flex align-items-center justify-content-center">

            <button class="quantity-btn rounded decrement-btn">
                <i class="fas fa-minus"></i>
            </button>
            <div class="quantity-display">
                0
            </div>
            <button class="quantity-btn rounded increment-btn">
                <i class="fas fa-plus"></i>
            </button>


            <button class="add-to-cart" id="">
                <i class="fas fa-cart-plus cart-icon"></i>
            </button>

            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="title" value="{{ $title }}">
            <input type="hidden" name="price" value="{{ $price }}">
            <input type="hidden" name="quantidade" value="0">
            <input type="hidden" name="image" value="">
        </div>
    </div>


</div>

@section('scripts')
@endsection
