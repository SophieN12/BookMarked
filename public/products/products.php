<?php 
require('../../src/dbconnect.php');
$pageId = "Products";
$pageTitle = "Böcker";
$pageHeader ="";


if (isset($_POST["submitSearch"]) or $_GET["search"]){
    if (isset($_POST["submitSearch"])){
        $searchResult = trim($_POST['search-result']);
    } else {
        $searchResult = ($_GET['search']);
    }
    $sql = "
        SELECT * FROM books 
        WHERE title like :search 
        OR author LIKE :search
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search', '%' . $searchResult .'%');
    $stmt->execute();
    $pageHeader = "Sökresultat";
    
} else if (isset($_GET['category'])){  
    $selected_category = $_GET['category'];
    $sql = "
        SELECT * FROM books 
        WHERE CATEGORY LIKE :category
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':category', '%' . $selected_category . '%');
    $stmt->execute();

    $pageHeader = ucfirst($selected_category);
    $pageTitle  = ucfirst($selected_category);
    
} else if (isset($_GET['author'])){  
    $selected_author = $_GET['author'];
    $sql = "
        SELECT * FROM books 
        WHERE AUTHOR = :author;
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':author', $selected_author);
    $stmt->execute();

    $pageHeader = ucfirst($selected_author) . "s böcker";

} else if(isset($_GET['sortBy'])) {
    if ($_GET["sortBy"] == 'latest'){
        $stmt  = $pdo -> query("SELECT * FROM books order by published_date DESC");
        $pageHeader = "Senaste";

    } 
    if ($_GET["sortBy"] == 'alphabetical'){
        $stmt  = $pdo -> query("SELECT * FROM books ORDER BY title");
        $pageHeader = "A till Ö";
    } 
    if ($_GET["sortBy"] == 'ascending'){
        $stmt  = $pdo -> query ("SELECT * FROM books ORDER BY price ASC");
        $pageHeader = "Pris - Stigande";
    }   
    if ($_GET["sortBy"] == 'descending'){
        $stmt  = $pdo -> query("SELECT * FROM `books` ORDER BY price DESC");
        $pageHeader = "Pris - Fallande";
    } 

} else if(isset($_GET['language'])) {
    $sql = "SELECT * FROM books 
            WHERE language = :lang";

    $stmt = $pdo->prepare($sql); 
    $stmt->bindValue(':lang', $_GET['language']);
    $stmt -> execute();
    $pageHeader = ucfirst($_GET['language']) . " böcker";
    
} else {
    $sql  = 'SELECT * FROM books';
    $stmt = $pdo-> prepare($sql); //SÅRBAR! 
    $stmt -> execute();

    $pageHeader = "Böcker";
}

$books = $stmt->fetchAll();
?>

<?php include("../layout/header.php")?>

<h1><?= $pageHeader ?></h1>

<div id="filter-menu">
    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Språk
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="products.php?language=engelska">Engelska</a></li>
            <li><a class="dropdown-item" href="products.php?language=svenska"">Svenska</a></li>
        </ul>
    </div>

    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kategorier
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="products.php?category=deckare">Deckare</a></li>
            <li><a class="dropdown-item" href="products.php?category=fantasy">Fantasy</a></li>
            <li><a class="dropdown-item" href="products.php?category=romantik">Romantik</a></li>
            <li><a class="dropdown-item" href="products.php?category=science fiction">Science Fiction</a></li>
            <li><a class="dropdown-item" href="products.php?category=thriller">Thriller</a></li>
        </ul>
    </div>

    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sortera efter
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="products.php?sortBy=latest">Senaste</a></li>
            <li><a class="dropdown-item" href="products.php?sortBy=alphabetical">A till Ö</a></li>
            <li><a class="dropdown-item" href="products.php?sortBy=ascending">Pris - Stigande</a></li>
            <li><a class="dropdown-item" href="products.php?sortBy=descending">Pris - Fallande</a></li>
        </ul>
    </div>
</div>


<main id="products-grid">
    <?php foreach ($books as $book) {
        $id = $book['id'];
        $title = $book['title'];
        $author = $book['author'];
        $price = $book['price'];
        $img = $book['img_url']; ?>

    <div class=" card product-card">
        <a href="product.php?id=<?= $id ?>">
            <img src="../admin/products/<?= $img ?>">
            <div class="card-info">
                <h3><?= $title?></h3>
                <p><?= $author ?></p>
                <p><?= $price ?> SEK</p>
            </div>
        </a>
        
        <form id="add-cart-form" action="../add-cart-item.php" method="POST">
            <input type="hidden" name="productId" value="<?= $id ?>">
            <input type="submit" class="btn product-add-btn" name="addToCart" value="Köp">
        </form>
    </div>
    <?php } ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<!-- <script src="js/products.js"></script> -->


<?php include("../layout/footer.php")?>