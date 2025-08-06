@extends('backend.app')

@section('title', 'social media')

@push('style')

@endpush

@section('content')
<div class="container mt-4 shadow-sm border rounded">
    <h2 class="mb-4 mt-4">Social Media Links</h2>

    {{-- Social Media Links Table --}}
    <div class="table-responsive">
        {{-- <div class="text-end">
            <a href="{{ route('social-media.create') }}" class="btn btn-primary mb-3">
                <i class="fa fa-plus-circle"></i> Create
            </a>
        </div> --}}
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col" style="color: white">Platform</th>
                    <th scope="col" style="color: white">Link</th>
                    <th scope="col" style="color: white">Status</th>
                    <th scope="col" style="color: white">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($socialMedia as $media)
                    <tr>
                        {{-- Update Form --}}
                        <form action="{{ route('social.media.update', $media->id) }}" method="POST" class="d-flex">
                            @csrf
                            @method('PUT')
                            <td class="align-middle">{{ ucfirst($media->platform) }}</td>
                            <td class="align-middle">
                                <input type="url" name="link" value="{{ $media->link }}" class="form-control" required>
                            </td>
                            <td class="align-middle">
                                <select name="status" class="form-select">
                                    <option value="active" {{ $media->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $media->status == 'inactive' ? 'selected' : '' }}>Deactive</option>
                                </select>
                            </td>
                            <td class="align-middle">
                                <button type="submit" class="btn btn-primary btn-sm me-1">Update</button>
                                {{-- Delete Form --}}
                               {{--  <form action="{{ route('social.media.destroy', $media->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                </form> --}}
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
