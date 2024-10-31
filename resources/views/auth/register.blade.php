
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"><!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Registro - Colegio Particular Mixto Shaddai</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background: linear-gradient(135deg, #0066cc 0%, #87CEEB 100%);
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }
                    .login-card {
                        background: white;
                        padding: 2rem;
                        border-radius: 8px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        width: 100%;
                        max-width: 400px;
                        border: 2px solid #FFD700;
                    }
                    h1 {
                        color: #0066cc;
                        text-align: center;
                        margin-bottom: 1rem;
                    }
                    h2 {
                        color: #0066cc;
                        text-align: center;
                        margin-bottom: 1.5rem;
                    }
                    .input-group {
                        margin-bottom: 1rem;
                    }
                    label {
                        display: block;
                        margin-bottom: 0.5rem;
                        color: #0066cc;
                    }
                    input[type="text"],
                    input[type="email"],
                    input[type="password"] {
                        width: 100%;
                        padding: 0.5rem;
                        border: 1px solid  #0000b3;
                        border-radius: 4px;
                        font-size: 1rem;
                    }
                    button {
                        width: 100%;
                        padding: 0.75rem;
                        background-color: #0066cc;
                        color: white;
                        border: none;
                        border-radius: 4px;
                        font-size: 1rem;
                        cursor: pointer;
                        transition: background-color 0.3s ease;
                    }
                    button:hover {
                        background-color: #004c99;
                    }
                    .links {
                        text-align: center;
                        margin-top: 1rem;
                    }
                    .links a {
                        color: #0000b3;
                        text-decoration: none;
                    }
                    .links a:hover {
                        text-decoration: underline;
                    }
                    .school-colors {
                        display: flex;
                        justify-content: center;
                        margin-bottom: 1rem;
                    }
                    .color-bar {
                        width: 25%;
                        height: 5px;
                    }
                    .blue { background-color: #0066cc; }
                    .yellow { background-color: #FFD700; }
                    .white { background-color: skyblue; }
                    .light-blue { background-color: #0000b3; }
                </style>
            </head>
            <body>
            <div class="login-card">
                <div class="school-colors">
                    <div class="color-bar blue"></div>
                    <div class="color-bar yellow"></div>
                    <div class="color-bar white"></div>
                    <div class="color-bar light-blue"></div>
                </div>

                <h2>Registro</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="input-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="links">
                    <p class="mt-3">
                        ¿Ya tienes una cuenta? <a href="/login">Iniciar Sesión</a>
                    </p>
                </div>
            </div>
            </body>
            </html>
        </div>
    </div>
</div>

