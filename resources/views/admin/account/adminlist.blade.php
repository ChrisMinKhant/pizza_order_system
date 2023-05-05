@extends('admin.layouts.master')

@section('title', 'Admin - Category Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admin List</h2>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Search Keyword --}}
                        <div>
                            <h4 class="text-muted mt-3">Search Keyword -
                                <span class="text-primary">{{ request('searchData') }}</span>
                            </h4>
                        </div>
                        {{-- Search Keyword End --}}
                        {{-- Search Bar and Total --}}
                        <div class="my-5 d-flex flex-column align-items-end">
                            <form class="form-header" action="{{ route('admin#listpage') }}" method="get">
                                @csrf
                                <input class="au-input au-input--xl" type="text" name="searchData"
                                    placeholder="Search for datas..."
                                    value="{{ old('searchData', request('searchData')) }}" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <h4 class="text-muted mt-3">Total Admin - {{$adminList->total()}} <span class="text-primary"><i class="fa-solid fa-database"></i></span></h4>
                        </div>
                        {{-- Search Bar and Total End --}}
                    </div>
                    @if (session('adminRoleChanged'))
                        <div class="alert alert-success alert-dismissible fade show col-5 offset-7" role="alert">
                            {{ session('adminRoleChanged') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('deletedAdminList'))
                        <div class="alert alert-warning alert-dismissible fade show col-5 offset-7" role="alert">
                            {{ session('deletedAdminList') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive table-responsive-data2">
                        @if (count($adminList) == 0)
                        <h3 class="text-muted text-center mt-5">THERE IS NO ADMIN LIST HERE!</h3>
                        @else
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ( $adminList as $admins )
                                <tr>
                                    <td class="col-2">
                                        @if ($admins->image == null)
                                            @if ($admins->gender == 'male')
                                                <img src="{{asset('image/male_default_user_profile.jpg')}}" class="img-thumbnail">
                                            @else
                                            <img src="{{asset('image/female_default_user_profile.jpg')}}" class="img-thumbnail">
                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.$admins->image)}}" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td class="col-2">{{$admins->name}}</td>
                                    <td class="col-1">{{$admins->gender}}</td>
                                    <td class="col-1">{{$admins->email}}</td>
                                    <td class="col-2">{{$admins->phone}}</td>
                                    <td class="col-2">{{$admins->address}}</td>
                                    <td>
                                        @if (Auth::user()->id == $admins->id)

                                        @else
                                            <div class="table-data-feature">
                                                <a href="{{route('admin#rolechange',$admins->id)}}">
                                                    <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Change Admin Role">
                                                        <i class="fa-solid fa-person-circle-minus"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('admin#listdelete',$admins->id)}}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{$adminList->links()}}
                            </div>
                        @endif
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
