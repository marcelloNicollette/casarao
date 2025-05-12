<x-front-layout>
    <x-front-header />
  <style>
    .row{
        margin-left: 0px;
        margin-right: 0px;
    }
    .row_segmentacao{
      background: #fffef9;
      box-shadow: 0px 3px 5px #EEE;
    }
    .row_segmentacao img {
      float: left;
      padding: .5rem 1rem .5rem 5rem;
    }
    .row_segmentacao h1{
      color: #e41a18;
      font-size: 25px;
      padding: 1rem 1rem .5rem 5rem;
      font-weight: bold;
    }

    #home-slide .search:before {
        content: "";
        width: 30px;
        height: 30px;
        position: absolute;
        background: url(/images/icon-search.jpg) no-repeat center;
        background-size: contain;
        margin: 5px 0 0 -21px;
    }
    #buscar{
        margin: 15px 0 0 20px;
        border: 1px solid #CCC;
        width: 80%;
    }


.list-post {
    margin: 2rem 0 0rem;
    background: #F7F4F8;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 3px 6px #00000029;
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform: scale(1.2);
    transition: all .2s ease-out
}

.list-post.visible {
    opacity: 1;
    transform: scale(1)
}

.list-post .image {
    width: 100%;
    overflow: hidden;
    height: 230px
}

.list-post .image a {
    display: block;
    height: 100%
}

.list-post .image img {
    height: 100%;
    width: 100%;
    transition: transform .25s ease-in-out;
    -o-object-fit: cover;
    object-fit: cover;
    -o-object-position: center center;
    object-position: center center
}

.list-post .image img:hover {
    transform: scale(1.1)
}

.list-post .list-post-content {
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
    flex: 1
}

.list-post .list-post-content .list-post-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%
}

.list-post .list-post-content .list-post-header .tag {
    color: #a500b9;
    text-transform: uppercase;
    font-weight: 700
}

.list-post .list-post-content .list-post-header .date {
    color: #e41a18;
    font-size: 1.2rem;
    position: relative
}

.list-post .list-post-content .title {
    font-size: 1.25rem;
    line-height: 1.5rem;
    font-weight: 600;
    color: #000;
    text-decoration: none;
    flex: 1
}

.list-post.highlight {
    margin: 3rem 0
}

.list-post.highlight .image {
    max-height: none;
    border-radius: 30px;
    height: 100%
}

.list-post.highlight .list-post-content {
    height: 100%;
    gap: .75rem;
    align-items: flex-start
}

.list-post.highlight .list-post-content .title {
    font-size: 2.2rem;
    line-height: 2.45rem
}

.list-post.highlight .list-post-content .description {
    color: #5d5d69;
    font-size: 1rem;
    text-decoration: none
}

.list-post.highlight .list-post-content .description:hover {
    text-decoration: underline
}

.list-post.highlight .list-post-content a.link-post {
    font-size: 1rem
}
.list-all-post {
    display: grid;
    gap: 2rem;
    grid-template-columns: 1fr 1fr 1fr;
    margin-bottom: 3rem;
}
  </style>
    <section id="home-slide">
      <div class="row row_segmentacao">
        <div class="col-8">
          <img src="/images/icone-chinelo.jpg">
         <h1>Comunicado(s)</h1>
        </div>
        <div class="col-lg-4">
            <form action="https://www.cashin.com.br/blog/search" class="search">
                <input type="text" name="buscar" class="form-control" id="buscar" placeholder="Pesquisar">
            </form>
        </div>
      </div>
      <div class="container">
        <div class="list-post highlight visible">
            @foreach($comunicado_destaque as $destaque)
            <div class="row">
                <div class="col-lg-6">
                    <div class="image">
                            <picture>
                                <source type="image/webp" srcset="/storage/{{ $destaque->imagem_webp }}">
                                    <source type="image/jpeg" srcset="/storage/{{ $destaque->imagem }}">
                                    <img loading="lazy" src="/storage/{{ $destaque->imagem }}" class="img-responsive" alt="{{ $destaque->title }}">
                            </picture>
                    </div>
                </div>
                <div class="col-lg-6">
                    
                    <div class="list-post-content">
                        <div class="list-post-header">
                            <!-- <div class="tag">Cashin na Mídia</div> -->
                            <div class="date">{{ \Carbon\Carbon::parse($destaque->data_noticia)->format('d/m/Y') }}</div>
                        </div>
                        <p class="title">{{ $destaque->title }}</p>
                        <p>{!! $destaque->conteudo !!}</p>
                    
                    </div>

                </div>
            </div>
            @endforeach
        </div>    
        <div id="list-all-post" class="list-all-post">
            <!-- item da lista de comunicado -->
            @foreach($comunicados as $comunicado)
                <div class="list-post list visible">
                    <div class="image">
                        
                            <picture>
                                <source type="image/webp" srcset="/storage/{{ $comunicado->imagem_webp }}">
                                    <source type="image/jpeg" srcset="/storage/{{ $comunicado->imagem }}">
                                    <img loading="lazy" src="/storage/{{ $comunicado->imagem }}" class="img-responsive" alt="{{ $comunicado->title }}">
                            </picture>
                        
                    </div>
                
                    <div class="list-post-content">
                        <div class="list-post-header">
                            <!-- <div class="tag">Novidades</div> -->
                            <div class="date">{{ \Carbon\Carbon::parse($comunicado->data_noticia)->format('d/m/Y') }}</div>
                            
                        </div>

                        <p class="title">{{ $comunicado->title }}</p>
                        <p>{!! $comunicado->conteudo !!}</p>
                        
                    </div>

                </div>
                @endforeach
                <!-- fim item comunicado -->               
                                             
        </div>

        
    </div>
    </section>

  </x-front-layout>