<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body  style="background-color:skyblue;text-align:center">
       <?php
       $datetime=new DateTime("now",new DateTimeZone('GMT+2'));
        $date_creat_acc=$datetime->format('Y-m-d H:i:s');
        echo $date_creat_acc;
       ?>
        
        <h1>******Captain*****</h1>
        <br>
        <h4>*************************************************************************************</h4>
        <div>TODO write content</div>
        <br><br>
        <h2>Select Favorite</h2>
        <br>
        <h4>*************************************************************************************</h4>
        <br>
        <form action="MyFavorite.php" method="POST" enctype="multipart/form-data">
            captain id:<br> <input type='texte' name='cap_id'>
             <br> <br>   <input type='submit' name='search' value='search'>
        </form>
        <br>
        <h3>*************************************************************************************</h3>
        <br><br>
        <h2>Add Favorite</h2>
        <br>
        <h4>*************************************************************************************</h4>
        <br>
        <form action="AddFavoriteOffer.php" method="POST" enctype="multipart/form-data">
            captain id:<br> <input type='texte' name='cap_id'>
            <br>
             offer  id:<br> <input type='texte' name='offer_id'>
             <br>
              vendor  id:<br> <input type='texte' name='ven_id'>
             <br>
             <br>   <input type='submit' name='search' value='search'>
        </form>
        <br>
        <h3>*************************************************************************************</h3>
        <br><br>
        <h2>Delete Favorite</h2>
        <br>
        <h4>*************************************************************************************</h4>
        <br>
        <form action="UnFavoriteOffer.php" method="POST" enctype="multipart/form-data">
            captain id:<br> <input type='texte' name='cap_id'>
             <br>
             offer  id:<br> <input type='texte' name='offer_id'>
             
              save  id:<br> <input type='texte' name='save_id'>
             
              <br><br>   <input type='submit' name='search' value='search'>
        </form>
    </body>
</html>