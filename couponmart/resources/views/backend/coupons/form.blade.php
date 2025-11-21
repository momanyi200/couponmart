@csrf

{{-- Coupon Name --}}
<div class="my-2">
    <label for="title" class="block text-sm font-medium text-gray-700">Coupon Name</label>
    <input type="text" name="title" id="title"
           class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
           value="{{ old('title', $coupon->title ?? '') }}">
</div>

{{-- Coupon Category --}}
<div class="my-2">
    <label for="categories" class="block text-sm font-medium text-gray-700">Coupon Category</label>
    <select name="categories" id="categories" required
            class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <option value="">Select category</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ isset($couponCategories) && $couponCategories->id == $cat->id ? 'selected' : '' }}>
                {{ $cat->cat_name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Description --}}
<div class="my-2">
    <label for="description" class="block text-sm font-medium text-gray-700">Coupon Description</label>
    <textarea name="details" id="description" rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('details', $coupon->details ?? '') }}</textarea>
</div>

{{-- Cost & Total Coupons --}}
<div class="grid grid-cols-1 my-2 sm:grid-cols-2 gap-6">
    <div>
        <label for="cost" class="block text-sm font-medium text-gray-700">Cost per Coupon</label>
        <input type="number" name="cost" id="cost"
               class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('cost', $coupon->cost ?? '') }}">
    </div>

    <div>
        <label for="total_coupons" class="block text-sm font-medium text-gray-700">Total Available Coupons</label>
        <input type="number" name="total_vouchers" id="total_coupons"
               class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('total_vouchers', $coupon->total_vouchers ?? '') }}">
    </div>
</div> 

{{-- Valid From & End Date --}}
<div class="grid grid-cols-1 my-2 sm:grid-cols-2 gap-6">
    <div>
        <label for="start_date" class="block text-sm font-medium text-gray-700">Valid From</label>
        <input type="date" name="start_date" id="start_date" min="{{ $mindate ?? now()->toDateString() }}"
               class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('start_date', $starts ?? '') }}">
    </div>

    <div>
        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
        <input type="date" name="end_date" id="end_date" min="{{ $mindate ?? now()->toDateString() }}"
               class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('end_date', $endss ?? '') }}">
    </div>
</div>

{{-- Submit --}}
<div>
    <button type="submit"
            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-md shadow">
        {{ isset($coupon) ? 'Update' : 'Create' }}
    </button>
</div>
