@extends('backend.app')

@section('title', 'Template Create')

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
    {{-- PAGE-HEADER END --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="POST" action="{{ route('template.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="type" class="form-label">Type:</label>
                            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" required>
                                <option value="" selected disabled hidden>Select Type</option>
                                <option value="birthday" {{ old('type') == 'birthday' ? 'selected' : '' }}>Birthday</option>
                                <option value="anniversary" {{ old('type') == 'anniversary' ? 'selected' : '' }}>Anniversary</option>
                                <option value="festive" {{ old('type') == 'festive' ? 'selected' : '' }}>Festive</option>
                                <option value="thank_you" {{ old('type') == 'thank_you' ? 'selected' : '' }}>Thank You</option>
                                <option value="congratulations" {{ old('type') == 'congratulations' ? 'selected' : '' }}>Congratulations</option>
                                <option value="reminders" {{ old('type') == 'reminders' ? 'selected' : '' }}>Reminders</option>
                                <option value="invitations" {{ old('type') == 'invitations' ? 'selected' : '' }}>Invitations</option>
                                <option value="professional" {{ old('type') == 'professional' ? 'selected' : '' }}>Professional</option>
                                <option value="welcome" {{ old('type') == 'welcome' ? 'selected' : '' }}>Welcome</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">Message:</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" placeholder="Message" cols="30" rows="3" required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
