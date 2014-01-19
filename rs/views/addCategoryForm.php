<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
    <head>
        <meta http-equiv=\"Content-type\" content=\"text/html; charset=windows-1250\" />
        <title>Přidat kategorii</title>
        <link rel=stylesheet type="text/css" href="css/style.css" media="screen,projection" />
        <style type="text/css">
            a{
                color: blue;

            }
        </style>
    </head>
    <body class="produkty">

        <h1>Přidat kategorii</h1>
        
        <form action="actions.php?id=<?php echo $_GET['id']; ?>" method="POST" name="categoryForm">
            <table>
                <tr>
                    <td>Název kategorie:</td>
                    <td><input type="text" name="name" value="<?php echo isset($name) ? $name : ''?>"/></td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id_category" />
                        <?php if (isset($name)) { ?>
                            <input type="submit" value="Upravit" name="editCategorySubmit" />
                        <?php } else {?>
                            <input type="hidden" value="<?php echo $level + 1; ?>" name="level" />
                            <input type="submit" value="Uložit" name="addCategorySubmit" />
                        <?php } ?>
                    </td>
                    <td><a href="/rs/" />Zpět</td>
                    
                </tr>
            </table>
            
        </form>

    </body>
</html>