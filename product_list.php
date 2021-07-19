<?php
require_once "../classes/pdo_connect6.php";

// 抓現有商品的數量
$sqlCount = "SELECT * FROM db_recipe.product";
$stmtCount = $db_host->query($sqlCount);
$count = $stmtCount->rowCount();
$_SESSION['count'] = $count;

//給p預設值
// if(isset($_GET["p"])){
//     $p=$_GET["p"];
// }else{
//     $p=1;
// }
// $per_page=10; //預設每筆頁數
// $start_item=($p-1)*$per_page;  //本頁開始記錄筆數
  
$sql="SELECT pd.*,img.image FROM product pd, image img WHERE pd.id=img.product_id AND valid = 1 
ORDER BY id ASC ";
$stmt=$db_host->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);

// $queryTotal="SELECT * FROM db_recipe.product WHERE valid=1";
// $stmtTotal = $db_host->query($queryTotal);
// $stmtTotal->execute(); 
// $total=$stmtTotal->rowCount(); //總共筆數
// $pages=ceil($total/$per_page); //總頁數
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Head metas, css, and title -->
  <?php require_once '../includes/head.php'; ?>
  <?php require_once '../css/product_css.php'; ?>
</head>

<body>
  <!-- Header banner -->
  <?php require_once '../includes/header.php'; ?>
  <!--contect-->
  <div class="container-fluid position-absolute px-0">
    <div class="row w-100 mx-0"  style="width: 100wh;">
      <!-- Sidebar menu -->
      <?php require_once '../includes/sidebar.php'; ?>

        <!-- </nav> -->
        <main class="col w-100 bg-light">
          <h1 class="h2" style="margin-top: 16px">666購物商城</h1>
          
            <!-- search-box -->
            <form action="product_list_search.php" method="GET">
                <div class="d-flex search-box mb-2">
                    <input class="form-control col-3 mr-2" name="searchInput" placeholder="請輸入商品名稱" >
                    <select class="form-control col-2 mr-2 " name="money">
                        <option class="btn">價錢範圍</option>
                        <option class="btn">0~500</option>
                        <option class="btn">501~1000</option>
                        <option class="btn">1001~</option>
                      </select>
                    <button type="submit" name="search" class="btn btn-info">查詢</button>
                </div>
            </form>

            <form action="productDelete.php" method="POST" class="mb-2">
                <div class="row d-flex justify-content-between align-items-center mb-2">
                  <div class="col-4">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><span data-feather="x-circle"></span> 刪除勾選</button>

                    <a href="product_add.php" type="button" class="btn btn-info" ><span data-feather="plus-circle"></span> 新增</a>
                  </div>
                    <div class="col-3 h4 m-0 text-right">
                      共有 <?=$stmt->rowCount();?> 項商品
                    </div>
                    
                </div>
                <!-- 刪除 Modal -->
                <?php require_once 'modal_delete.php'; ?>
            <?php
            if(isset($_GET['updated'])){
                echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                <strong>商品</strong>更新成功!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"> &times; </span>
                </button>
                </div>';
            }else if(isset($_GET['deleted'])){
                echo '<div class="alert alert-danger alert-dismissable fade show" role="alert">
                <strong>商品</strong>刪除成功!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"> &times; </span>
                </button>
            </div>';
            }else if(isset($_GET['inserted'])){
                echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                <strong>商品</strong>新增成功!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"> &times; </span>
                </button>
                </div>';
            }else if(isset($_GET['error'])){
                echo '<div class="alert alert-danger alert-dismissable fade show" role="alert">
                <strong>DB Error!</strong>部分出錯請再試一次!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"> &times; </span>
                </button>
                </div>';
            } ?>
            <table class="table table-striped table-sm" id="product">
              <thead>
                <tr>
                  <th>
                    <input type="checkbox" name="checkAll">
                  </th>
                  <th>商品<br>ID</th>
                  <th>商品<br>名稱</th>
                  <th>商品<br>圖片</th>
                  <th>商品<br>價錢</th>
                  <th>商品<br>類別</th>
                  <th>功能</th>
                </tr>
              </thead>
              
              <tbody>
              <?php foreach($stmt as $rows) { ?>
                <tr>
                  <td><input type="checkbox" name="check[]" value='<?=$rows["id"]?>'></td>
                  <td><?=$rows["id"]?></td>
                  <td><?=$rows["name"]?></td>
                  <td><img class="cover-fit" src="../images/products/<?=$rows["image"]?>" alt=""></td>
                  <td><?=$rows["price"]?></td>
                  <td id="category">
                    <?php 
                      $pp = $rows["category"];
                      switch($pp){
                        case "1":
                          echo "食材";
                          break;
                        case "2":
                          echo "鍋具";
                          break;
                        case "3":
                          echo "調味料";
                          break;
                      }
                    ?>
                  </td>
                  <td>
                    <!-- <div class="btn-group"> -->
                      <a href="product_view.php?id=<?=$rows['id']?>" class="btn btn-outline-info">查看</a>
                      <a href="product_update.php?id=<?=$rows['id']?>" class="btn btn-outline-info">編輯</a>
                      <a href="product_delete.php?id=<?=$rows['id']?>" class="btn btn-outline-danger">刪除</a>
                      <!-- <a id="<?=$rows['id']?>" class="btn btn-outline-danger text-danger delete" data-name="<?=$rows['name']?>">刪除</a> -->
                    <!-- </div> -->
                  </td>
                </tr>
                <?php }; ?>
              </tbody>
              </table>
            </form>         
            <!-- table結束 -->
            <!-- <div class="warning-msg fixed" id="warningMsg" data-name="<?=$rows['name']?>">
              <h3 class="text-center" id="warningTitle"></h3>
              <div class="warning-btn position-absolute">
                <a class="btn btn-danger mr-3" id="doDelete">確定刪除</a>
                <button class="btn btn-info" id="doNotDelete">不要</button>
              </div>
            </div> -->
      </main>
    </div>
  </div>
  <!-- Footer scripts, and functions -->
  <?php require_once '../includes/footer.php'; ?>
  <!-- Custom scripts -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> <!-- data tables -->
    <script>
      // $(".delete").click(function(){
      //   let id = $(this).attr("id");
      //   let name = $(this).data("name");
      //   // console.log(id,name);
      //   $("#warningMsg").addClass("active");
      //   $("#warningTitle").html(`確定要刪除 ${name} 嗎？`);
      //   $("#doNotDelete").on("click",function(){
      //   $("#warningMsg").removeClass("active");
      //   })
      //   $("#doDelete").on("click",function(){
      //     $(this).attr({
      //       href: `productDelete.php?id=${id}`
      //     })
      //   })
      // })     

      $(document).ready(function(){
        $("#product").DataTable({
          "info": false,
          // "paging": false,
          "searching": false,
          "columnDefs": [{
            "targets": [0,2,3,6],
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

      let all = $("#product > tbody input:checkbox").length; //共有10個checkbox
      //全選、全勾消
      $("input[name=checkAll]").change(function () {
        let checked = $(this).prop("checked");
        $("#product > tbody input:checkbox").prop("checked", checked);
      });
      // if () {
      //   let checked = $(this).prop("checked");
      //   $("input[name=checkAll]").prop("checked", checked);
      //   console.log("123");
      // } else {
      //   // $("input[name=checkAll]").attr("checked", unchecked);
      // }
    </script>
</body>

</html>