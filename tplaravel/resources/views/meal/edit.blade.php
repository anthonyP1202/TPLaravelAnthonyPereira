<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Post
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('meal.edit', $post->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- Title --}}
                    <div class="mb-4">
                        <label for="title" class="block font-medium mb-1">Title</label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ $post->title }}"
                            class="w-full border rounded p-2 @error('title') border-red-500 @enderror"
                            required
                        >
                        @error('title')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="description" class="block font-medium mb-1">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="w-full border rounded p-2 @error('description') border-red-500 @enderror"
                            required
                        >{{ $post->recipie }}</textarea>
                        @error('description')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Edit Post</button>
                        <a href="{{ url()->previous() }}" class="px-3 py-2 border rounded text-gray-700">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('image')?.addEventListener('change', function (e) {
                const previewDiv = document.getElementById('preview');
                previewDiv.innerHTML = '';
                const file = e.target.files[0];
                if (!file) return;

                const allowed = ['image/png', 'image/jpg', 'image/jpeg'];
                if (!allowed.includes(file.type)) {
                    previewDiv.innerHTML = '<p class="text-red-600 text-sm">Invalid file type.</p>';
                    e.target.value = '';
                    return;
                }

                const img = document.createElement('img');
                img.className = 'max-h-48 rounded';
                img.src = URL.createObjectURL(file);
                previewDiv.appendChild(img);
            });
        </script>
    @endpush
</x-app-layout>
