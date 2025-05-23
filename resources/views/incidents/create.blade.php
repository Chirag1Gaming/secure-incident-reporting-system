@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Report New Incident</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('incidents.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title *</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description *</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category *</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Select</option>
                <option value="Phishing" {{ old('category')=='Phishing' ? 'selected' : '' }}>Phishing</option>
                <option value="Malware" {{ old('category')=='Malware' ? 'selected' : '' }}>Malware</option>
                <option value="Ransomware" {{ old('category')=='Ransomware' ? 'selected' : '' }}>Ransomware</option>
                <option value="Unauthorized Access" {{ old('category')=='Unauthorized Access' ? 'selected' : '' }}>Unauthorized Access</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority *</label>
            <select class="form-select" id="priority" name="priority" required>
                <option value="">Select</option>
                <option value="Low" {{ old('priority')=='Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ old('priority')=='Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ old('priority')=='High' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="evidence" class="form-label">Evidence Upload (jpg, png, pdf, max 2MB)</label>
            <input type="file" class="form-control" id="evidence" name="evidence" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <button type="submit" class="btn btn-primary">Submit Incident</button>
    </form>
</div>
@endsection
