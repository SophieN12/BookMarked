<?php 
    require("../../../src/config.php");
    $pageTitle = "Manage Products";

    if ($_SESSION['id'] == 1){
        $books = $booksDbHandler -> fetchAllBooks();
        
        if (isset($_POST['searchSubmitBtn'])  && trim($_POST['search-result'])) {
            $searchResult = trim($_POST['search-result']);

            if ($_POST['searchBy'] === 'title' || $_POST['searchBy'] === '') {
                $sql = "
                    SELECT * FROM books 
                    WHERE title like :search 
                ";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $searchResult .'%');
                $stmt->execute();
            }

            else if ($_POST['searchBy'] === 'author'){
                $sql = "
                    SELECT * FROM books 
                    WHERE author LIKE :search 
                ";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $searchResult .'%');
                $stmt->execute();
            }

            else if ($_POST['searchBy'] === 'id'){
                $sql = "
                    SELECT * FROM books 
                    WHERE id = :id
                ";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id',  $searchResult);
                $stmt->execute();
            }
            $books = $stmt->fetchAll();
        }

    } else {
        redirect("../../products/index.php");
    }

?>  

<?php include('../../layout/admin-header.php')?>

<main class= "manage-books-container">
    <h1>Manage products</h1>

    <div id="messages"></div>

    <a href="add-product.php" id="add-product-btn">Add new book +</a>

    <form id="search-form" class="d-flex" role="search" method="post" >
        <select class="form-select" name="searchBy">
            <option value="" selected hidden>Sök efter:</option>
            <option value="title">Titel</option>
            <option value="author">Författare</option>
            <option value="id">ID</option>
        </select>
        <input class="form-control me-2" id="search-bar" name="search-result" type="search" placeholder="Sök..." aria-label="Search">
        <input type="submit" class="btn" id="search-submit" name="searchSubmitBtn" value="Sök">
    </form>

    <table id="books-tbl">
        <thead>
            <tr>
                <th>ID</th>
                <th>IMG</th>
                <th>TITEL</th>
                <th>FÖRFATTARE</th>
                <th>PRIS</th>
                <th>KATEGORI</th>
                <th>SPRÅK</th>
                <th>PUBLISERINGSDATUM</th>
                <th>ACTIONS</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($books as $book) { ?>
                <tr>
                    <td><?= htmlentities($book['id']) ?></td>
                    <td><img src=<?=htmlentities($book['img_url'])?> style= "max-height: 120px" ></td>
                    <td><?= htmlentities($book['title']) ?></td>
                    <td><?= htmlentities($book['author']) ?></td>
                    <td><?= htmlentities($book['price']) ?> SEK</td>
                    <td><?= htmlentities($book['category']) ?></td>
                    <td><?= htmlentities($book['language']) ?></td>
                    <td><?= htmlentities($book['published_date']) ?></td>
                    <td>
                        <form action="update-product.php" method="POST">
                            <input type="hidden" name="bookId" value="<?=htmlentities($book['id']) ?>">
                            <input type="submit" name="updateBookBtn" value="Update">
                        </form>

                        <form class="delete-book-form" method="POST">
                            <input type="hidden" name="bookId" value="<?= htmlentities($book['id']) ?>">
                            <input type="submit" name="deleteBookBtn" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table> 
</main>

<script src="js/delete-product.js"></script>

</body>
</html>