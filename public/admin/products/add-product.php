<?php 
    $pageTitle = "Add Product";
    require('../../../src/config.php');

    $message = "";
    
    $title          = "";
    $author         = "";
    $price          = "";
    $description    = "";
    $pages          = "";
    $category       = "";
    $language       = "";
    $published_date = "";

    if (isset($_POST['addProductBtn'])) {
        $title          = trim($_POST['title']);
        $author         = trim($_POST['author']);
        $description    = trim($_POST['description']);
        $price          = trim($_POST['price']);
        $pages          = trim($_POST['pages']);
        $category       = trim($_POST['category']);
        $language       = trim($_POST['language']);
        $published_date = trim($_POST['published_date']);

        if (is_uploaded_file($_FILES['uploadedFile']['tmp_name'])) {
            $fileName 	    = $_FILES['uploadedFile']['name'];
            $fileType 	    = $_FILES['uploadedFile']['type'];
            $fileTempPath   = $_FILES['uploadedFile']['tmp_name'];
            $path 		    = "product-images/";

		    $newFilePath = $path . $fileName; 

            $allowedFileTypes = [
                'image/png',
                'image/jpeg',
                'image/gif',
            ];
            
            $isFileTypeAllowed = array_search($fileType, $allowedFileTypes, true);
            if ($isFileTypeAllowed === false) {
    			$errorMessages .= "<li> Invalid file type. Accepted file types are jpeg, png, gif. </li>";

            }

            if ($_FILES['upfile']['size'] > 10000) { 
    			$errorMessages .= '<li> Exceeded filesize limit. </li>';
            }

            if (empty($errorMessages)) {
                $isTheFileUploaded = move_uploaded_file($fileTempPath, $newFilePath);
        
                if ($isTheFileUploaded) {
                    $imgUrl = $newFilePath;
                } else {
				    $errorMessages .= "<li> Could not upload the file </li>";
                }
            }
        } 	

        if (empty($title) || empty($author) || empty($description) || empty($price) || 
            empty($pages) || empty($category) || empty($language) || empty($imgUrl)) {
            $errorMessages .= generateErrorMessageForEmptyField($title, "Titel");
            $errorMessages .= generateErrorMessageForEmptyField($author, "Författare");
            $errorMessages .= generateErrorMessageForEmptyField($description, "Beskrivning");
            $errorMessages .= generateErrorMessageForEmptyField($price, "Pris");
            $errorMessages .= generateErrorMessageForEmptyField($pages, "Sidor");
            $errorMessages .= generateErrorMessageForEmptyField($category, "Kategori");
            $errorMessages .= generateErrorMessageForEmptyField($language, "Språk");
            $errorMessages .= generateErrorMessageForEmptyField($published_date, "Publiseringsdatum");
            $errorMessages .= generateErrorMessageForEmptyField($imgUrl, "Produktbild");
        } 

        if (is_numeric($price) === false && !empty($price) || is_numeric($stock) === false && !empty($stock)) {
            if (is_numeric($price) === false ){
                $errorMessages .= '<li> Wrong input for <strong> Price </strong> (Needs to be a number). </li>';
            }
            if (is_numeric($stock) === false ){
                $errorMessages .= '<li> Wrong input for <strong> Stock </strong> (Needs to be a number). </li>';
            }
        }
        if (!empty($errorMessages)) {
            $message .= '<div class="alert alert-danger messages-div" ><ul>'. $errorMessages. '</ul></div> ' ;
        
        } else {
            $booksDbHandler -> addBook($title, $author, $description, $price, $pages, $imgUrl, $category, $language, $published_date);
            redirect('manage-products.php');
        }
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $pageTitle ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/products.css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</head>
<body>

    <div class="container mt-3">
        <h1 class="center" >Add new product</h1>
        <br>

        <img src="product-images/placeholder.png" class="mb-3 product-img-form"height="300px">
        <?= $message ?>

        <div class="form-background">
            <form class="input-form" action="" method="post" enctype="multipart/form-data">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Book title" id="floatingInput" name="title" value= "<?=htmlentities($title)?>">
                    <label for="floatingInput">Boktitel *</label>
                </div>  
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Author" id="floatingInput" name="author" value= "<?=htmlentities($author)?>">
                    <label for="floatingInput">Författare *</label>
                </div> 

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Price" id="floatingInput" name="price" value= "<?=htmlentities($price)?>">
                    <label for="floatingInput">Pris *</label>
                </div>
                
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="floatingTextarea2" style="height: 200px" name="description"><?=htmlentities($description)?></textarea>
                    <label for="floatingTextarea2">Beskrivning *</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Sidor" id="floatingInput" name= "pages" value= "<?=htmlentities($pages)?>">
                    <label for="floatingInput">Sidor *</label>
                </div> 

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Språk" id="floatingInput" name= "language" value= "<?=htmlentities($language)?>">
                    <label for="floatingInput">Språk *</label>
                </div> 

                <div class="form-floating mb-3">
                    <select class="form-select pt-2" aria-label="Default select example" name="category" placeholder="Kategori">
                        <option value="" disabled selected hidden>Kategori</option>
                        <option value="Romantik">Romantik</option>
                        <option value="Science Fiction">Science Fiction</option>
                        <option value="Skönhetslitteratur">Skönhetslitteratur</option>
                        <option value="Thriller">Thriller</option>
                        <option value="Deckare">Deckare</option>
                    </select>
                </div>

                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="floatingInput" name="published_date">
                    <label for="floatingInput">Publiseringsdatum *</label>
                </div>

                <label class="floatingInput mb-1" for="inputGroupFile02">Product image:</label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="inputGroupFile02" name="uploadedFile">
                    <label class="input-group-text" for="inputGroupFile02" >Upload</label>
                </div>
        </div>
                <div class="d-grid gap-3 col-6 mx-auto mt-4">
                    <input type="submit" class="btn" name="addProductBtn" value="Add">

                    <a href="manage-products.php" class="btn btn-secondary cancel-btn">Cancel</a>
            </form>

        </div>
    </div>
</body>
</html>