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
        
        <h1>******Market*****</h1>
        <br>
        <h4>*************************************************************************************</h4>
        <div>TODO write content</div>
        <br><br>
        <form action="InsertOfferMarket.php" method="POST" enctype="multipart/form-data">
            ven id:<br> <input type='texte' name='ven_id'>
            <br>
            s_id : <br><input type="text" name='sub_id'>
            <br>
            city : <br> <input type='texte' name='city'>
            <br>
            tily:<br> <input type="text" name='offer_title'>
            <br>
            
           deacidification :<br><input type="text" name='offer_disc'>
           <br> imag:<br> <input type="text" name='offer_pic1'>
          <br>  imag:<br> <input type="text" name='offer_pic2'>
            <br>imag: <br><input type="text" name='offer_pic3'>
            <br>imag: <br><input type="text" name='offer_pic4'>
            <br>imag: <br><input type="text" name='offer_pic5'>
           <br> imag:<br> <input type="text" name='offer_pic6'>
           <br>date :<br> <input type='number' name='offer_end'>
             cost: <input type="number" name='cost'>
           <br> <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
        <br>
         **************************************************************************************
        <h2>Update Data :</h2>
        <form action="UpdateOfferMarket.php" method="POST" enctype="multipart/form-data">
          <br>  Offer id:<br> <input type='texte' name='offer_id'>
          <br>  city : <br> <input type='texte' name='city'>
          <br>  tily: <br><input type="text" name='offer_title'>
          <br>   deacidification : <br><input type="text" name='offer_disc'>
         <br>   imag:<br> <input type="text" name='offer_pic1'>
         <br>   imag: <br><input type="text" name='offer_pic2'>
         <br>   imag: <br><input type="text" name='offer_pic3'>
         <br>   imag: <br><input type="text" name='offer_pic4'>
         <br>   imag: <br><input type="text" name='offer_pic5'>
         <br>   imag: <br><input type="text" name='offer_pic6'>
          cost: <input type="number" name='cost'>
         <br>   <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Delete Data :</h2>
        <form action="DeleteOfferMarket.php" method="POST" enctype="multipart/form-data">
         <br>   Offer id:<br> <input type='texte' name='offer_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Select My Offer :</h2>
        <form action="SelectMyOffer.php" method="POST" enctype="multipart/form-data">
         <br>   Vendor id:<br> <input type='texte' name='ven_id'>
           
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Select  Offer :</h2>
        <form action="SelectMarketOffer.php" method="POST" enctype="multipart/form-data">
         <br>   Sub id:<br> <input type='texte' name='sub_id'>
           <br>   captain id:<br> <input type='texte' name='cap_id'>
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <br><br>
        --------------------------------------------------------------------------------------
         <br>
         **************************************************************************************
        <h2>Select  MY Offer ... Test :</h2>
        <form action="SelectMyOfferPaging.php" method="GET" enctype="multipart/form-data">
         <br>   Sub id:<br> <input type='texte' name='ven_id'>
           <br>   page id:<br> <input type='texte' name='page'>
            <br>   item id:<br> <input type='texte' name='item'>
          <br>  <input type='submit' name='search' value='search'>
        </form>
        <br><br>
    </body>
</html>