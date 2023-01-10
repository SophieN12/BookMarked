<?php
require('../../src/config.php');

$pageId = "Home";
$pageTitle = "Homepage";
$alertMessages = "";

if (isset($_GET['logout'])){
    $alertMessages = "You have logged out";
}

$sql = "SELECT * FROM books";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll();
?>

<?php include('../layout/header.php')?>

<?php if (isset($_GET['logout'])){ ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        Du är nu<strong> utloggad.</strong>
        <button type="button" class="close alert-close-btn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<main>
    <section id="slideshow-container">
        <div class="mySlides fade-slide">
            <img src="../img/CTA-1.png" style="width:100%">
        </div> 
        
        <div class="mySlides fade-slide">
            <img src="../img/CTA-2.png" style="width:100%">
        </div>
        
        <div class="mySlides fade-slide">
            <img src="../img/CTA-3.png" style="width:100%">
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        <div class="dots-div">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </section>

    <section id="secondary-menu">
        <nav>
            <a href="products.php">Alla</a>
            <a href="products.php?category=skönlitteratur">Skönlitteratur</a>
            <a href="products.php?category=romantik">Romantik</a>
            <a href="products.php?category=deckare">Deckare </a>
            <a href="products.php?category=thriller">Thriller </a>
            <a href="products.php?category=fantasy">Fantasy </a>
            <a href="products.php?category=science fiction">Science Fiction </a>
            <a href="">Barn & Ungdom</a>
        </nav>
    </section>

    <section id="trending-books-section">
        <h2>Trendande böcker</h2>
        <ul id="product-slideshow">
            <?php 
            for($num = 0; $num < 8; $num++) {?>
                <li class="book-card card">
                    <a href="product.php?id=<?= $books[$num]['id'] ?>">
                        <img src="../admin/products/<?= $books[$num]['img_url'] ?>">
                        <div class="card-info">
                            <h3><?= htmlentities($books[$num]['title']) ?></h3>
                            <p><?= htmlentities($books[$num]['author']) ?></p>
                            <b
                            ><?= htmlentities($books[$num]['price']) ?> SEK</b>
                        </div>
                    </a>

                    <form id="add-cart-form" action="../add-cart-item.php" method="POST">
                        <input type="hidden" name="productId" value="<?= $books[$num]['id'] ?>">
                        <input type="submit" class="btn product-add-btn" name="addToCart" value="Köp">
                    </form>
                </li>
            <?php } ?>
        </ul>
    </section>

    <section id="CTA-section">
        <img src="../img/CollenHooverBooks.png" alt="">
        <div>
            <h3>CHECK OUT COLLEEN HOOVERS MOST POPULAR BOOKS!</h3>
            <a href="products.php?author=Colleen Hoover">
                <button>See more</button>
            </a>
        </div>
    </section>

    <section id="categories-section">
        <h2>Våra mest populära kategorier</h2>
        <div class="boxes-div">
            <a href="products.php?category=skönlitteratur">Skönlitteratur</a>
            <a href="products.php?category=romantik">Romantik</a>
            <a href="products.php?category=deckare">Deckare </a>
        </div>
    </section>

    <section id="TOP10-section"->
        <h2>This month TOP 10</h2>
        <div class="top10-list">
            <?php 
            $num = 0;
            for($num = 0; $num <10; $num++) {?>
                <li class="top10-listitem">
                    <h3><?=$num+1?></h3>
                    <img src="../admin/products/<?= $books[$num]['img_url'] ?>">
                    <div>
                        <a href="product.php?id=<?= $books[$num]['id'] ?>">
                            <h4><?=$books[$num]['title'] ?></h4>
                        </a>
                        <p>Författare: <b><?= htmlentities($books[$num]['author']) ?></b></p>
                        <p><?= htmlentities($books[$num]['price']) ?> SEK</p>
                    </div>
                </li>
            <?php } ?>
        </div>
    </section>

    <section id="our-services-section">
        <img src="../img/OurServices.png" alt="">
    </section>

    <script src="js/slideshow.js"></script>
</main>

<?php include('../layout/footer.php')?>