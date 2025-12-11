@extends('layouts.admin')

@section('title', 'Create News')
@section('header-title', 'Create News')

@section('header-buttons')
    <a href="{{ route('admin.news.index') }}"
       class="inline-flex items-center px-3 sm:px-4 py-2 sm:py-2.5 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200 text-sm">
        <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="hidden sm:inline">Back to News</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Form Header --}}
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Create New News Article</h2>
            <p class="text-purple-100 text-sm mt-1">Fill in the details below to create a new news article</p>
        </div>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title *</label>
                <input type="text" 
                       name="title" 
                       id="title"
                       value="{{ old('title') }}"
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
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug <span class="text-gray-400 font-normal">(Optional - auto-generated from title)</span></label>
                <input type="text" 
                       name="slug" 
                       id="slug"
                       value="{{ old('slug') }}"
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
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
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
                          required>{{ old('excerpt') }}</textarea>
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
                <input type="hidden" name="content" id="content" value="{{ old('content') }}">
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

            {{-- Image Upload --}}
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Featured Image</label>
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
                           {{ old('is_published') ? 'checked' : '' }}
                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="is_published" class="ml-3 text-sm font-medium text-gray-700">Publish immediately</label>
                </div>

                {{-- Published Date --}}
                <div id="publishedDateField" style="display: none;">
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Published Date</label>
                    <input type="datetime-local" 
                           name="published_at" 
                           id="published_at"
                           value="{{ old('published_at') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t">
                <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all">
                    Create News
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
            // Set current datetime as default
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('published_at').value = now.toISOString().slice(0, 16);
        } else {
            dateField.style.display = 'none';
        }
    });
</script>
@endpush
