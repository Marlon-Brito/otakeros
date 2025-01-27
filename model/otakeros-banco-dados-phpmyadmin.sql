CREATE DATABASE  IF NOT EXISTS `if0_38182847_bd_otakeros`;
USE `if0_38182847_bd_otakeros`;

DROP TABLE IF EXISTS `anime`;

CREATE TABLE `anime` (
  `id_anime` int NOT NULL AUTO_INCREMENT,
  `nome_anime` varchar(50) NOT NULL,
  `descricao_anime` text NOT NULL,
  `imagem_anime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_anime`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

LOCK TABLES `anime` WRITE;

INSERT INTO `anime` VALUES (1,'Bleach','O jovem Ichigo, depois de passar grande parte de sua vida vendo fantasmas, se torna um Shinigami, um ser sobrenatural capaz de controlar a morte. Devido a isso, ele dedica sua vida a proteger os inocentes e ajudar os espíritos torturados até que eles encontrem a paz.','Bleach.jpg'),(2,'Naruto Clássico','A série gira em torno das aventuras vividas por Naruto Uzumaki, um jovem órfão habitante da Aldeia da Folha que sonha em se tornar o quinto Hokage, o maior guerreiro e governante da vila. Ao se graduar como ninja, Naruto descobre que tem um demônio raposa selado dentro de si.','Naruto Clássico.jpg'),(3,'Naruto Shippuden','O enredo de Naruto Shippuden dá continuidade à história do ninja Naruto Uzumaki, iniciada no anime antecessor. Nesta nova fase, três anos se passaram desde que Sasuke Uchiha, o melhor amigo do protagonista, deixou Konoha e se tornou um ninja fugitivo com o objetivo de matar o irmão mais velho, Itachi.','Naruto Shippuden.jpg'),(4,'Fairy Tail','Lucy Heartfilia é uma jovem maga de 17 anos que deseja tornar-se uma maga evoluída. Para isso, ela terá que entrar em uma guilda de magos, para ganhar dinheiro para sobreviver e também para aprimorar suas habilidades. Assim sendo, ela chega até a cidade de Hargeon, onde encontra Natsu Dragneel e Happy.','Fairy Tail.jpeg'),(5,'One Piece','A trama segue Luffy, um jovem com o corpo elástico que sonha em criar sua própria tripulação e partir em uma aventura para se tornar o próximo Rei dos Piratas.','One Piece.jpg'),(6,'Black Clover','A história acompanha os dois garotos que competem entre si para se tornar o Rei Mago, o cavaleiro mágico mais forte do reino de Clover. Mesmo sem magia, Asta tenta ser um cavaleiro mágico, assim sua jornada começa quando obtém o misterioso poder &#34;antimagia&#34;, que pode anular qualquer magia na obra.','Black Clover.jpg'),(7,'Boku no Hero','Em um mundo onde quase toda a população possui algum poder sobre-humano, Izuku Midoriya é um dos poucos casos de pessoas comuns. Mas esse não é o maior de seus problemas. Exatamente por ser desprovido de qualquer poder, Izuku sofre constantemente nas mãos de seus colegas de classe.','Boku no Hero.jpg'),(8,'Jujutsu Kaisen','Em Jujutsu Kaisen, a vida de um adolescente é virada de cabeça para baixo após entrar em contato com um talismã amaldiçoado. No conceituado anime, o adolescente Yuuji Itadori participa de um clube de ocultismo e acaba se envolvendo com um item perigoso, um dedo amaldiçoado.','Jujutsu Kaisen.jpg'),(9,'Dragon Ball Super','Dragon Ball Super segue as aventuras do protagonista Goku e seus amigos, depois de derrotar Majin Boo e trazer paz para Terra mais uma vez. Goku encontra seres de longe mais poderosos e atinge o poder de um deus.','Dragon Ball Super.jpg'),(10,'Tokyo Ghoul','Em Tóquio, criaturas conhecidas como ghouls vivem entre os humanos e os devoram para sobreviver. Dentre eles, o jovem universitário Ken Kaneki leva uma vida pacata entre livros, até que um trágico encontro o coloca diante desses seres e o obriga a lutar por sua humanidade.','Tokyo Ghoul.jpg');

UNLOCK TABLES;

DROP TABLE IF EXISTS `episodio`;

CREATE TABLE `episodio` (
  `id_episodio` int NOT NULL AUTO_INCREMENT,
  `id_numero_episodio` int NOT NULL,
  `nome_episodio` varchar(100) NOT NULL,
  `video_url_episodio` text NOT NULL,
  `id_anime` int NOT NULL,
  PRIMARY KEY (`id_episodio`),
  KEY `fk_id_anime_idx` (`id_anime`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

LOCK TABLES `episodio` WRITE;
INSERT INTO `episodio` VALUES (1,1,'Bleach - Episódio 1','1-bleach-episodio-1.mp4',1),(2,2,'Bleach - Episódio 2','1-bleach-episodio-2.mp4',1);
UNLOCK TABLES;

DROP TABLE IF EXISTS `tipo_usuario`;

CREATE TABLE `tipo_usuario` (
  `id_tipo` int NOT NULL,
  `nome_tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

LOCK TABLES `tipo_usuario` WRITE;

INSERT INTO `tipo_usuario` VALUES (1,'administrador'),(2,'espectador');
UNLOCK TABLES;

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `idade` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `id_tipo` int NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_id_tipo_idx` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb3;

LOCK TABLES `usuario` WRITE;
INSERT INTO `usuario` VALUES (1,'Marlon',20,'m@m.com','admin','',1), (2,'Asta',15,'asta@asta.com','clover','Asta.jpeg',2);
UNLOCK TABLES;