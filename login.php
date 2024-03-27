<?php
    session_start();
    require_once("include/header.php");
    if(isset($_SESSION['user_id'])){
        header('Location:index.php');

    }
?>


<div class="container">
    <h2 class="text-center">Welcome to the Blog</h2>

    <div class="row gx-0">
        <div class="card col col-5">
            <div class="card-header">
                Register
            </div>
            <?php
            if(isset($_SESSION['register_error'])){?>
                <ul class="bg-danger">
            <?php
                foreach($_SESSION['register_error'] as $error){?> 
                    <li class="text-light"><?=$error?></li>
            <?php } ?>
                    </ul>    
            <?php    
                unset($_SESSION['register_error'] );
            }else if(isset($_SESSION['register_success'])){?>
                <h5 class="text-success text-center"><?=$_SESSION['register_success']?></h5>
            <?php    
                unset($_SESSION['register_success'] );
            }
            ?>

            <form action="process.php" method="POST" class="card-body ">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="firstName">
                </div>

                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" id="lastName" >
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" >
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirmPassword" >
                </div>

                <input type="submit" name="register" value="Register" class="btn btn-primary">
            </form>
        </div>

        <div class="card col-auto col-5 offset-2">
            <div class="card-header">
                Login
            </div>
            <?php
            if(isset($_SESSION['login_error'])){ ?>
                <ul class="bg-danger">
            <?php
                foreach($_SESSION['login_error'] as $error){?>
                    <li class="text-light"><?=$error?></li>    
             
            <?php    
                    }
            
            ?>
                </ul>
            <?php    
            unset($_SESSION['login_error'] );
                    }
            
            ?>

                

            

        <form action="process.php" method="POST" class="card-body">

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" >
                </div>

                <input type="submit" name="login" value="Login" class="btn btn-primary">
            </form>
        </div>


</div>


<?php
    
    require_once("include/footer.php");

?>