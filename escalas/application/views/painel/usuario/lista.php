<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="tabela" class="table table-bordered  table-hover table-responsive text-center" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Conta</th>
                                <th>Status</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tb_user as $ln) {
    ?>
                            <tr>
                                <td>
                                    <?php echo $ln['nome'] ?>
                                </td>
                                <td>
                                    <?php echo $ln['email'] ?>
                                </td>
                                <td>
                                    <?php echo $ln['cpf'] ?>
                                </td>
                                <td>
                                <?php  if($ln['tipo'] == 0){ 
                                    echo "Admin";

                                 } else if ($ln['tipo'] == 1){
                                     echo "Usuário";

                                 } else {
                                    echo "Admin Grupo";

                                 }
                                 ?>
                                </td>
                                <td>
                                    <?php 
                                      if($ln['status'] == 0){
                                        echo "Criado";
                                      } else if ($ln['status'] == 1){
                                        echo "Ativo";
                                      } else {
                                        echo "Bloqueado";
                                      }
                                     ?>
                                </td>
                                <td><a href="
                                    <?php echo base_url('painel_controle/usuario/') .$ln['id']?>"><i class="fa fa-edit"></i>
                                </a>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</section>