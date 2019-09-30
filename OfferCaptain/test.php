<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <title>TODO supply a title Captain</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="background: chartreuse; text-align:center">
       <?php
      $timeA = new DateTime("now",new DateTimeZone('GMT+3'));
        echo $timeA->format('Y-m-d H:i:s');
        echo "<br>";
        $per = 1 ;
        $timeB = new DateInterval("PT".$per."H0M0S"); 
        $timeA->add($timeB);
        echo $timeA->format('Y-m-d H:i:s');
       
       ?>
        <div>TODO write content Captain</div>
        <br><br>
        <form action="InsertOfferCaptain.php" method="POST" enctype="multipart/form-data">
            Captin id: <input type='texte' name='cap_id'>
            s_id :<input type="text" name='sub_id'>
            city :  <input type='texte' name='city'>
            tily: <input type="text" name='offer_title'>
             deacidification :<input type="text" name='offer_disc'>
            imag: <input type="text" name='offer_pic1'>
            imag: <input type="text" name='offer_pic2'>
            imag: <input type="text" name='offer_pic3'>
            imag: <input type="text" name='offer_pic4'>
            imag: <input type="text" name='offer_pic5'>
            imag: <input type="text" name='offer_pic6'>
            date: <input type="text" name='offer_end'>
            cost: <input type="number" name='cost'>
            address: <input type="text" name='address'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
        <h4>Update Data :</h4>
        <form action="UpdateOfferCaptain.php" method="POST" enctype="multipart/form-data">
            Offer id: <input type='texte' name='offer_id'>
            city :  <input type='texte' name='city'>
            tily: <input type="text" name='offer_title'>
             deacidification :<input type="text" name='offer_disc'>
            imag: <input type="text" name='offer_pic1'>
            imag: <input type="text" name='offer_pic2'>
            imag: <input type="text" name='offer_pic3'>
            imag: <input type="text" name='offer_pic4'>
            imag: <input type="text" name='offer_pic5'>
            imag: <input type="text" name='offer_pic6'>
            cost: <input type="number" name='cost'>
            address: <input type="text" name='address'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         --------------------------------------------------------------------------------------
        <h4>Delete Data :</h4>
        <form action="DeleteOfferCaptain.php" method="POST" enctype="multipart/form-data">
            Offer id: <input type='texte' name='offer_id'>
           
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
         <h4>Select My Offer :</h4>
         <form action="SelectMyOffer.php" method="POST" enctype="multipart/form-data">
            Captain id: <input type='texte' name='cap_id'>
           
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        ***********************************************************************************************
        -----------------------------------------------------------------------------------------------
         <br><br>
         <h4>Select My Offer :</h4>
         <form action="SelectCaptainOffer.php" method="POST" enctype="multipart/form-data">
            Sub id: <input type='texte' name='sub_id'>
           vendor id: <input type='texte' name='ven_id'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <h1>Push Offer :</h1>
        <br><br>
        <form action="AddPushOffer.php" method="POST" enctype="multipart/form-data">
            Captin id: <input type='texte' name='cap_id'>
            s_id :<input type="text" name='sub_id'>
            city :  <input type='texte' name='city'>
            tily: <input type="text" name='offer_title'>
             deacidification :<input type="text" name='offer_disc'>
            imag: <input type="text" name='offer_pic1'>
            imag: <input type="text" name='offer_pic2'>
            imag: <input type="text" name='offer_pic3'>
            imag: <input type="text" name='offer_pic4'>
            imag: <input type="text" name='offer_pic5'>
            imag: <input type="text" name='offer_pic6'>
            date: <input type="text" name='offer_end'>
            cost: <input type="number" name='cost'>
            address: <input type="text" name='address'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
    </body>
</html>