@extends('layouts.app')


@section('content')
<div class='d-flex justify-content-end mb-2'>
    <a href="{{ route('categories.create') }}" class="btn btn-success">Add Category</a>
</div>

<div class="card card-drfault">
    <div class="card-header">Categories</div>
    <div class="card-body">
        @if ($categories->count()>0)
            <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Posts Count</th>
                        <th></th>
                    </thead>
        
                    <tbody>
                        @foreach($categories as $categorie)
                            <tr>
                        
                                <td>
                                    {{$categorie->name }}
                                </td>
                                <td>
                                    {{ $categorie->posts->count() }}
                                </td>
                                <td>
                                <a href="{{ route('categories.edit',$categorie->id )}}" class="btn btn-info">Edit</a>
                                <button class="btn btn-danger" onclick="handleDelete({{$categorie->id}})">Delete</button>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        @else
            <h3 class="text-center">No categories yet</h3>
        @endif
       

        <form id="deleteCategoryForm" method="POST">
            @csrf
            @method('DELETE')
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center text-bold">
                                        Are you sure you want to delete this Category ?
                                </p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" data-dismiss="modal">No, Go back</button>
                              <button type="submit" class="btn btn-danger">Yes , Delete</button>
                            </div>
                          </div>
                        </div>
                </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')

<script>
    function handleDelete(id)
    {
        //console.log("delete");
        ///console.log(id);
        var form=document.getElementById('deleteCategoryForm')
        form.action='/categories/'+id
        $('#deleteModal').modal('show')
    }
</script>
    
@endsection