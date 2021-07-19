<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'privateCrud.php';

$objUser = new Collection();


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Head metas, css, and title -->
    <?php require_once '../includes/head.php'; ?>
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
          <?php require_once 'private_datatable_list.php'; ?>


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
