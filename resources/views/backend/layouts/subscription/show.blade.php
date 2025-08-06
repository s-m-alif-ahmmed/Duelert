@extends('backend.app')

@section('title', 'package Show')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">package Show</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">package</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center shadow-lg p-4 rounded-4 border-0" style="max-width: 800px; background-color: #fafafa;">
                <h3 class="text-dark fw-bold">Subscription Details</h3> <hr>
                <table class="table mt-3" style="font-size: 18px;">
                    <tbody>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Package:</th>
                            <td style="width: 70%;">{{ optional(DB::table('plans')->where('plan_code', $data->paystack_plan)->first())->type ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Amount Paid:</th>
                            <td style="width: 70%;">
                                @php
                                    $plan = DB::table('plans')->where('plan_code', $data->paystack_plan)->first();
                                @endphp
                                {{ $plan ? $plan->price : 'N/A' }}
                            </td>
                        </tr>
                        
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">End Date:</th>
                            <td style="width: 70%;">{{ $data->ends_at ? $data->ends_at : 'N/A' }}</td>
                        </tr>
                         <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Status:</th>
                            <td style="width: 70%;">{{ $data->paystack_status }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Name:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('name') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Email:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('email') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Avatar:</th>
                            <td style="width: 70%;">
                                @php
                                    $avatar = DB::table('users')->where('id', $data->user_id)->value('avatar');
                                @endphp
                                <img src="{{ $avatar ? asset($avatar) : asset('frontend/default-avatar-profile.jpg') }}" alt="Avatar" style="width: 100px; height: 80px;">
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Phone:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('phone') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Position:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('position') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">About:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('about') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Address:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('address') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Country:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('country') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">City:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('city') ?? 'N/A' }}</td>
                        </tr>
                         <tr>
                            <th style="width: 30%; background-color: #f5f5f5;">Role:</th>
                            <td style="width: 70%;">{{ DB::table('users')->where('id', $data->user_id)->value('role') ?? 'N/A' }}</td>
                        </tr> 
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="{{ route('package.index') }}"
                        class="btn btn-outline-secondary btn-sm rounded-pill px-4">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
