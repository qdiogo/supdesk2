<section class="content">

           
        <div class="row">
         <?php for ($i=0 ; $i< count($tb_grupo) ; $i++){ ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $tb_grupo[$i]['nome'];  ?></h3>

              <p></p>
            </div>
            <div class="icon">
              <i class=""></i>
            </div>
            <a href="<?php echo base_url('painel/grupo/meus_grupos/informacao/') .$tb_grupo[$i]['id_grupo'] ?>" class="small-box-footer">
              Entrar <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <?php }  ?>
        
      </div>


               
</section>
</section>