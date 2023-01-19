<?php 
require('../../src/config.php');

$messages="";

$book = $booksDbHandler -> fetchSpecificBook($_GET["id"]);

$pageTitle = $book['title'] . ' - ' . $book['author'];

$sql = 'SELECT reviews.rating, reviews.review_text, reviews.create_date, users.first_name, users.last_name 
        FROM reviews LEFT JOIN users ON reviews.user = users.id 
        WHERE reviews.book = :id';

$stmt = $pdo-> prepare($sql); 
$stmt-> bindParam(":id",  $_GET["id"]);
$stmt -> execute();
$reviews = $stmt->fetchAll();

if (isset($_POST['submitReviewBtn']) && isset($_SESSION['id'])){
    $bookId         = $_POST['bookId'];
    $userId         = $_SESSION['id'];
    $rating         = trim($_POST['rating']);
    $reviewText     = trim($_POST['reviewText']);
    
    $sql = "INSERT INTO reviews (book, user, rating, review_text)
    VALUES (:book, :user, :rating, :review_text)";

    $stmt = $pdo->prepare($sql);
    $stmt-> bindParam(":book",  $bookId);
    $stmt-> bindParam(":user",  $userId);
    $stmt-> bindParam(":rating", $rating);
    $stmt-> bindParam(":review_text", $reviewText);
    $stmt-> execute(); 

    header("Refresh:0");
} 

?>
<?php include("../layout/header.php")?>
<section id="secondary-menu" style="background-color:#60607d;margin-bottom:30px;">
    <nav>
        <a href="products.php">Alla</a>
        <a href="products.php?category=skönlitteratur">Skönlitteratur</a>
        <a href="products.php?category=romantik">Romantik</a>
        <a href="products.php?category=deckare">Deckare </a>
        <a href="products.php?category=thriller">Thriller </a>
        <a href="products.php?category=fantasy">Fantasy </a>
        <a href="products.php?category=science fiction">Science Fiction </a>
        <a href="products.php?category=barn & ungdom">Barn & Ungdom</a>
    </nav>
</section>

<main>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="products.php">Böcker</a></li>
            <li class="breadcrumb-item"><a href="products.php?category=Romantik">Romantik</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$book['title']?></li>
        </ol>
    </nav>

    <section id="product-section">
        <div>
            <img src="../admin/products/<?= $book['img_url'] ?>">
        </div>
        <div id="product-div">
            <b class='price'> <?= $book["price"]; ?> SEK</b>
            <h3><?= $book["title"]; ?></h3>
            <h6>Av <a href="products.php?author=<?=$book["author"]?>"><?=$book["author"]?></a></h6>
            <p> <?= $book["category"]; ?> </p>
            <br>
            <p style="line-height: 1.7em; ">
                <?php
                        $string = strip_tags($book["description"]);
                        if (strlen($string) > 300) {
                        
                            // truncate string
                            $stringCut = substr($string, 0, 300);
                            $endPoint = strrpos($stringCut, ' ');
                        
                            //if the string doesn't contain any space then it will cut without word basis.
                            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                            $string .= '... <a href="#product-info" fade>Read more</a>';
                        } 
                        echo $string;
                ?>
            </p>
            <p style="float:right; margin-top: 10px;"><b>Leveranstid: </b>3-5 arbetsdagar</p>

            <form id="add-cart-form" action="../add-cart-item.php" method="POST" onsubmit= "addToCart(); return false">
                <input type="hidden" name="productId" value="<?= $book['id'] ?>">
                <button type="submit" class="btn product-add-btn" name="addToCart"><i class="fa-solid fa-bag-shopping"></i>&nbsp; &nbsp; Lägg till i varukorg</button>
            </form>
        </div>
    </section>

    <section id="product-info">
        <div class="toggle-btn-div">
            <button id="desc-btn" class="active-link">Beskrivning</button>
            <button id="info-btn">Produktinfo</button>
        </div>

        <div class="product-info">
            <div class="info-box show-box" style="width: 700px; overflow:auto">
                <pre><?=$book["description"];?></pre>   
            </div>

            <div class="info-box">
                <p>Författare: 
                    <a href="products.php?author=<?=$book["author"]?>"> <?=$book["author"]?> </a>
                </p>
                <p>Språk: <?= $book["language"]; ?> </p>
                <p>Antal sidor: <?= $book["pages"]; ?> </p>
                <p>ISBN: 1234567890123456789</p>
            </div>
        </div>
    </section>


    <section id="reviews-section">
        <h3>Recensioner</h3>

        <?php foreach($reviews as $review){ ?>
            <div class="review-card">
                <i><?= substr($review['create_date'], 0, -9);?></i>
                <b> <?= $review['first_name'] . " " . $review['last_name']?> </b>
                <img src="../img/<?=$review['rating']?>-stars.png" height="15px">
                <br>
                <p> <?= $review['review_text']?> </p>
            </div>
        <?php } ?>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reviewModal">
            Skriv en recension
        </button>

        <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Vad tyckte du om "<?= $book['title']?>"?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div id="reviewMessages"><?=$messages?></div>
                        <form id="review-form" method="POST">
                            <input type="hidden" name="bookId" value= <?=$book['id']?> >
                            <input type="hidden" name="sessionId" value= <?=$_SESSION['id']?> >

                            <div class="rating-div mb-3 mt-3">
                                <input type="hidden" class="form-control" id="rating-input" name="rating" value="">
                                <i class="fa-regular fa-star fa-lg" data-star="1"></i>
                                <i class="fa-regular fa-star fa-lg" data-star="2"></i>
                                <i class="fa-regular fa-star fa-lg" data-star="3"></i>
                                <i class="fa-regular fa-star fa-lg" data-star="4"></i>
                                <i class="fa-regular fa-star fa-lg" data-star="5"></i>
                            </div>

                            <div class="form-group">
                                <label for="reviewText">Recension (valfritt):</label>
                                <textarea class="form-control" id="floatingTextarea2" style="height: 200px" name="reviewText" placeholder="Skriv din recension här..."><?=htmlentities($reviewText)?></textarea>
                            </div>
                            
                            <div class="modal-footer py-0">
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submitReviewBtn" >Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </section>

</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/product.js"></script>

<script>
    alertDiv = document.getElementsByClassName("alert-div");

    function addToCart(e){
        e.preventDefault();
        alertDiv.innerHTML = '<div class="alert alert-success" role="alert"> This is a success alert—check it out! </div>';
    }
</script>

<?php include("../layout/footer.php")?>