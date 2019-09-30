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
        
        <h1>******Following*****</h1>
        <br>
        <h4>*************************************************************************************</h4>
        <div>TODO write content</div>
        <br><br>
         --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Following To Captain  :</h2>
        <form action="FollowToCaptain.php" method="POST" enctype="multipart/form-data">
         <br>   captain id:<br> <input type='texte' name='cap_id'>
         <br>  vendor id:<br> <input type='texte' name='ven_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Un Follow Captain :</h2>
        <form action="FollowToCaptain.php" method="POST" enctype="multipart/form-data">
         <br>   Follow id:<br> <input type='texte' name='f_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         **************************************************************************************
        <h2>Block To Captain  :</h2>
        <form action="BlockToCaptain.php" method="POST" enctype="multipart/form-data">
         <br>   vendor id:<br> <input type='texte' name='ven_id'>
         <br>  captain id:<br> <input type='texte' name='cap_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         **************************************************************************************
        <h2>UnBlock To Captain  :</h2>
        <form action="BlockToCaptain.php" method="POST" enctype="multipart/form-data">
         <br>   Block id:<br> <input type='texte' name='b_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         **************************************************************************************
        <h2>Un Follow To Captain  :</h2>
        <form action="UnFollowToCaptain.php" method="POST" enctype="multipart/form-data">
         <br>   cap id:<br> <input type='texte' name='cap_id'>
         <br>   ven id:<br> <input type='texte' name='ven_id'>

          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <br><br>
         **************************************************************************************
        <h2>Following Captain  :</h2>
        <form action="MyFollowing.php" method="POST" enctype="multipart/form-data">
         <br>   cap id:<br> <input type='texte' name='cap_id'>

         <br> <br> <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <br><br>
         **************************************************************************************
        <h2>Followers Captain  :</h2>
        <form action="MyFollowers.php" method="POST" enctype="multipart/form-data">
         <br>   cap id:<br> <input type='texte' name='cap_id'>

         <br> <br> <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <br><br>
         **************************************************************************************
        <h2>Block Captain  :</h2>
        <form action="MyBlock.php" method="POST" enctype="multipart/form-data">
         <br>   cap id:<br> <input type='texte' name='cap_id'>

         <br> <br> <input type='submit' name='search' value='search'>
        </form>
        <br><br>
    </body>
</html>