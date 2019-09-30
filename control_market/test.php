<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       
        <div>TODO write content</div>
        <br><br>
        <form action="signUp.php" method="POST" enctype="multipart/form-data">
            user name : <input type='texte' name='ven_name'>
            password :<input type="text" name='ven_city'>
            mobile: <input type="text" name='ven_address'>
             password :<input type="text" name='ven_email'>
            mobile: <input type="text" name='ven_password'>
            mobile: <input type="text" name='ven_trad'>
            mobile: <input type="text" name='code'>
            <input type='submit' name='search' value='search'>
        </form>
        <br>
        <br>
         <form action="signUp.php" method="POST" enctype="multipart/form-data">
           
             email :<input type="text" name='ven_mobile'>
           
            <input type='submit' name='search' value='search'>
        </form>
         <br>
        <br>
        <form action="MyLocation.php" method="POST" enctype="multipart/form-data">
           
            ven_id :<input type="number" name='ven_id'>
            lon : <input type="text" name='lon'>
            lat : <input type="text" name='lat'>
           
            <input type='submit' name='search' value='search'>
        </form>
         <br>
        <br>
        <form action="MyLocation.php" method="POST" enctype="multipart/form-data">
           
            ven_id  :<input type="number" name='ven_id'>
           
            <input type='submit' name='search' value='search'>
        </form>
        
         <br>
        <br>
        <form action="logIn.php" method="POST" enctype="multipart/form-data">
           
            phone  :<input type="number" name='ven_mobile'>
            pass  :<input type="number" name='ven_password'>
           
            <input type='submit' name='search' value='search'>
        </form>
        
    </body>
</html>