@extends('backend.app')

@section('title', 'Create New Social Media')

@section('content')
    <main class="content--wrapper p-5">

        {{-- Form --}}
        <section class="container">

            <div class="card text-center backend-form-wrapper">
                <div class="card-header text-start">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="pt-3">Create New Social Media</h4>
                       {{--  <div>
                            <a href="{{ route('social.media') }}" class="btn btn-sm btn-danger">View All</a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body my-4 text-start">
                    <form action="{{ route('social.media.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label for="platform" class="form-label ">Social
                                    Media</label>
                                <select class="form-select  sb-select-field" id="platform" name="platform">
                                    <option value="">Select Platform</option>
                                    <option value="1">Facebook</option>
                                    <option value="2">TikTok</option>
                                    <option value="3">Twitter</option>
                                    <option value="4">Instagram</option>
                                    <option value="5">Youtube</option>
                                    <option value="6">LinkedIn</option>
                                    <option value="7">Pinterest</option>
                                    <option value="8">Snapchat</option>
                                    <option value="9">Reddit</option>
                                    <option value="10">WhatsApp</option>
                                </select>
                            </div>
                            <div class="col-6" style="margin-top: 33px">
                                <div class="form-outline">
                                    <input type="text" name="link" class="form-control  " id="link"
                                        value="{{ old('link') }}" />
                                    <label for="link" class="form-label ">Link: </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-3">
                            <label for="status" class="form-label ">Status</label>
                            <select class="form-select  sb-select-field" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="deactive">Deactive</option>
                            </select>
                        </div>


                        <div class="d-flex justify-content-start align-items-center mb-3 mt-3">
                            <button type="submit" class="btn btn-success text-white shadow-sm me-3">
                                Submit
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-danger text-white shadow-sm">
                                Cancle
                            </a>
                        </div>
                </div>
            </div>
        </section>
    </main>

@endsection
