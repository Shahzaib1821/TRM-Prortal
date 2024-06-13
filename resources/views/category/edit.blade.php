@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Category</h4>

                <form action="{{ route('category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="label-input">Name :</label>
                                <input type="text" class="form-control" id="label-input" name="category_name" value="{{ $category->category_name }}" placeholder="Enter navbar item name">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-12">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                                <a href="{{ route('category.index') }}" class="btn btn-secondary w-md">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
