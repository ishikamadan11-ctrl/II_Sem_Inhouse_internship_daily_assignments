
    <?php 
   
    include("db_connect.php");
include("checkloginerror.php");
 include("header.php");
    ?>
    <div class="container">
        <h1>Login Form</h1>
        <form action="" method="POST" enctype="multipart/form-data">
          
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="profilepic" class="form-label">Profile Image (optional)</label>
                <input type="file" class="form-control" id="profilepic" name="profilepic" accept="image/*">
            </div>
           
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <?php
    include("footer.php");
    ?>