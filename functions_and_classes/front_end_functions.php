<?php   
    // Kanei echo ena tetragwno-proiontos -atomikh vitrina
    // kaleitai apo thn front-end function echoRowOfProductBox
    // pairnei ws parametrous
    //      - $marginsString: kapoia margin kai padding pou dinontai me bash th thesh toy ProductBox
    //      - $row: pinakas me ta stoixeia tou proiontos poy katexei thn current vitrina
    //      - $indexOfBox: to index tou box sth diataksh apo aristera pros ta deksia kai apo panw 
                           // pros ta katw. -> xreiazetai sth leitourgeia tou kalathiou
                           // sos se ola ta names mpainei sto sto telos _$indexOfBox
                           // etsi mporw na ta diatreksw kata th leitoyrgia tou  kalathiou
    //      - $page: h selida sthn opoia typwnetai to productBox -> anagkaio gia ta links
    //      - $dataAttributString: string gia na mpei ws value sto data-vitrina->
    //                             data attribute - mpainei pop h row analoga to row sthn index page.
    //                             an prokeitai gia to page2 -> afhnetai keno

    // exw valei klash buyButton (koumpi kalathiou) sto koumpi agoras gia na mporei na ta tsimphsei sto onclick
    
// exw valei klash vitrinaDiv (geniko div vitrinas) sto koumpi agoras giati voleuei sto traverse ths js sto sugxronismo

// exw valei klash productCodeInput (posothta) sto koumpi agoras giati voleuei sto traverse ths js sto sugxronismo

// data-vitrina-> einai sto div ths vitrinas ws  data attribute - mpainei value pop h row 
    // h xrhsh tou einai oti otan h js sugronizei ta quantities anamesa se
    // koinh emfanish proiontos sto pop kai sto last row, voleuei h xrhs tou ws flag
    function echoProductBox($marginsString,$row,$indexOfBox,$page,$dataAttributString) {
?>       
        <div class="vitrinaDiv col border border-dark <?php echo $marginsString ?>" data-vitrina="<?php if (!is_null($dataAttributString)) {echo $dataAttributString;} ?>">
<!--      apofasisa se deutero xrono na entaksw kai tis 6 vitrines se mia koinh forma
          arxika htan to kathena sth dikh toy forma pragma pou profanws de voleue-->
<!--            <form action="<?php echo $page;?>" method="post">-->
				<div class="custom-control-inline">
				    <p id="prodNameP_<?php echo $indexOfBox;?>" class="font-weight-bold"><?php echo $row['PRODNAME']; ?></p>
                    <input type="text" class="font-weight-bold" style="background-color:#e9d28c;visibility: hidden;width:1px;" id="prodName_<?php echo $indexOfBox;?>" name="prodName_<?php echo $indexOfBox;?>"value="<?php echo $row['PRODNAME']; ?>" /> 
                    <pre>   </pre>
				    <input type="text" class="productCodeInput" style="width:30px;height:20px;visibility: hidden;" id="prodCode_<?php echo $indexOfBox;?>" name="prodCode_<?php echo $indexOfBox;?>" value="<?php echo $row['PRODCODE']; ?>" >
                </div>
				
				<div class="row mt-1" style="height:60%;">
					<div class="col ml-1" style="height:100%;">
				        <img id="prodPic_<?php echo $indexOfBox;?>" src="images\products\<?php echo $row['PRODPIC']; ?>" class="img-fluid rounded" alt="mocca" style="height:95%;">
					</div>
					<div class="col" style="height:100%;">
						<p id="prodDescreption_<?php echo $indexOfBox;?>" class="small"><?php echo $row['PRODDESCRIPTION']; ?>
						</p>
					</div>
				</div>
				<div class="row mt-2" style="height:25%;">
					<div class="col mt-2" style="height:100%;">
						<div class="custom-control-inline">
						    <input id="prodValue_<?php echo $indexOfBox;?>" type="text" style="width:50px;height:30px;" name="prodValue_<?php echo $indexOfBox?>" value="<?php echo $row['PRODVALUE']; ?>"/>€
						    <input id="quantity_<?php echo $indexOfBox;?>" type="number" class="quantityInput ml-3" name="quantity_<?php echo $indexOfBox;?>" min="0" max="<?php echo $row['PRODSTOCK']; ?>" value="<?php echo getQuantityOfSpecificProdCodeCart($row['PRODCODE']);?>" onkeydown="return false"/>
                        </div>
					</div>
					<div class="col" style="height:100%;">
						<input id="prodStock_<?php echo $indexOfBox;?>"  type="text" class=" " style="width:30px;visibility: hidden;" name="prodStock_<?php echo $indexOfBox;?>" value="<?php echo $row['PRODSTOCK']; ?>" >
						<button type="submit" class="buyButton btn btn-sm btn-outline-warning mb-2" name="btnPr_<?php echo $indexOfBox?>" style="border:1px;border-color: #2196F3;">
                            <i class="material-icons float-left mr-1" style="font-size:32px;color:#0000ff;">add_shopping_cart</i>
<!--							<small style="font-size:9px;">-->
<!--								Προσθήκη στο Καλάθι-->
<!--							</small>	-->
						</button>
						
					</div>
				</div>
<!--            </form>-->
        </div>
<?php
    }
?>

