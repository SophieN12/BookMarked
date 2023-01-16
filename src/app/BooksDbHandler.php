<?php 

class BooksDbHandler {
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fetchAllBooks() {
        $sql = "SELECT * FROM books;";
        $stmt = $this->pdo->prepare($sql);
        $stmt ->execute();

        return $stmt->fetchAll();
    }

    public function fetchSpecificBook($bookId) {
        $sql = "
            SELECT * FROM books
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindParam(':id', $bookId);
        $stmt -> execute();

        return $stmt->fetch();
    }

    public function deleteBook($bookId) {
        $sql = "
            DELETE FROM books
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindParam(':id', $bookId);
        $stmt -> execute();
    }

    public function addBook($title, $author, $description, $price, $pages, $imgUrl, $category, $language, $published_date) {
        $sql = "
            INSERT INTO books (title, author, description, price, pages, img_url, category, language, published_date)
            VALUES (:title, :author, :description, :price, :pages, :img_url, :category, :language, :published_date)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':pages', $pages);
        $stmt->bindParam(':img_url', $imgUrl);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':published_date', $published_date);
        $stmt->execute();
    }

    public function updateBook($bookId, $title, $author, $description, $price, $pages, $imgUrl, $category, $language, $published_date) {
        $sql = "
                UPDATE books
                SET title = :title, 
                author = :author,
                description = :description, 
                price = :price, 
                pages = :pages, 
                img_url = :img_url,
                category = :category,
                language = :language,
                published_date = :published_date
                WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $bookId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':pages', $pages);
        $stmt->bindParam(':img_url', $imgUrl);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':published_date', $published_date);
        $stmt->execute();
    }

//     public function searchProduct() {
//         $searchResult = trim($_POST['search-result']);
//         $sql = "
//         SELECT * FROM products
//         WHERE title like :search;
//         ";
    
//         $stmt = $this->pdo->prepare($sql);
//         $stmt->bindValue(':search', $searchResult . '%');
//         $stmt->execute();
//         return $stmt->fetchAll();
//     }
}
?>

