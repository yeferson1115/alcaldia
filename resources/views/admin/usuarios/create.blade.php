@extends('layouts.app')

@section('title', 'Usuarios')
@section('page_title', 'Usuarios')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Nuevo usuario</h2>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Crear Usuario</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" action="javascript:void(0)" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('user') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                            <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombres</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombres">
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="last_name">Apellidos</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Apellidos">
                                        <span class="missing_alert text-danger" id="last_name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Género</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="M" checked="">
                                                <label class="form-check-label" for="inlineRadio1">Masculino</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="F">
                                                <label class="form-check-label" for="inlineRadio2">Femenino</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="username">Usuario para el sistema</label>
                                        <input type="text"id="username" name="username" class="form-control"  placeholder="Usuario">
                                        <span class="missing_alert text-danger" id="username_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico">
                                        <span class="missing_alert text-danger" id="email_alert"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Tipo de usuario</label>
                                        <div class="demo-inline-spacing">
                                            <input type="hidden" value="{{$roles = Spatie\Permission\Models\Role::get()}}">
                                            @foreach ($roles as $role)
                                            @if($role->name!='Scaneer')
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="role" id="role{{ $role->id }}" value="{{ $role->name }}">
                                                <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
                                            </div>
                                            @endif
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="password">Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                                            <button type="button" class="btn btn-outline-secondary" id="toggle-password" style="cursor: pointer;">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        <span class="missing_alert text-danger" id="password_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña">
                                            <button type="button" class="btn btn-outline-secondary" id="toggle-password-confirm" style="cursor: pointer;">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        <span class="missing_alert text-danger" id="password_confirmation_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Acceso al sistema</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status1" value="1">
                                                <label class="form-check-label" for="status1">Activo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status2" value="0">
                                                <label class="form-check-label" for="status2">Inactivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" style="margin-right: 10px;" class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
  
    <script src="{{ asset('js/admin/user/create.js') }}"></script>

    <!-- Add the JavaScript for the Show/Hide Password functionality -->
    <script>
        // Toggle password visibility for the 'Contraseña' field
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');

            // Toggle password visibility
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        });

        // Toggle password visibility for the 'Confirmar Contraseña' field
        document.getElementById('toggle-password-confirm').addEventListener('click', function () {
            const confirmPasswordField = document.getElementById('password_confirmation');
            const toggleIconConfirm = document.getElementById('toggle-icon-confirm');

            // Toggle password visibility
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                toggleIconConfirm.classList.remove('bi-eye-slash');
                toggleIconConfirm.classList.add('bi-eye');
            } else {
                confirmPasswordField.type = 'password';
                toggleIconConfirm.classList.remove('bi-eye');
                toggleIconConfirm.classList.add('bi-eye-slash');
            }
        });
    </script>
@endpush