<?php

    // sos -> na ftiaksw kai to ana dhmofilia kai na dw pws tha mporesw na meiwsw epanalipsimothta

    // Kaleitai 2 fores sto index.php 
    //      - Prwta: gia ta 3 last products - me orisma: RowOfProductBoxPlace::last
    //      - Epeita: gia ta 3 most popular products - me orisma: RowOfProductBoxPlace::popular
    // shmeiwsh yparxei kai pagination - opou erxontai ola ta proionta basei prosfatothta-popularity
    
    // Kaleitai 2 fores (2 dyades) sto page2.php kai tis 2 fores me orisma RowOfProductBoxPlace::byType
    // 
    // shmeiwsh yparxei pagination wste na mporoun na diatrexthoyn ola ta proionta ana tessera

    // Kanei echo mia seira apo products - opws yparxoyn sto index.php (2 triades) kai sto page2.php (2 duades)
    // parametroi 
    //          - $RowOfProductBoxPlace -> kathorizei to typo ths taksinomhsh -- tha dw kata poso xreiazetai
    //          - $resultProducts -> to resultset me ta proionta
    //          - $page ->arithmos selidas sto pagination (to indexing kssekina apo 0)
    //          - $isDown -> xrhsimopoieitai mono se klhsh apo page2.php (to index.php dinei null) 
    //                        - deixnei an einai h panw h hkatw seira

    //          - $plus3InIdIndexes -> katarghthike - mporouse na oristei eswterika -iparxei ws variable pleon

    //                           pairnei times {0,3}. Pairnei thn timh 3, mono otan
    //                                  kanei echo thn triada twn dhmofilwn proiontwn
    //                                  to nohma toy einai na dwsei  id vitrinas: 
    //                                  3,4,5 anti gia 0,1,2 poy tha kaparwthoyn apo ta 3 pio dhmofilh

    function echoRowOfProductBox($RowOfProductBoxPlace,$resultProducts,$page,$isDown) {
        
        // result set me ola ta products vasei prosfatothtas -> apo to pio prosfato sto pio palio (index.php)
        //global $resultAllProductsByIdDesc;
        
        // result set me ola ta products vasei prosfatothtas (mporei na exei kai filtrarisma ana kathgoria omws)
        // -> apo to pio prosfato sto pio palio (page2.php)
        //global $resultProducts;
        
        // arithmo selidas pou thelw na apeikonisw sthn panw triada (ana prosfatothta) (index.php)
        //global $lastPage;
        
        // arithmo selidas pou thelw na apeikonisw sthn tetrada (ana prosfatothta) (page2.php)
        //global $page;
        
        // pairnei timh sthn page2.php kai afora ayth mono - 0:panw duada, 1:katw duada
        //global $isDown;
        
        // metablhth pou krata to onoma ths selidas pou kalese th synarthsh
        // arxikopoihsh
        $actionPage="index.php";
        
        $plus3InIdIndexes=0;
        $dataAttributString=null;
        
        // an to orisma afora taksinomhsh an palaiothta apo to pio prosfato
        // prwth triada - index.php
        if ($RowOfProductBoxPlace == RowOfProductBoxPlace::last || $RowOfProductBoxPlace ==     RowOfProductBoxPlace::popular){
            
            if ($RowOfProductBoxPlace == RowOfProductBoxPlace::popular){
                
                $plus3InIdIndexes=3;
                $dataAttributString='pop_page';
            }
            else {
                
                $dataAttributString='last_page';
            }
            
            // vale to index tou fetch sthn arxh ths zhtoymenh triadas me vash th zhtoymenh page
            mysqli_data_seek($resultProducts,($page*3));
            
            // diatrexei thn triada twn proiontwn pou einai na tupwsei
            // kai otan yparxei row kalei thn echoProductBox
            // alliws vazei keno div (gia na diathrhhthei h diataksh)
            for($counter = 0; $counter < 3; $counter++){
                    
                if ($row = mysqli_fetch_assoc($resultProducts)){
                        
                    echoProductBox("mr-4",$row,$counter + $plus3InIdIndexes,$actionPage,$dataAttributString);
                }
                else{
?>
                    <div class="col  <?php echo "mr-4" ?>">
                    </div>
<?php
                }
            } 
        }
        
        // tote afora thn ana typo
        // ths page2.php (dyo duades)
        else {
            
            // tote h klhsh prohlthe apo thn allh selida
            $actionPage="page2.php";
            
            // vale to index tou fetch sthn arxh ths zhtoymenh duadas me vash th zhtoymenh page kai to $isDown
            mysqli_data_seek($resultProducts,($page * 4) + ($isDown * 2));
            
            // ousiastika frontizw na dwsw ton counter ths tetradas
            if ($isDown==0){
                
                $first=0;
                $second=1;
            }
            else {
                
                $first=2;
                $second=3;
            }
            
            // otan yparxei row kalei thn echoProductBox
            // alliws vazei keno div (gia na diathrhhthei h diataksh)
            if ($row = mysqli_fetch_assoc($resultProducts)){
                        
                echoProductBox("mr-2",$row,$first,$actionPage,$dataAttributString);
            }
            else{
?>
                <div class="col  <?php echo "mr-2" ?>">
                </div>
<?php
            }
            
            // otan yparxei row kalei thn echoProductBox
            // alliws vazei keno div (gia na diathrhhthei h diataksh)
             if ($row = mysqli_fetch_assoc($resultProducts)){
                        
                echoProductBox("ml-2 mr-n5",$row,$second,$actionPage,$dataAttributString);
            }
            else{
?>
                <div class="col  <?php echo "ml-2 mr-n5" ?>">
                </div>
<?php
            }
        }      
    }    
?>


<?php
    
    // Kaleitai sto header.php
    // kanei echo ena mhnyma sxetika me to an o xrhsths einai signed in h oxi
    function echoCheckLoginMessage() {
        
        if (UserType::$userType == UserType::notLogged || isset($_POST['delete'])) {
            echo "You are not signed in!";    
        }
        else {
            echo "You are signed in!";    
        }
    }    
?>

<?php

    // Kaleitai sto header.php
    // Analoga me to an o xrhsths einai syndedemenos h oxi - kai analoga me to an einai admin h oxi
    
    // kanei echo ena mhnyma poy:
    //                  - an o xrhsths einai guest -> sundesmos gia log in h sign up
    //                  - an o xrhsths einai syndedemnos -> grafei xairetismo (grafei kai admin an admin)
    //                                                      kai syndesmos gia logout
    function echoLoginLink() {
        
        if (UserType::$userType == UserType::notLogged || isset($_POST['delete'])) {
?>
            <a href="sign_in.php">		
                <span class= "align-middle"> 
				    <small class="font-weight-bolder">Log in or sign up!</small> 
				</span>
            </a>
<?php       
        }
        else {
?>
    <small class="font-weight-bolder">       
<?php
            echo "Welcome, " . UserType::$userFirst . " " . UserType::$userLast;
            
            if (UserType::$userType == UserType::admin){
                
                echo " (admin)";
            }?>
            
    <br/>
    <a href="index.php?loginButton=1">		
                <span class= "align-middle"> 
				    <p class="font-weight-bolder">Log out!</p> 
				</span>
    </a>    
            
    <?php        
        }
?>
    </small>
    
<?php      
    }    
