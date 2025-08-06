@extends('backend.app')

@section('title', 'Template Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Template Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Template</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('template.update', ['id' => $data->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="type" class="form-label">Template Type:</label>
                            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                <option value="">Select Type</option>
                                <option value="birthday" {{ old('type', $data->type) == 'birthday' ? 'selected' : '' }}>Birthday</option>
                                <option value="anniversary" {{ old('type', $data->type) == 'anniversary' ? 'selected' : '' }}>Anniversary</option>
                                <option value="festive" {{ old('type', $data->type) == 'festive' ? 'selected' : '' }}>Festive</option>
                                <option value="thank_you" {{ old('type', $data->type) == 'thank_you' ? 'selected' : '' }}>Thank You</option>
                                <option value="congratulations" {{ old('type', $data->type) == 'congratulations' ? 'selected' : '' }}>Congratulations</option>
                                <option value="reminders" {{ old('type', $data->type) == 'reminders' ? 'selected' : '' }}>Reminders</option>
                                <option value="invitations" {{ old('type', $data->type) == 'invitations' ? 'selected' : '' }}>Invitations</option>
                                <option value="professional" {{ old('type', $data->type) == 'professional' ? 'selected' : '' }}>Professional</option>
                                <option value="welcome" {{ old('type', $data->type) == 'welcome' ? 'selected' : '' }}>Welcome</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">Message:</label>
                            <textarea class="ck-editor form-control @error('message') is-invalid @enderror" name="message" id="message" placeholder="Message" cols="30" rows="3">{{ old('message', $data->message) }}</textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('template.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
