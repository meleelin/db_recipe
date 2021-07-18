<!-- add Modal -->
<div class="row">
<div class="modal fade" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">新增食譜</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="privateAdd.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <p>(<span class="text-danger">*</span>)為必填資料</p>
          <!-- id -->
          <div class="form-group">
            <label for="id">id</label>
            <input class="form-control" type="text" name="id" id="id" readonly>
          </div>

          <!-- picture -->
          <div class="form-group">
            <label for="picture">圖片</label>
            <input class="form-control-file" type="file" name="picture" id="picture">
          </div>

          <!-- name -->
          <div class="form-group">
            <label for="name">名稱 <span class="text-danger">*</span></label>
            <input  class="form-control" type="text" name="name" id="name" placeholder="請輸入食譜名稱" required>
          </div>

          <!-- intro -->
          <div class="form-group">
            <label for="intro">介紹 <span class="text-danger">*</span></label>
            <input  class="form-control" type="text" name="intro" id="intro" placeholder="介紹你的食譜" required>
          </div>

          <!-- qty -->
          <div class="form-group">
            <label for="qty">份量 <span class="text-danger">*</span></label>
            <input  class="form-control" type="text" name="qty" id="qty" placeholder="1份" required>
          </div>

          <!-- ingred and unit -->
          <div class="form-row">
            <div class="col-5">
                <label for="prep">食材</label>
            </div>
            <div class="col-5">
                <label for="unit">單位</label>
            </div>
          </div>
          <div id="dynamic_field">                            
              <div class="form-row">
                  <div class="form-group col-5">
                      <input type="text" name="ingred[]" id="ingred" class="form-control" placeholder="白飯">
                  </div>
                  <div class="form-group col-5">
                      <input type="text"  name="unit[]" id="unit" class="form-control" placeholder="1碗">
                  </div>
                  <div class="form-group col">
                      <td><button type="button" name="add_f" id="add_f" class="btn btn-info w-100">新增</button></td>
                  </div>
              </div>
          </div>
          
           <!-- step -->
           <div class="form-group">
            <label for="step">步驟 <span class="text-danger">*</span></label>
            <textarea class="form-control" type="text" name="step" id="step" cols="30" rows="10" placeholder="1.將洋蔥切開" required></textarea>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info" name="btn_save" value="1">新增</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        </div>
      </form>
    </div>
  </div>
</div>  
</div>