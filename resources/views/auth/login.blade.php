<x-guest-layout>
    @section('title', 'Log in')

    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-box {
            margin-top: 5%;
        }

        .login-logo img {
            width: 80px;
            height: auto;
        }

        .card-primary.card-outline {
            border-top: 3px solid #007bff;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 20px;
        }

        .form-control {
            border-radius: 20px;
        }

        .login-box-msg {
            font-weight: 600;
            font-size: 18px;
        }
    </style>

    <div class="login-box">
        <div class="card card-outline card-primary shadow">
            <div class="card-header text-center">
                <div class="login-logo">
                    <img src="{{ asset('images/emed-logo.png') }}" alt="EMR Logo"> {{-- Replace with your logo --}}
                </div>
                <a href="/" class="h1 text-primary"><b>{{ config('app.name', 'e-Medical Record') }}</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Welcome back! Please sign in to your account</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                            required autofocus placeholder="Email address">
                        <div class="input-group-append">
                            <div class="input-group-text bg-white">
                                <span class="fas fa-envelope text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="text-danger mb-2" />

                    <div class="input-group mb-3">
                        <input id="password" class="form-control" type="password" name="password" required
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text bg-white">
                                <span class="fas fa-lock text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-danger mb-2" />

                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4 text-right">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>

                {{-- Optional: Social login --}}
                {{-- <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="{{ route('google.login') }}" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in with Google
                    </a>
                </div> --}}

                <p class="mb-1 text-center">
                    {{-- <a href="{{ route('password.request') }}">Forgot your password?</a> --}}
                </p>
                <p class="mb-0 text-center">
                    <a href="{{ route('register') }}" class="text-primary">Create a new account</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
