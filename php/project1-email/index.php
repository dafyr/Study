<!doctype html>

<?php

$error = ""; $success = "";

if ($_POST) {
    
    
    
    if (!$_POST["email"]) {
            
            $error .= "The Email field is required. <br>";
            
            }
    
    else  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                
            $error .= "The email is invalid.<br>";
                            
            }
    
    if (!$_POST["subject"]) {
            
            $error .= "The Subject field is required. <br>";
            
            }
            
    if (!$_POST["question"]) {
            
            $error .= "The Question field is required.";
            
            }
            

    
    if ($error != "") {
               
               $error = '<div class="alert alert-danger" role="alert"><p>There were error(s) in your form:</p>' . $error . '</div>';
               
           }
    else {
        
        $mailTo = "krugx4444@mail.ru";
        $subject = $_POST['subject'];
        $question = $_POST['question'];
        $headers = "From: ".$_POST['email'];
        
        if (mail($mailTo, $subject, $question, $headers)) {
            
            $success = '<div class="alert alert-success" role="alert"><p>Email was sent succesfully</p> </div>';
            
        } else {
            
            $error = '<div class="alert alert-danger" role="alert"><p>There were unexpected error</p></div>';
            
        }
        
    }
}

?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>!!!!!!!!!!!!!!!!!</title>
  </head>
  <body>
      
<form method="post" class="container py-3">
    <h1>Get in touch!</h1>
    
    <div id="error"><? echo $error.$success ?></div>
    
    
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="subject" class="form-label">Subject</label>
    <input type="text" name="subject" class="form-control" id="subject">
  </div>
  <div class="mb-3">
    <label for="question" class="form-label">What is your question?</label>
    <textarea class="form-control" name="question" id="question" rows="3"></textarea>
  </div>
  <button type="submit" id="mainBut" class="btn btn-primary">Submit</button>
</form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"> </script>
    
        
        <script type="text/javascript">

        
            $("form").submit(function(e) {
                
            var error = "";
            
            if ($("#email").val() == "") {
            
            error += "The Email field is required. <br>";
            
            }
            
            if ($("subject").val() == "") {
            
            error += "The Subject field is required. <br>";
            
            }
            
            if ($("#question").val() == "") {
            
            error += "The Question field is required.";
            
            }
            
           if (error != "") {
               
               $("#error").html('<div class="alert alert-danger" role="alert"><p>There were error(s) in your form:</p>' + error + '</div>');
               
                return false  
           } else {
               
               return true
               
           }
                
        })  
            
       </script>
      
  </body>
</html>



    