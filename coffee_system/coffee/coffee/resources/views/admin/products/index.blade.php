<x-app-layout>
    <style>
        /* ===========================
           Classic Coffee Shop Admin
        ============================ */
        body { background: #f7f3ef; font-family: 'Poppins', sans-serif; color: #4b2e15; }
        
        .bg-white { 
            background: #fffdfc; 
            border-radius: 15px; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); 
            overflow-x: auto; 
        }

        table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 0.95rem; }
        th, td { padding: 12px 15px; text-align: left; vertical-align: middle; }
        
        /* Header Styling */
        th { 
            background: #e6d8c3; 
            color: #4b2e15; 
            font-weight: 700; 
            text-transform: uppercase; 
            border-bottom: 2px solid #d9c5b4; 
        }

        tbody tr:hover { background: #fff3e6; transform: translateX(3px); transition: 0.3s; }

        /* --- BUTTON STYLES --- */
        .btn { 
            font-weight: 600; 
            border-radius: 8px; 
            padding: 6px 12px; 
            border: none; 
            cursor: pointer; 
            transition: all 0.25s ease;
            font-size: 0.9rem;
        }

        .btn-edit { background: #4b2e15; color: #fff; }
        .btn-edit:hover { background: #6f4436; }

        .btn-delete { background: #c0392b; color: #fff; }
        .btn-delete:hover { background: #e74c3c; }

        .btn-toggle-enabled { background: #27ae60; color: #fff; }
        .btn-toggle-disabled { background: #c0392b; color: #fff; }

        .btn-add { 
            background: #4b2e15; color: #fff; padding: 8px 16px; 
            border-radius: 10px; font-weight: 700; text-decoration: none; display: inline-block; 
        }
        
        .btn-back { 
            background: #7e7e7e; color: #fff; padding: 10px 20px; 
            border-radius: 10px; text-decoration: none; display: inline-block; 
        }

        .alert-success { 
            background: #d4edda; border: 1px solid #c3e6cb; color: #155724; 
            border-radius: 8px; padding: 10px 15px; margin-bottom: 20px; 
        }

        /* --- FLEX UTILITIES --- */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 0.5rem; }

        @media (max-width: 640px) {
            .flex { flex-direction: column; gap: 10px; }
            .btn { width: 100%; }
        }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Coffee Inventory') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="btn-add">+ Add New Product</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Actions</th>
                                <th>Status</th> </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr class="border-b">
                                <td class="p-3">
                                    @if($product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" class="w-16 h-16 object-cover rounded">
                                    @else
                                    <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>

                                <td class="p-3 font-bold">{{ $product->name }}</td>

                                <td class="p-3 text-sm text-gray-600">{{ Str::limit($product->description, 30) }}</td>

                                <td class="p-3">
                                    <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-semibold">
                                        {{ $product->categoryData->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="p-3 text-green-700 font-bold">₱{{ number_format($product->price, 2) }}</td>

                                <td class="p-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-edit" style="text-decoration:none;">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this coffee?');" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </td>

                                <td class="p-3">
                                    <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn {{ $product->status ? 'btn-toggle-enabled' : 'btn-toggle-disabled' }}" style="min-width: 80px;">
                                            {{ $product->status ? 'Enabled' : 'Disabled' }}
                                        </button>
                                    </form>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-500">
                                    No coffee products found. Add your first item to get started!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.dashboard') }}" class="btn-back">
                    &larr; Go Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>