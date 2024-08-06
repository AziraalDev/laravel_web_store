@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center pt-5">
                <form class="card w-75" method="POST" action="{{route('admin.categories.store')}}">
                    @csrf
                    <div class="card-header">
                        Category creation
                    </div>
                    <div class="card-body p-2">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   placeholder="Category name"
                                   value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                               <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent category</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">No parent</option>
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}"
                                        @if(old('parent_id') && old('parent_id') === $category->id) selected @endif
                                    >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-outline-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
