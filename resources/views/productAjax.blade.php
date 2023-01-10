<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <title>Project</title>
</head>
<body>
   
    <div class="container">
        <div class="jumbotron">
           
            <p>Product Controller</p>
            <a href="javascript:void(0)" class="btn btn-success" id="CreateNewProduct">Create Product</a>
        </div>
        <table class="table table-bordered table-responsive data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Details</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
            </tbody>

        </table>
    </div>
    <div id="ajaxModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeader">Heading Goes Here</h4>
                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal" action="">
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="form-group">
                          <label for="name" class="col-sm-2 control-label">Product Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" required class="form-control" placeholder="Enter Name" aria-describedby="helpId">
                                <small id="helpId" class="text-muted">Enter Product Name</small>
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="detail" class="col-sm-2 control-label">Product Detail</label>
                            <div class="col-sm-10">
                                <input type="text" name="detail" id="detail" class="form-control" required placeholder="Enter Detail" aria-describedby="helpId">
                                <small id="helpId" class="text-muted">Enter Product Detail</small>
                            </div>
                        </div>
                        <div class="col-sm offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="Create">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing:true,
                serverSide:true,
                ajax: "{{ route('products.index') }}",
                columns:[
                    {data: 'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'name',name:'name'},
                    {data:'detail',name:'detail'}                    
                ] 
            });
            $('#CreateNewProduct').click(function(){
                // alert("add button clicked");
                $("#saveBtn").val("Create-Product");
                $("#product_id").val('');
                $("#productForm").trigger("reset");
                $("#modelHeader").html("Create New Product");
                $('#ajaxModal').modal('show');
            });

            /// add button code
            $("#saveBtn").click(function(e){
                e.preventDefault();
                $(this).html('Sending......');

                $.ajax({
                    data:$('#productForm').serialize(),
                    url: "{{ route('products.store')}}",
                    type: "POST",
                    dataType: 'json',

                    success:function(data){
                        console.log(data.success);
                        $("#productForm").trigger("reset");
                        $("#saveBtn").val("Save Changes");
                        $('#ajaxModal').modal('hide');
                        table.draw();
                    },
                    error:function(data){
                        console.log('Error:',data);
                        $("#saveBtn").val("Save Changes");
                    }

                });


                // alert("add button is clicked");
                // $('#ajaxModal').modal('hide');
            });
        });
    </script>
    
</body>
</html>