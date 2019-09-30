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
        <div>Save Offer Market : </div>
        <br><br>
        <form action="SaveOfferMarketFree.php" method="POST" enctype="multipart/form-data">
            vendor id: <input type='texte' name='ven_id'>
            Captin id: <input type='texte' name='cap_id'>
            offer id: <input type='texte' name='offer_id_market'>
            
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
         <div>Accept Offer Captain : </div>
        <br><br>
        <form action="AcceptOfferCaptain.php" method="POST" enctype="multipart/form-data">
           
             Captin id: <input type='texte' name='cap_id'>
            vendor id: <input type='texte' name='ven_id'>
           
            offer id: <input type='texte' name='offer_id'>
            
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
         <div>Save Offer Captain : </div>
        <br><br>
        <form action="SaveOfferCaptainFree.php" method="POST" enctype="multipart/form-data">
            vendor id: <input type='texte' name='ven_id'>
            Captin id: <input type='texte' name='cap_id'>
            offer id: <input type='texte' name='offer_id_market'>
            
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
        
         <div>end Offer Market : </div>
        <br><br>
        <form action="EndSaveProcessOffer.php" method="POST" enctype="multipart/form-data">
            save id: <input type='texte' name='save_id'>
            vendor id: <input type='texte' name='ven_id'>
            Captin id: <input type='texte' name='cap_id'>
            rank: <input type='texte' name='rank'>
            
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
        
         <div>Rank Offer Market : </div>
        <br><br>
        <form action="EndSaveProcessOffer.php" method="POST" enctype="multipart/form-data">
            save id: <input type='texte' name='save_id'>
            cap_id : <input type='texte' name='cap_id'>
            rank : <input type='texte' name='rank'>
            
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
         <div>Select Now Offer Market : </div>
        <br><br>
        <form action="SelectNowOffer.php" method="POST" enctype="multipart/form-data">
            ven id: <input type='texte' name='ven_id'>
            
            
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
         <div>Select Now Offer Market : </div>
        <br><br>
        <form action="SelectNowOffer.php" method="POST" enctype="multipart/form-data">
            cap id: <input type='texte' name='cap_id'>
            
            
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        --------------------------------------------------------------------------------------
       
    </body>
</html>