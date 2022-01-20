<section class="ftco-section">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-12 col-lg-10">
                @error('message') <span class="error"><div class="alert alert-warning" role="alert">
                    {{ $message }}
                  </div> @enderror
                <div class="wrap d-md-flex">
                    <div class="img"
                        style="background-image: url(https://www.creativografico.dev/webAOA/wp-content/uploads/2019/10/fondo-intranet-AOA-Colombia.jpg);">
                    </div>
                   

                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Call Center AOA</h3>
                            </div>
                        </div>
                        <form method="get" action="{{route('login.auth')}}" class="signin-form">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="label" for="name">Usuario</label>
                                <input type="text" name="usuario" class="form-control"  required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="password">Contraseña</label>
                                <input type="password" name="clave" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Iniciar Sesion</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>