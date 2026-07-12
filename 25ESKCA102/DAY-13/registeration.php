
    <?php 
    include("header.php");
    include("db_connect.php");
include("checkRegisterationError.php");

    ?>
    <div class="container">
        <h1>Registration</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control mb-3" placeholder="Name" id="name" name="name" value="<?=$name ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?=$email ?>">
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?=$password ?>">
            </div>
            <div class="mb-3">
                <label for="confirmpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" value="<?=$confirmpassword ?>">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <?php
    include("footer.php");
    ?>

