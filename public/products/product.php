<?php 
require('../../src/dbconnect.php');

$messages="";

$sql = 'SELECT * FROM books WHERE id =' . $_GET["id"];
$stmt = $pdo-> prepare($sql);  
$stmt -> execute();
$book = $stmt->fetch();
$pageTitle = $book['title'] . ' - ' . $book['author'];

$sql = 'SELECT reviews.rating, reviews.review_text, reviews.create_date, users.first_name, users.last_name 
        FROM reviews LEFT JOIN users ON reviews.user = users.id 
        WHERE reviews.book = :id';

$stmt = $pdo-> prepare($sql); 
$stmt-> bindParam(":id",  $_GET["id"]);
$stmt -> execute();
$reviews = $stmt->fetchAll();

if (isset($_POST['submitReviewBtn'])){
    $bookId         = $_POST['bookId'];
    $userId         = $_POST['userId'];
    $rating         = trim($_POST['rating']);
    $reviewText     = trim($_POST['reviewText']);

    if (empty($rating) || empty($reviewText)){
        echo"Hello";

    } else {
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
}?>
<?php include("../layout/header.php")?>


<main>
    <section id="product-section">
        <div>
            <img src="../admin/products/<?= $book['img_url'] ?>">
        </div>
        <div>
            <h3><?= $book["title"]; ?></h3>
            <h4><?= $book["author"]; ?></h4>
            <p> <?= $book["category"]; ?> </p>
            <p> <?= $book["price"]; ?> SEK</p>
            <p>
                <?php
                        $string = strip_tags($book["description"]);
                        if (strlen($string) > 200) {
                        
                            // truncate string
                            $stringCut = substr($string, 0, 200);
                            $endPoint = strrpos($stringCut, ' ');
                        
                            //if the string doesn't contain any space then it will cut without word basis.
                            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                            $string .= '... <a href="#product-info" fade>Read More</a>';
                        } 
                        echo $string;
                ?>
            </p>

            <button>Lägg i varukorgen</button>
            <button>Favorisera</button>
        </div>

    </section>

    <section id="product-info">
        <button id="desc-btn" class="active-link">Beskrivning</button>
        <button id="info-btn">Produktinfo</button>

        <div>
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
                        <div id="message"></div>
                        <form id="review-form" action="" method="POST">
                            <input type="hidden" name="bookId" value= <?=$book['id']?> >
                            <div class="form-group">
                                <label for="userId">UserID:</label>
                                <input type="int" class="form-control" name="userId" value= <?=htmlentities($userId)?> >
                            </div>

                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <input type="int" class="form-control" name="rating" value= <?=htmlentities($rating)?> >
                            </div>
                            
                            <div class="form-group">
                                <label for="reviewText">Recension (valfritt):</label>
                                <input type="text" class="form-control" name="reviewText" value= <?=htmlentities($reviewText)?>>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submitReviewBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </section>

</main>

<script src="js/product-info.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php include("../layout/footer.php")?>