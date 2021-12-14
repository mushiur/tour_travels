<?php



 

  session_start();


    $username = $email = "";
    $errors = array();
    $message = "";
    


    // registration here
    if(isset($_POST["reg_submit"])) //$_SERVER["REQUEST_METHOD"] == "POST"
    {

      if(empty(trim($_POST['uname']))) 
      { 
        array_push($errors,"Username is required"); 
      }
      else{

       
            if (!preg_match("/^[a-zA-Z-' ]*$/",trim($_POST['uname']))) {
              $message  = "Only letters and white space allowed in Full name"; 
              array_push($errors,"Invalid name format"); 

              echo "<script>alert('$message');</script>";
          }else{

            $username = mysqli_real_escape_string($con,$_POST['uname']);
          }
      }


      if(empty(trim($_POST['uemail'])))
       {
         array_push($errors,"Email is required");
        }else{

        

          if (!filter_var(trim($_POST['uemail']), FILTER_VALIDATE_EMAIL)) {
            $message  = "Invalid email format";
            array_push($errors,"Invalid email format"); 

            echo "<script>alert('$message');</script>";
          }else{

            $email = mysqli_real_escape_string($con,$_POST['uemail']);
          }
        }

        

      if(empty(trim($_POST['upassword']))) 
      {array_push($errors, "Password is required");}
      else{
        $password_ = mysqli_real_escape_string($con,$_POST['upassword']);
      }


   


      //check if the email is already in the database or not
      $user_check_query = " SELECT * FROM registerdata WHERE email='$email' LIMIT 1";
      $result = mysqli_query($con,$user_check_query);
      $user_result = mysqli_fetch_assoc($result);

      if($user_result)
      {

      
        //user already exist

        if($user_result['email'] === $email)
        {
          array_push($errors,"email alraedy exists");

          $message = "email alraedy exists";

          echo "<script>alert('$message');</script>";

        }
      }

    

      if(strlen($password_) < 8)
      {
        array_push($errors, "Password should be atleast 8 character or long");

        
        $message = "Password should be atleast 8 character or long";

        
          echo "<script>alert('$message');</script>";
        

      
        
      }

      if(count($errors) == 0)
      {
        $password = md5($password_); //encrypting the user password for secqurity

        $query = "INSERT INTO registerdata (username,email,password)
        VALUES('$username','$email','$password')";

        mysqli_query($con,$query);
        $_SESSION['username'] = $username;
        $_SESSION['useremail'] = $email;
        $_SESSION['success'] = "You registartion is completed";
       

        ?>

        <script>

          
          echo "<script>alert('Registration is completed');</script>";


          </script>

        <?php

        header('location: index.php');
      }else{

        echo "<script>alert('opps.something went wrong.please try again');</script>";

      }
    }


    //login here
    
  
?>

<?php


if((isset($_POST["login"])))
{
  $user_email = mysqli_real_escape_string($con,$_POST['Useremail_']);
  $user_pass = mysqli_real_escape_string($con,$_POST['Userpassword_']);

  $user_pass = md5($user_pass);

  $another_query = " SELECT * FROM registerdata WHERE email='$user_email' AND password='$user_pass' ";
    $user_name_query = "SELECT username FROM registerdata WHERE email='$user_email'";

  $result_query = mysqli_query($con,$another_query); 
    $name_query  = mysqli_query($con,$user_name_query);
   $currentUserName = mysqli_fetch_assoc($name_query);
  if(mysqli_num_rows($result_query) == 1)
  {
    $_SESSION['useremail'] = $user_email;
    $_SESSION['success'] = "You logged in successfully";
     $_SESSION['CurrentUser'] = $currentUserName['username'];
    // echo $name_;
    echo "<script>alert('Log in successful');</script>";
    
    
  }else{

    echo "<script>alert('Log in Failed due to wrong password or email');</script>";
    
  }

  header('location: index.html');


 
  
}

?>