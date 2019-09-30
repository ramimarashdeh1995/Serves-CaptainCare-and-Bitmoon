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
    <body  style="background-color:sandybrown;text-align:center">
       <?php
       $datetime=new DateTime("now",new DateTimeZone('GMT+2'));
        $date_creat_acc=$datetime->format('Y-m-d H:i:s');
        echo $date_creat_acc;
       ?>
        
        <h1>******Following*****</h1>
        <br>
        <h4>*************************************************************************************</h4>
        <div>TODO write content</div>
        <br><br>
         --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Following To Market  :</h2>
        <form action="FollowToMarlet.php" method="POST" enctype="multipart/form-data">
         <br>   Vendor id:<br> <input type='texte' name='ven_id'>
         <br>  Captain id:<br> <input type='texte' name='cap_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Un Follow Market :</h2>
        <form action="FollowToMarlet.php" method="POST" enctype="multipart/form-data">
         <br>   Follow id:<br> <input type='texte' name='f_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         **************************************************************************************
        <h2>Block To Market  :</h2>
        <form action="BlockToMarket.php" method="POST" enctype="multipart/form-data">
         <br>  captain id:<br> <input type='texte' name='cap_id'>
         <br>   vendor id:<br> <input type='texte' name='ven_id'>
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         **************************************************************************************
        <h2>UnBlock To Market  :</h2>
        <form action="BlockToMarket.php" method="POST" enctype="multipart/form-data">
         <br>   Block id:<br> <input type='texte' name='b_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        **************************************************************************************
        <h2>Un Follow To Market  :</h2>
        <form action="UnFollowToMarket.php" method="POST" enctype="multipart/form-data">
         <br>   cap id:<br> <input type='texte' name='cap_id'>
         <br>   market id:<br> <input type='texte' name='ven_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <br><br>
         **************************************************************************************
        <h2>Following Market  :</h2>
        <form action="MyFollowing.php" method="POST" enctype="multipart/form-data">
         <br>   Market id:<br> <input type='texte' name='ven_id'>

         <br> <br> <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <br><br>
         **************************************************************************************
        <h2>Followers Market  :</h2>
        <form action="MyFollowers.php" method="POST" enctype="multipart/form-data">
         <br>   Market id:<br> <input type='texte' name='ven_id'>

         <br> <br> <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <br><br>
         **************************************************************************************
        <h2>Block Market  :</h2>
        <form action="MyBlock.php" method="POST" enctype="multipart/form-data">
         <br>   Market id:<br> <input type='texte' name='ven_id'>

         <br> <br> <input type='submit' name='search' value='search'>
        </form>
        <br><br>
    </body>
</html>