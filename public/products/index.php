<?php
require('../../src/config.php');

$pageTitle = "Homepage";

$books = $booksDbHandler -> fetchAllBooks();
?>

<?php include('../layout/header.php')?>

<main>
    <section id="carousel-container">
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
            <a href="products.php?category=barn & ungdom">Barn & Ungdom</a>
        </nav>
    </section>

    <section id="trending-books-section">
        <h2>Trendande böcker</h2>
        <ul id="products-display">
            <?php 
            for($num = 0; $num < 8; $num++) {?>
                <li class="book-card card">
                    <a href="product.php?id=<?= $books[$num]['id'] ?>">
                        <img src="../admin/products/<?= $books[$num]['img_url'] ?>">
                        <div class="card-info">
                            <h3><?= htmlentities($books[$num]['title']) ?></h3>
                            <p><?= htmlentities($books[$num]['author']) ?></p>
                        </div>
                        <b class="card-price-sm"><?= htmlentities($books[$num]['price'])?>:-</b>
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
            <a href="products.php?category=skönlitteratur">
                <p>Skönlitteratur</p>
            </a>
            <a href="products.php?category=romantik">
                <p>Romantik</p>
            </a>
            <a href="products.php?category=deckare">
                <p>Deckare</p>
            </a>
        </div>
    </section>

    <section id="TOP10-section"->
        <h2>Månadens topp 10</h2>
        <div class="top10-list">
            <?php 
            $num = 0;
            for($num = 0; $num <10; $num++) {?>
                <li class="top10-listitem">
                    <h3><?=$num+1?></h3>
                    <img src="../admin/products/<?= $books[$num]['img_url'] ?>">
                    <div>
                        <a href="product.php?id=<?= $books[$num]['id'] ?>">
                            <h5><?=$books[$num]['title'] ?></h5>
                        </a>
                        <p><?= htmlentities($books[$num]['author']) ?></p>
                        <p><?= htmlentities($books[$num]['price']) ?> SEK</p>
                    </div>
                </li>
            <?php } ?>
        </div>
    </section>

    <section id="our-services-section">
        <img src="../img/OurServices.png" alt="">
    </section>


    <script src="js/carousel.js"></script>
</main>

<?php include('../layout/footer.php')?>