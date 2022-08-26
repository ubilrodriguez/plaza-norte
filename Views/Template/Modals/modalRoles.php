<!-- Modal el id=modalFormRol llamar la funcion nuevo en js -->
<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal"></h5> DE SUB FAMILIA
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tile">
          <div class="tile-body">
            <form id="formRol" name="formRol">
              <input type="hidden" id="idRol" name="idRol" value="">
             
              <div class="form-group">
                <label for="listCategoria">ID Familia <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listIDSubFamilia" name="listIDSubFamilia" required=""></select>
              </div>
                <div class="form-group">
                <label class="control-label">nombre</label>
                <textarea class="form-control" id="txtnombre" name="txtnombre" rows="2" placeholder="codigo" required=""></textarea>
              </div>
              <div class="form-group">
                <label class="control-label">descripcion</label>
                <input class="form-control" id="txtdescripcion" name="txtdescripcion" type="text" placeholder="Nombre del rol" required="">
              </div>
          
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>