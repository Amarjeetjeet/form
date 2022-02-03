<?php

if(isset($_POST['submit'])){
    include "database.php";
    $obj = new DATABASE();

    $filename = $_FILES["fileToUpload"]["name"];
    $tempname = $_FILES["fileToUpload"]["tmp_name"];    
    $folder = "upload/".$filename;

    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $hobbie = implode(',',$_POST['hobbie']);
    $mobile = $_POST['mobile'];
    $password = md5($_POST['password']);

    $param = ["firstname" => $firstname ,
    "lastname" => $lastname ,
    "email" => $email ,
    "gender" => $gender ,
    "city" => $city ,
    "hobbie" => $hobbie ,
    "password" => $password ,
    "img" => $filename ,
    "mobile" => $mobile 
];
    $obj->update("users",$param,"id = $id");

    $result = $obj->getresult();

    if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
    }else{
            $msg = "Failed to upload image";
    }

    if(!empty($result)){
        header("location:index.php");
    }else{
        echo "Record not insert successful";
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css?v=<?php echo time(); ?>">

    <title>update page</title>
</head>

<body>
    <?php

    include "database.php";
    
    $obj = new database();

    $id = $_GET['id'];
    $obj->select("users","*",null,"id = $id",null,null,null);
    $result = $obj->getResult();

    ?>

        <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" onsubmit="return bg()" method="post" enctype="multipart/form-data">
            <p class="usererror" id="mainError">*</p>
        <h1>Edit page</h1>
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <input type="text" name="firstname" id="firstname" placeholder="firstname" value="<?php echo $result[0]['firstname'];?>"><br>
        <p class="usererror" id="firstnameError">*</p>

        <input type="text" name="lastname" id="lastname" placeholder="lastname" value="<?php echo $result[0]['lastname'];?>"><br>
        <p class="usererror" id="lastnameError"></p>

        <input type="email" name="email" id="email" placeholder="email" value="<?php echo $result[0]['email'];?>"><br>
        <p class="usererror" id="emailError"></p>
        <br>
        
        <input type="radio" name="gender" id="gender" <?php if($result[0]['gender'] == 'male'){ echo "checked";} ?> value="male">male
        <input type="radio" name="gender" id="gender"  <?php if($result[0]['gender'] == 'female'){ echo "checked";} ?> value="female">female
        <p class="usererror" id="genderError"></p>
        <br>
        <br>
        
        <p class="usererror" id="cityError">*</p>
        <br>
        <select name="city" id="select">
            <option value="">select city</option>
            <option value="ahmedabad" <?php if($result[0]['city'] == 'ahmedabad'){ echo "selected";} ?> >ahmedabad</option>
            <option value="surat" <?php if($result[0]['city'] == 'surat'){ echo "selected";} ?>>surat</option>
            <option value="vadodara" <?php if($result[0]['city'] == 'vadodara'){ echo "selected";} ?>>vadodara</option>
        </select>
        <p class="usererror" id="cityError">*</p>
        <br>
        
        <?php
        $checked_arr = array();

    
        $checked_arr = explode(",",$result[0]['hobbie']);
        
        $hobbie_arr = array("cricket","writing","singing");
        foreach($hobbie_arr as $hobbie){    
        $checked = "";
        if(in_array($hobbie,$checked_arr)){
        $checked = "checked";
      }
      echo '<input type="checkbox" name="hobbie[]" id="'.$hobbie.'" value="'.$hobbie.'" '.$checked.' > '.$hobbie.' <br/>';
    }
    ?>
        <input type="checkbox" name="hobbie[]" id="hobbie" value="" hidden checked><br/>
        <p class="usererror" id="hobbieError"></p>
        <br>
        <input type="text" id="phone" name="mobile"  maxlength="10" value="<?php echo $result[0]['mobile'];?>">
        <p class="usererror" id="phoneError"></p>
        
        
        <br>
        
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload"  title=" ">
        <img  src="upload/<?php echo $result[0]['img'] ; ?>" height="100px">
        <input type="hidden" name="old-image" value="/<?php echo $result[0]['img'] ; ?>">
        <p class="usererror" id="fileError"></p>
        <br>

        <input type="password" name="password" id="password" placeholder="password" value="<?php echo $result[0]['password'];?>"><br>
        <p class="usererror" id="passwordError"></p>
        <input type="submit" value="submit" name="submit" class="submit">`
    </form>
</body>
<script>
    let firstname = document.getElementById("firstname");
    let lastname = document.getElementById("lastname");
    let email = document.getElementById("email");
    let phone = document.getElementById("phone");
    let fileToUpload = document.getElementById("fileToUpload");
    let password = document.getElementById("password");
    let cricket = document.getElementById("cricket");
    let singing = document.getElementById("singing");
    let writing = document.getElementById("writing");
    let hobbie = document.getElementById("hobbie");
    let flag =1;
    function bg(){

        // file upload
        var filePath = fileToUpload.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        const oFile = fileToUpload.files[0]; 
        if(fileToUpload.value == ""){
            document.getElementById("fileError").innerHTML = "Please select image";
            flag =0 ; 
        }
        else if(!allowedExtensions.exec(filePath)){
        document.getElementById("fileError").innerHTML = "Please upload file having extensions .jpeg/.jpg/.png/.gif only.";
        fileToUpload.value = '';
        flag = 0;
        }
    
        else if (oFile.size > 1048576) // 1 MiB for bytes.
        {
            document.getElementById("fileError").innerHTML = "File size must under 1MB";
            flag = 0;
        }
        else{
        document.getElementById("fileError").value = ""; 
        document.getElementById("fileError").innerHTML = ""; 
        flag =1;
        }

        // file upload ending



        //firstname
        if(firstname.value == ""){
            document.getElementById("firstnameError").innerHTML = "Please fill the details";
            flag = 0;
        }
        else if(firstname.value.length < 5){
            document.getElementById("firstnameError").innerHTML = "Firstname will have at least 5 characters";
            flag = 0;
        }
        else{
            document.getElementById("firstnameError").innerHTML = "";
            flag = 1;
            
        }
        

        //lastname
        if(lastname.value == ""){
            document.getElementById("lastnameError").innerHTML = "Please fill the details";
            flag = 0;
        }
        else if(lastname.value.length < 5){
            document.getElementById("lastnameError").innerHTML = "Lastname will have at least 5 characters";
            flag = 0;
        }
        else{
            document.getElementById("lastnameError").innerHTML = "";
            flag = 1;
            
        }

        //Email
        if(email.value == ""){
            document.getElementById("emailError").innerHTML = "Please fill the Email address";
            flag = 0;
        }
        else{
            document.getElementById("emailError").innerHTML = "";
            flag = 1;
            
        }
        

        //gender
        let option = document.getElementsByName('gender');
        
        if (!(option[0].checked || option[1].checked)) {
            document.getElementById("genderError").innerHTML = "Please Select Your Gender";
            flag = 0;
        }
        else{
            document.getElementById("genderError").innerHTML = "";
            flag = 1;
        }
        

        // city
        let select = document.getElementById('select'); // or in jQuery use: select = this;
        if (select.value== "") {
            document.getElementById("cityError").innerHTML = "select your city";
            flag = 0;
        }
        else{
            document.getElementById("cityError").innerHTML = "";
            flag = 1;
        }

        // Hobbie
        
        if (!(cricket.checked || singing.checked  ||writing.checked)) {
            document.getElementById("hobbieError").innerHTML = "Please Select at leaste one hobbie";
            flag = 0;
        }
        else{
            document.getElementById("hobbieError").innerHTML = "";
            flag = 1;
        }


        //number
        if(phone.value == ""){
            document.getElementById("phoneError").innerHTML = "Please fill the number";
            flag = 0;
        }
        else if(phone.value.length < 10){
            document.getElementById("phoneError").innerHTML = "phone should be 10 characters";
            flag = 0;
        }
        else{
            document.getElementById("phoneError").innerHTML = "";
            flag = 1;

        }


        //password
        if(password.value == ""){
            document.getElementById("passwordError").innerHTML = "Please fill the password";
            flag = 0;
        }
        else if(password.value.length < 8){
            document.getElementById("passwordError").innerHTML = "password should be 8 characters";
            flag = 0;
        }
        else{
            document.getElementById("passwordError").innerHTML = "";
            flag = 1;
        }
        
        // if(firstname.value == "" && lastname.value == "" && email.value == "" && select.value == "" && password.value == "" &&  select.value == "" && hobbie.value == ""  ){
        //     document.getElementById("mainError").innerHTML = "something is wrong";
        //     flag = 0;
        // }else{
        //     flag =1;
        // }

        if(flag==1){
            return true;
        }

        else{
            
            return false;
        }

    }
    

</script>
</html>