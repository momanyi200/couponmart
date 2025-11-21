@extends('layouts.app')

@section('title', 'Business Account Registration')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Step 1: Create Account</h2>

    <form method="POST" action="{{ route('onboarding.stage1.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Business Name</label>
            <input type="text" name="business_name" value="{{ old('business_name') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Contact Person Name</label>
            <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <!-- Account Type -->
        <div class="mb-4">
            <label class="block font-semibold mb-1" for="account_type">Town</label>
            <select id="town_id" name="town_id"  class="w-full border p-2 rounded" required>
                <option value="">Select Town</option>
                @foreach($town as $town)
                  <option value="{{$town->id}}">{{$town->town_name}}</option>
                @endforeach
               
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Continue to Step 2
        </button>
    </form>
</div>
@endsection
