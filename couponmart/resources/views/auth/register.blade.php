@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Create an Account</h2>

    <div>
        {{-- Error messages --}}
        @if ($errors->any())
            <div class="space-y-2 mb-4">
                @foreach ($errors->all() as $error)
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded flex justify-between items-center">
                        <span>{{ $error }}</span>
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                class="w-full border p-2 rounded" required>
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
        </div>

        <!-- Account Type -->
        <div class="mb-4">
            <label class="block font-semibold mb-1" for="account_type">Account Type</label>
            <select id="account_type" name="account_type"  class="w-full border p-2 rounded" required>
                <option value="">Select Account Type</option>
                <option value="customer">Customer</option>
                <option value="business">Business</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">
            Register
        </button>
    </form>
</div>
@endsection
