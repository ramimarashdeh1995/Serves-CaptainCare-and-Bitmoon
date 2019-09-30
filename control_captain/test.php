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
        <?php
        require 'class_captain.php';
        $co=new class_captain();
        $co->read_table_cust()
        ?>
        <div>TODO write content</div>
        <br><br>
        <form action="signUp.php" method="POST" enctype="multipart/form-data">
            user name : <input type='texte' name='cap_name'>
            password :<input type="text" name='cap_password'>
            mobile: <input type="text" name='cap_mobile'>
             password :<input type="text" name='cap_city'>
            mobile: <input type="text" name='cap_lic_url'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <form action="logIn.php" method="POST" enctype="multipart/form-data">
                        mobile: <input type="text" name='cap_mobile'>

            password :<input type="text" name='cap_password'>
            <input type='submit' name='search' value='search'>
        </form>
    </body>
</html>