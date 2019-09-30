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
        require 'classService.php';
        $co=new classService();
        echo json_encode($co->SelectAllCategory(),JSON_UNESCAPED_UNICODE);
        
        ?>
        <div>TODO write content</div>
        <br><br>
        <form action="SelectAllCategory.php" method="POST" enctype="multipart/form-data">
                        cadsdsd: <input type="text" name='category'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <form action="SelectAllSubCategory.php" method="POST" enctype="multipart/form-data">
                        Sub: <input type="text" name='sub_category'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <form action="SelectAllCategory.php" method="POST" enctype="multipart/form-data">
                        c_id: <input type="text" name='c_id'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <form action="InsertService.php" method="POST" enctype="multipart/form-data">
                        v_id: <input type="text" name='ven_id'>
                        c_id: <input type="text" name='cat_id'>
                        s_id: <input type="text" name='sub_id'>
            <input type='submit' name='search' value='search'>
        </form>
        <br><br>
        <form action="SelectAllServiceMarket.php" method="POST" enctype="multipart/form-data">
                        v_id: <input type="text" name='ven_id'>
            <input type='submit' name='search' value='search'>
        </form>
        
    </body>
</html>