?>

<?php
    // Kanei echo mhnyma epityxias h apotyxias analoga me thn timh ths boolean $success
    // to successMessage den yparxei panta - dinetai null otan den yparxei
    // mporoun na dothoun osa link-keimena zeugh thelw
    function echoAttemptMessage($success,$successTitle,$successMessage,$successLinksArray,$successLinkTitlesArray,$failTitle,$failMessage,$failLinksArray,$failLinkTitlesArray) {
?>
       
       <div class="jumbotron mx-auto mt-5" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:400px;width:540px;background-color:#e9d28c;">
       
<?php
        //global $emailAlreadyExists;
        
        if ($success) { ?>
            
            <h4 class="font-weight-bolder mx-auto mt-n5 pl-4" style="width:500px">Η <?php echo $successTitle;?> πραγματοποιήθηκε.</h4>
                
                <?php if (! is_null($successMessage)) { ?>
                    <div class="row mt-5">         
                        <p class="mx-auto"><?php echo $successMessage;?></p>
                    </div>
                <?php } ?> 
                  
<?php          
                $length = count($successLinksArray);
        
                for($counter=0; $counter < $length; $counter++){             
?>    
                      
                <div class="row mt-4 pt-2">         
                    <a href= "<?php echo $successLinksArray[$counter];?>" class="mx-auto" style="text-decoration:none;">
                        <p class="font-weight-bold"><?php echo $successLinkTitlesArray[$counter];?></p>
                    </a>
                </div> 

<?php  
                }
        }
        else {
?>           
            <h4 class="font-weight-bolder mx-auto mt-n5 pl-4" style="width:400px">Η προσπάθεια <?php echo $failTitle;?> απέτυχε.</h4>
                
                <?php if (! is_null($failMessage)) { ?>
                    <div class="row mt-5">         
                        <p><?php echo $failMessage;?></p>
                    </div>   
                <?php } ?>   
                  
<?php          
                $length = count($failLinksArray);
        
                for($counter=0; $counter < $length; $counter++){             
?>    
                <div class="row mt-4 pt-2">         
                    <a href= "<?php echo $failLinksArray[$counter];?>" class="mx-auto" style="text-decoration:none;">
                        <p class="font-weight-bold"><?php echo $failLinkTitlesArray[$counter];?></p>
                    </a>
                </div> 
<?php     
                }
            }
?>
  
       </div>
     
<?php
    }
?>

<?php
    // // Kanei echo mhnyma 
    // to message den yparxei panta - dinetai null otan den yparxei
    // mporoun na dothoun osa link-keimena zeugh thelw
    function echoSingleMessage($title,$message,$linksArray,$linkTitlesArray) {
?>
       
       <div class="jumbotron mx-auto mt-5" style="border-style:solid;border-radius: 12px; border-color:#f0ad4e;height:400px;width:540px;background-color:#e9d28c;">
       
        <h4 class="font-weight-bolder mx-auto mt-n5 pl-4" style="width:500px"><?php echo $title;?></h4>
                
        <?php if (! is_null($message)) { ?>
                <div class="row mt-5">         
                    <p class="mx-auto"><?php echo $message;?></p>
                </div>
        <?php } ?> 
                  
<?php          
        $length = count($linksArray);
        
        for($counter=0; $counter < $length; $counter++){             
?>    
                      
            <div class="row mt-4 pt-2">         
                <a href= "<?php echo $linksArray[$counter];?>" class="mx-auto" style="text-decoration:none;">
                    <p class="font-weight-bold"><?php echo $linkTitlesArray[$counter];?></p>
                </a>
            </div> 
<?php  
        }
?>
       </div>
<?php
    }
?> 
          
<?php
    // kaleitai apo tis add_product.php me orisma -1
    //                  edit_product.php me orisma ton kwdiko tou tupou proiontos pou ginetai edit
    // opote otan prokeitai gia edit, ginetai selected to option pou anaferetai ston uparxonta tupo proiontos
    // otan prokeitai gia add_product.php proepilegetai h prwth epilogh proiontos opws erxetai sto result set

    // Gemizei ena HTML <select> element me tous yparxontes tupous proiontwn 
    // vazei to onoma tou proiontos sto keimeno tou combo box kai ton kwdiko proiontos sto value
    
    function echoProdTypes($productTypeCode) {
        
        //echo $productTypeCode;
        
        //$result = fetchProdTypes();
        
        $currentExecQueryResultObject = fetchProdTypes();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoProdTypes -- tha kanw kati smarter soon edw!');
        }
    
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet)){
        
            $currentId = $row['TYPECODE'];
            $currentName = $row['TYPENAME'];
?>        
        
            <option value="<?php echo $currentId; ?>"
            
<?php       if ($currentId == $productTypeCode){
                
                echo " selected";
            }
?>            
            > <?php echo $currentName;?> </option>"
    <?php } 
    }
?>

<?php
function echoOrderStates($productTypeCode) {
        
        //echo $productTypeCode;
        
        //$result = fetchProdTypes();
        
        $currentExecQueryResultObject = fetchOrderStates();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoProdTypes -- tha kanw kati smarter soon edw!');
        }
    
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet)){
        
            $currentId = $row['STATECODE'];
            $currentName = $row['STATENAME'];
?>        
        
            <option value="<?php echo $currentId; ?>"
            
<?php       if ($currentId == $productTypeCode){
                
                echo " selected";
            }
?>            
            > <?php echo $currentName;?> </option>"
    <?php } 
    }
?>


