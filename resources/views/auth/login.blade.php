<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-6">
                <a href="/" class="app-brand-link">
                    <img style="width: 200px !important;" src="{{ asset('assets/img/logo.png') }}"/>  
                </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">Bienvenido(a) a SAAS Empresas!</h4>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="username" class="form-label" :value="__('Usuario')" />
                    <x-text-input id="username" class="form-control" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" class="form-label" :value="__('Contraseña')" />

                    <div class="input-group">
                        <x-text-input id="password" class="form-control"
                                      type="password"
                                      name="password"
                                      required autocomplete="current-password" />
                        <button type="button" class="btn btn-outline-secondary" id="toggle-password" style="cursor: pointer;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2 " />
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <!--<a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>-->
                    @endif
                    <div class="d-flex justify-content-center">
                        <x-primary-button class="ms-3">
                        <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right: 10px;"></i> {{ __('Ingresar') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>              
        </div>
    </div>

    <!-- JavaScript to toggle password visibility -->
    <script>
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
    </script>
</x-guest-layout>
