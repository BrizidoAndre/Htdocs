
O arquivo de diagrama está na raiz do projeto e tem como nome diagram.png

O arquivo dump do banco de dados está na raiz do projeto e tem como nome script.sql


Existe uma rota para o gerenciamento dos status de portos. Segue as informações
url: http://localhost/134_modulo_rest/harbor
method: PUT
body:
{
         "id": <id-do-porto>,
         "status": <status-a-ser-inserido>
}

Segue os parâmetros para o cadastro de Ordens de Serviço. Segue as informações
url: http://localhost/134_modulo_rest/os
method: POST
body:
{
    "cnpj": <cpf_de_exemplo>,
    "id_porto": <id_do_porto>
}

Segue os parâmetros para a busca de Orderns de Serviço. Segue as informações
url: http://localhost/134_modulo_rest/os/<código da OS>
method: GET

Segue os parâmetros para o cadastro de Ordens de Serviço. Segue as informações
url: http://localhost/134_modulo_rest/os/<código da OS>
method: DELETE