<?php 
    // Kaleitai apo th list_delete_product.php - kanei echo ola ta proionta se morfh pinaka

    function echoAllProductsByCategoryAndName($page){
        
        $currentExecQueryResultObject = fetchAllProductsByCategoryAndName();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoAllProductsByCategoryAndName -- tha kanw kati smarter soon edw!');
        }
        
        $result = $currentExecQueryResultObject -> resultSet;
        
        if ($page !== -1){
            
            $limit = 10;
            mysqli_data_seek($result,($page*10));
        }
        else{
            
            $limit= $currentExecQueryResultObject -> resultSetRows;
        }    
        
        //global $page;
        //mysqli_data_seek($result,($page*10));
            
        for($counter = 0; $counter < $limit; $counter++){
            
            if ($row = mysqli_fetch_assoc($result)){
        
                $currentProdcode = $row['PRODCODE'];
                $currentProdName = $row['PRODNAME'];
                $currentTypeName = $row['TYPENAME'];
                $currentProdStock = $row['PRODSTOCK'];
                $currentProdValue = $row['PRODVALUE'];
                //$currentTypeName = $row['TYPENAME'];
?>
                <tr>
                    <td class="prodCode"><?php echo $currentProdcode; ?></td>
                    <td><?php echo $currentProdName; ?></td>
                    <td><?php echo $currentTypeName; ?></td>
                    <td><?php echo $currentProdStock; ?></td>
                    <td><?php echo $currentProdValue; ?></td>
                    <td>
                        <?php // button-link gia diagrafh tou sygkekrimenou proiontos
                          // kalei th list_delete_product.php kai dinei GET var. -> delkwdikosProiontos
                            echo "<a href='list_delete_product.php?act=del" . $currentProdcode . "'>
								    <i class='delProduct mjt-4 mjl-3 material-icons' style='font-size:35px;color:red;cursor:pointer;'>delete_forever</i>
								</a>";?>
                    </td>
                    <td>
                        <?php // button-link gia edit tou sygkekrimenou proiontos
                          // kalei th edit_product.php kai dinei GET var. -> edtkwdikosProiontos
                            echo "<a href='edit_product.php?act=edt" . $currentProdcode . "'>
                                    <i class='material-icons' style='font-size:35px;color:#0000ff'>edit</i>
								</a>";?>
                    </td>
                </tr>
<?php
            }
        }  
    }
?>

<?php
    // kaleitai apo page2.php 
    // gia na tupwsei th sthlh me tis epiloges proiontwn sta aristera
    // otan epilegetai mia kathgoria ginetai highlight ayth h kathgoria kai probalei mono
    // proionta auths ths kathgorias
    // Prokeitai gia links ths klashs  list-group-item list-group-item-action
    // kai allazei xrwma sto epilegmeno
    function echoProductTypes(){
            
        $currentExecQueryResultObject = fetchProdTypes();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoProductTypes -- tha kanw kati smarter soon edw!');
        }
        
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet)){
            
            // vlepw oti to link anaferetai thn idia selida (page2.php) kai vazei 
            //              GET παράμετρο type με value = kwdikos tupoy
            $str = "<a data-typeCode='" . $row['TYPECODE'] . "' href='page2.php?type=" . $row['TYPECODE'] . "'";
            echo $str;
            //echo 'e';
            //echo $row['TYPECODE'];    
?>
         class="list-group-item list-group-item-action" style="background-color:<?php if ( isset($_GET['type']) && $_GET['type']==$row['TYPECODE']){?>#f0ad4e<?php } else{?>#e9d28c<?php }?>">            
            
<?php       // san keimeno tou link dinei to onoma tou typou proiontos
            echo $row['TYPENAME']; ?>           
            </a>
<?php        
        }   
    }

?>


<?php
    // kaleitai apo to header.php
    // Tsekarei an yparxei estw kai ena proion sto kalathi 
    // kai tupwnei to mhnyma toy kalthiou sto header
    // sugkekrimena h tha grapsei oti to kalathi einai adeio
    // h  tha grapsei arithmo proiontwn kai sunolikh aksia agoras
    function echoCartMessage(){
        
        if (UserType::$userType == UserType::notLogged) {
            
            echo "Το καλάθι είναι άδειο";
            
            return;
        }
        
        $amount = calcCartHeadAmountOrValue(1);
        $value = calcCartHeadAmountOrValue(2);
        
        if ($amount!=0 && $value!=0) {
            
            echo "Το καλάθι περιέχει " . $amount . " προϊόντα (" . $value . " €)";
        }
        
        else{
            echo "Το καλάθι είναι άδειο";
        }
        
    }
?>

<?php
    //kaleitai apo thn page3.php
    
    // typwnei ta periexomena tou kalathiou ston pinaka sto aristero meros tou view
    // kai exei:   
    //              - input type number gia to quantity - mporei na to auksomeiwsei o xrhsths
    //                                                     me max to stock
    //              - <a> - link gia th diagrafh - kalei thn idia selida (page3.php) kai
    //                                                  dinei get metablhth del me value ton kwdiko proiontos
    //              - form me submit me name edt kai value ton kwdiko proiontos
    //                                              gia to edit ths pososthtas proiontos sto kalathi
    

    function echoCartContent(){
        
        foreach($_SESSION['cortTable'] as $currentProduct){
            
            if ($currentProduct['deleted'] == 0){
 ?>
                 <tr>
                    <td><?php echo $currentProduct['prodName']; ?></td>
                    <td><?php echo $currentProduct['prodValue']; ?></td>
                    <!--td><?php echo $currentProduct['quantity']; ?></td-->
                    <!--td><?php echo $currentProduct['prodStock']; ?></td-->
            <form action="page3.php" method="post">    
                    <td>
                        <input type="number" class="quantityInput ml-1" min="1" max="<?php echo $currentProduct['prodStock']; ?>" data-initQuantity="<?php echo $currentProduct['quantity']; ?>" value="<?php echo $currentProduct['quantity']; ?>" onkeydown="return false" name="newQuantity"> 
                    </td>
                    <td><?php echo $currentProduct['quantity'] * $currentProduct['prodValue']; ?></td>     <td>
                       <a class="delProduct" data-productId="<?php echo $currentProduct['prodCode'];?>" href="page3.php?del=<?php echo $currentProduct['prodCode'];?>">
                           <i class="material-icons " style="color:red;cursor:pointer;">&#xe92b;</i>
                       </a>
                    </td>  
                    <td>  
                       <button class="editProduct" type="submit" style="height:30px; background-color:#f0ad4e; background:none; padding:0px; border:none;" name="edt" value="<?php echo $currentProduct['prodCode'];?>">
                           <i class="material-icons " style="color:grey;cursor:default;">mode_edit</i>
                       </button>
                    </td>
            </form>    
                </tr> 
<?php
            }
        } 
    }
?>       
        

