<div class="header {{ @$type }} navbar navbar-expand-xl navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('/images/logo.png') }}" alt="Logo Casarão" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05"
            aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample05">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="{{ url('/colaborador/produtos') }}"
                        class="nav-link {{ request()->is('/colaborador/produtos') ? 'active' : '' }}">Início</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/colaborador/meus-pedidos') }}"
                        class="nav-link {{ request()->is('/') ? 'active' : '' }}">Meus Pedidos</a>
                </li>
                <!--<li class="nav-item">
                    <a href="#" target="_blank" class="nav-link">Links Úteis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Ajuda</a>

                </li>-->

            </ul>

            <ul class="list-icons list-unstyled">

                <li class="dropdown">
                    <a href="#" class="link icon-user dropdown-toggle" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false"></a>
                    <div class="dropdown-menu">
                        <div class="row">
                            <div class="col-12">
                                <div class="user-detail d-flex gap-2">
                                    <div class="icon"></div>
                                    <div class="user-data text-body-secondary d-flex flex-column">
                                        <div class="name fs-4 lh-1 mb-1">{{ $user->name }}</div>
                                        <div class="email mb-2">{{ $user->email }}</div>


                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="btn btn-primary btn-sm text-white">Sair</a>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!--<li class="dropdown">
                    <a href="#" class="link icon-search dropdown-toggle" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false"></a>
                    <div class="dropdown-menu dropdown-large">

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group">
                                    <form action="/search" method="POST" style="width:100%">
                                        {{ csrf_field() }}
                                        <input style="width: 70%; float:left; margin-right:1rem" type="text"
                                            name="search" class="form-control border border-1">
                                        <button class="btn btn-primary text-white" type="submit">Buscar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>-->


                <li class="dropdown">
                    <a href="#" class="link icon-checkout dropdown-toggle" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false"><span
                            class="cta-number-whilistis">0</span></a>
                    <div class="dropdown-menu dropdown-large">

                        <div class="row">
                            <div class="col-12">

                                <div class="header-list-dropdown">
                                    <div class="title">
                                        <h6>Minha Sacola</h6>
                                        <!-- <div>Cliente X</div> -->
                                    </div>

                                    <div class="icons">
                                        <!--<a href="#" class="icon icon-xls">gerar planilha</a>-->
                                        <a href="#" id="gerar_pdf_sacola" class="icon icon-pdf">gerar pdf</a>
                                    </div>

                                    <form id="sacola_form" target="_blank" method="POST"
                                        action="{{ url('/export/pdf/checkout') }}" style="display: none">
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div id="checkout-content" class="content-dropdown-list">

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">
                                <a href="#" id="btn-finalizar-prepedido"
                                    class="btn btn-primary btn-sm text-white">Finalizar pré-pedido</a>
                            </div>
                        </div>

                    </div>
                </li>
            </ul>

        </div>
    </div>
</div>


@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
