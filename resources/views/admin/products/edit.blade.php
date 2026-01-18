@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" class="bg-white shadow rounded-lg p-6">
    @csrf
    @method('PUT')
    <div class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" id="category_id" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">No Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="base_price" class="block text-sm font-medium text-gray-700">Base Price</label>
            <input type="number" step="0.01" name="base_price" id="base_price" value="{{ old('base_price', $product->base_price) }}" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" 
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image URL</label>
            <div class="flex flex-col space-y-2">
                <input type="text" name="image" id="image" value="{{ old('image', $product->image) }}" 
                       class="mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <div class="flex space-x-2">
                    <input type="file" id="file-input" accept="image/*" 
                           class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" id="upload-btn" class="bg-secondary-500 text-white px-4 py-2 rounded-md hover:bg-secondary-600">
                        Upload
                    </button>
                </div>
            </div>
            <!-- Image Preview -->
            <div class="mt-3" id="image-preview-container" style="display: {{ old('image', $product->image) ? 'block' : 'none' }};">
                <img id="image-preview" src="{{ old('image', $product->image) }}" alt="Image Preview" class="max-w-xs max-h-40 rounded">
            </div>
        </div>

        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $product->sort_order) }}" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadBtn = document.getElementById('upload-btn');
        const fileInput = document.getElementById('file-input');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        
        // Get route and CSRF token from server
        const uploadUrl = '{{ route('admin.products.upload-image') }}';
        const csrfToken = '{{ csrf_token() }}';

        // Click upload button to trigger file selection
        uploadBtn.addEventListener('click', function() {
            fileInput.click();
        });

        // Auto upload after file selection
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                uploadImage();
            }
        });

        // Upload image
        function uploadImage() {
            const file = fileInput.files[0];
            if (!file) {
                alert('Please select an image file.');
                return;
            }
            
            console.log('Uploading file:', file);
            
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', csrfToken);

            const xhr = new XMLHttpRequest();
            
            xhr.open('POST', uploadUrl, true);
            
            xhr.onload = function() {
                console.log('Response status:', xhr.status);
                console.log('Response text:', xhr.responseText);
                
                try {
                    const data = JSON.parse(xhr.responseText);
                    
                    if (xhr.status === 200 && data.url) {
                        // Fill in image URL
                        imageInput.value = data.url;
                        
                        // Show image preview
                        imagePreview.src = data.url;
                        imagePreviewContainer.style.display = 'block';
                        
                        // Reset file input
                        fileInput.value = '';
                        
                        console.log('Image uploaded successfully:', data.url);
                    } else {
                        alert('Image upload failed: ' + (data.error || 'Unknown error'));
                    }
                } catch (e) {
                    console.error('JSON parse error:', e);
                    alert('Image upload failed: Invalid response from server.');
                }
            };
            
            xhr.onerror = function() {
                console.error('Network error occurred.');
                alert('Image upload failed: Network error. Please check your connection.');
            };
            
            xhr.send(formData);
        }
    });
</script>

@endsection

