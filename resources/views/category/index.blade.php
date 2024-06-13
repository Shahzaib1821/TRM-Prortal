@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Categories</h4>
                        <a href="{{ route('category.create') }}"
                            class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                            <i class="bx bx-plus"></i> Add New category
                        </a>
                    </div>
                    <hr>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->category_name }}</td>

                                    <td>
                                        <a href="{{ route('category.edit', $category->id) }}"
                                            class="btn btn-soft-info waves-effect waves-light">
                                            <i class="bx bx-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger waves-effect waves-light">
                                                <i class="bx bx-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
