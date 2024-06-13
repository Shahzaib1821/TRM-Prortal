@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center mt-3">
                                <h4 class="card-title">Scrub Numbers from the master database</h4>
                                <div class="col-lg-8">
                                    <form action="{{ route('csv-check.scrub') }}" method="post" id="uploadForm"
                                        class="m-3">
                                        @csrf
                                        <div class="file-upload-contain mb-4 mt-2">
                                            <label for="number">Enter Single Number</label>
                                            <input name="number" placeholder="One Number Per Line"
                                                class="form-control"required="">
                                        </div>
                                        <input class="btn btn-primary" type="submit" name="submit" value="Scrub Manual" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
