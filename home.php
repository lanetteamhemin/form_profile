<?php
require_once("header_include.php");
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <script src="./script/js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <style type="text/css">
        .btnlogout {
            float: right;
            padding-right: 2%;

        }

        table {
            border: 2px solid black

        }

        td {
            margin-left: 15%;
        }

        .settable {
            border-collapse: collapse;
            border: 2px solid black;
        }

        .settbl-head {
            background-color: rgba(0, 0, 0, 0.91);
            color: aqua;
            font-weight: bold;
            font-size: x-large;
        }

        .set-welcome{
            margin: auto;
            width: 60%;
            padding: 5px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {


            function formdataget() {
                $id = $("#data_id").val();
                $name = $("#name").val();
                $email = $("#email").val();
                $pwd = $("#pwd").val();
            }

            function clearformdata() {
                $("#data_id").val("-1");
                $("#name").val("");
                $("#email").val("");
                $("#pwd").val("");
            }

            function removedata(_id) {
                console.log(_id);
                $req = "http://192.168.200.83:1212/delete/" + _id
                $.ajax({
                    type: "DELETE",
                    url: $req,
                    data: {id: _id},
                    success: function (res) {
                        swal("Your selected data has been deleted successfully!", {
                            icon: "success",
                        });
                        loadmydata();
                    },
                    error: function (err) {
                        alert(err);
                    }
                });
            }

            function updatedata() {
                var id=$("#data_id").val();
                var name = $("#name").val();
                var email = $("#email").val();


                $.ajax({
                    type: "POST",
                    url: "http://192.168.200.83:1212/updatebyid/" + id,
                    data: {name: $name, email: $email},
                    success: function (res) {
                        if (res) {
                            swal("Your data successfully updated...!", {
                                icon: "success",
                            });
                            clearformdata();
                            loadmydata();
                        }
                    },
                    error: function (err) {
                        alert("update error");
                    }
                });
            }

            function savedata() {
                console.log("hello");
                formdataget();
                $.ajax({
                    type: "POST",
                    url: "http://192.168.200.83:1212/insert",
                    data: {name: $name, email: $email, password: $pwd},
                    success: function (res) {
                        if (res) {
                            clearformdata();
                            loadmydata();
                        }
                    },
                    error: function (err) {
                        alert(err);
                    }
                });
            }

            function loadmydata() {
                <?php
                if(isset($_SESSION['name']))
                {
                    $name = $_SESSION['name'];
                    if($name != "")
                    {
                    ?>
                        $("#up").hide();
                        //console.log(localStorage.getItem("userinfo"));

                        //alert("load function call");
                        $.ajax({
                            type: "GET",
                            url: "http://192.168.200.83:1212/show",//"API/fetch_all_record.php",
                            success: function (res) {
                                console.log(res);
                                var len = res.length;
                                var txt = "";
                                var name = "";
                                if (len > 0) {
                                    for (var i = 0; i < len; i++) {
                                        if (res[i].name && res[i].email && res[i].password) {
                                            txt += '<tr class="settable">';
                                            txt += '<td>' + res[i].name + '</td>';
                                            name +='<option>' + res[i].name + '</option>';
                                            txt += '<td>' + res[i].email + '</td>';
                                            // txt += '<td><img src="http://192.168.200.83/JS_Example/Rest_api_php/img/' + res[i].profile + '" height="50px" width="50px" class="img-circle"/></td>';
                                            txt += '<td><a class="_Editdata" _id="' + res[i].id + '">Edit</a> | ';
                                            txt += '<a class="_Removedata model" _id="' + res[i].id + '">Remove</a></td>'
                                            txt += '</tr>';
                                        }
                                    }
                                }
                                if (txt !== "") {
                                    $("#tblbody").html(txt);
                                    $(".single-search-name").html(name);
                                }
                            },
                            error: function (err) {
                                console.log('error');
                                alert("error" + err);
                            }
                        }).done(function (d) {
                            $(".single-search-name").select2();
                            $("#tbl").DataTable();
                            /*$("#tbl").DataTable({
                                serverSide: true,
                                ordering: false,
                                searching: false,
                                ajax: function ( data, callback) {
                                    var out = [];
                                    // console.log(data);

                                    d.forEach(function(e){
                                        out.push([e.name,e.email,"<a class='_Editdata' _id='"+e.id +"' >Edit</a> | <a class='_Removedata' _id='" + e.id + "'>Remove</a>"])
                                    })

                                    setTimeout( function () {
                                        callback( {
                                            draw: data.draw,
                                            data: out,
                                            recordsTotal: out.length,
                                            recordsFiltered: out.length
                                        } );
                                    }, 50 );
                                },
                                scrollY: 200,
                                scroller: {
                                   loadingIndicator: true
                                },success : function () {
                                    alert();
                                }
                            });*/

                            $("._Removedata").click(function () {

                                $("#up").hide();
                                swal({
                                    title: "Are you sure?",
                                    text: "Once deleted, you will not be able to recover selected record!",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                }).then((willDelete) => {
                                    if (willDelete) {
                                        var _id = $(this).attr("_id");
                                        removedata(_id);
                                    }
                                    else {
                                        swal("your selected record canceled...");
                                    }
                                });
                            });

                            $("._Editdata").click(function () {
                                var _id = $(this).attr("_id");
                                console.log('fetch by id update='+_id);
                                $req = "http://192.168.200.83:1212/fetchbyid/" + _id;
                                $.ajax({
                                    type: "GET",
                                    url: $req,
                                    data: {id: _id},
                                    success: function (res) {
                                        $("#up").show();
                                        $("#data_id").val(res[0].id);
                                        $("#name").val(res[0].name);
                                        $("#email").val(res[0].email);

                                        // $("#update_profile").attr("src","http://192.168.200.83/JS_Example/Rest_api_php/img/"+res[0].profile);
                                        $("#register").text("update");
                                    },
                                    error: function (err) {
                                        alert(err);
                                    }
                                });
                            });
                        });
                    <?php
                    }
                }else
                {
                    ?>
                    window.location="logout.php";
                    <?php
                }
                ?>

            };

            loadmydata();

            $("#register").click(function () {
                formdataget();
                if ($id == "-1") savedata();
                else updatedata();

            });
            $("#cancel").click(function () {
                clearformdata();
                $("#up").hide();
            });
            $("#logout").click(function () {
                $.ajax({
                    type: "GET",
                    url: "logout.php",
                    data: {data: data},
                    success: function (res) {
                        console.log("logout");
                    },
                    error: function (err) {
                        alert(err);
                    }
                });
            });
            //$("#chktbl").DataTable();
            //$("#tbl").DataTable();
        });
    </script>
</head>
<body>
<br>
<?php
require_once("header.php");
?>
<center>
    <h3>Display Record</h3><hr>
</center>
Search By Name(select2 lib):
<select class="single-search-name" name="name">

</select><br>
<div class="row" id="up">
    <div class="col-sm-3">
        <input type="hidden" id="data_id" value="-1"><br>
        <div class="form-group">
            <label for="text">Name:</label>
            <input type="text" class="form-control" id="name">
        </div>
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email">
        </div>
        <button type="submit" class="btn btn-info btnregister" name="register" id="register">Register</button>
        <button type="submit" class="btn btn-danger" name="cancel" id="cancel">Cancel</button>
    </div>
</div>

<br>
<div id="datasource" class="well">
    <table id="tbl" class="table settable">
        <thead class="settbl-head">
        <tr>
            <th>Name</th>
            <th>Email</th>
<!--            <th>Profile</th>-->
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="tblbody">
        </tbody>
    </table>
</div>
</body>
</html>

