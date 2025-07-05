# Otakeros

__Otakeros__ é um site e também comunidade online cuja mídia se baseia na transmissão de vídeo, tendo como foco principal os animes, animação japonesa ou, especificamente, à animação produzida no Japão.

## 🛠️ Tecnologias Utilizadas

* HTML
* TailwindCSS
* JS
* PHP
* MySQL

## 📥 Instalação

1. Clone este repositório:
   ```bash
   git clone https://github.com/Marlon-Brito/otakeros.git

2. Acesse a pasta do projeto:
   ```bash
   cd nome-projeto

3. Também será necessário baixar o __Laragon__, é um ambiente de desenvolvimento para Windows que facilita a configuração de servidores locais para desenvolvimento web (ou se possuir outro sistema operacional o **Xampp** pode ser uma boa pedida por ser multiplataforma).

   O usaremos devido ao _PHP_ (Hypertext Preprocessor - linguagem de programação cuja qual o projeto foi feito, de código aberto e utilizada para o desenvolvimento de sites e aplicações web) ser executado no servidor, que processa o código e gera a página web final que o usuário visualiza.
   Então sem servidor a linguagem não executará! Por isso se usará o **Laragon**, seu ambiente dev fornece a famosa tríade AMP de ferramentas para simular um servidor , são elas:
     * Apache - solução que transforma a máquina num servidor gerenciável e que consiga entregar arquivos.
     * MySQL - um SGBD (Sistema Gerenciador de Banco de Dados).
     * PHP - e um interpretador PHP.
  
   Baixar [Laragon](https://laragon.org/download/).
  
## 🚀 Como usar

   Após instalá-lo será criada uma pasta chamada "laragon" no devido lugar que escolher guardá-la, dentro desta terá outra pasta chamada "www", nesta última ficará seus projetos feitos em PHP (devendo-se lembrar sempre de salvá-los nela, senão não executarão).
   
   Então pode-se pegar o projeto e jogar na pasta "www" para ele poder rodar, uma vez feito isso abra o laragon e faça o seguinte:
1. Clique no botão "Iniciar Tudo"
2. Aguarde um momento e veja se tanto o Apache quanto o MySQL se mostraram como ativados (eles respectivamente usam geralmente as sequintes portas, 80 e 3306).
3. Então vai-se instalar o banco de dados do projeto:
   1. Entre no projeto e acesse sua pasta "model".
   2. Procure o arquivo **SQL** "otakeros-script-bd" e copie todo seu código (este é o script do banco de dados do projeto).
      **Dica:** dentro deste script que cria o banco, bem no final há um código que cria o usuário administrador (no caso eu "Marlon") e um usuário comum/espectador (no caso o "Asta"):
      ```
      INSERT INTO `usuario` VALUES (1,'Marlon',20,'m@m.com','admin','',1), (2,'Asta',15,'asta@asta.com','clover','Asta.jpeg',2);
      ```
      Se quiser pode mudar isso! De começo já altere o ADM com as suas informações e faça login com elas depois. O ADM é único e ao acessar o site com ele se vê todas as informações, seja de usuários cadastrados ou de animes e seus respectivos episódios. Já o espectador ou usuário comum apenas acessa o site para ver seu conteúdo.

      Exemplo de como pode alterar os dados:
       ```
      INSERT INTO `usuario` VALUES (1,'Nemo',20,'neminho@gmail.com','1234','',1), (2,'Sara',15,'sara@gmail.com','2468','Sara.jpeg',2);
      ```
      E só informando sobre os campos de dados acima:
      | Campos               | Dados                | Descrição            |
      | -------------------- | -------------------- | -------------------- |
      | 1 º                  | 1                    | ID ou identificador do usuário.               |
      | 2 º                  | 'Nemo'               | Nome do usuário.      |
      | 3 º                  | 'neminho@gmail.com'  | E-mail do usuário.    |
      | 4 º                  | '1234'               | Senha do usuário.     |
      | 5 º                  | ''                   | Imagem do usuário (sem imagem nesse caso, caso insira uma ela deve ter o mesmo nome do usuário seguido de sua extensão e deve estar na pasta avatar, é prara lá que todos uploads de imagens de usuários vão).              |
      | 6 º     | 1     | ID ou código identificador do tipo de usuário (só há dois tipos: o 1 que é o ADM e o 2 que é o espectador). |
      
      Assim como também pode inserir outros dados... Mas de começo deixei apenas um usuário administrador e um espectador, o resto fica a critério de vocês!
   3. Voltando para o laragon já inicializado, clique no botão "Terminal", ele levará para o console/linha de comando do MySQL.
   4. Digite o comando "mysql -u root -p" para acessar o SGBD, se pedir a senha aperte ENTER pois é padrão não ter uma, mas caso você já use o MySQL e possui uma criada terá que inserí-la.
   5. Feito isso dá para usar os comandos de banco de dados livremente neste momento, então aqui se vai colar todo aquele código copiado do arquivo aberto anteriormente e dar ENTER para criar o banco.
      **Dica:** Caso tenha familiaridade com o **MySQL Workbench** (uma ferramenta visual para modelagem de bancos de dados), há um arquivo chamado **otakeros.mwb** na pasta "model", cujo qual também contém uma versão do banco de dados "otakeros" mas que pode ser modelada de forma visual.
   6. E tendo o banco do projeto já instalado deve-se conectá-lo ao projeto em si, por isso na pasta "config" se abrirá o arquivo "banco_credenciais.php" e irá substituir as informações descritivas que estão nas constantes de definição "define" pelas do banco de dados, exemplo:

      Constantes de definição com informações descritivas em pares chave-valor.
      ```
      define('DB_HOST', 'host');
      define('DB_USER', 'usuario');
      define('DB_PASS', 'senha');
      define('DB_NAME', 'banco_de_dados');
      ```
      Trocando estas informações pelas reais do banco.
      ```
      define('DB_HOST', 'localhost');
      define('DB_USER', 'root');
      define('DB_PASS', '12345678');
      define('DB_NAME', 'otakeros');
      ```
      E só informando sobre os campos de dados acima:
      | Campos               | Dados                | Descrição            |
      | -------------------- | -------------------- | -------------------- |
      | 1 º                  | 'localhost'                   | Servidor (no caso é o local).               |
      | 2 º                  | 'root'               | Nome do usuário (por padrão é o root).      |
      | 3 º                  | '12345678'  | Senha do usuário.    |
      | 4 º                  | 'otakeros'  | Nome do banco de dados.    |
   
4. Agora vá no botão "Menu", clique na pasta "www" e selecione o projeto.
5. Então você pode acessar o projeto tanto como ADM com as informações de e-mail e senha feitas no script ou, como visto na interface do site, criar um registro e acessar como espectador.
6. E para finalizar, usei o framework **TailwindCSS** para estilizar o projeto, de código aberto e que permite criar designs personalizados diretamente no HTML através de classes utilitárias. Para usá-lo de forma simples, basta usar o Play CDN para experimentar o Tailwind diretamente no navegador, sem precisar de nenhuma etapa de compilação:
   1. Acesse a documentação do **TailwindCSS** [aqui](https://tailwindcss.com/docs/installation/play-cdn).
   2. Adicione a tag de script Play CDN ao final do <head> do seu arquivo HTML e comece a usar as classes utilitárias do Tailwind para estilizar seu conteúdo.
     
   Pronto! Agora tendo baixado os arquivos, configurado o ambiente e criado o banco de dados, o projeto estará rodando no servidor criado.

## 🖥️ Deploy

   [Clique aqui para ver a implementação do site.](https://otakeros.infinityfreeapp.com)
