<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'privateCrud.php';

$objUser = new Collection();

if(isset($_GET["search"])){
    $searchInput = $_GET["searchInput"];
    $sql="SELECT * FROM private_recipe WHERE valid = '1' AND (name LIKE '%".$searchInput."%') ORDER BY id ASC";
}else{
    $sql="SELECT * FROM private_recipe WHERE valid = '1' ORDER BY id ASC";
}

    $stmt = $objUser->runQuery($sql);
    $stmt->execute();
    $total=$stmt->rowCount();

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Head metas, css, and title -->
    <?php require_once '../includes/head.php'; ?>
    <style>
        .form-control::placeholder{
            color: #dc143c;
        }
        .form-control{
            border: 1px solid #dc143c;
            box-shadow:0px 0px 2px 0px #dc143c;
            animation: shake .8s ease-in;
        }

        @keyframes shake{
            0%{
                transform: translate(0);
            }
            20%,
            40%,
            60%{
                transform: translate(.5em);
            }
            10%,
            30%,
            50%,
            80%{
                transform: translate(-.5em);
            }
            95%{
                transform: translate(.2em);
            }
            70%,
            90%,
            100%{
                transform: translate(0);
            }
        }
    </style>
  </head>
  <body>
    <!-- Header banner -->
    <?php require_once '../includes/header.php'; ?>
    <div class="container-fluid position-absolute px-0">
    <div class="row w-100 mx-0" style="width: 100wh;">
        <!-- Sidebar menu -->
        <?php require_once '../includes/sidebar.php'; ?>
        <main class="col w-100 bg-light">
          <h1 class="h2" style="margin-top: 16px">私藏食譜列表</h1>
          <!-- 新增 Modal -->
          <?php require_once 'private_modal_add.php'; ?>
          <?php require_once 'popUpCrud.php'; ?>

<!-- search-box -->
<form method="GET">
    <div class="d-flex search-box mb-2">
        <input class="form-control col-3 mr-2" name="searchInput" placeholder="請輸入食譜名稱" <?php if(isset($_GET['searchInput'])): ?> value="<?=$_GET['searchInput'] ?>"
<?php endif; ?>>
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
            <a class="btn btn-info" href="private_list.php">回上頁</a>
        </div>

        <div class="col-8 h4 m-0 text-right">
            針對 <?=$_GET['searchInput'] ?> 的查詢結果，共有 <?=$total?> 筆私藏食譜
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

</script>


    <!-- Footer scripts, and functions -->
    <?php require_once '../includes/footer.php'; ?>

    <!-- Custom scripts -->
    <script>
        // 食材與單位新增
        $(document).ready(function(){
            var i = 1;
            $('#add_f').click(function(){
                i++;
                $('#dynamic_field').append('<div class="form-row" id="row'+i+'"><div class="form-group col-5"><input type="text" name="prep[]" placeholder="白飯" id="prep" class="form-control"></div><div class="form-group col-5"><input type="text" name="unit[]" id="unit" class="form-control" placeholder="1碗"></div><div class="form-group col"><td><button type="button" name="remove_f" id="'+i+'" class="btn btn-danger btn_remove w-100">刪除</button></td></div></div>');
            });
            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr('id');
                $('#row' + button_id + '').remove();
            });
        });

        $(document).ready(function(){
            $("#myTable").DataTable({
                "info": false,
                // "paging": false,
                "searching": false,
                "columnDefs": [{
                    "targets": [0,2,3,8],
                    "orderable": false
                }],
                "language": { //搜尋文字更改
                    "paginate": 
                    {"next": "下一頁",
                    "previous": "前一頁"},
                    "lengthMenu": "此頁顯示 _MENU_ 筆資料",
                }
            });
        })

        // 單選跟全選
        let dataCount=$("tbody tr").length;
        $("tbody :checkbox").click(function(){
            let checkedCount=$("tbody :checked").length
            // console.log(checkedCount)
            if(checkedCount===dataCount){
                $("#selectAll").prop("checked",true)
            }else{
                $("#selectAll").prop("checked",false)
            }
            let checked=$(this).prop("checked")
        })
        $("#selectAll").click(function(){
            let checked=$(this).prop("checked")
            $("tbody :checkbox").prop("checked",checked)
        })
    </script>
  </body>
</html>
