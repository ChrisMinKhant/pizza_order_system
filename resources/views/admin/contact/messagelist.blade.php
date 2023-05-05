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
                                <h2 class="title-1 fs-1 fw-bolder">Message List</h2>
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

                            {{-- Search With Keywords --}}
                            <form class="form-header" action="{{ route('admin#contact#messageListPage') }}" method="get">
                                @csrf
                                <input class="au-input au-input--xl" type="text" name="searchData"
                                    placeholder="Search for datas..."
                                    value="{{ old('searchData', request('searchData')) }}" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <p class="text-muted mt-3 fs-6 fw-bold">Total Order - <span class="text-primary">
                                    {{ count($contactData) }}<i class="ms-2 fa-solid fa-database"></i></span></p>
                        </div>
                        {{-- Search Bar and Total End --}}
                    </div>

                    <div class="table-responsive table-responsive-data2">
                        @if (count($contactData) == 0)
                            <h3 class="text-muted text-center mt-5">THERE IS NO ORDER LIST HERE!</h3>
                        @else
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contactData as $contact)
                                        <tr class="tr-shadow" id="orderListTable">
                                            <td>{{ $contact->created_at }}</td>
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td><a href="{{ route('admin#contact#messageDetailPage', $contact->id) }}"
                                                    class="text-decoration-none text-dark fw-bold">{{ Str::limit($contact->message, 30, '...') }}</a>
                                            </td>
                                            <td><a href="{{ route('admin#contact#deleteMessage',$contact->id) }}" class="text-danger text-decoration-none"><i class="fa-regular fa-trash-can"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
