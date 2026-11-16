@props(['message' => 'Belum ada data.', 'resetUrl' => null])
<div class="rounded-2xl border border-dashed border-gray-300 bg-white p-12 text-center">
    <x-lucide-inbox class="mx-auto h-10 w-10 text-gray-300" />
    <p class="mt-4 text-gray-600">{{ $message }}</p>
    @if ($resetUrl)
        <a href="{{ $resetUrl }}" class="btn-outline mt-6">Atur Ulang Filter</a>
    @endif
</div>