<?php 
    // Kaleitai apo to myOrders.php
    // gemizei ton pinaka me to synolo twn paraggeliwn (head) tou xrhsth

    // sthn teleutaia sthlh vazei syndesmo-koumpi prow th selida OrderDetails.php
    // wste na dei o xrhsths thn analush (detail) ths paraggelias

    function echoMyOrdersById($page,$userCode){
        
        $currentExecQueryResultObject = fetchAllMyOrdersByDateDesc($userCode);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoMyOrdersById -- tha kanw kati smarter soon edw!');
        }
        
        $result = $currentExecQueryResultObject -> resultSet;
        
        if ($page !== -1){
            
            $limit = 10;
            mysqli_data_seek($result,($page*10));
        }
        else{
            
            $limit= $currentExecQueryResultObject -> resultSetRows;
        }    
        
        
        //global $page;
        //mysqli_data_seek($result,($page*10));
            
        for($counter = 0; $counter < $limit; $counter++){
                    
            if ($row = mysqli_fetch_assoc($result)){
        
                $currentOrdercode = $row['ORDERCODE'];
                $currentOrderDate = $row['ORDERDATE'];
                $currentTotalAmount = $row['TOTALAMOUNT'];
                $currentTotalValue = $row['TOTALVALUE'];
                $currentStateName = $row['STATENAME'];
                //$currentTypeName = $row['TYPENAME'];
?>
                <tr>
                    <td><?php echo $currentOrdercode; ?></td>
                    <td><?php echo $currentOrderDate; ?></td>
                    <td><?php echo $currentTotalAmount; ?></td>
                    <td><?php echo $currentTotalValue; ?></td>
                    <td><?php echo $currentStateName; ?></td>
                    <td>
                    <?php // vazei GET metablhth orderCode me value ton kwdiko paraggelias
                          echo "<a href='OrderDetails.php?orderCode=" . $currentOrdercode . "&from=mine'>
								    <button type='button' class='btn btn-info'>Ανάλυση</button>
								</a>";?>
                    </td>
                </tr>
<?php
            }
        }  
    }
?>

<?php 
    // kaleitai apo to OrderDetails.php me parametro ton kwdiko ths paraggelias
    
    // kanei echo ston pinaka to detail ths sugkekrimenhs paraggelias

    function echoMySpecificOrderDetails($orderCode,$allFlag){
        
        $currentExecQueryResultObject = MySpecificOrderDetails($orderCode);
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoMySpecificOrderDetails -- tha kanw kati smarter soon edw!');
        }
        
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet)){
        
            $currentProdcode = $row['PRODCODE_FK'];
            $currentProdName = $row['PRODNAME'];
            $currentProdQuantity = $row['PRODQUANTITY'];
            $currentOrderProdValue = $row['ORDERPRODVALUE'];
            $currentOrderProdStock = $row['PRODSTOCK'];
?>
            <tr>
                <td><?php echo $currentProdcode; ?></td>
                <td><?php echo $currentProdName; ?></td>
                <td class="tdQuantity"><?php echo $currentProdQuantity; ?></td>
                <td><?php echo $currentOrderProdValue; ?></td>
                <?php if ($allFlag){?> 
                <td class="tdStock" style="width:7px;"><?php echo $currentOrderProdStock; ?></td>
                <?php }?>
            </tr>
<?php
        }  
    }
?>

<?php 
    // Kaleitai apo to allOrders.php - dinetai ws parametros to page (10-ada)
    // pou tha tupwthei.

    // ginetai echo ston pinaka to synolo olwn twn paraggeliwn olwn twn xrhstwn

    // sthn teleutaia sthlh mpainei link-button gia th selida OrderDetails.php
    // opou tha apeikonistei h analush ths paraggelias
    // pernietai GET parametros orderCode me value ton kwdiko paragggelias

    function echoAllOrders($page){
        
        //$result = fetchAllOrdersByDateDesc();
        $limit;
        
        $currentExecQueryResultObject = fetchAllOrdersByDateDesc();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoAllOrders -- tha kanw kati smarter soon edw!');
        }
        
        $result = $currentExecQueryResultObject -> resultSet;
        
        if ($page !== -1){
            
            $limit = 10;
            mysqli_data_seek($result,($page*10));
        }
        else{
            
            $limit= $currentExecQueryResultObject -> resultSetRows;
        }    
        
        //global $page;
        //mysqli_data_seek($result,($page*10));
          
       // echo $limit;
       // for($counter2 = 0; $counter2 < $limit; $counter2++){echo $counter2;}
        /*for($counter = 0; $counter < $limit; $counter++){
            if ($row = mysqli_fetch_assoc($result))
            {echo $row['USERCODE'];
                echo $row['LASTNAME'];
                echo $row['FIRSTNAME'];
                echo $row['ORDERCODE'];
                echo $row['ORDERDATE'];
                echo $row['TOTALAMOUNT'];
                echo $row['TOTALVALUE'];
                echo $row['STATENAME'];
                //$currentTypeName = $row['TYPENAME'];
                
                echo $row['STATE_FK'];}
        }*/
        
        for($counter = 0; $counter < $limit; $counter++){
                    
            if ($row = mysqli_fetch_assoc($result)){
                        
                $currentUsercode = $row['USERCODE'];
                $currentLastName = $row['LASTNAME'];
                $currentFirstName = $row['FIRSTNAME'];
                $currentOrdercode = $row['ORDERCODE'];
                $currentOrderDate = $row['ORDERDATE'];
                $currentTotalAmount = $row['TOTALAMOUNT'];
                $currentTotalValue = $row['TOTALVALUE'];
                $currentStateName = $row['STATENAME'];
                //$currentTypeName = $row['TYPENAME'];
                
                $currentStateCode = $row['STATE_FK'];
            
                $customer = $currentLastName  . "_" . $currentFirstName . "(" . $currentUsercode . ")";
?>
<!--
                <tr>
                    <td>aaa</td>
                    <td>bbb</td>
                    <td>ccc</td>
                    <td>ddd</td>
                    <td>eee</td>
                    <td>zzz</td>
                    <td>iii</td>
                </tr>
-->

                <tr>
                    <td><?php echo $currentLastName . ' ' . $currentFirstName . " (" . $currentUsercode . ")"; ?></td>
                    <td class='orderCodeTd'><?php echo $currentOrdercode; ?></td>
                    <td><?php echo $currentOrderDate; ?></td>
                    <td><?php echo $currentTotalAmount; ?></td>
                    <td><?php echo $currentTotalValue; ?></td>
                    <td>
                        <select class="form-control stateSelect" data-initValue="<?php echo $currentStateCode; ?>" style="width:160px">
                        <?php echo echoOrderStates($currentStateCode); ?>
                        </select>
                    </td>
                    <td>
                    <?php echo "<a href='OrderDetails.php?orderCode=" . $currentOrdercode . "&from=all&for=" . $customer . "'>
								    <button style='width:120px;height:40px' type='button' class='btn btn-info'>Ανάλυση<span style='display:none' class='orderNow' >  <i class='material-icons' style='font-size:18px;color:white'>add_alert</i></span></button>
								</a>";?>
                    </td>
                </tr>


<?php       }
        }
    }
