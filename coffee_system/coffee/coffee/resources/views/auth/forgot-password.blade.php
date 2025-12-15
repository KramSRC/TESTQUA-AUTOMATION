<x-guest-layout>

    <style>
        /* ===== Coffee Aesthetic Theme ===== */
        body {
            background: #f3ebe3;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            border: 1px solid #e0d6cf;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 30px;
            width: 100%;
            max-width: 420px;
            animation: fadeIn .9s ease-in-out;
        }

        .auth-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #4b2e1e;
            text-align: center;
            margin-bottom: 5px;
        }

        .auth-subtext {
            font-size: 0.9rem;
            color: #6d5446;
            text-align: center;
            margin-bottom: 20px;
        }

        .coffee-btn {
            background: #b58863;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            transition: .3s;
        }

        .coffee-btn:hover {
            background: #a06f4d;
        }

        .back-btn {
            background: #7d6b61;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            transition: .3s;
        }

        .back-btn:hover {
            background: #5c4d45;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="auth-card mx-auto mt-10">
        <h2 class="auth-title">Forgot Password?</h2>
        <p class="auth-subtext">
            Don’t worry — enter your email and we'll send you a reset link.
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email"
                              name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex justify-between items-center mt-4">
                <x-primary-button class="coffee-btn">
                    {{ __('Send Reset Link') }}
                </x-primary-button>

                <button type="button" onclick="window.history.back()" class="back-btn text-sm">
                    &larr; Back
                </button>
            </div>
        </form>
    </div>

</x-guest-layout>
