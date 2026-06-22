<x-admin-layout>
    <x-slot name="title">Edit Course</x-slot>

    <div style="max-width:720px;">
        <div style="margin-bottom:1.5rem;">
            <a href="/admin/courses" style="font-size:0.875rem;color:#6B7C8D;text-decoration:none;">← Back to Courses</a>
        </div>
        <div class="card" style="padding:2rem;">
            @if(session('success'))
                <x-alert type="success" message="{{ session('success') }}" />
            @endif
            @if($errors->any())
                <x-alert type="error" message="{{ $errors->first() }}" />
            @endif
            <form method="POST" action="/admin/courses/{{ $course->id }}">
                @csrf @method('PUT')
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                    <div style="grid-column:1/-1;">
                        <label class="label">Course Title *</label>
                        <input type="text" name="title" value="{{ old('title', $course->title) }}" class="input" required>
                    </div>
                    <div>
                        <label class="label">Category</label>
                        <select name="category_id" class="input">
                            <option value="">— Select Category —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Delivery Mode</label>
                        <select name="mode" class="input">
                            @foreach(['virtual','in_person','hybrid'] as $m)
                                <option value="{{ $m }}" {{ old('mode', $course->mode) == $m ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$m)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Price (₦) *</label>
                        <input type="number" name="price" value="{{ old('price', $course->price) }}" class="input" min="0" step="0.01" required>
                    </div>
                    <div>
                        <label class="label">Duration (Days)</label>
                        <input type="number" name="duration_days" value="{{ old('duration_days', $course->duration_days) }}" class="input" min="1">
                    </div>
                    <div>
                        <label class="label">Level</label>
                        <select name="level" class="input">
                            <option value="">— Any —</option>
                            @foreach(['beginner','intermediate','advanced'] as $l)
                                <option value="{{ $l }}" {{ old('level', $course->level) == $l ? 'selected' : '' }}>{{ ucfirst($l) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Max Delegates</label>
                        <input type="number" name="max_delegates" value="{{ old('max_delegates', $course->max_delegates) }}" class="input">
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="label">Short Description</label>
                        <input type="text" name="short_description" value="{{ old('short_description', $course->short_description) }}" class="input">
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="label">Full Description</label>
                        <textarea name="description" class="input" rows="6">{{ old('description', $course->description) }}</textarea>
                    </div>
                    <div style="grid-column:1/-1;display:flex;gap:2rem;">
                        <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $course->is_published) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#1A4D5E;"> <span style="font-weight:600;color:#0F1F2B;font-size:0.875rem;">Published</span></label>
                        <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#E07B2A;"> <span style="font-weight:600;color:#0F1F2B;font-size:0.875rem;">Featured</span></label>
                    </div>
                </div>
                <div style="display:flex;gap:0.75rem;">
                    <button type="submit" class="btn-primary">Update Course</button>
                    <a href="/admin/courses" class="btn-outline" style="padding:0.75rem 1.5rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
