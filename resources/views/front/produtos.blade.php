<x-front-layout>

    <x-front-header />

    <div class="container" id="show-product">
        <div class="row">



            <div class="col-md-12">
                <div class="list-products d-grid my-5 gap-3">

                    @foreach ($produtos->products as $product)
                        @php
                            if ($product->image) {
                                $imagem = [$product->image];
                            } else {
                                $imagem = [];
                            }
                        @endphp
                        <x-front-product price="{{ $product->pivot->price }}" unidade="{{ $product->unidade }}"
                            id="{{ $product->id }}" title="{{ $product->title }}"
                            description="{{ $product->description }}" :images="$imagem" :slug="$product->title" />
                    @endforeach

                </div>
            </div>

        </div>
    </div>

</x-front-layout>
