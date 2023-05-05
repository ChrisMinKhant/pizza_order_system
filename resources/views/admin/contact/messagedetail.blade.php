@extends('admin.layouts.master')

@section('title', 'Category - Create Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Message Detail</h3>
                            </div>

                            <hr>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-10 offset-1">
                                    <div class="row">
                                        <div class="col-6">
                                            <h6 class="text-muted"><i class="fa-solid fa-id-card-clip me-2"></i>Name</h6>
                                            <p class="fs-6">{{ $requestedContactData->name }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted fw-bold"><i class="fa-solid fa-clock me-2"></i>Date :
                                                {{ $requestedContactData->created_at->format('m-d-Y') }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="text-muted"><i class="fa-solid fa-envelope me-2"></i>Email</h6>
                                        <p class="fs-6">{{ $requestedContactData->email }}</p>
                                    </div>
                                    <div>
                                        <h6 class="text-muted"><i class="fa-solid fa-circle-info me-2"></i>Message</h6>
                                        <p class="fs-6">{{ $requestedContactData->message }}</p>
                                    </div>
                                    {{-- Back Button --}}
                                    <div>
                                        <a href="{{ route('admin#contact#messageListPage') }}" class="btn btn-primary">Back</a>
                                    </div>
                                    {{-- Back Button End --}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
