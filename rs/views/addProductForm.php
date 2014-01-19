<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
    <head>
        <meta http-equiv=\"Content-type\" content=\"text/html; charset=windows-1250\" />
        <title>Přidat Produkt</title>
        <link rel=stylesheet type="text/css" href="css/style.css" media="screen,projection" />
        <script src="../lib/ckeditor/ckeditor.js"></script>
        
        <script>
            function Focus() {
                CKEDITOR.instances.editor1.focus();
            }

            function onFocus() {
                document.getElementById( 'eMessage' ).innerHTML = '<b>' + this.name + ' is focused </b>';
            }

            function onBlur() {
                document.getElementById( 'eMessage' ).innerHTML = this.name + ' lost focus';
            }

        </script>
        <style type="text/css">
            a{
                color: blue;

            }
        </style>
    </head>
    <body class="produkty">


        <h1>Přidat Produkt</h1>
        
        <form action="actions.php" method="POST" name="productForm" enctype="multipart/form-data" >
            <table>
                <tr>
                    <td>Název produktu:</td>
                    <td><input type="text" name="name" value="<?php echo isset($product->name) ? $product->name : ''?>"/></td>
                </tr>
                <tr>
                    <td>Popis:</td>
                    <td>
                        <textarea id="ckeditor" name="description" rows="5" cols="38"><?php echo isset($product->description) ? $product->description : ''?></textarea>
                        <script>
                            // Replace the <textarea id="editor1"> with an CKEditor instance.
                            CKEDITOR.replace( 'ckeditor', {
                                on: {
                                    focus: onFocus,
                                    blur: onBlur,

                                    // Check for availability of corresponding plugins.
                                    pluginsLoaded: function( evt ) {
                                        var doc = CKEDITOR.document, ed = evt.editor;
                                        if ( !ed.getCommand( 'bold' ) )
                                            doc.getById( 'exec-bold' ).hide();
                                        if ( !ed.getCommand( 'link' ) )
                                            doc.getById( 'exec-link' ).hide();
                                    }
                                }
                            });
                        </script>
                        <span class="poznamka">Pozn. maximálně 5 řádků</span>
                    </td>
                    
                </tr>
                <tr>
                    <td>Cena:</td>
                    <td><input type="text" name="prize" value="<?php echo isset($product->prize) ? $product->prize : ''?>"/>Kč</td>
                </tr>
                <tr>
                    <td>Obrázek:</td>
                    <td><input type="file" name="file" /><br /><span class="poznamka">(Pozn. Pouze formát obrázků JPG/JPEG/PNG)</span></td>
                </tr>
                <tr>
                    <td>
                        <?php if (isset($product)) { ?>
                            <input type="hidden" value="<?php echo $_GET['id_product']; ?>" name="id_product" />
                            <input type="submit" value="Upravit" name="editProductSubmit" />
                        <?php } else {?>
                            <input type="hidden" value="<?php echo $_GET['id_category']; ?>" name="id_category" />
                            <input type="submit" value="Uložit" name="addProductSubmit" />
                        <?php } ?>
                    </td>
                    <?php if (isset($product)) { ?>
                    <td><a href="/rs/products.php?id_category=<?php echo $product->id_category; ?>" />Zpět</td>
                    <?php } else {?>
                    <td><a href="/rs/products.php?id_category=<?php echo $_GET['id_category']; ?>" />Zpět</td>
                    <?php } ?>
                    
                </tr>
                
            </table>
            
        </form>

    </body>
</html>