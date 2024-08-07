window.confirma = function (status) {
    if (status == 1) {
        //alert("Usuário registrado com sucesso!!!");
        $.alert({
            title: 'Bem-vindo',
            content: 'Seu cadastro foi realizado com sucesso!!! <br> Click em Ok para voltar para página de Login ',
            buttons: {
                OK: function () {
                    window.location = "/droncall"
                }
            },
            animationBounce: 1.5,
        });

        return true;
    }
};

window.remover = function () {
    $.alert({
        title: 'Remover Usuário do Grupo',
        content: 'Tem certeza que gostaria de remover este usuário do Grupo???',
        buttons: {
            SIM: function () {
                document.getElementById("remover").submit();
            },

            NÃO: function () {

            }
        }
    })
};


