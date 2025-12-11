@extends('layouts.admin')

@section('title', 'Edit News')
@section('header-title', 'Edit News')

@section('header-buttons')
    <div class="flex items-center gap-2 sm:gap-3">
        <a href="{{ route('admin.news.index') }}"
           class="inline-flex items-center px-3 sm:px-4 py-2 sm:py-2.5 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200 text-sm">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="hidden sm:inline">Back to News</span>
        </a>

        <form action="{{ route('admin.news.destroy', $news) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this news?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-3 sm:px-4 py-2 sm:py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all duration-200 text-sm">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span class="hidden sm:inline">Delete</span>
            </button>
        </form>
    </div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Form Header --}}
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Edit News Article</h2>
            <p class="text-purple-100 text-sm mt-1">Update the details below to modify this news article</p>
        </div>

        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title *</label>
                <input type="text" 
                       name="title" 
                       id="title"
                       value="{{ old('title', $news->title) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-transparent transition-all @error('title') border-red-500 @enderror"
                       placeholder="Enter news title..."
                       required>
                @error('title')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug</label>
                <input type="text" 
                       name="slug" 
                       id="slug"
                       value="{{ old('slug', $news->slug) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-transparent transition-all @error('slug') border-red-500 @enderror"
                       placeholder="news-slug-url">
                @error('slug')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                <select name="category" 
                        id="category"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-transparent transition-all @error('category') border-red-500 @enderror"
                        required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $news->category) == $cat ? 'selected' : '' }}>
                            @switch($cat)
                                @case('info') 📰 Informasi @break
                                @case('tips') 💡 Tips & Trik @break
                                @case('regulation') 📋 Peraturan @break
                                @case('event') 🎉 Event @break
                            @endswitch
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Excerpt --}}
            <div>
                <label for="excerpt" class="block text-sm font-semibold text-gray-700 mb-2">Excerpt *</label>
                <textarea name="excerpt" 
                          id="excerpt"
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-transparent transition-all @error('excerpt') border-red-500 @enderror"
                          placeholder="Brief summary of the news (max 200 characters)"
                          required>{{ old('excerpt', $news->excerpt) }}</textarea>
                <p class="mt-2 text-xs text-gray-500">Brief summary of the news (max 200 characters)</p>
                @error('excerpt')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Content *</label>
                <input type="hidden" name="content" id="content" value="{{ old('content', $news->content) }}">
                <div id="editor" style="height: 400px;" class="border border-gray-300 rounded-xl"></div>
                @error('content')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Current Image --}}
            @if($news->image)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Current Image</label>
                    <div class="relative inline-block">
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="max-w-md w-full h-auto rounded-xl shadow-md">
                        <div class="absolute top-2 right-2">
                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Current</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Image Upload --}}
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">{{ $news->image ? 'Replace Image' : 'Featured Image' }}</label>
                <div class="flex items-center justify-center w-full">
                    <label id="dropzone" for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        <input type="file" 
                               name="image" 
                               id="image"
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(event)">
                    </label>
                </div>
                
                {{-- Image Preview --}}
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-sm font-semibold text-gray-700 mb-2">New Image Preview:</p>
                    <img id="preview" src="" alt="Preview" class="max-w-full h-auto rounded-xl shadow-md">
                </div>
                
                @error('image')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Publishing Options --}}
            <div class="bg-gray-50 rounded-xl p-4 space-y-4">
                <h3 class="text-sm font-semibold text-gray-700">Publishing Options</h3>
                
                {{-- Published Status --}}
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_published" 
                           id="is_published"
                           value="1"
                           {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="is_published" class="ml-3 text-sm font-medium text-gray-700">Published</label>
                </div>

                {{-- Published Date --}}
                <div id="publishedDateField" style="{{ old('is_published', $news->is_published) ? 'display: block;' : 'display: none;' }}">
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Published Date</label>
                    <input type="datetime-local" 
                           name="published_at" 
                           id="published_at"
                           value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t">
                <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all">
                    Update News
                </button>
                <a href="{{ route('admin.news.index') }}" 
                   class="w-full sm:w-auto px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition-all text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Initialize Quill Editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Load existing content
    var existingContent = {!! json_encode(old('content', $news->content)) !!};
    quill.root.innerHTML = existingContent;

    // Sync Quill content to hidden textarea on form submit
    document.querySelector('form').onsubmit = function() {
        document.getElementById('content').value = quill.root.innerHTML;
    };

    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function(e) {
        const title = e.target.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    });

    // Image preview
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Drag and Drop functionality
    const dropZone = document.getElementById('dropzone');
    const fileInput = document.getElementById('image');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop zone when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-purple-500', 'bg-purple-50');
        dropZone.classList.remove('border-gray-300', 'bg-gray-50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-purple-500', 'bg-purple-50');
        dropZone.classList.add('border-gray-300', 'bg-gray-50');
    }

    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            // Set the file to the input element
            fileInput.files = files;
            
            // Trigger preview
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
            
            // Call preview function directly
            previewImage({ target: { files: files } });
        }
    }

    // Show/hide published date field
    document.getElementById('is_published').addEventListener('change', function() {
        const dateField = document.getElementById('publishedDateField');
        if (this.checked) {
            dateField.style.display = 'block';
            if (!document.getElementById('published_at').value) {
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                document.getElementById('published_at').value = now.toISOString().slice(0, 16);
            }
        } else {
            dateField.style.display = 'none';
        }
    });
</script>
@endpush
