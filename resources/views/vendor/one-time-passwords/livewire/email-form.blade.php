<div>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        لطفاً شماره موبایل خود را وارد کنید
    </h2>

    <form wire:submit="submitUsername" class="mt-6 space-y-6">
        <div>
            <label for="username" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                شماره موبایل
            </label>
            <input
                class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                id="username"
                type="text"
                wire:model="username"
                required
            >
            @error('username')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                ارسال کد ورود
            </button>
        </div>
    </form>
</div>
