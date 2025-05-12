<div class="clearProduct position-relative shadow-sm bg-white p-3 rounded-3" data-id="{{ $id }}" data-categories="{{ $categories }}" data-slug="{{ $slug }}">
  

  <div class="list-data d-flex flex-column gap-2">
    <div class="images-product position-relative">
      <div class="swiper">
        <div class="swiper-wrapper">
          @foreach ($images as $image)
          <div class="swiper-slide" style="min-height: 14.2rem;" data-id-color="{{ $image['id'] }}">
            @if ($image['ec'] == 1)
            <img class="imgEC" id="imgEC" src="http://127.0.0.1:8000/images/img-ec.jpg" alt="">
            @endif
            <a href="{{ route('front.produto', $slug ) }}"><img src="{{ asset($image['image']) }}" class="img-fluid mt-4" alt="" /></a>
          </div>
          @endforeach
        </div>
      </div>

      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>

    <div class="name-product text-primary">
      {{ $title }}
    </div>
  </div>
</div>