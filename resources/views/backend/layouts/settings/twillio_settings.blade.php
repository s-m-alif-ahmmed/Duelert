@extends('backend.app')

@section('title', 'Twillio Settings')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Twillio Settings</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Twillio Settings</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('twillio.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-4">
                            <label for="twilio_sid" class="col-md-3 form-label">TWILIO SID</label>
                            <div class="col-md-9">
                                <input class="form-control @error('twilio_sid') is-invalid @enderror" id="twilio_sid"
                                    name="twilio_sid" placeholder="Enter your twilio sid" type="text"
                                    value="{{ env('TWILIO_SID') }}">
                                @error('twilio_sid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="twilio_auth_token" class="col-md-3 form-label">TWILIO AUTH TOKEN</label>
                            <div class="col-md-9">
                                <input class="form-control @error('twilio_auth_token') is-invalid @enderror" id="twilio_auth_token"
                                    name="twilio_auth_token" placeholder="Enter your paystack public key" type="text"
                                    value="{{ env('TWILIO_AUTH_TOKEN') }}">
                                @error('twilio_auth_token')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="twilio_from" class="col-md-3 form-label">TWILIO FROM</label>
                            <div class="col-md-9">
                                <input class="form-control @error('twilio_from') is-invalid @enderror" id="twilio_from"
                                    name="twilio_from" placeholder="Enter your Paystack client secret" type="text"
                                    value="{{ env('TWILIO_FROM') }}">
                                @error('twilio_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <div>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
