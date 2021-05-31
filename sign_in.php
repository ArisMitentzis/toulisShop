<?php include "functions_and_classes\\front_end_functions.php" ?>
<?php include "functions_and_classes\\controller_functions.php" ?>
<?php include "functions_and_classes\\back_end_functions.php" ?>
<?php include "functions_and_classes\\classes.php" ?>

<?php include "scripts\\driver.php" ?>
<?php include "scripts\\header.php" ?>
<?php include "scripts\\menu.php" ?>


<div class="container-width mt-2" style="height:1100px;background-color:#e9d28c">
	
    <div class="jumbotron mx-auto mt-5" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:500px;width:500px;background-color:#e9d28c;">
               
        <h2 class="font-weight-bolder mx-auto mt-n5 pl-4" style="width:300px">Είσοδος χρήστη</h2>
                
        <form action="index.php" method="post">
                
            <div class="form-group">
                
                <div class="row pt-4 mt-5">
				    <input type="text" class="form-control mx-auto" id="userEmail" name="userEmail" style="width:300px" placeholder="Email χρήστη" required>
                </div>
                
                <div class="row mt-3">
				    <input type="password" class="form-control mx-auto" id="userPassword" name="userPassword" style="width:300px" placeholder="Password" required>
                </div>
                
                <div class="row mt-5 pt-2">
                     <button type="submit" class="form-control mx-auto btn btn-secondary ml-5" style="width:300px" name="loginButton">Σύνδεση</button>  
                </div>
                
                <div class="row mt-4">
				    <a href="sign_up.php" class="mx-auto" style="text-decoration:none;">
				        <p class="font-weight-bold">Δεν έχετε λογαριασμό; Πατήστε για να εγγραφείτε</p>
				    </a>
                </div>
            </div>
        </form>	
        
        <div class="row mt-1 pt-2">
            <button class="form-control mx-auto btn btn-secondary ml-5" style="width:300px" id="fillSimpleUser">Fill with sample simple user</button>  
        </div>
                
        <div class="row mt-1 pt-2">
            <button class="form-control mx-auto btn btn-secondary ml-5" style="width:300px" id="fillAdmin">Fill with sample admin</button>  
        </div>
        
    </div>	
</div>


<?php include "scripts\\footer.php" ?>

<script src="js\\fillSampleCredentials.js"></script>