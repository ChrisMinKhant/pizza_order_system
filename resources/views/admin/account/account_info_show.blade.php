@extends('admin.layouts.master')

@section('title', 'Category - Create Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-9">
                    @if (session('accountUpdate'))
                        <div class="alert alert-success alert-dismissible fade show col-5 offset-7" role="alert">
                            {{ session('accountUpdate') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Information</h3>
                            </div>

                            <hr>
                            {{-- Account Image and Data Open --}}
                            <div class="row justify-content-center align-items-center">
                                <div class="col-4">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{asset('image/male_default_user_profile.jpg')}}" class="img-thumbnail">
                                        @else
                                            <img src="{{asset('image/female_default_user_profile.jpg')}}" class="img-thumbnail">
                                        @endif
                                    @else
                                        <img src="{{asset('storage/'.Auth::user()->image)}}" class="img-thumbnail">
                                    @endif
                                </div>
                                <div class="col-6">
                                    <h6 class="my-2"><i class="fa-solid fa-id-card-clip me-2"></i>{{ Auth::user()->name }}
                                    </h6>
                                    <h6 class="my-2"><i
                                            class="fa-solid fa-square-envelope me-2"></i>{{ Auth::user()->email }}
                                    </h6>
                                    <h6 class="my-2"><i
                                            class="fa-solid fa-square-phone me-2"></i>{{ Auth::user()->phone }}
                                    </h6>
                                    <h6 class="my-2"><i class="fa-solid fa-venus-mars me-2"></i>{{ Auth::user()->gender }}
                                    </h6>
                                    <h6 class="my-2"><i
                                            class="fa-solid fa-map-location-dot me-2"></i>{{ Auth::user()->address }}</h6>
                                    <h6 class="my-2"><i
                                            class="fa-solid fa-calendar-check me-2"></i>{{ Auth::user()->created_at->format('j-F-Y') }}
                                    </h6>
                                </div>
                            </div>
                            {{-- Account Image and Data Close --}}

                            {{-- Edit Button Open --}}
                            <div class="row mt-3 justify-content-end">
                                <div class="col-5">
                                    <a href="{{ route('admin#accountinfo#edit') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-pen me-2"></i>Edit Profile
                                    </a>
                                </div>
                            </div>
                            {{-- Edit Button Close --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
