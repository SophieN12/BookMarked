<?php 
    $pageTitle = "Update Product";
    require('../../../src/config.php');
    
    $message       = "";
    $errorMessages = "";

if (isset($_POST['updateProductBtn'])) {
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

		if ($_FILES['upfile']['size'] > 1000000) {  // Allows only files under 1 mbyte
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
	} else {
        $imgUrl = $_POST['currentImg'];
    }

    if (empty($title) || empty($author) || empty($description) || empty($price) || 
        empty($pages) || empty($category) || empty($language)) {
        $errorMessages .= generateErrorMessageForEmptyField($title, "Titel");
        $errorMessages .= generateErrorMessageForEmptyField($author, "Författare");
        $errorMessages .= generateErrorMessageForEmptyField($description, "Beskrivning");
        $errorMessages .= generateErrorMessageForEmptyField($price, "Pris");
        $errorMessages .= generateErrorMessageForEmptyField($pages, "Sidor");
        $errorMessages .= generateErrorMessageForEmptyField($category, "Kategori");
        $errorMessages .= generateErrorMessageForEmptyField($language, "Språk");
        $errorMessages .= generateErrorMessageForEmptyField($published_date, "Publiseringsdatum");
    } 
    if (is_numeric($price) === false && !empty($price) || is_numeric($pages) === false && !empty($pages)){
        if (is_numeric($price) === false ){
            $errorMessages .= '<li> Fel input för <strong> Pris </strong> (Måste vara ett nummer). </li>';
        }
        else {
            $errorMessages .= '<li> Fel input för <strong> Sidor </strong> (Måste vara ett nummer). </li>';
        }
    }

    if (!empty($errorMessages)) {
        $message .= '<div class="alert alert-danger messages-div"><ul>'. $errorMessages. '</ul></div> ' ;

	} else {
        $booksDbHandler -> updateBook($_POST['bookId'], $title, $author, $description, $price, $pages, $imgUrl, $category, $language, $published_date);
        redirect("manage-products.php");
    }
}    
    $book = $booksDbHandler -> fetchSpecificBook($_POST['bookId'])
?>

<?php include('../../layout/admin-header.php')?>

    <div class="container w-50 mt-5 mb-5">
        <h2>Update Product</h2>
        <br>

        <?= $message ?>
        
        <img src="<?= $book['img_url']?>" class="mb-3 product-img" height= "400px">

        <div class="form-background">
        <form class="input-form" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="bookId" value="<?= $book['id']?>">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($book['title'])?>" name="title">
                <label for="floatingInput">Titel *</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($book['author'])?>" name="author">
                <label for="floatingInput">Författare *</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($book['price'])?>" name="price">
                <label for="floatingInput">Pris (SEK) *</label>
            </div>
            
            <div class="form-floating mb-3">
                <textarea class="form-control" id="floatingTextarea2" style="height: 200px" name="description"><?=htmlentities($book['description'])?></textarea>
                <label for="floatingTextarea2">Beskrivning *</label>
            </div>
            
            <div class="form-row">
                <div class="form-floating col mb-3">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($book['pages'])?>" name="pages">
                    <label for="floatingInput">Sidor *</label>
                </div>
                <div class="form-floating col mb-3">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($book['language'])?>" name="language">
                    <label for="floatingInput">Språk *</label>
                </div>
            </div>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($book['category'])?>" name="category">
                <label for="floatingInput">Kategori *</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="floatingInput" value="<?=$book['published_date']?>" name="published_date">
                <label for="floatingInput">Publiseringsdatum *</label>
            </div>

            <label class="floatingInput mb-1" for="inputGroupFile02">Product image:</label>
            <div class="input-group mb-3">
                <input type="hidden" value=<?=$book['img_url']?> name="currentImg">
                <input type="file" class="form-control" id="inputGroupFile02" name="uploadedFile">
                <label class="input-group-text" for="inputGroupFile02" >Upload</label>
            </div>

            <div class="d-grid gap-3 col-6 mx-auto mt-4 ">
                <input type="submit" class="btn btn-primary" name="updateProductBtn" value="Uppdatera">
                
                <a href="manage-products.php" class="btn btn-secondary cancel-btn">Avbryt</a>
            </div>
        </form>
        </div>

</body>
</html>
