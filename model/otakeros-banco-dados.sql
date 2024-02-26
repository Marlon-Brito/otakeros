CREATE DATABASE  IF NOT EXISTS `otakeros` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `otakeros`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: otakeros
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anime`
--

DROP TABLE IF EXISTS `anime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anime` (
  `id_anime` int NOT NULL AUTO_INCREMENT,
  `nome_anime` varchar(50) NOT NULL,
  `descricao_anime` text NOT NULL,
  `imagem_anime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_anime`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anime`
--

LOCK TABLES `anime` WRITE;
/*!40000 ALTER TABLE `anime` DISABLE KEYS */;
INSERT INTO `anime` VALUES (1,'Bleach','O jovem Ichigo, depois de passar grande parte de sua vida vendo fantasmas, se torna um Shinigami, um ser sobrenatural capaz de controlar a morte. Devido a isso, ele dedica sua vida a proteger os inocentes e ajudar os espíritos torturados até que eles encontrem a paz.','Bleach.jpg'),(2,'Naruto Clássico','A série gira em torno das aventuras vividas por Naruto Uzumaki, um jovem órfão habitante da Aldeia da Folha que sonha em se tornar o quinto Hokage, o maior guerreiro e governante da vila. Ao se graduar como ninja, Naruto descobre que tem um demônio raposa selado dentro de si.','Naruto Clássico.jpg'),(3,'Naruto Shippuden','O enredo de Naruto Shippuden dá continuidade à história do ninja Naruto Uzumaki, iniciada no anime antecessor. Nesta nova fase, três anos se passaram desde que Sasuke Uchiha, o melhor amigo do protagonista, deixou Konoha e se tornou um ninja fugitivo com o objetivo de matar o irmão mais velho, Itachi.','Naruto Shippuden.jpg'),(4,'Fairy Tail','Lucy Heartfilia é uma jovem maga de 17 anos que deseja tornar-se uma maga evoluída. Para isso, ela terá que entrar em uma guilda de magos, para ganhar dinheiro para sobreviver e também para aprimorar suas habilidades. Assim sendo, ela chega até a cidade de Hargeon, onde encontra Natsu Dragneel e Happy.','Fairy Tail.jpeg'),(5,'One Piece','A trama segue Luffy, um jovem com o corpo elástico que sonha em criar sua própria tripulação e partir em uma aventura para se tornar o próximo Rei dos Piratas.','One Piece.jpg'),(6,'Black Clover','A história acompanha os dois garotos que competem entre si para se tornar o Rei Mago, o cavaleiro mágico mais forte do reino de Clover. Mesmo sem magia, Asta tenta ser um cavaleiro mágico, assim sua jornada começa quando obtém o misterioso poder &#34;antimagia&#34;, que pode anular qualquer magia na obra.','Black Clover.jpg'),(7,'Boku no Hero','Em um mundo onde quase toda a população possui algum poder sobre-humano, Izuku Midoriya é um dos poucos casos de pessoas comuns. Mas esse não é o maior de seus problemas. Exatamente por ser desprovido de qualquer poder, Izuku sofre constantemente nas mãos de seus colegas de classe.','Boku no Hero.jpg'),(8,'Jujutsu Kaisen','Em Jujutsu Kaisen, a vida de um adolescente é virada de cabeça para baixo após entrar em contato com um talismã amaldiçoado. No conceituado anime, o adolescente Yuuji Itadori participa de um clube de ocultismo e acaba se envolvendo com um item perigoso, um dedo amaldiçoado.','Jujutsu Kaisen.jpg'),(9,'Dragon Ball Super','Dragon Ball Super segue as aventuras do protagonista Goku e seus amigos, depois de derrotar Majin Boo e trazer paz para Terra mais uma vez. Goku encontra seres de longe mais poderosos e atinge o poder de um deus.','Dragon Ball Super.jpg'),(10,'Tokyo Ghoul','Em Tóquio, criaturas conhecidas como ghouls vivem entre os humanos e os devoram para sobreviver. Dentre eles, o jovem universitário Ken Kaneki leva uma vida pacata entre livros, até que um trágico encontro o coloca diante desses seres e o obriga a lutar por sua humanidade.','Tokyo Ghoul.jpg');
/*!40000 ALTER TABLE `anime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `episodio`
--

DROP TABLE IF EXISTS `episodio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `episodio` (
  `id_episodio` int NOT NULL AUTO_INCREMENT,
  `id_numero_episodio` int NOT NULL,
  `nome_episodio` varchar(100) NOT NULL,
  `video_url_episodio` text NOT NULL,
  `id_anime` int NOT NULL,
  PRIMARY KEY (`id_episodio`),
  KEY `fk_id_anime_idx` (`id_anime`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `episodio`
--

LOCK TABLES `episodio` WRITE;
/*!40000 ALTER TABLE `episodio` DISABLE KEYS */;
INSERT INTO `episodio` VALUES (1,1,'Bleach - Episódio 1','1-bleach-episodio-1.mp4',1),(2,2,'Bleach - Episódio 2','1-bleach-episodio-2.mp4',1),(3,1,'Dragon Ball Super - Episódio 1','9-dragonballsuper-episodio-1.mp4',9);
/*!40000 ALTER TABLE `episodio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_usuario` (
  `id_tipo` int NOT NULL,
  `nome_tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'administrador'),(2,'espectador');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Marlon',20,'blackreaper4399@gmail.com','m4399','Marlon.jpeg',1),(60,'Asta',15,'asta@asta.com','clover','Asta.jpeg',2),(61,'Itadori',16,'itadori@itadori.com','pancadaria','Itadori.jpg',2);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-26  8:29:26
