<x-admin-layout>
    <x-slot name="title">Add New Course</x-slot>

    <div style="max-width:720px;">
        <div style="margin-bottom:1.5rem;">
            <a href="/admin/courses" style="font-size:0.875rem;color:#6B7C8D;text-decoration:none;">← Back to Courses</a>
        </div>
        <div class="card" style="padding:2rem;">
            @if($errors->any())
                <x-alert type="error" message="{{ $errors->first() }}" />
            @endif
            <form method="POST" action="/admin/courses">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                    <div style="grid-column:1/-1;">
                        <label class="label">Course Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="input" placeholder="e.g. Advanced Financial Modelling" required>
                    </div>
                    <div>
                        <label class="label">Category</label>
                        <select name="category_id" class="input">
                            <option value="">— Select Category —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Delivery Mode</label>
                        <select name="mode" class="input">
                            <option value="virtual" {{ old('mode')=='virtual'?'selected':'' }}>Virtual</option>
                            <option value="in_person" {{ old('mode')=='in_person'?'selected':'' }}>In-Person</option>
                            <option value="hybrid" {{ old('mode')=='hybrid'?'selected':'' }}>Hybrid</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Price (₦) *</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="input" placeholder="150000" min="0" step="0.01" required>
                    </div>
                    <div>
                        <label class="label">Duration (Days) *</label>
                        <input type="number" name="duration_days" value="{{ old('duration_days') }}" class="input" placeholder="3" min="1" required>
                    </div>
                    <div>
                        <label class="label">Level</label>
                        <select name="level" class="input">
                            <option value="">— Any Level —</option>
                            <option value="beginner" {{ old('level')=='beginner'?'selected':'' }}>Beginner</option>
                            <option value="intermediate" {{ old('level')=='intermediate'?'selected':'' }}>Intermediate</option>
                            <option value="advanced" {{ old('level')=='advanced'?'selected':'' }}>Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Max Delegates</label>
                        <input type="number" name="max_delegates" value="{{ old('max_delegates') }}" class="input" placeholder="20">
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="label">Short Description</label>
                        <input type="text" name="short_description" value="{{ old('short_description') }}" class="input" placeholder="Brief one-line summary...">
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="label">Full Description</label>
                        <textarea name="description" class="input" rows="6" placeholder="Detailed course description...">{{ old('description') }}</textarea>
                    </div>
                    <div style="grid-column:1/-1;display:flex;align-items:center;gap:0.75rem;">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#1A4D5E;">
                        <label for="is_published" style="font-weight:600;color:#0F1F2B;font-size:0.875rem;">Publish immediately</label>
                    </div>
                    <div style="grid-column:1/-1;display:flex;align-items:center;gap:0.75rem;">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#E07B2A;">
                        <label for="is_featured" style="font-weight:600;color:#0F1F2B;font-size:0.875rem;">Feature on homepage</label>
                    </div>
                </div>
                <div style="display:flex;gap:0.75rem;">
                    <button type="submit" class="btn-primary">Create Course</button>
                    <a href="/admin/courses" class="btn-outline" style="padding:0.75rem 1.5rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
