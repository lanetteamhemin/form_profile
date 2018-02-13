<html>
<head>
    <meta charset="UTF-8">
    <title>Demo | Register</title>

    <?php
        require_once("header_include.php");
    ?>

    <script type="text/javascript">
        $(document).ready(function () {

            function clearformdata(){
                $("#data_id").val("-1");
                $("#name").val("");
                $("#email").val("");
                $("#pwd").val("");
            }

            function savedata(){

                var form=new FormData();
                var name = $("#name").val();
                var email = $("#email").val();
                var pwd = $("#pwd").val();
                var file=$("#profile")[0].files[0];
                console.log("file name = "+file);
                if(file)
                {
                     form.append('name',name);
                     form.append('email',email);
                     form.append('password',pwd);
                     form.append('profile',file);
                }

                $.ajax({
                    type: "POST",
                    url: "http://192.168.200.83:1212/insert",
                    data: form,//{name: name, email: email, password: pwd, profile:file.name}
                    //data: {name: name, email: email, password: pwd,profile:file},
                    cache: false,
                    contentType: false, //must, tell jQuery not to process the data
                    processData: false,
                    success: function (data) {
                        if (data === "index") {
                            clearformdata();
                        } else {
                            console.log(data._id);
                            $.ajax({
                                type: "POST",
                                url: "API/session_data.php",
                                data:{id: data._id},
                                success: function(data){
                                    console.log(data);
                                    window.location = "home.php";
                                },error: function(err){
                                    console.log("error occure during access session data");
                                }
                            });
                        }
                        //window.location="home.php";
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }

            $("#register").click(function () {
                alert("call click event");
                var id = $("#data_id").val();
                if(id=="-1") savedata();
                else updatedata();

            });
            $("#cancel").click(function(){
                clearformdata();
            })
        });
    </script>
</head>
<body>

    <br>
    <form method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 well" style="height:600px">
            <center><h2>Register</h2></center>
            <input type="hidden" id="data_id" value="-1"><br>
            <div class="form-group">
                <label for="text">Name:</label>
                <input type="text" class="form-control" id="name">
            </div><br>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email">
            </div><br>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd">
            </div><br>
            <div class="form-group">
                <label for="profile">Profile:</label>
                <input type="file" class="" id="profile">
            </div><br>
            <center>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-info btnregister" name="register" id="register">Register</button>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-danger" name="cancel" id="cancel">Cancel</button>
                </div><br>
            </center>

            <br><br>
            Click Here <a href="index.php">Login</a>
        </div>
    </div>
    </form>


<br><br>
<div id="datasource">

</div>

</body>
</html>