?>

<?php 
    // Kaleitai apo to allUsers.php.

    // tupwnei ston pinaka to sunolo twn users

    function echoAllUsersByLastName($page){
        
        //$result = fetchAllUsersByLast();
        
        $currentExecQueryResultObject = fetchAllUsersByLast();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoAllUsersByLastName -- tha kanw kati smarter soon edw!');
        }
        
        $result = $currentExecQueryResultObject -> resultSet;
        
        if ($page !== -1){
            
            $limit = 10;
            mysqli_data_seek($result,($page*10));
        }
        else{
            
            $limit= $currentExecQueryResultObject -> resultSetRows;
        }   
        
        //global $page;
        //mysqli_data_seek($result,($page*10));
            
        for($counter = 0; $counter < $limit; $counter++){
            
            if ($row = mysqli_fetch_assoc($result)){
        
                $currentUsercode = $row['USERCODE'];
                $currentLastName = $row['LASTNAME'];
                $currentFirstName = $row['FIRSTNAME'];
                $currentMobile = $row['MOBILE'];
                $currentEmail = $row['EMAIL'];
                $currentAdress = $row['ADRESS'];
                $currentTk = $row['TK'];
                $currentCity = $row['CITY'];
                $currentNomos = $row['NOMOS'];
                $currentBirthdate = $row['BIRTHDATE'];
?>
                <tr>
                    <td><?php echo $currentUsercode; ?></td>
                    <td><?php echo $currentLastName; ?></td>
                    <td><?php echo $currentFirstName; ?></td>
                    <td><?php echo $currentMobile; ?></td>
                    <td><?php echo $currentEmail; ?></td>
                    <td><?php echo $currentAdress; ?></td>
                    <td><?php echo $currentTk; ?></td>
                    <td><?php echo $currentCity; ?></td>
                    <td><?php echo $currentNomos; ?></td>
                    <td><?php echo $currentBirthdate; ?></td>
                </tr>
<?php
            }
        }
    }
?>


<?php 
    // kaleitai apo to statistics.php 
                
    // kanei echo se pinaka ta 5 proionta me tis upshloteres pwlhseis
                
    function echo5MostSaleProducts(){
        
        //$result = get5MostSaleProducts();
        
        $currentExecQueryResultObject = get5MostSaleProducts();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echo5MostSaleProducts -- tha kanw kati smarter soon edw!');
        }
        
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet)){
        
            $currentProdcode = $row['PRODCODE_FK'];
            $currentProdName = $row['PRODNAME'];
            $currentQuantity = $row['TOTALSOLDQUANTITY'];
            
?>
            <tr>
                <td><?php echo $currentProdcode; ?></td>
                <td><?php echo $currentProdName; ?></td>
                <td><?php echo $currentQuantity; ?></td>
            </tr>    
<?php
        }
    }
?>

<?php 
    // kaleitai apo to statistics.php 
                
    // kanei echo se pinaka tous 3 pelates me tis upshloteres katanalwseis

    function echoTop3Customers(){
        
        //$result = getTop3Customers();
        
        $currentExecQueryResultObject = getTop3Customers();
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoTop3Customers -- tha kanw kati smarter soon edw!');
        }
        
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet)){
        
            $currentUserCode = $row['USERCODE'];
            $currentLastName = $row['LASTNAME'];
            $currentFirstName = $row['FIRSTNAME'];
            $currentTotalValue = $row['TOTALVALUE'];
            
?>
            <tr>
                <td><?php echo $currentUserCode; ?></td>
                <td><?php echo $currentLastName; ?></td>
                <td><?php echo $currentFirstName; ?></td>
                <td><?php echo $currentTotalValue; ?></td>
            </tr>    
<?php
        }
    }
?>


