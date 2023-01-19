<?php 
    require("../../../src/config.php");
    $pageTitle = "Manage Users";

    if ($_SESSION['id'] == 1){
        $users = $usersDbHandler -> fetchAllUsers();
        
        if (isset($_POST['searchUserBtn']) && trim($_POST['search-result']) != '') {
            $searchResult = trim($_POST['search-result']);

            if ($_POST['searchBy'] === 'name' || $_POST['searchBy'] === '') {
                $sql = "
                    SELECT * FROM users 
                    WHERE first_name like :search 
                    OR last_name LIKE :search 
                ";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $searchResult .'%');
                $stmt->execute();
            } 
            
            else if ($_POST['searchBy'] === 'id'){
                $sql = "
                    SELECT * FROM users 
                    WHERE id = :id
                ";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $searchResult);
                $stmt->execute();
            }

            else if ($_POST['searchBy'] === 'email'){
                $sql = "
                    SELECT * FROM users 
                    WHERE email = :email
                ";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':email', $searchResult);
                $stmt->execute();
            }

            else if ($_POST['searchBy'] === 'phone'){
                $sql = "
                    SELECT * FROM users 
                    WHERE phone = :phone
                ";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':phone', $searchResult);
                $stmt->execute();
            } 

            $users = $stmt->fetchAll();
        }

    } else {
        redirect("../../products/index.php");
    }
?> 

<?php include('../../layout/admin-header.php')?>

<main class= "manage-container">
    
    <a href="../../users/my-page.php" style="color:white; text-decoration:none">
        <button class="btn btn-secondary px-4 mt-3 mb-3"><i class="fa-solid fa-arrow-left">
            </i>&nbsp; Tillbaka till mina sidor 
        </button>
    </a>

    <h1>Manage users</h1>

    <div id="messages"></div>

    <a href="add-user.php" class="add-link">Add new user +</a>

    <form id="search-form" class="d-flex" role="search" method="post" >
        <select class="form-select w-25" name="searchBy">
            <option value="" selected hidden>Sök efter:</option>
            <option value="name">Name</option>
            <option value="id">ID</option>
            <option value="email">Email</option>
            <option value="phone">Phone</option>
        </select>

        <input class="form-control me-2" id="search-bar" name="search-result" type="search" placeholder="Search..." aria-label="Search">
        <input type="submit" class="btn btn-primary px-4" id="search-submit" name="searchUserBtn" value="Sök">
    </form>

    <table id="users-tbl">
        <thead>
            <tr>
                <th>ID</th>
                <th>Namn</th>
                <th>Email</th>
                <th>Mobil</th>
                <th>Adress</th>
                <th>Skapad:</th>
      
                <th>ACTIONS</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?= htmlentities($user['id']) ?></td>
                    <td><?= htmlentities($user['first_name']) . " " . htmlentities($user['last_name'])?></td>
                    <td><?= htmlentities($user['email']) ?></td>
                    <td><?= htmlentities($user['phone']) ?></td>
                    <td><?= htmlentities($user['street']) . " " . htmlentities($user['postal_code']) . " " . htmlentities($user['city'])?> </td>
                    <td><?= htmlentities($user['create_date']) ?></td>
                    <td>
                        <form action="update-user.php" method="POST">
                            <input type="hidden" name="userId" value="<?=htmlentities($user['id'])?>">
                            <input type="submit" name="updateUserBtn" value="Update">
                        </form>

                        <form class="delete-user-form" method="POST">
                            <input type="hidden" name="userId" value="<?= htmlentities($user['id'])?>">
                            <input type="submit" name="deleteUserBtn" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table> 
</main>

<script src="js/delete-user.js"></script>

</body>
</html>
