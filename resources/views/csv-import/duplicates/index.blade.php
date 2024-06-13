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
                                    <form action="{{ route('scan') }}" method="post"
                                        enctype="multipart/form-data" class="mb-5">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <label for="column_selection">Select File :</label>
                                                            <select name="column_selection"
                                                                class="form-select @error('column_selection') is-invalid @enderror"
                                                                id="column_selection">
                                                                <option value="">Choose a column</option>
                                                                <option value="1">Column 1</option>
                                                                <option value="2">Column 2</option>
                                                                <option value="3">Column 3</option>
                                                                <option value="4">Column 4</option>
                                                                <option value="5">Column 5</option>
                                                                <option value="6">Column 6</option>
                                                                <option value="7">Column 7</option>
                                                            </select>
                                                            @error('column_selection')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <label for="csvfile">CSV File</label>
                                                            <input type="file"
                                                                class="form-control @error('csvfile') is-invalid @enderror"
                                                                name="csvfile" accept=".csv" multiple />
                                                            @error('csvfile')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-end">
                                                    <div class="col-sm-12">
                                                        <div>
                                                            <button type="submit"
                                                                class="btn btn-primary w-md">Create</button>
                                                            <a href="{{ route('category.index') }}"
                                                                class="btn btn-secondary w-md">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>
@endsection
