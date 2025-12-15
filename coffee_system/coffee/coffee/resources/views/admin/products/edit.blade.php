<x-app-layout>
    <style>
        /* ==============================
           Classic Coffee Shop Edit Form
        =============================== */
        body {
            font-family: 'Georgia', serif;
            background: #f3ece5 url('https://www.transparenttextures.com/patterns/cream-paper.png') repeat;
            color: #4b2e15;
        }

        .bg-white {
            background: linear-gradient(145deg, #fff8f0, #f7eee5);
            border: 1px solid #e0d6c3;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .bg-white:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        /* Error Alert Styling */
        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            color: #842029;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        h2 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #4b2e15;
            margin-bottom: 1.5rem;
        }

        label {
            font-weight: bold;
            color: #4b2e15;
            display: block;
            margin-bottom: 0.5rem;
        }

        /* UPDATED: Added 'select' to the list of styled inputs */
        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #d1c4b1;
            border-radius: 12px;
            margin-bottom: 1rem;
            background: #fffdfc;
            font-weight: bold;
            transition: 0.3s;
        }

        /* UPDATED: Added select:focus */
        input:focus, textarea:focus, select:focus {
            border-color: #c4a484;
            box-shadow: 0 0 8px rgba(111, 68, 54, 0.3);
            outline: none;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        button, .btn-back {
            display: inline-block;
            font-weight: bold;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .btn-update {
            background: linear-gradient(135deg, #6f4436, #4b2e15);
            color: #fff;
            flex: 1;
        }

        .btn-update:hover {
            background: linear-gradient(135deg, #4b2e15, #6f4436);
            transform: scale(1.03);
        }

        .btn-back {
            background: #a47149;
            color: #fff;
            flex: 1;
        }

        .btn-back:hover {
            background: #6b4226;
            color: #fff;
            transform: scale(1.03);
        }

        .text-xs {
            font-size: 0.75rem;
            color: #7a5c44;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        @media (max-width: 640px) {
            .button-group { flex-direction: column; }
            .btn-update, .btn-back { width: 100%; }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-coffee-dark leading-tight text-center md:text-left">
            Edit Coffee Item: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                
                @if ($errors->any())
                    <div class="alert-error">
                        <strong>Whoops! Something went wrong:</strong>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label>Coffee Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label>Description</label>
                        <textarea name="description">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label>Price ($)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" required>
                            <option value="" disabled>Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>  

                    <div class="mb-4">
                        <label>Product Image (Leave blank to keep current)</label>
                        <input type="file" name="image">
                        <p class="text-xs mt-1">Current path: {{ $product->image }}</p>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-update">Update Product</button>

                        <a href="{{ route('admin.products.index') }}" class="btn-back">
                            &larr; Go Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>