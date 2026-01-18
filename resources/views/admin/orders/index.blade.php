@extends('layouts.admin')

@section('title', 'Order Management')
@section('page-title', 'Order Management')

@section('content')
<div class="mb-4 flex gap-4">
    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        All
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded {{ request('status') == 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Pending
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'preparing']) }}" class="px-4 py-2 rounded {{ request('status') == 'preparing' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Preparing
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded {{ request('status') == 'completed' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Completed
    </a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order Number</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($orders as $order)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->code }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->customer->name ?? 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">¥{{ number_format($order->total_amount, 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @elseif($order->status == 'preparing') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $order->status }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection

