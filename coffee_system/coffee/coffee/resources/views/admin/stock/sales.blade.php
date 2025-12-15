<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sales & Revenue</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="p-4 bg-green-100 rounded-lg shadow">
                    <h3 class="font-bold text-gray-700">Today's Sales</h3>
                    <p class="text-2xl text-green-700">₱{{ number_format($todaySales, 2) }}</p>
                </div>

                <div class="p-4 bg-blue-100 rounded-lg shadow">
                    <h3 class="font-bold text-gray-700">Weekly Revenue</h3>
                    <p class="text-2xl text-blue-700">₱{{ number_format($weeklyRevenue, 2) }}</p>
                </div>

                <div class="p-4 bg-purple-100 rounded-lg shadow">
                    <h3 class="font-bold text-gray-700">Monthly Revenue</h3>
                    <p class="text-2xl text-purple-700">₱{{ number_format($monthlyRevenue, 2) }}</p>
                </div>

                <div class="p-4 bg-yellow-100 rounded-lg shadow">
                    <h3 class="font-bold text-gray-700">Total Orders</h3>
                    <p class="text-2xl text-yellow-700">{{ $totalOrders }}</p>
                </div>

                <div class="p-4 bg-pink-100 rounded-lg shadow col-span-full">
                    <h3 class="font-bold text-gray-700">Average Order Value</h3>
                    <p class="text-2xl text-pink-700">₱{{ number_format($averageOrderValue, 2) }}</p>
                </div>

            </div>

            <!-- Back to Dashboard Button -->
            <div class="mt-6 text-center">
                <a href="{{ route('dashboard') }}" 
                   class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    &larr; Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
