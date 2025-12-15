<x-guest-layout>

    <style>
        /* ============================
           COFFEE SHOP REGISTER THEME ☕
           Responsive + Animated
        ============================ */

        body {
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

        /* Fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Card animation */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Main Card */
        .coffee-card {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(6px);
            border-radius: 20px;
            padding: 35px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            animation: slideUp 1s ease-out;
        }

        .card-title {
            font-size: 30px;
            font-weight: 800;
            text-align: center;
            color: #4b2e15;
            margin-bottom: 10px;
        }

        .card-subtitle {
            text-align: center;
            color: #6c584c;
            margin-bottom: 25px;
        }

        /* Inputs */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            background: #fffdfc;
            border: 1px solid #d9c5b4;
            border-radius: 10px;
            padding: 12px;
            transition: 0.25s ease;
        }

        input:focus {
            border-color: #c4a484;
            box-shadow: 0 0 6px rgba(153, 102, 51, 0.3);
            transform: scale(1.02);
        }

        /* Button */
        .btn-register {
            background: linear-gradient(135deg, #6f4436, #4b2e15);
            color: white;
            font-weight: 700;
            padding: 12px 20px;
            border-radius: 12px;
            transition: 0.3s ease;
            box-shadow: 0 4px 12px rgba(75,46,21,0.3);
        }

        .btn-register:hover {
            background: #3a2311;
            transform: translateY(-2px) scale(1.03);
        }

        /* Link */
        .coffee-link {
            color: #6f4e37;
            font-weight: 600;
        }

        .coffee-link:hover {
            color: #4b2e15;
        }

        /* =====================
           RESPONSIVE DESIGN
        ===================== */
        @media (max-width: 480px) {
            .coffee-card {
                padding: 25px;
            }

            .card-title {
                font-size: 26px;
            }

            .btn-register {
                width: 100%;
                margin-top: 15px;
            }

            .flex {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>

    <div class="coffee-card">
        <h2 class="card-title">Create an Account ☕</h2>
        <p class="card-subtitle">Join our Coffee Shop Community</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full"
                    type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full"
                    type="email" name="email"
                    :value="old('email')" required autocomplete="username" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password"
                    name="password" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                    type="password" name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="coffee-link underline text-sm" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button class="btn-register">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>

</x-guest-layout>
