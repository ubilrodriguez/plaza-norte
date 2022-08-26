<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formUsuario" name="formUsuario" class="form-horizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
             
                <div class="form-group col-md-6">
                <label for="listCategoria">IDSubFamilia <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listIDSubFamilia2" name="listIDSubFamilia2" required=""></select>
             
              </div>
              </div>
             
              <div class="form-group">
                <label class="control-label">nombre</label>
                <textarea class="form-control" id="txtnombreG" name="txtnombreG" rows="2" placeholder="codigo" required=""></textarea>
              </div>
              <div class="form-group">
                <label class="control-label">descripcion</label>
                <input class="form-control" id="txtdescripcionGrupo" name="txtdescripcionGrupo" type="text" placeholder="Nombre del rol" required="">
              </div>

            

              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
              </div>
<!--              
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div> -->
            </form>
      </div>
    </div>
  </div>
</div>


