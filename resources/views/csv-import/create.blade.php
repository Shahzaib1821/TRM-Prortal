@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Insert Data Into DB</h4>
                            <p class="card-title-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates
                                quaerat debitis consectetur fugiat hic quos maxime eum dolorem, assumenda facilis.
                            </p>
                            <form action="{{ route('csv-import.store') }}" method="post" enctype="multipart/form-data"
                                class="mb-5">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label for="column_selection">Select File :</label>
                                                    <select name="column_selection"
                                                        class="form-select @error('column_selection') is-invalid @enderror" id="column_selection">
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
                                                    <input type="file" class="form-control @error('csvfile') is-invalid @enderror" name="csvfile" accept=".csv" multiple  />
                                                    @error('csvfile')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label for="category">Assign Category</label>
                                                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                                                        <option value="">Select Post Category Type</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category }}">{{ $category }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category')
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
                                                    <button type="submit" class="btn btn-primary w-md">Create</button>
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
                    <div class="form_wrapper">
                        <div id="loader" class="text-center" style="display: none;">
                            <img src="https://i.gifer.com/SVKl.gif" alt="Loading..." width="50">
                            <p>Processing Please Wait...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
