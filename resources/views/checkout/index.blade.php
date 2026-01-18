@extends('layouts.app')

@section('title', 'Confirm Order')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-primary-700 mb-8">Confirm Order</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Delivery Method -->
                <div class="bg-white rounded-xl shadow-soft overflow-hidden p-6">
                    <h2 class="text-lg font-semibold text-primary-700 mb-5">Delivery Method</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="inline-flex items-center p-3 border border-primary-200 rounded-lg hover:border-primary-500 cursor-pointer transition-all duration-200 hover:shadow-sm">
                                <input type="radio" name="delivery_type" value="pickup" 
                                       @checked(old('delivery_type', 'pickup') === 'pickup') 
                                       class="form-radio text-primary-600 focus:ring-primary-500">
                                <span class="ml-3 text-gray-700 font-medium">In-store Pickup</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center p-3 border border-primary-200 rounded-lg hover:border-primary-500 cursor-pointer transition-all duration-200 hover:shadow-sm">
                                <input type="radio" name="delivery_type" value="delivery" 
                                       @checked(old('delivery_type') === 'delivery') 
                                       class="form-radio text-primary-600 focus:ring-primary-500">
                                <span class="ml-3 text-gray-700 font-medium">Home Delivery (¥5.00)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div id="delivery-address-section" class="mt-8" 
                         style="display: {{ old('delivery_type') === 'delivery' ? 'block' : 'none' }}">
                        <h3 class="text-sm font-semibold text-primary-700 mb-4">Delivery Address</h3>
                        
                        <!-- Select Existing Address -->
                        @if (count($deliveryAddresses) > 0)
                            <div class="mb-6">
                                @foreach ($deliveryAddresses as $index => $address)
                                    <div class="mb-3">
                                        <label class="inline-flex items-start p-4 border border-primary-200 rounded-lg hover:border-primary-500 cursor-pointer transition-all duration-200 hover:shadow-sm">
                                            <input type="radio" name="address_option" 
                                                   value="existing-{{ $index }}" 
                                                   class="form-radio text-primary-600 focus:ring-primary-500 mt-1">
                                            <span class="ml-4">
                                                <div class="font-medium text-primary-700">{{ $address['name'] }} {{ $address['phone'] }}</div>
                                                <div class="text-sm text-gray-600 mt-1">
                                                    {{ $address['province'] }}{{ $address['city'] }}{{ $address['district'] }}{{ $address['detail'] }}
                                                </div>
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                                <div class="mb-3">
                                    <label class="inline-flex items-start p-4 border border-primary-200 rounded-lg hover:border-primary-500 cursor-pointer transition-all duration-200 hover:shadow-sm">
                                        <input type="radio" name="address_option" value="new" 
                                               checked 
                                               class="form-radio text-primary-600 focus:ring-primary-500 mt-1">
                                        <span class="ml-4 font-medium text-primary-700">Add New Address</span>
                                    </label>
                                </div>
                            </div>
                        @endif

                        <!-- New Address Form -->
                        <div id="new-address-form">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="delivery_address[name]" class="block text-sm font-medium text-gray-700 mb-2">
                                        Recipient Name
                                    </label>
                                    <input type="text" name="delivery_address[name]" 
                                           value="{{ old('delivery_address.name') }}" 
                                           class="block w-full border border-primary-200 rounded-lg px-4 py-3 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    @error('delivery_address.name')
                                        <p class="text-secondary-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="delivery_address[phone]" class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number
                                    </label>
                                    <input type="text" name="delivery_address[phone]" 
                                           value="{{ old('delivery_address.phone') }}" 
                                           class="block w-full border border-primary-200 rounded-lg px-4 py-3 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    @error('delivery_address.phone')
                                        <p class="text-secondary-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
                                <div>
                                    <label for="delivery_address[province]" class="block text-sm font-medium text-gray-700 mb-2">
                                        Province
                                    </label>
                                    <input type="text" name="delivery_address[province]" 
                                           value="{{ old('delivery_address.province') }}" 
                                           class="block w-full border border-primary-200 rounded-lg px-4 py-3 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    @error('delivery_address.province')
                                        <p class="text-secondary-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="delivery_address[city]" class="block text-sm font-medium text-gray-700 mb-2">
                                        City
                                    </label>
                                    <input type="text" name="delivery_address[city]" 
                                           value="{{ old('delivery_address.city') }}" 
                                           class="block w-full border border-primary-200 rounded-lg px-4 py-3 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    @error('delivery_address.city')
                                        <p class="text-secondary-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="delivery_address[district]" class="block text-sm font-medium text-gray-700 mb-2">
                                        District
                                    </label>
                                    <input type="text" name="delivery_address[district]" 
                                           value="{{ old('delivery_address.district') }}" 
                                           class="block w-full border border-primary-200 rounded-lg px-4 py-3 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    @error('delivery_address.district')
                                        <p class="text-secondary-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-5">
                                <label for="delivery_address[detail]" class="block text-sm font-medium text-gray-700 mb-2">
                                    Detailed Address
                                </label>
                                <input type="text" name="delivery_address[detail]" 
                                       value="{{ old('delivery_address.detail') }}" 
                                       class="block w-full border border-primary-200 rounded-lg px-4 py-3 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                @error('delivery_address.detail')
                                    <p class="text-secondary-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-soft overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-primary-700">Order Summary</h2>
                </div>
                <div class="px-6 py-5">
                    <div class="space-y-5">
                        @foreach ($cart as $index => $item)
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-20 w-20">
                                    @if ($item['image'])
                                        <img class="h-20 w-20 object-cover rounded-lg shadow-sm" src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    @else
                                        <div class="h-20 w-20 bg-primary-50 flex items-center justify-center rounded-lg">
                                            <span class="text-primary-400 text-xs">No Image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-5 flex-1">
                                    <div class="text-base font-semibold text-primary-700">{{ $item['name'] }}</div>
                                    @if (!empty($item['selected_options']))
                                        <div class="text-xs text-gray-500 mt-2 space-y-1">
                                            @foreach ($item['selected_options'] as $optionType => $optionValue)
                                                <span class="inline-block bg-primary-50 px-2 py-1 rounded-full">
                                                    {{ ucfirst($optionType) }}: {{ $optionValue }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-500 mt-2">
                                        ¥{{ number_format($item['unit_price'], 2) }} × {{ $item['quantity'] }}
                                    </div>
                                </div>
                                <div class="text-lg font-bold text-primary-600">
                                    ¥{{ number_format($item['total_price'], 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            <div class="bg-white rounded-xl shadow-soft overflow-hidden p-6">
                <h2 class="text-lg font-semibold text-primary-700 mb-5">Order Notes</h2>
                <textarea name="notes" rows="4" 
                          placeholder="Special requirements" 
                          class="block w-full border border-primary-200 rounded-lg px-4 py-3 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">{{ old('notes') }}</textarea>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="mt-8 space-y-6">
            <div class="bg-white rounded-xl shadow-soft overflow-hidden p-6">
                <h2 class="text-lg font-semibold text-primary-700 mb-5">Order Summary</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between text-base">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-primary-600">¥{{ number_format($totalAmount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-base">
                        <span class="text-gray-600">Delivery Fee</span>
                        <span id="delivery-fee" class="text-primary-600">¥5.00</span>
                    </div>
                    <div class="flex justify-between text-base">
                        <span class="text-gray-600">Discount</span>
                        <span class="text-primary-600">-¥0.00</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-semibold text-primary-700">Total</span>
                            <span id="total-amount" class="text-2xl font-bold text-primary-700">¥{{ number_format($totalAmount + 5.00, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-7">
                    <button type="submit" 
                            class="w-full bg-primary-600 text-white py-4 px-6 rounded-lg hover:bg-primary-700 hover:shadow-md font-medium transition-all duration-200 transform hover:-translate-y-0.5">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<script>
    // Delivery method switching
    document.querySelectorAll('input[name="delivery_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const deliveryAddressSection = document.getElementById('delivery-address-section');
            const deliveryFee = document.getElementById('delivery-fee');
            const totalAmount = document.getElementById('total-amount');
            const baseAmount = {{ $totalAmount }};

            if (this.value === 'delivery') {
                deliveryAddressSection.style.display = 'block';
                // Enable address fields
                deliveryAddressSection.querySelectorAll('input').forEach(input => {
                    input.disabled = false;
                    input.required = true;
                });
                deliveryFee.textContent = '¥5.00';
                totalAmount.textContent = '¥' + (baseAmount + 5.00).toFixed(2);
            } else {
                deliveryAddressSection.style.display = 'none';
                // Disable address fields and clear values
                deliveryAddressSection.querySelectorAll('input').forEach(input => {
                    input.disabled = true;
                    input.required = false;
                    // Clear input values
                    input.value = '';
                });
                deliveryFee.textContent = '¥0.00';
                totalAmount.textContent = '¥' + baseAmount.toFixed(2);
            }
        });
    });

    // Initialize form status and display
    document.addEventListener('DOMContentLoaded', function() {
        const deliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
        const deliveryAddressSection = document.getElementById('delivery-address-section');
        const deliveryFee = document.getElementById('delivery-fee');
        const totalAmount = document.getElementById('total-amount');
        const baseAmount = {{ $totalAmount }};
        
        if (deliveryType === 'pickup') {
            // If pickup mode is selected during initialization, disable address fields
            deliveryAddressSection.querySelectorAll('input').forEach(input => {
                input.disabled = true;
                input.required = false;
            });
            deliveryAddressSection.style.display = 'none';
            deliveryFee.textContent = '¥0.00';
            totalAmount.textContent = '¥' + baseAmount.toFixed(2);
        } else {
            deliveryAddressSection.style.display = 'block';
            deliveryFee.textContent = '¥5.00';
            totalAmount.textContent = '¥' + (baseAmount + 5.00).toFixed(2);
        }
    });
</script>
@endsection