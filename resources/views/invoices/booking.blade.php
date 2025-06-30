<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align:center; margin-bottom:20px; }
        .table { width:100%; border-collapse: collapse; margin-bottom:20px; }
        .table th, .table td { border:1px solid #ddd; padding:8px; }
        .table th { background:#f3f3f3; }
        .text-right { text-align:right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>BengkelKita Invoice</h2>
    </div>

    <p><strong>Invoice Code:</strong> {{ $booking->booking_code }}</p>
    <p><strong>Date:</strong> {{ $booking->created_at->format('d M Y') }}</p>

    <h4>Customer</h4>
    <p>{{ $booking->customer->user->name }}<br>
       {{ $booking->customer->user->phone }}<br>
    </p>

    <h4>Vehicle</h4>
    <p>Plate: {{ $booking->vehicle->license_plate }}<br>
       Model: {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }} ({{ $booking->vehicle->year }})
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($booking->serviceDetails as $detail)
            <tr>
                <td>{{ $detail->description }}</td>
                <td class="text-right">Rp {{ number_format($detail->total_price,0,',','.') }}</td>
            </tr>
            @empty
            <tr>
                <td>{{ $booking->serviceCategory?->name }}</td>
                <td class="text-right">Rp {{ number_format($booking->serviceCategory?->price ?? 0,0,',','.') }}</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th class="text-right">Rp {{ number_format($booking->actual_cost ?? $booking->estimated_cost,0,',','.') }}</th>
            </tr>
        </tfoot>
    </table>

    <p>Thank you for your business.</p>
</body>
</html>
