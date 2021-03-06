Trello Control PHP Manual in pt_BR
==================================

Ferramenta para verificação dos cards e arquivos ainda não traduzidos na documentação do PHP em pt_BR!

Criando a aplicação
-------------------

A ferramenta usa o Composer para a criação do novo projeto:

.. code-block:: console

    $ composer create-project royopa/trello-control-doc-pt-br path/to/install dev-master

Composer irá criar o projeto no diretório `path/to/install`.

Criando a chave e o token no Trello
-----------------------------------
Para acessar a API do Trello é necessário criar uma chave e um token do Trello.
Acesse a página abaixo:

https://trello.com/c/jObnWvl1/25-generating-your-developer-key

Após a criação de sua chave e do token, altere o arquivo /src/controllers.php com 
as suas informações.

.. code-block:: console

    $client->authenticate(
        'trello_api_key', //api_key
        'trello_token_key', //token trello
        Client::AUTH_URL_CLIENT_ID
    );

Acessando a aplicação
---------------------

Para ver a página rodando, inicie o PHP built-in web server com o comando abaixo

.. code-block:: console

    $ cd path/to/install
    $ composer run

Então, acesse http://localhost:8888/
