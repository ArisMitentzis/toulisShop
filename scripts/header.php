
<!DOCTYPE html>
<html lang="en">
<head>

	<title>Pet Shop Aris</title>
  
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"></script>

    
<!--
    <script src="https://cdn.datatables.net/1.10.24/css/dataTables.jqueryui.min.css"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.jqueryui.min.js"></script>
-->
    
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<script src="js/interact.js"></script>
	
    <link rel="stylesheet" href="css/style.css">
  
</head>

<body>

<div class="container-width" style="background-color:#e9d28c">
<div class="container" style="background-color:#e9d28c">

	<!-- η γραμμή του header -->
	<div class="row" style="height:140px;">
		
		<!-- η αριστερή στήλη του header που περιέχει το λογότυπο -->
		<div class="col-2 bg-warning">
			 <a href="index.php">
				<img src="images\logoNew.jpg" class="img-fluid pt-1 rounded-circle" alt="logo" stlyle="height:130px;"> 
			 </a>
		</div>
		
		<!-- η μεσαία στήλη του header που περιέχει την αναζήτηση -->
		<div class="col-4 bg-warning">
		<br>
<!--
			<div class="input-group pt-2 pl-1">
				<div class="input-group-prepend border border-0">
					<span class="input-group-text border border-0 bg-warning">
						<i class='fas fa-search' style='font-size:120%;color:#0000ff;'></i>
					</span>
				</div>
					<input type="text" class="form-control bg-warning text-dark" placeholder="Αναζήτηση" style="border:2px solid #0000ff" >
			</div>
-->
<!--            <br>-->
            <div class="mt-n2 ml-n3"><h1 class="ml-n4" style="font-weight:bold;color:#0000ff;">Toulis shop</h1></div>
		</div>
		
		<!-- η δεξιά στήλη του header που περιέχει τα υπόλοιπα(λογαριασμό,καλάθι,email,τηλέφωνο) -->
		<div class="col-6 bg-warning">
		<br>
			<div class="row mt-n3" style="height:40%;">
				
				<div class="col">
					<span>
						<a href="index.php">
							<i class="material-icons float-left mr-1 " style="font-size:45px;color:#0000ff;">&#xe0e1;</i>	
						</a>
							<span class= "align-middle"> 
								<p class="tiny mt-2" style="height:3px;">
									<small style="font-weight:bold">sales@petshop.gr</small> 
									<br>
									<small style="font-size:10px;"class=""> Email για παραγγελία </small>
								</p>
							</span>
					</span>
				</div>
				
				<div class="col">
					<span>
						<a href="<?php if (UserType::$userType == UserType::notAdmin || UserType::$userType == UserType::admin){echo "menu_account";} else {echo "sign_in";}?>.php">
							<i class="material-icons float-left mr-1 " style="font-size:26px;color:#0000ff;">&#xe853;</i>		
							<span class= "align-middle"> 
								<small>Ο λογαριασμός μου</small> 
							</span>
						</a>
					</span>
				</div>
				
				<div class="col">
					<span>
								
							<span class= "align-middle"> 
								<small class="font-weight-bolder" >
								    <?php echoCheckLoginMessage();?>
								</small> 
							</span>
						
					</span>
				</div>

			</div>
			
			<div class="row" style="height:40%;">
				
				<div class="col">
					<span>
						<i class="material-icons float-left mr-1 " style="font-size:45px;color:#0000ff;">&#xe551;</i>		
						<span class= "align-middle"> 
							<p class="tiny mt-2" style="height:3px;">
								<small style="font-weight:bold">+30 2310 123456</small>  
								<br>
								<small style="font-size:10px;"class=""> Τηλεφωνική παραγγελία </small>
							</p>
						</span>
					</span>
				</div>
				
				<div class="col">
					<span>
						<a href="<?php if (UserType::$userType == UserType::notLogged) {echo "sign_in";} else {echo "page3";}?>.php">
							<i class="fas fa-shopping-cart float-left mr-1 " style="font-size:26px;color:#0000ff;"></i>		
							<span class= "align-middle"> 
								<small id="cartHlineSmall"><?php echoCartMessage();?></small>
							</span>
						</a>
					</span>
				</div>
				
				<div class="col">
					<span>
				        <?php echoLoginLink();?>
					</span>
				</div>
				
			</div>
		</div>
	</div>
	
	