<?php 
    // kaleitai apo index.php,page2.php,allOrders.php.

    // sthn index.php ylopoioyntai 2 pagination
    // sth page2.php yparxei kai filtrarisma ana tupo

    // kanei echo to pagination (to kanei kai leitourgiko fysika)
    // parametroi:      
    //              - $pagesKeyArray: 
    //              - $pagesValueArray
    //              - $currentPageIndex -- me poio page kineitai auth h ylopoihsh tou pagination
    //                                      p.x to index.php exei 2 ylopoihseis
    //                                          h 1 kineitai me vash to last (index 0)
    //                                          h allh kineitai me vash to pop (index 1)
    //              - $maxPage  -- h megisth selida sthn opoia mporei na fthasei
    //              - $currentUrl -- h selida sthn opoia ylopoieitai to pagination
    //              - $typeKey  -- xrhsh gia page2.php poy uparxei filtrarisma kai ana typo
    //              - $typeValue -- xrhsh gia page2.php poy uparxei filtrarisma kai ana typo
    function echoPagination($pagesKeyArray,$pagesValueArray,$currentPageIndex,$maxPage,$currentUrl,$typeKey,$typeValue,$dataPaginationString){
        
        $length = count ($pagesKeyArray);   
    
?> 
<!--    auto einai to div tou pagination    -->
<!--    exw prosthesei to data attribute data-pagination
        to opoio mou xreiazetai gia na matsarei h js th swsth row-vitrina    -->
        <div class="dataTables_paginate paging_full_numbers row mt-2" style="height:50px;" data-pagination="<?php if (!is_null($dataPaginationString)) {echo $dataPaginationString;} ?>">
		<ul class="pagination" data-maxPage=<?php echo $maxPage;?>
            <li class="page-item" style="bjorder:2px solid blue;">
                <a class="page-link bg-warning font-weight-bolder" style="text-decoration:none" href="
<?php 
                if($pagesValueArray[$currentPageIndex] > 0){

                    echo $currentUrl . '?';                          
                                                  
                    for($i = 0; $i < $length; $i++){
                        
                        if ($i != 0){
                            
                            echo '&';
                        }
                        
                        echo $pagesKeyArray[$i] . '=';
                        
                        if ($i == $currentPageIndex){
                            
                            echo $pagesValueArray[$i] - 1;
                        }
                        else{
                            
                            echo $pagesValueArray[$i];
                        }
                    }
                    
                    if (! is_null($typeKey)) {
                        
                        echo '&' . $typeKey . '=' . $typeValue;
                    }
                }
?>
                        ">Previous</a>
            </li>
            <li class="page-item bg-warning" style="border:2px solid #0086b3;">
                <input type="text" class="vitrinaPage bg-warning font-weight-bolder mt-1" style="width:25px;color:blue;" value=" 
<?php 
                       echo ($pagesValueArray[$currentPageIndex] + 1);
?>
                        "/>
            </li>
            <li class="page-item" style="bjorder:2px solid blue;">
                <a class="page-link bg-warning font-weight-bolder" style="text-decoration:none"  href="
<?php 
                if($pagesValueArray[$currentPageIndex] < $maxPage){

                        echo $currentUrl . '?';                        
                                                   
                    for($i = 0; $i < $length; $i++){
                        
                        if ($i != 0){
                            
                            echo '&';
                        }
                        
                        echo $pagesKeyArray[$i] . '=';
                        
                        if ($i == $currentPageIndex){
                            
                            echo $pagesValueArray[$i] + 1;
                        }
                        else{
                            
                            echo $pagesValueArray[$i];
                        }
                    }
                    
                    if (! is_null($typeKey)) {
                        
                        echo '&' . $typeKey . '=' . $typeValue;
                    }
                }
?>
                                    ">Next</a>
            </li>
        </ul>
        </div>
<?php
    }
?>


<?php
    // καλείται στο xml_view.php

    // κάνει echo to μόλις κατασκευασμένο  XML file με βάση το 
    // xsl file: allOrdersAndTop5SalesProducts.xsl που βρίσκεται στο φάκελο xml
    function echoXSL(){
           
       
        $myXmlFile = new DOMDocument;
        global $currentXmlFile;
        $myXmlFile -> load ($currentXmlFile) ;

        $myXslFile = new DOMDocument;
        $myXslFile -> load ('xml/allOrdersAndTop5SalesProducts.xsl');

        $XSLTProcessorObject = new XSLTProcessor;

        $XSLTProcessorObject->importStyleSheet($myXslFile);

        echo $XSLTProcessorObject->transformToXML($myXmlFile);
    }
?>


<?php

    function echoAccountForm($edit){     
?>

                <div class=" mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
                            <div class="custom-control-inline">
                            <span style="width:25%"><label for="firstName" class="" >Όνομα</label></span>
								<input type="text" class="form-control mr-2" id="firstName" name="firstName" style="width:260px" required value=<?php if ($edit){echo UserType::$userFirst;}?>>
                            </div>
				        </div>
                        
                        <div class="mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
                                <div class="custom-control-inline">
								<span style="width:25%"><label for="lastName" class="">Επώνυμο</label></span>
								<input type="text" class="form-control" id="lastName" name="lastName" style="width:260px" required value=<?php if ($edit){ echo UserType::$userLast;}?>>
                                </div>    
						</div>
                                            
						<div class="mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
                                <div class="custom-control-inline">
								<span style="width:25%"><label for="email" class="">Email</label></span>
								<input type="email" class="form-control mr-2" id="email" name="email" style="width:260px" required value=<?php if ($edit){echo UserType::$userEmail;}?>>
                                </div>
                        </div>  
                        
                        <div class="mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
                                <div class="custom-control-inline">
								<span style="width:25%"><label for="mobile" class="">Κινητό</label></span>
								<input type="text" data-type="number" class="form-control " id="mobile" name="mobile" style="width:260px" required value=<?php if ($edit){echo UserType::$userMobile;}?>>
                                </div>
						</div>
                        
                <?php if (!$edit){ ?>

						<div class="mx-auto  mb-2" style="width:100%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
                                <div class="custom-control-inline">
								<label for="password" class="">Κωδικός</label>
								<input type="password" class="form-control mr-2" id="password" name="password" style="width:260px" required>
								<label for="confirmPassword" class="mr-1"> Επιβεβ.</label>
								<input type="password" class="form-control" id="confirmPassword" style="width:260px" >
                                </div>
						</div>
                <?php } ?>
                                    
                        
						<div class="mx-auto  mb-2" style="width:100%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
                                <div class="custom-control-inline">
								<label for="adress" class="mr-1">Διεύθυνση</label>
								<input type="text" class="form-control mr-1" id="adress" name="adress" style="width:170px" placeholder="Οδός, Αριθμός" value=<?php if ($edit){echo UserType::$userAdress;}?>>
								<input type="text" class="form-control mr-1" id="tk" name="tk" style="width:80px" placeholder="Τ.Κ" value=<?php if ($edit && UserType::$userTk !=0) {echo UserType::$userTk;}?>>
								<input type="text" class="form-control mr-1" id="city" name="city" style="width:170px" placeholder="Πόλη/Περιοχή" value=<?php if ($edit){echo UserType::$userCity;}?>>
								<select class="form-control" id="nomos" name="nomos" style="width:170px" value=<?php if ($edit){echo UserType::$userNomos;}?>>
									<option>Ν. Αττικής</option>
									<option>Ν. Ηρακλείου</option>
									<option>Ν. Θεσσαλονίκης</option>
									<option>Ν. Μαγνησίας</option>
									<option>Ν. Ροδόπης</option>
									<option>Ν. Ιωαννίνων</option>
								</select>
                                </div>
						</div>
						
						<div class=" mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
							<div class="custom-control-inline">	
                                
								<label for="birthdate" class="ml-3 mr-4">Birthday</label>
								<input type="date" class="form-control" id="birthdate" name="birthdate" value=<?php if ($edit){echo UserType::$userBirthdate;}?>>
                            </div>
						</div>



<?php
        
    }
