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
                                <h2 class="title-1">User List</h2>
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
                            <form class="form-header" action="{{ route('admin#userListPage') }}" method="get">
                                @csrf
                                <input class="au-input au-input--xl" type="text" name="searchData"
                                    placeholder="Search for datas..."
                                    value="{{ old('searchData', request('searchData')) }}" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <h4 class="text-muted mt-3">Total User - {{ $userData->total() }} <span class="text-primary"><i
                                        class="fa-solid fa-database"></i></span></h4>
                        </div>
                        {{-- Search Bar and Total End --}}
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        @if (count($userData) == 0)
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
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userData as $user)
                                        <tr id="tableData">
                                            <input type="hidden" value="{{ $user->id }}" class="userId">
                                            <td class="col-1">
                                                @if ($user->image == null)
                                                    @if ($user->gender == 'male')
                                                        <img src="{{ asset('image/male_default_user_profile.jpg') }}"
                                                            class="img-thumbnail">
                                                    @else
                                                        <img src="{{ asset('image/female_default_user_profile.jpg') }}"
                                                            class="img-thumbnail">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/' . $user->image) }}" class="img-thumbnail">
                                                @endif
                                            </td>
                                            <td class="col-3"><a href="{{  route('admin#editUserInfoPage',$user->id)}}" class="text-decoration-none text-pirmary fw-bold">{{ $user->name }}</a></td>
                                            <td class="col-1">{{ $user->gender }}</td>
                                            <td class="col-1">{{ $user->email }}</td>
                                            <td class="col-2">{{ $user->phone }}</td>
                                            <td class="col-2">{{ $user->address }}</td>
                                            <td class="col-2">
                                                <select name="userRole"
                                                    class="form-control rounded-2 shadow-sm text-center border-0 changeRole">
                                                    <option value="admin" @selected($user->role == 'admin')>Admin</option>
                                                    <option value="user" @selected($user->role == 'user')>User</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm text-danger deleteButton">
                                                    <i class="fa-solid fa-user-xmark" title="Delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $userData->links() }}
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

@section('scriptSection')
    <script>
        $(document).ready(function() {

            //Change User Role Ajax
            $('.changeRole').change(function() {

                $parents = $(this).parents('#tableData');

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/admin/user/changeUserRole',
                    data: {
                        'userId': $parents.find('.userId').val(),
                        'userRole': $(this).val()
                    },
                    dataType: 'json'
                })

                location.reload();
            });

            //Delete User
            $('.deleteButton').click(function(){
                $parents = $(this).parents('#tableData');

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/admin/user/deleteUser',
                    data: {
                        'userId': $parents.find('.userId').val()
                    },
                    dataType: 'json'
                })
                location.reload();
            });
        });
    </script>
@endsection
