@extends('layouts.app')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form_wrapper">
                    <div class="form_container bg-white p-5">
                        <div class="title_container">
                            <h2>Your Results Are Ready!</h2>
                        </div>
                        @foreach ($categoryCounts as $category => $counts)
                        <div class="row clearfix">
                            <div class="d-flex justify-content-center align-items-center m-auto text-center">
                                <div class="col-md-12">
                                    <h3>{{ $category }}</h3>
                                    <p> Bad: {{ $counts['bad'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
