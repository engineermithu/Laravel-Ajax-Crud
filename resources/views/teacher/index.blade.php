<!doctype html>
<html lang="en">
<head>
    <title>Laravel Ajax</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.33/sweetalert2.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.33/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.33/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.33/sweetalert2.all.min.js"></script>

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <!--Button icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<div style="padding: 30px;"></div>
<div class="container">
    <h2 style="color: green;">
        <marquee behavior="#" direction="#"> Laravel Ajax</marquee>
    </h2>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-border">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Title</th>
                            <th scope="col">Department</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <span id="addT">Add new Teacher</span>
                    <span id="UpdateT">Update Teacher</span>
                </div>
                <div class="card-body">
{{--                    <form>--}}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Institute</label>
                            <input type="text" class="form-control" id="institute">
                        </div>

                        <input type="hidden" class="form-control" id="id" />
                        <button type="submit" id="addB"class="btn btn-primary" onclick="addData()">Add</button>
                        <button type="submit" id="updateB"class="btn btn-primary" onclick="updateData()">Update</button>
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
</div>

<!--JS-->
<script>
    $('#addT').show();
    $('#UpdateT').hide();
    $('#addB').show();
    $('#updateB').hide();

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    function allData(){
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/teacher/all",
            success:function (response){
                var data ="";
                $.each(response, function (key,value){
                    data = data + "<tr>"
                    data = data + "<td>"+value.id+"</td>"
                    data = data + "<td>"+value.name+"</td>"
                    data = data + "<td>"+value.title+"</td>"
                    data = data + "<td>"+value.institute+"</td>"
                    data = data + "<td>"
                    data = data + "<button class='btn btn-info text-light' onclick='editData("+value.id+")'>Edit</button>"
                    data = data + "<button class='btn btn-danger m-2' onclick='deleteData("+value.id+")'>  Delete</button>"
                    data = data + "</td>"
                    data = data + "</tr>"
                })
                $('tbody').html(data);
            }
        })
    }
    allData();

    function clearData(){
        $('#name').val('');
        $('#title').val('');
        $('#institute').val('');
    }
    function addData(){
        var name        =   $('#name').val();
        var title       =   $('#title').val();
        var institute   =   $('#institute').val();

        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {name:name, title:title, institute:institute},
            url: "/teacher/store/",
            success: function (data){
                allData();
                clearData();
                // Alert
              const Msg = Swal.mixin({
                    toast:'true',
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1600
                });
              Msg.fire({
                  type: 'success',
                  title: 'Data Added Successfully'
              })
                // End Alert
                console.log('Successfully Data Added');
            }
        })
    }

    function editData(id){
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/teacher/edit/"+id,
            success: function (data){
                $('#addT').hide();
                $('#UpdateT').show();
                $('#addB').hide();
                $('#updateB').show();
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#title').val(data.title);
                $('#institute').val(data.institute);
            }
        })
    }

    function updateData(){
        var id          =   $('#id').val();
        var name        =   $('#name').val();
        var title       =   $('#title').val();
        var institute   =   $('#institute').val();

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {name:name, title:title, institute:institute},
            url: "/teacher/update/"+id,
            success: function (data){
                $('#addT').show();
                $('#UpdateT').hide();
                $('#addB').show();
                $('#updateB').hide();
                allData();
                clearData();
                // Alert
                const Msg = Swal.mixin({
                    toast:'true',
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1600
                });
                Msg.fire({
                    type: 'success',
                    title: 'Data Updated Successfully'
                })
                // End Alert
                console.log('Successfully Data Update');
            }
        })
    }

    function deleteData(id){
        // swal({
        //     title:"Are you shure to Delete",
        //     text:"Once deleted , you will not able to recover this data!",
        //     icon:"warning",
        //     buttons:true,
        //     dangerMode: true,
        // })
        //     .then((willDelete) => {
        //         if(willDelete){
        //             $.ajax({
        //                 type: "GET",
        //                 dataType: "json",
        //                 url: "/teacher/destroy/"+id,
        //                 success:function (data){
        //                     clearData();
        //                     allData();
        //                     // Alert
        //                     const Msg = Swal.mixin({
        //                         toast:'true',
        //                         position: 'top-end',
        //                         icon: 'success',
        //                         showConfirmButton: false,
        //                         timer: 1600
        //                     });
        //                     Msg.fire({
        //                         type: 'success',
        //                         title: 'Data Updated Successfully'
        //                     })
        //                     // End Alert
        //                 }
        //             });
        //         }else{
        //             swal("Canceled");
        //         }
        //     })


        $.ajax
        ({
            type: "GET",
            dataType: "json",
            url: "/teacher/destroy/"+id,
            success:function (data){
                clearData();
                allData();
                // Alert
                const Msg = Swal.mixin({
                    toast:'true',
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1600
                });
                Msg.fire({
                    type: 'success',
                    title: 'Data Deleted Successfully'
                })
                // End Alert
            }
        });




}






</script>

</body>
</html>
