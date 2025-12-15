<x-app-layout>
    <style>
        /* ===============================
            Coffee Shop Add Product Form
        =============================== */
        body {
            background: #f7f3ef;
            font-family: 'Poppins', sans-serif;
            color: #4b2e15;
        }

        .bg-white {
            background: #fffdfc;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .bg-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #4b2e15;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: #4b2e15;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border-radius: 10px;
            border: 1px solid #d9c5b4;
            background: #fffdfc;
            transition: 0.25s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #c4a484;
            box-shadow: 0 0 8px rgba(111, 68, 54, 0.3);
            outline: none;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        /* General Button Styles */
        button, .btn-back {
            font-weight: 700;
            border-radius: 10px;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            font-size: 1rem; /* Ensure consistent text size */
        }

        .btn-save {
            background: linear-gradient(135deg, #6f4436, #4b2e15);
            color: #fff;
        }

        .btn-save:hover {
            background: #3a2311;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 4px 12px rgba(75,46,21,0.3);
        }

        /* Updated Back Button Styles for <a> tag */
        .btn-back {
            background: #7e7e7e;
            color: #fff;
            display: inline-block; /* Required for <a> to behave like a button */
            text-decoration: none; /* Removes underline */
            text-align: center;
        }

        .btn-back:hover {
            background: #5e5e5e;
            color: #fff; /* Keeps text white on hover */
            transform: translateY(-1px);
        }

        .bg-red-100 {
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            color: #842029;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        @media (max-width: 640px) {
            .flex {
                flex-direction: column;
                gap: 12px;
            }
            .btn-back {
                width: 100%; /* Full width on mobile */
            }
        }
    </style>

    <x-slot name="header">
        <h2>Add New Coffee Item</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="bg-red-100">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="mb-4">
                        <label>Coffee Name</label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="mb-4">
                        <label>Description</label>
                        <textarea name="description"></textarea>
                    </div>

                    <div class="mb-4">
                        <label>Price (₱)</label>
                        <input type="number" step="0.01" name="price" **min="0"** required>
                    </div>

                    <div class="mb-4">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" required>
                            <option value="" disabled selected>Select Category</option>
                            
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>Product Image</label>
                        <input type="file" name="image">
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit" class="btn-save">Save Product</button>
                        
                        <a href="{{ route('admin.dashboard') }}" class="btn-back">
                            &larr; Go Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>