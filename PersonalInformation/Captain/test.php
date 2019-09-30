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
    <body  style="background-color:gold;text-align:center">
       <?php
       $datetime=new DateTime("now",new DateTimeZone('GMT+2'));
        $date_creat_acc=$datetime->format('Y-m-d H:i:s');
        echo $date_creat_acc;
       ?>
        
        <h1>******Information*****</h1>
        <br>
        <h4>*************************************************************************************</h4>
        <div>TODO write content</div>
        <br><br>
         --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Information To Captain  :</h2>
        <form action="SelectInformaionFromCapToVen.php" method="POST" enctype="multipart/form-data">
         <br>   captain id:<br> <input type='texte' name='cap_id'>
         <br>  vendor id:<br> <input type='texte' name='ven_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br>
        <br>
         **************************************************************************************
        <h2>Follow To Captain  :</h2>
        <form action="SelectCounterFollow.php" method="POST" enctype="multipart/form-data">
         <br>   captain id:<br> <input type='texte' name='cap_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
       
    </body>
</html>