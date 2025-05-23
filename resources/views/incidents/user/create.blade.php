@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Report Incident</h2>

    <form action="{{ route('user.incidents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input name="title" type="text" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="Phishing">Phishing</option>
                <option value="Malware">Malware</option>
                <option value="Unauthorized Access">Unauthorized Access</option>
                <option value="Ransomware">Ransomware</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Priority</label>
            <select name="priority" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Evidence (optional)</label>
            <input type="file" name="evidence" class="form-control">
            <small>Accepted: jpg, png, pdf | Max: 2MB</small>
        </div>

        <button type="submit" class="btn btn-success">Submit Incident</button>
    </form>
</div>
@endsection
