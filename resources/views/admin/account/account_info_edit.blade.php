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
                                <h3 class="text-center title-2">Edit Account Information</h3>
                            </div>
                            <hr>
                            {{-- Account Info Edit Input Open --}}
                            <form action="{{ route('admin#accountinfo#update', Auth::user()->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                                <img src="{{asset('image/male_default_user_profile.jpg')}}" class="img-thumbnail">
                                            @else
                                                <img src="{{asset('image/female_default_user_profile.jpg')}}" class="img-thumbnail">
                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.Auth::user()->image)}}" class="img-thumbnail">
                                        @endif
                                        <div class="mt-3">
                                            <input type="file" name="image" id=""
                                                class="form-control @error('image') is-invalid @enderror">
                                            @error('image')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-primary col-12" type="submit">
                                                Update<i class="fa-solid fa-arrow-turn-up ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text"
                                                class="@error('name') is-invalid @enderror form-control"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Admin Name"
                                                value="{{ old('name', Auth::user()->name) }}">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="text"
                                                class="@error('name') is-invalid @enderror form-control"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Admin Email"
                                                value="{{ old('email', Auth::user()->email) }}">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="text"
                                                class=" @error('phone') is-invalid @enderror form-control"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Admin Phone"
                                                value="{{ old('phone', Auth::user()->phone) }}">
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Gender</label>
                                            <select name="gender"
                                                class=" @error('name') is-invalid @enderror form-control">
                                                <option value="">Choose Your Gender</option>
                                                <option value="male" @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male</option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Address</label>
                                            <textarea name="address" cols="30" rows="10" placeholder="Enter Admin Address"
                                                class=" @error('name') is-invalid @enderror form-control">{{ old('address', Auth::user()->address) }}</textarea>
                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Role</label>
                                            <input id="cc-pament" name="role" type="text" class="form-control"
                                                aria-required="true" aria-invalid="false"
                                                value="{{ old('role', Auth::user()->role) }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                {{-- Accoutn Info Edit Input Close --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
