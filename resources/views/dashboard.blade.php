<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Todo List</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{!! route('dashboard') !!}"><b>Home</b> </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> <b>Welcome,{{ Auth::user()->name }}</b> </a>
                    </li>

                    <li class="nav-item">
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <a class="btn btn-dark" href="{!! route('logout') !!}">logout</a>
                </form>
            </div>
        </div>
    </nav>
</head>

<body>

    <div class="container mt-5">
        {{-- <h2>Todo List</h2> --}}
        <a class="btn btn-primary mb-3" href="{!! route('todo.index') !!}">Add Todo</a>
        @include('includes.main')
        <table class="table table-striped table-bordered" id="todos">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#todos').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('todo.getData') }}",
                    "type": "GET"
                },
                "columns": [{
                        "data": "title",
                        "name": "title"
                    },
                    {
                        "data": "description",
                        "name": "description"
                    },
                    {
                        "data": "due_date",
                        "name": "due_date"
                    },
                    {
                        "data": "status",
                        "name": "status"
                    },
                    {
                        "data": "action",
                        "name": "action",
                        "orderable": false,
                        "searchable": false
                    }
                ]
            });



            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();

                var editBtn = $(this);
                var id = editBtn.data('row-id');

                window.location.href = '/todo/' + id + '/edit';
            });


            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();

                var deleteBtn = $(this);
                var id = deleteBtn.data('row-id');

                if (!confirm('Are you sure you want to delete this data?')) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '/todo/' + id,
                    data: {
                        _method: 'DELETE',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        $('#todos').DataTable().ajax.reload();
                        alert('Data deleted successfully!');
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Error occurred while deleting data.');
                    }
                });
            });
        });
    </script>
</body>

</html>
