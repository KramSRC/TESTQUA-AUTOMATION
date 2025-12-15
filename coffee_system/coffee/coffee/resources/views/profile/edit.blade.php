<x-app-layout>
    <style>
        /* ================================
           Profile Page - Modern Aesthetic
        ================================ */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f3ece5 url('https://www.transparenttextures.com/patterns/cream-paper.png') repeat;
            color: #4b2e15;
        }

        .bg-white {
            background: linear-gradient(145deg, #fff8f0, #f7eee5);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .bg-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        h2 {
            font-weight: 800;
            font-size: 1.8rem;
            color: #4b2e15;
        }

        .profile-section {
            padding: 2rem;
        }

        .profile-section label {
            font-weight: 600;
            color: #4b2e15;
        }

        .profile-section input,
        .profile-section textarea,
        .profile-section select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1c4b1;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 500;
            background: #fffdfc;
            transition: 0.25s;
        }

        .profile-section input:focus,
        .profile-section textarea:focus,
        .profile-section select:focus {
            border-color: #c4a484;
            box-shadow: 0 0 8px rgba(111,68,54,0.3);
            outline: none;
        }

        .btn {
            display: inline-block;
            font-weight: bold;
            text-transform: uppercase;
            padding: 0.5rem 1.2rem;
            border-radius: 12px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-back {
            background: #7e7e7e;
            color: #fff;
            margin-bottom: 1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-back:hover {
            background: #5e5e5e;
            transform: scale(1.03);
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            color: #fff;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #b91c1c, #ef4444);
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        @media (max-width: 768px) {
            .profile-section {
                padding: 1rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .btn {
                width: 100%;
                text-align: center;
                margin-bottom: 0.5rem;
            }
        }

        /* Card spacing */
        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-coffee-dark leading-tight text-center md:text-left">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Back to Dashboard Button -->
            <a href="{{ route('dashboard') }}" class="btn btn-back">&larr; Back to Dashboard</a>

            <div class="bg-white profile-section shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white profile-section shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white profile-section shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Another Back to Dashboard Button at bottom -->
            <a href="{{ route('dashboard') }}" class="btn btn-back">&larr; Back to Dashboard</a>

        </div>
    </div>
</x-app-layout>