?>

<?php

    function echoProductForm($edit,$selectedProduct){     
?>
            <div class=" mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
						  <div class="custom-control-inline ">
								<span style="width:20%"><label for="prodName" class="">Όνομα</label></span>
								<input type="text" class="form-control mr-2" id="prodName" name="prodName" style="width:270px" value="<?php if($edit) {echo $selectedProduct['PRODNAME'];}?>" required>
						  </div>
            </div> 
                        
            <div class=" mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
						  <div class="custom-control-inline ">
								<span style="width:30%"><label for="typeCode" class="">Κατηγορία</label></span>
								<select class="form-control" id="typeCode" name="typeCode" style="width:230px" required ><?php if($edit) {echoProdTypes($selectedProduct['TYPECODE']);} else{echoProdTypes(-1);}?> 
									
								</select>
                            </div>
            </div>
               
<?php
            if (false){
                echo '@@@';
                echo $selectedProduct['PRODPIC'];
                echo '@@@';
            }
?>

            <div class=" mx-auto  mb-2" style="width:80%;height:145px;margin=auto;padding-left: 0%;padding-top: 0%;">
						  <div class="custom-control-inline ">
								<span style="width:40%"><label for="prodPic" class="mt-4">Εικόνα</label></span>
                              
                                 <img id="prodPic" src="images\products\<?php if ($edit && !is_null($selectedProduct['PRODPIC'])) {echo $selectedProduct['PRODPIC'];} else {echo 'none.jpg';} ?>" class="ml-4 prPic img-fluid rounded" alt="mocca" style="height:100px;" title="<?php echo $selectedProduct['PRODPIC'];?>">
                              
								<input id="fileInput" type="file"  id="prodPic" name="prodPic" style="width:260px;dpisplay: none;" class="ml-1 pl-2" value="<?php if($edit && !is_null($selectedProduct['PRODPIC'])) {echo $selectedProduct['PRODPIC'];}?>" hidden >
                              
                                <i id="clearPic" class="mt-4 ml-3 material-icons" style="font-size:45px;color:red;cursor:pointer;">delete_forever</i>
                              
                                <button id="fileBrowseButton" type="button" value="Browse..." class="btn btn-secondary ml-3 mt-4" style="width:80px;height:40px;">Browse</button>
                              
                                <p id="fileP" name="fileP" class="ml-4 mt-4"><?php if($edit && !is_null($selectedProduct['PRODPIC'])) {echo $selectedProduct['PRODPIC'];}else{echo 'None';}?></p>
                              
                                <input id="filePInput" name="filePInput" value="<?php if($edit && !is_null($selectedProduct['PRODPIC'])) {echo $selectedProduct['PRODPIC'];}else{echo 'none.jpg';}?>" hidden>
                              
                              <?php 
                                  //  }
                             // ?>
                              
                       
                              
                              <?php
                                                     
                              ?>
                              
                              
                          </div>
            </div>
                        
            <div class=" mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
						  <div class="custom-control-inline mt-3 mb-2 pr-3">
								<span style="width:40%"><label for="prodStock" class="">Απόθεμα</label></span>
								<input type="text" data-type="number" class="form-control ml-4" id="prodStock" name="prodStock" style="width:60px" value="<?php if($edit) {echo $selectedProduct['PRODSTOCK'];}?>" required>
                          </div>
            </div>
                        
            <div class=" mx-auto  mb-2" style="width:80%;height:85px;margin=auto;padding-left: 0%;padding-top: 0%;">
						  <div class="custom-control-inline mt-3 mb-2 pr-3">
								<span style="width:40%"><label for="prodValue" class=""> Τιμή</label></span>
								<input type="text" data-type="number" class="form-control ml-5" id="prodValue" name="prodValue" style="width:60px" value="<?php if($edit) {echo $selectedProduct['PRODVALUE'];}?>" required>
                          </div>
            </div>
                        
            <div class=" mx-auto  mb-2" style="width:80%;height:180px;margin=auto;padding-left: 0%;padding-top: 0%;">
						  <div class="custom-control-inline mt-3 mb-2 ml-n4 pr-1">
								<span style="width:20%" class="ml-4"><label for="prodDescription" class="mr-1">Περιγραφή</label></span>
								<textarea data-limit="180" id="prodDescription" style="height:30%;" name="prodDescription" rows="5" cols="50"><?php if($edit) {echo $selectedProduct['PRODDESCRIPTION'];}?></textarea>
						  </div>
                          <br>
                          <span id ="prodDescription_count" class="ml-5 pl-5" style="color:red;"></span>
            </div>

<?php      
    }
?>

<?php

    function echoRadioButtons($name){     

        if ($name === 'shipment'){
        
            $currentExecQueryResultObject = fetchShipmentStates();
        }    
        else {
        
            $currentExecQueryResultObject = fetchPaymentStates();
        }
       
        // εδω τσεκαρει για αποτυχια εκτέλεσης του query ή για λογικό σφάλμα των αποτελεσμάτων
        // αντι για die θα το βαλω να κανει κατι πιο εξυπνο συντομα
        if (! $currentExecQueryResultObject -> querySuccess ){ 
            
            die('function echoTop3Customers -- tha kanw kati smarter soon edw!');
        }
        
        $counter = 1;
        
        while ($row = mysqli_fetch_assoc($currentExecQueryResultObject -> resultSet)){   
            
            $currentId= $name . '_' . $counter;
            
            $currentValue = $row['ID'];
            $currentDescription = $row['FULLDESCRIPTION'];
?>
            <div class="form-check">
                <label class="form-check-label" for="<?php echo $currentId;?>">
                <input type="radio" class="form-check-input" id="<?php echo $currentId;?>" name="<?php echo $name?>" value="<?php echo $currentValue;?>" <?php if ($counter===1){echo 'checked';}?>>
                <?php echo $currentDescription;?></label>
            </div>
<?php
            $counter++;
        }  
    }
?>