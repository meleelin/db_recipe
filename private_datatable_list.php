<?php
    $objUser = new Collection();



    $query = "SELECT * FROM db_recipe.private_recipe WHERE valid = '1' ORDER BY id ASC";
    $stmt = $objUser->runQuery($query);
    $stmt->execute();

    $queryTotal="SELECT * FROM private_recipe WHERE valid=1";
    $stmtTotal = $objUser->runQuery($queryTotal);
    $stmtTotal->execute(); 

    $total=$stmtTotal->rowCount(); //總共筆數

?>

<!-- search-box -->
<form action="private_search.php" method="GET">
    <div class="d-flex search-box mb-2">
        <input class="form-control col-3 mr-2" name="searchInput" placeholder="請輸入食譜名稱" >
        <button type="submit" name="search" class="btn btn-info">查詢</button>
    </div>
</form>

<form id="form" method="post" action="privateDelete.php" class="mb-2">
    <div class="row d-flex justify-content-between align-items-center mb-2">
        <div class="col-4">
            <!-- 刪除 -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                <span data-feather="x-circle"></span> 刪除勾選
            </button>
            <!-- 新增 -->
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModal">
                <span data-feather="plus-circle"></span> 新增
            </button>
        </div>

        <div class="col-3 h4 m-0 text-right">
            共有 <?=$total?> 筆私藏食譜
        </div>
    </div>

    
    <!-- 刪除 Modal -->
    <?php require_once 'modal_delete.php'; ?>

    <table id="myTable" class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>id</th>
                <th>名稱</th>
                <th>份量</th>
                <th>按讚數</th>
                <th>瀏覽數</th>
                <th>建立日期</th>
                <th>會員</th>
                <th>功能</th>
            </tr>
        </thead>
        <tbody>
            <?php if($stmt->rowCount() > 0){
                while($rowRecipe = $stmt->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr>
                <td><input type="checkbox" name='check[]' value='<?= $rowRecipe['id'] ?>'></td>
                <td><?= $rowRecipe['id'] ?></td>
                <td><?= $rowRecipe['name'] ?></td>
                <td><?= $rowRecipe['qty'] ?></td>
                <td><?= $rowRecipe['like_qty'] ?></td>
                <td><?= $rowRecipe['view_qty'] ?></td>
                <td><?= $rowRecipe['create_date'] ?></td>
                <td>
                      <a class="btn btn-light border" href="private_member_view.php?id=<?= $rowRecipe['member_id'] ?>"><?= $rowRecipe['member_id'] ?></a>
                    </td>
                <td>
                    <a class="btn btn-outline-info" href="private_view.php?id=<?= $rowRecipe["id"] ?>" role="button">查看</a>
                    <a class="btn btn-outline-info" href="private_edit.php?id=<?= $rowRecipe["id"] ?>" role="button">編輯</a>
                    <a class="btn btn-outline-danger" href="private_delete.php?id=<?= $rowRecipe["id"] ?>" role="button" name="delete_btn">刪除</a>
                    <a class="btn btn-outline-info" href="private_comment.php?id=<?= $rowRecipe["id"] ?>" role="button">留言</a>
                </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
</form>
<script>
    function check(){
        if("#form.check[].value=''"){
        alert("GG");
        }
    }
    
</script>