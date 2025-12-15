<x-guest-layout>

    <style>
        /* ============================
           COFFEE SHOP LOGIN THEME ☕
           (Responsive + Animated)
        ============================ */

        body {
            background: #f6f3f1ff;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-height: 100vh;
            animation: fadeIn 1.2s ease-in-out;
        }

        /* Main animated login container */
        .coffee-overlay {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(6px);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.9s ease-out;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(35px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes buttonPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.04); }
            100% { transform: scale(1); }
        }

        /* Headers */
        .coffee-title {
            font-size: 28px;
            font-weight: 800;
            color: #4b2e15;
            text-align: center;
            margin-bottom: 10px;
        }

        .coffee-subtitle {
            text-align: center;
            color: #6c584c;
            margin-bottom: 25px;
        }

        /* Input fields */
        input[type="email"],
        input[type="password"] {
            background: #fffdfc;
            border: 1px solid #d9c5b4;
            border-radius: 10px;
            padding: 12px;
            transition: 0.2s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #c4a484;
            box-shadow: 0 0 6px rgba(153, 102, 51, 0.3);
            transform: scale(1.02);
        }

        /* Buttons */
        .btn-coffee {
            background: linear-gradient(135deg, #6f4436, #4b2e15);
            color: white;
            font-weight: 700;
            padding: 12px 20px;
            border-radius: 12px;
            transition: 0.25s;
            box-shadow: 0 4px 12px rgba(75,46,21,0.3);
            animation: buttonPulse 2.5s infinite ease-in-out;
        }

        .btn-coffee:hover {
            background: #3a2311;
            transform: translateY(-2px) scale(1.03);
        }

        /* Links */
        .coffee-link {
            color: #6f4e37;
            font-weight: 600;
        }

        .coffee-link:hover {
            color: #4b2e15;
            transform: scale(1.03);
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .coffee-overlay {
                padding: 25px;
                margin-top: 20px;
            }

            .coffee-title {
                font-size: 24px;
            }

            .btn-coffee {
                width: 100%;
                margin-top: 15px;
            }

            .flex {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>

    <div class="coffee-overlay">
        <h2 class="coffee-title">☕ Welcome</h2>
        <p class="coffee-subtitle">Login your Account</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full"
                    type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password" name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-brown-700"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-between items-center mt-6">

                <div class="flex flex-col">
                    @if (Route::has('password.request'))
                        <a class="coffee-link text-sm underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <a class="coffee-link text-sm underline mt-1" href="{{ route('register') }}">
                        {{ __('Register here') }}
                    </a>
                </div>

                <button class="btn-coffee">
                    {{ __('Log in') }}
                </button>

            </div>

        </form>
    </div>

</x-guest-layout>
