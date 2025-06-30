<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Customer</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between">
            <div>
                <a href="{{ route('customer.dashboard') }}" class="font-bold">Dashboard</a>
            </div>
            <div>
                <a href="{{ route('customer.vehicles.index') }}" class="mr-4">Vehicles</a>
                <a href="{{ route('customer.bookings.index') }}" class="mr-4">Bookings</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4">
        {{ $slot ?? '' }}
    </main>
</body>
</html>
