@extends('backend.app')

@section('title', 'PayStack Settings')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">PayStack Settings</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">PayStack Settings</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('credentials.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-4">
                            <label for="callback_url" class="col-md-3 form-label">Callback URL</label>
                            <div class="col-md-9">
                                <input class="form-control @error('callback_url') is-invalid @enderror" id="callback_url"
                                    name="callback_url" placeholder="Enter your Paystack callback url" type="text"
                                    value="{{ env('PAYSTACK_CALLBACK_URL') }}">
                                @error('callback_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="paystack_public_key" class="col-md-3 form-label">PAYSTACK PUBLIC KEY</label>
                            <div class="col-md-9">
                                <input class="form-control @error('paystack_public_key') is-invalid @enderror" id="paystack_public_key"
                                    name="paystack_public_key" placeholder="Enter your paystack public key" type="text"
                                    value="{{ env('PAYSTACK_PUBLIC_KEY') }}">
                                @error('paystack_public_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="paystack_client_secret_id" class="col-md-3 form-label">PAYSTACK SECRET KEY</label>
                            <div class="col-md-9">
                                <input class="form-control @error('paystack_secret') is-invalid @enderror" id="paystack_secret"
                                    name="paystack_secret" placeholder="Enter your Paystack client secret" type="text"
                                    value="{{ env('PAYSTACK_SECRET') }}">
                                @error('paystack_secret')
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
