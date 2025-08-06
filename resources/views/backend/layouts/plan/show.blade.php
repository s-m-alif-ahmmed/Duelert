@extends('backend.app')

@section('title', 'Plan Show')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Plan Show</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plan</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center shadow-lg p-4 rounded-4 border-0" style="max-width: 800px;">
                    {{-- Plan Price --}}
                    <h2 class="text-dark fw-bold">${{ $data->price }}<span class="text-muted fs-5">/month</span></h2>
                    {{-- Plan Type --}}
                    <h3 class="text-dark fw-bold">{{ $data->type }}</h3>
                    

                    {{-- Plan Title --}}
                    <h3 class="mt-3" style="font-size: 20px">{{ $data->title }}</h3>

                    <hr class="my-3">

                    {{-- Plan Features --}}
                    <ul class="list-unstyled text-start px-4" style="font-size: 20px;">
                        <li class="mb-2">✔️ <strong>{{ $data->customers_limit }}</strong> customers only</li>
                        <li class="mb-2">✔️ <strong>{{ $data->storage_limit }} GB</strong> of Storage</li>
                        <li class="mb-2">✔️ <strong>{{ $data->sms_limit }}</strong> SMS per week</li>
                        <li class="mb-2">✔️ <strong>{{ $data->currency }}</strong> Currency Type</li>
                        <li class="mb-2">✔️ <strong>{{ $data->plan_code }}</strong> Plan Code</li>
                        <li class="mb-2">✔️ Customize Birthday Message</li>
                    </ul>

                    {{-- Choose Plan Button --}}
                    <a href="#" class="btn btn-danger btn-lg w-100 py-2 mt-3 rounded-pill" style="background-color: #f41435;">Choose Plan</a>

                    {{-- Back Button --}}
                    <div class="mt-3">
                        <a href="{{ route('plan.index') }}"
                            class="btn btn-outline-secondary btn-sm rounded-pill px-4">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection