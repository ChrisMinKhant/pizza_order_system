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
                                <h2 class="title-1">Category List</h2>
                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('category#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add category
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
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
                            <form class="form-header" action="{{ route('category#listPage') }}" method="get">
                                @csrf
                                <input class="au-input au-input--xl" type="text" name="searchData"
                                    placeholder="Search for datas..."
                                    value="{{ old('searchData', request('searchData')) }}" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <h4 class="text-muted mt-3">Total Category - <span
                                    class="text-primary">{{ $categoryData->total() }}
                                    <i class="fa-solid fa-database"></i></span></h4>
                        </div>
                        {{-- Search Bar and Total End --}}
                    </div>
                    @if (session('createdCategory'))
                        <div class="alert alert-success alert-dismissible fade show col-5 offset-7" role="alert">
                            {{ session('createdCategory') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('deletedCategory'))
                        <div class="alert alert-warning alert-dismissible fade show col-5 offset-7" role="alert">
                            {{ session('deletedCategory') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive table-responsive-data2">
                        @if (count($categoryData) == 0)
                            <h3 class="text-muted text-center mt-5">THERE IS NO CATEGORY LIST HERE!</h3>
                        @else
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Created At</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categoryData as $category)
                                        <tr class="tr-shadow">
                                            <td>{{ $category->id }}</td>
                                            <td>
                                                {{ $category->name }}
                                            </td>
                                            <td>{{ $category->created_at }}</td>
                                            <td class="d-flex justify-content-center">
                                                <div class="table-data-feature">
                                                    <a href="{{ route('category#edit', $category->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('category#delete', $category->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $categoryData->links() }}
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
