@extends('backend.app')

@section('title', 'Plan Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Plan Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plan</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('plan.update', ['id' => $data->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="title" class="form-label">Plan Title:</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   name="title" placeholder="Plan Title" id="title" value="{{ old('title', $data->title) }}">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="currency" class="form-label">Plan currency:</label>
                            <input type="text" class="form-control @error('currency') is-invalid @enderror"
                                   name="currency" placeholder="Plan currency" id="currency" value="{{ old('currency', $data->currency) }}">
                            @error('currency')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-label">Plan Price:</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                   name="price" placeholder="Plan Price" id="price" value="{{ old('price', $data->price) }}">
                            @error('price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group d-none">
                            <label for="type" class="form-label">Plan Type:</label>
                            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                <option value="starter" {{ old('type', $data->type) == 'starter' ? 'selected' : '' }}>Starter</option>
                                <option value="professional" {{ old('type', $data->type) == 'professional' ? 'selected' : '' }}>Professional</option>
                                <option value="company" {{ old('type', $data->type) == 'company' ? 'selected' : '' }}>Company</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="customers_limit" class="form-label">Customers Limit:</label>
                            <input type="number" class="form-control @error('customers_limit') is-invalid @enderror"
                                   name="customers_limit" placeholder="Customers Limit" id="customers_limit" value="{{ old('customers_limit', $data->customers_limit) }}">
                            @error('customers_limit')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="plan_code" class="form-label">Plan Code:</label>
                            <input type="text" class="form-control @error('plan_code') is-invalid @enderror"
                                   name="plan_code" placeholder="Plan Code" id="plan_code" value="{{ old('plan_code', $data->plan_code) }}">
                            @error('plan_code')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="storage_limit" class="form-label">Storage Limit(GB):</label>
                            <input type="number" class="form-control @error('storage_limit') is-invalid @enderror"
                                   name="storage_limit" placeholder="Storage Limit(MB)" id="storage_limit" value="{{ old('storage_limit', $data->storage_limit) }}">
                            @error('storage_limit')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sms_limit" class="form-label">SMS Limit:</label>
                            <input type="number" class="form-control @error('sms_limit') is-invalid @enderror"
                                   name="sms_limit" placeholder="SMS Limit" id="sms_limit" value="{{ old('sms_limit', $data->sms_limit) }}">
                            @error('sms_limit')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="customize_birth_message" class="form-label">Customize Birth Message:</label>
                            <input type="text" class="form-control @error('customize_birth_message') is-invalid @enderror"
                                   name="customize_birth_message" id="customize_birth_message" value="{{ old('customize_birth_message', $data->customize_birth_message) }}">
                            @error('customize_birth_message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('plan.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
