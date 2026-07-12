
    <?php 
    include("dashboardheader.php");
    
    
include("checkupdateerror.php");

    ?>
    <div class="container">
        <h1>Update Password</h1>
        <form action="" method="POST">
          
            <div class="mb-3">
                <label for="password" class="form-label"></label>
                <input type="password" class="form-control" id="password" name="oldpassword" placeholder="Old Password">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"></label>
                <input type="password" class="form-control" id="password" name="newpassword" placeholder="New Password">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"></label>
                <input type="password" class="form-control" id="password" name="confirmpassword" placeholder="Confirm New Password">
            </div>
           
            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>
    <?php
    
    include("footer.php");
    ?>