@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-800 dark:border-gray-800 bg-black text-white focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm placeholder-gray-500']) }}>
