@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-primary-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-soft p-8">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-bold text-primary-700">
                Create a new account
            </h2>
            <p class="mt-2 text-sm text-gray-500">
                Join us and enjoy more member benefits
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input id="name" name="name" type="text" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-primary-200 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm transition-all duration-200" 
                           placeholder="Enter your full name" value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-secondary-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (Optional)</label>
                    <input id="email" name="email" type="email" 
                           class="appearance-none relative block w-full px-4 py-3 border border-primary-200 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm transition-all duration-200" 
                           placeholder="Enter your email" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-secondary-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number (Optional)</label>
                    <input id="phone" name="phone" type="text" 
                           class="appearance-none relative block w-full px-4 py-3 border border-primary-200 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm transition-all duration-200" 
                           placeholder="Enter your phone number" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="mt-1 text-sm text-secondary-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-primary-200 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm transition-all duration-200" 
                           placeholder="At least 6 characters">
                    @error('password')
                        <p class="mt-1 text-sm text-secondary-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-primary-200 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm transition-all duration-200" 
                           placeholder="Enter password again">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-secondary-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    Register
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium transition-colors duration-200">
                    Already have an account? Log in now
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

