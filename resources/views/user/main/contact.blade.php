@extends('user.layouts.master')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Contact Us</h3>
                            </div>
                            <hr>
                            {{-- Account Info Edit Input Open --}}
                            <form action="{{ route('user#sentMessage') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-10 offset-1">
                                        @if (session('messageError'))
                                            <div class="alert alert-danger alert-dismissible fade show"
                                                role="alert">
                                                {{ session('messageError') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text" class="form-control"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Admin Name"
                                                value="{{ old('name', Auth::user()->name) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="text" class="form-control"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Admin Email"
                                                value="{{ old('email', Auth::user()->email) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="categoryName" class="control-label mb-1">Message</label>
                                            <textarea name="message" cols="30" rows="10" placeholder="Enter Your Message" class=" form-control"></textarea>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-primary rounded-2 fw-bold">Send
                                                Message</button>
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
