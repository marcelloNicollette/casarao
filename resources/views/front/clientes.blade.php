<x-front-layout>
    <section class="section-inicio min-vh-100">
        <div class="container-fluid p-0">
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('/images/bg_topo.jpg') }}" class="img-fluid" alt="" />
                <div class="cta-logout btn position-absolute">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
                @if (session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif
                <form action="{{ route('colaborador.setCliente') }}" method="POST" class="text-center">
                    @csrf
                    <div class="list-clientes my-4 text-center">
                        <select class="form-select" name="cliente_id" id="cliente_id">
                            <option value="">Selecione o cliente a ser atendido</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->razao_social }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="d-flex mt-3 justify-content-center">
                        <button type="submit" class="btn btn-warning fw-bold text-white btn-lg">Selecionar
                            Cliente</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
</x-front-layout>
