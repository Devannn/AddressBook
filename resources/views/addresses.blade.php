<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Address Book - Laravel</title>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"  ntegrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Addresses</h1>
        <a class="btn btn-success" href="javascript:void(0)" id="createNewAddress" style="float:right">Add</a>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>First Name</th>
                    <th>Addition</th>
                    <th>Last Name</th>  
                    <th>Address</th>
                    <th>Postal Code</th>
                    <th>City Name</th>
                    <th>Phonenumber</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="addressForm" name="addressForm" class="form-horizonal">
                        <nput type="hidden" name="address_id" id="address_id">
                        <div class="form-group">
                            First Name: <br>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name" value="" required>
                        </div>
                        <div class="form-group">
                            Addition: <br>
                            <input type="text" class="form-control" id="addition" name="addition" placeholder="Enter addition" value="">
                        </div>
                        <div class="form-group">
                            Last Name: <br>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name" value="" required>
                        </div>
                        <div class="form-group">
                            Address: <br>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="" required>
                        </div>
                        <div class="form-group">
                            Postal Code: <br>
                            <input type="text" class="form-control" id="postalcode" name="postalcode" placeholder="Enter postal code" value="" required>
                        </div>
                        <div class="form-group">
                            City Name: <br>
                            <input type="text" class="form-control" id="cityname" name="cityname" placeholder="Enter city name" value="" required>
                        </div>
                        <div class="form-group">
                            Phonenumber: <br>
                            <input type="text" class="form-control" id="phonenumber" name="phonenumber" placeholder="Enter phonenumber" value="" required>
                        </div>
                        <div class="form-group">
                            Email: <br>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</body>
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $(".data-table").DataTable({ 
            serverSide:true,
            processing:true,
            ajax:"{{route('addresses.index')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'firstname', name:'firstname'},
                {data:'addition', name:'addition'},
                {data:'lastname', name:'lastname'},
                {data:'address', name:'address'},
                {data:'postalcode', name:'postalcode'},
                {data:'cityname', name:'city'},
                {data:'phonenumber', name:'phonenumber'},
                {data:'email', name:'email'},
                {data:'action', name:'action'},
            ]
        });

        $("#createNewAddress").click(function(){
            $("#address").val('');
            $("#addressForm").trigger("reset");
            $("#modalHeading").html("Add Address");
            $('#ajaxModel').modal('show');
        });
        $("#saveBtn").click(function(e){
            e.preventDefault();
            $(this).html('Save');
            
            $.ajax({
                data:$("#addressForm").serialize(),
                url:"{{route('addresses.store')}}",
                type:"POST",
                dataType:'json',
                success:function(data){
                    console.log('Success: ', data);
                    $("#addressForm").trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error:function(data){
                    console.log('Error: ', data);
                    $("#saveBtn").html('Save');
                }
            });
        });
        $('body').on('click', '.deleteAddress', function(){
            var address_id = $(this).data("id");
            confirm("Are you sure you want to delete?");
            $.ajax({
                type:"DELETE",
                url:"{{route('addresses.store')}}"+'/'+address_id,
                success:function(data){
                    table.draw();
                },
                error:function(data){
                    console.log('Error: ', data);
                }
            });
        });
        $('body').on('click', '.editAddress', function(){
            var address_id = $(this).data("id");
            $.get("[[route('addresses.index')}}"+"/"+address_id+"/edit", function(data){
                $("modelHeading").html("Edit Address");
                $('#ajaxModel').modal('show');
            })
        });
    });
</script>
</html>
