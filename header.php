<?php
require_once("header_include.php");
?>

<div class="row">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav" style="alignment: right;float:right;margin-right: 3%">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <img src="http://192.168.200.83/JS_Example/Rest_api_php/img/<?php echo $_SESSION['profile']; ?>" height="50px" width="50px" id="profile" class="img-circle"/>
                        <?php echo ucwords($_SESSION['name']); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="update_profile.php">
                                <i class="glyphicon glyphicon-user"> Change Profile</i>
                            </a>
                        </li>
                        <li>
                            <a href="logout.php">
                                <i class="fa fa-power-off"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                </li>
            </ul>
        </div>
    </nav>
</div>