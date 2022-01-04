-- Chrome MySQL Admin version 4.10.0
--
-- Host: localhost
-- ------------------------------------------------------
-- Server version 5.5.5-10.4.17-MariaDB

--
-- Current Database: `musicaspes_pes`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `musicaspes_pes` /*!40100 DEFAULT CHARACTER SET utf8 */;

use `musicaspes_pes`;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL COMMENT 'Nome da categoria',
  `tipo` varchar(20) NOT NULL COMMENT 'Tipo de categoria',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Abertura','Missa'),(2,'Ato penitencial','Missa'),(3,'Glória','Missa'),(4,'Refrão orante','Missa'),(5,'Salmo','Missa'),(6,'Aclamação','Missa'),(7,'Ofertório','Missa'),(8,'Santo','Missa'),(9,'Cordeiro','Missa'),(10,'Comunhão','Missa'),(11,'Parabéns','Missa'),(12,'Canto final','Missa'),(13,'Louvor','Geral'),(14,'Espírito Santo','Geral'),(15,'Adoração','Geral'),(16,'Animação','Geral'),(17,'Maria','Geral'),(18,'Ladaínha','Geral'),(19,'Mensagem','Geral'),(20,'Pós-Comunhão','Missa'),(21,'Outros','Missa');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escala_repertorios`
--

DROP TABLE IF EXISTS `escala_repertorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escala_repertorios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idEscala` int(11) unsigned NOT NULL COMMENT 'Id da escala',
  `idRepertorio` int(11) NOT NULL COMMENT 'Id do repertório',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Data de criação do registro',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data de alteracção do registro',
  PRIMARY KEY (`id`),
  KEY `idEscala` (`idEscala`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escala_repertorios`
--

LOCK TABLES `escala_repertorios` WRITE;
/*!40000 ALTER TABLE `escala_repertorios` DISABLE KEYS */;
INSERT INTO `escala_repertorios` VALUES (1,1,1,'2021-10-12 02:08:34','2021-10-12 02:08:34'),(2,1,2,'2021-10-12 02:08:34','2021-10-12 02:08:34'),(3,1,3,'2021-10-12 02:08:34','2021-10-12 02:08:34'),(4,1,4,'2021-10-12 02:08:34','2021-10-12 02:08:34'),(5,1,5,'2021-10-12 02:08:34','2021-10-12 02:08:34'),(6,2,6,'2021-10-12 02:09:08','2021-10-12 02:09:08'),(7,2,7,'2021-10-12 02:09:08','2021-10-12 02:09:08'),(8,2,8,'2021-10-12 02:09:08','2021-10-12 02:09:08'),(9,2,9,'2021-10-12 02:09:08','2021-10-12 02:09:08'),(10,2,10,'2021-10-12 02:09:08','2021-10-12 02:09:08'),(11,2,11,'2021-10-12 02:09:08','2021-10-12 02:09:08'),(12,3,12,'2021-10-12 13:59:15','2021-10-12 13:59:15'),(13,3,13,'2021-10-12 13:59:15','2021-10-12 13:59:15'),(14,3,14,'2021-10-12 13:59:15','2021-10-12 13:59:15'),(15,3,15,'2021-10-12 13:59:15','2021-10-12 13:59:15'),(16,3,16,'2021-10-12 13:59:15','2021-10-12 13:59:15');
/*!40000 ALTER TABLE `escala_repertorios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escala_tipos`
--

DROP TABLE IF EXISTS `escala_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escala_tipos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(20) NOT NULL COMMENT 'Desctição do tipo de escala',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escala_tipos`
--

LOCK TABLES `escala_tipos` WRITE;
/*!40000 ALTER TABLE `escala_tipos` DISABLE KEYS */;
INSERT INTO `escala_tipos` VALUES (1,'Dia de semana'),(2,'Fim de semana');
/*!40000 ALTER TABLE `escala_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escalas`
--

DROP TABLE IF EXISTS `escalas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escalas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL COMMENT 'Descrição da escala',
  `tipo` varchar(11) NOT NULL COMMENT 'Id do Tipo de escala',
  `dataRef` date NOT NULL COMMENT 'Data de referência',
  `created_by` int(11) NOT NULL COMMENT 'ID do usuário que criou o registro',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Data de criação do registro',
  `updated_by` int(11) NOT NULL COMMENT 'ID do usuário que alterou o registro',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data de alteração do registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escalas`
--

LOCK TABLES `escalas` WRITE;
/*!40000 ALTER TABLE `escalas` DISABLE KEYS */;
INSERT INTO `escalas` VALUES (1,'Semana 35','1','2021-10-25',1,'2021-10-12 02:08:34',1,'2021-10-12 02:08:34'),(2,'Semana 35','2','2021-10-23',1,'2021-10-12 02:09:08',1,'2021-10-12 02:09:08'),(3,'Semana nova','1','2021-11-01',4,'2021-10-12 13:59:15',4,'2021-10-12 13:59:15');
/*!40000 ALTER TABLE `escalas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu` varchar(40) NOT NULL COMMENT 'Referencia para a identificação do Menu',
  `descricao` varchar(40) NOT NULL COMMENT 'Descrição do menu',
  `comentario` varchar(1000) NOT NULL COMMENT 'Comentário com informações detalhadas do menu',
  `sequencia` int(11) NOT NULL COMMENT 'Sequencia de exibição',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'repertorios','Repertórios','Lista dos repertórios avulsos do seu ministério de música, também são listados as escalas de missas liberadas pela equipe de coordenação de ministérios de música da PES, como também todo o histórico de eventos',2),(2,'templates','Templates de escalas','Criação de templates para escalas das Missas.\nÉ possivel criar templates para as missas de "Dia de semana" e "Fim de semana", além de atribuir cada missa em horários diferentes.',7),(3,'escalas','Escalas','Permite criar as escalas para as missas da paróquia tanto para dias de semana como fim de semana. Cada escala deverá ser atribuído a um ministério de música, onde um repertório (sem músicas) será criado automaricamente com o status pendente para o ministério de música defina as músicas do repertório',1),(4,'aprovacao','Aprovações','Lista de repertórios com status pendente para que seja revisado as músicas definidas pelos ministérios de música. Quando o repertório for aprovado estará disponivel para a PASCOM montar as playlists.',4),(5,'editor','Editor','Editor para que seja possível formatar as letras das músicas na fonte padrão do Painel de LED',5),(6,'musicas','Músicas','Cadastro das músicas no banco de dados. É possível inserir as músicas manualmente com também importar da biblioteca do "Vagalume" através de pesquisas na tela',3),(7,'ministerios','Ministérios','Cadastro dos ministérios de música, juntamente com o coordenador do ministério e co-responsável, que serão as pessoas do ministério autorizadas a atribuir as músicas das missas ou criar repertórios avulsos',0),(8,'acessos','Gestão de acessos','Painel de controle dos acessos do sistema.',8),(9,'pascom','PASCOM','Repertórios aprovados e disponíveis para a PASCOM registrar o painel de LED e GC',6);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ministerios`
--

DROP TABLE IF EXISTS `ministerios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ministerios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL COMMENT 'Nome do ministério',
  `coordenador` varchar(255) NOT NULL COMMENT 'ID do responsável pelo ministério',
  `corresponsavel` varchar(255) DEFAULT NULL COMMENT 'ID do Co-responsável pelo ministério',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Data de criação do registro',
  `created_by` int(11) NOT NULL COMMENT 'ID do usuário que criou o registro',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data de alteração do registro',
  `updated_by` int(11) NOT NULL COMMENT 'ID do usuario que alterou o registro',
  `ativo` tinyint(1) DEFAULT 1 COMMENT 'indicador para bloquear um Ministério inativo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ministerios`
--

LOCK TABLES `ministerios` WRITE;
/*!40000 ALTER TABLE `ministerios` DISABLE KEYS */;
INSERT INTO `ministerios` VALUES (1,'Âncora Divina','1','2','2021-10-12 02:02:00',1,'2021-10-12 02:02:00',1,1),(2,'Ministério 01','2',NULL,'2021-10-12 02:05:49',1,'2021-10-12 02:05:49',1,1),(3,'Ministério 02','3',NULL,'2021-10-12 02:05:59',1,'2021-10-12 02:05:59',1,1),(4,'Ministério 03','4',NULL,'2021-10-12 02:06:18',1,'2021-10-12 02:06:18',1,1),(5,'Ministério 04','5',NULL,'2021-10-12 02:06:26',1,'2021-10-12 02:06:26',1,1),(6,'Ministério 05','6',NULL,'2021-10-12 02:06:42',1,'2021-10-12 02:06:42',1,1),(7,'Ministério 06','1',NULL,'2021-10-12 02:07:06',1,'2021-10-12 02:07:06',1,1),(8,'Ministério novo','3','5','2021-10-12 13:52:33',1,'2021-10-12 13:52:33',1,1);
/*!40000 ALTER TABLE `ministerios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `musica_categorias`
--

DROP TABLE IF EXISTS `musica_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `musica_categorias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idMusica` int(11) NOT NULL COMMENT 'Id da música',
  `idCategoria` int(11) NOT NULL COMMENT 'Id da categoria da música',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Data de criação do registro',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Data de alteração do registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `musica_categorias`
--

LOCK TABLES `musica_categorias` WRITE;
/*!40000 ALTER TABLE `musica_categorias` DISABLE KEYS */;
INSERT INTO `musica_categorias` VALUES (1,1,16,'2021-03-10 22:25:01','2021-03-10 22:25:01'),(2,1,12,'2021-03-10 22:25:01','2021-03-10 22:25:01'),(3,2,19,'2021-03-11 01:56:58','2021-03-11 01:56:58'),(4,2,12,'2021-03-11 01:56:58','2021-03-11 01:56:58'),(5,3,17,'2021-03-19 05:36:49','2021-03-19 05:36:49'),(6,3,19,'2021-03-19 05:36:49','2021-03-19 05:36:49'),(7,4,13,'2021-03-19 05:45:48','2021-03-19 05:45:48'),(8,4,19,'2021-03-19 05:45:48','2021-03-19 05:45:48'),(9,5,13,'2021-03-20 00:35:59','2021-03-20 00:35:59'),(10,5,20,'2021-03-20 00:35:59','2021-03-20 00:35:59'),(11,6,14,'2021-03-20 01:23:43','2021-03-20 01:23:43'),(12,6,19,'2021-03-20 01:23:43','2021-03-20 01:23:43'),(13,7,13,'2021-03-20 06:53:29','2021-03-20 06:53:29'),(14,7,20,'2021-03-20 06:53:29','2021-03-20 06:53:29'),(16,9,17,'2021-03-28 18:13:28','2021-03-28 18:13:28'),(17,9,19,'2021-03-28 18:13:28','2021-03-28 18:13:28'),(18,10,1,'2021-04-01 01:06:52','2021-04-01 01:06:52'),(19,11,2,'2021-04-01 01:09:22','2021-04-01 01:09:22'),(20,12,21,'2021-04-01 01:11:16','2021-04-01 01:11:16'),(21,13,3,'2021-04-01 01:21:14','2021-04-01 01:21:14'),(22,14,21,'2021-04-01 01:24:08','2021-04-01 01:24:08'),(23,15,6,'2021-04-01 01:28:24','2021-04-01 01:28:24'),(24,16,7,'2021-04-01 01:31:12','2021-04-01 01:31:12'),(25,17,7,'2021-04-01 01:32:24','2021-04-01 01:32:24'),(26,18,8,'2021-04-01 01:34:45','2021-04-01 01:34:45'),(27,19,9,'2021-04-01 01:37:10','2021-04-01 01:37:10'),(28,20,10,'2021-04-01 01:38:04','2021-04-01 01:38:04'),(29,21,11,'2021-04-01 01:38:37','2021-04-01 01:38:37'),(30,22,12,'2021-04-01 01:39:38','2021-04-01 01:39:38'),(31,23,13,'2021-04-01 03:16:42','2021-04-01 03:16:42'),(32,23,19,'2021-04-01 03:16:42','2021-04-01 03:16:42'),(33,24,13,'2021-04-01 03:16:43','2021-04-01 03:16:43'),(34,24,19,'2021-04-01 03:16:43','2021-04-01 03:16:43'),(35,25,16,'2021-04-01 03:18:04','2021-04-01 03:18:04'),(36,26,17,'2021-10-12 14:12:19','2021-10-12 14:12:19'),(37,26,19,'2021-10-12 14:12:19','2021-10-12 14:12:19');
/*!40000 ALTER TABLE `musica_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `musicas`
--

DROP TABLE IF EXISTS `musicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `musicas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL COMMENT 'Nome da música',
  `autor` varchar(100) NOT NULL COMMENT 'Autor/Interprete da música',
  `letra` blob NOT NULL COMMENT 'Letra da música',
  `slides` blob DEFAULT NULL COMMENT 'Dados dos Slides para o datashow',
  `usuCriacao` int(11) NOT NULL COMMENT 'ID do usuário que criou o registro',
  `usuAlteracao` int(11) NOT NULL COMMENT 'ID do usuario que alterou o registro',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `musicas`
--

LOCK TABLES `musicas` WRITE;
/*!40000 ALTER TABLE `musicas` DISABLE KEYS */;
INSERT INTO `musicas` VALUES (1,'A alegria do senhor é nossa força','Vida Reluz','A ALEGRIA DO SENHOR \nÉ NOSSA FORÇA (3X)\nNOSSA FORÇA, NOSSA FORÇA\nNOSSA FORÇA É O SENHOR JESUS\n\nELE É A NOSSA RAZÃO \nDE LUTARMOS ATÉ O FINAL\nSIM ELE É A LUZ CHEGOU\nE AS TREVAS NÃO \nPUDERAM RESISTIR\nELE É SOL\nNOSSA CANÇÃO RELUZIRÁ\nRESPLANDECERÁ','<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">A ALEGRIA DO SENHOR </span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">&Eacute; NOSSA FOR&Ccedil;A (3X)</span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u style="text-underline: single;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">NOSSA FOR&Ccedil;A, NOSSA FOR&Ccedil;A</span></u></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u style="text-underline: single;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">NOSSA FOR&Ccedil;A &Eacute; O SENHOR JESUS</span></u></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;">&nbsp;</p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">ELE &Eacute; A NOSSA RAZ&Atilde;O </span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">DE LUTARMOS AT&Eacute; O FINAL</span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">SIM ELE &Eacute; A LUZ CHEGOU</span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">E AS TREVAS N&Atilde;O </span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">PUDERAM RESISTIR</span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">ELE &Eacute; SOL</span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">NOSSA CAN&Ccedil;&Atilde;O RELUZIR&Aacute;</span></p>\n<p style="language: pt-BR; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">RESPLANDECER&Aacute;</span></p>',1,1,'2021-03-10 22:25:01','2021-03-10 22:25:01'),(2,'A Bíblia é a Palavra de Deus','Desconhecido','A BÍBLIA É A PALAVRA DE DEUS,\nSEMEADA NO MEIO DO POVO,\nQUE CRESCEU, CRESCEU \nE NOS TRANSFORMOU \nENSINANDO-NOS VIVER UM MUNDO NOVO.\n\nDEUS É BOM, NOS ENSINA A VIVER, \nNOS REVELA O CAMINHO A SEGUIR: \nSÓ NO AMOR PARTILHANDO SEUS DONS, \nSUA PRESENÇA IREMOS SENTIR.\n\n\nA BÍBLIA É A PALAVRA DE DEUS,\nSEMEADA NO MEIO DO POVO,\nQUE CRESCEU, CRESCEU \nE NOS TRANSFORMOU \nENSINANDO-NOS VIVER UM MUNDO NOVO.\n\nSOMOS POVO, O POVO DE DEUS, \nE FORMAMOS O REINO DE IRMÃOS \nE A PALAVRA QUE É VIVA NOS GUIA \nE ALIMENTA A NOSSA UNIÃO.','<p style="line-height: 1.4;">&nbsp;</p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u style="text-underline: single;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">A B&Iacute;BLIA &Eacute; A PALAVRA DE DEUS,</span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u style="text-underline: single;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">SEMEADA NO MEIO DO POVO,</span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u style="text-underline: single;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">QUE CRESCEU, CRESCEU </span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u style="text-underline: single;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">E NOS TRANSFORMOU </span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u style="text-underline: single;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">ENSINANDO-NOS VIVER UM MUNDO NOVO.</span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;">&nbsp;</p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">DEUS &Eacute; BOM, NOS ENSINA A VIVER, </span></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">NOS REVELA O CAMINHO A SEGUIR: </span></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">S&Oacute; NO AMOR PARTILHANDO SEUS DONS, </span></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; text-align: left; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">SUA PRESEN&Ccedil;A IREMOS SENTIR.</span></p>\n<p style="line-height: 1.4;"><!-- pagebreak --></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">A B&Iacute;BLIA &Eacute; A PALAVRA DE DEUS,</span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">SEMEADA NO MEIO DO POVO,</span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">QUE CRESCEU, CRESCEU </span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">E NOS TRANSFORMOU </span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><u><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: yellow; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-color: yellow; mso-style-textfill-fill-alpha: 100.0%;">ENSINANDO-NOS VIVER UM MUNDO NOVO.</span></u></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;">&nbsp;</p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">SOMOS POVO, O POVO DE DEUS, </span></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">E FORMAMOS O REINO DE IRM&Atilde;OS </span></p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">E A PALAVRA QUE &Eacute; VIVA NOS GUIA </span></p>\n<p style="line-height: 1.4;">&nbsp;</p>\n<p style="line-height: 1.4; margin-top: 0pt; margin-bottom: 0pt; direction: ltr; unicode-bidi: embed; vertical-align: baseline;"><span style="font-size: 32.0pt; font-family: Arial; mso-ascii-font-family: Arial; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: +mn-cs; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: white; mso-color-index: 0; mso-font-kerning: 12.0pt; language: pt-BR; font-weight: bold; mso-style-textfill-type: solid; mso-style-textfill-fill-themecolor: background1; mso-style-textfill-fill-color: white; mso-style-textfill-fill-alpha: 100.0%;">E ALIMENTA A NOSSA UNI&Atilde;O.</span></p>\n<p style="line-height: 1.4;">&nbsp;</p>',1,1,'2021-03-11 01:56:58','2021-03-11 02:46:05'),(3,'Perfeito É Quem Te Criou','Vida Reluz','Se um dia um anjo declarou\nQue tu eras cheia de Deus\nAgora penso: Quem sou eu\nPara não te dizer também\nCheia de graça, ó Mãe? (bis)\nAgraciada\n\nSe a palavra ensinou\nQue todos hão de concordar\nE as gerações te proclamar\nAgora eu também direi\nTu és bendita, ó Mãe (bis)\nBem-aventurada\n\nSurgiu um grande sinal no céu\nUma mulher revestida de sol\nA lua debaixo de seus pés\nE na cabeça uma coroa\n\nNão há com que se comparar\nPerfeito é quem te criou\nSe o Criador te coroou\nTe coroamos, ó Mãe (3x)\nNossa Rainha','<p>Se um dia um anjo declarou<br />Que tu eras cheia de Deus<br />Agora penso: Quem sou eu<br />Para n&atilde;o te dizer tamb&eacute;m<br />Cheia de gra&ccedil;a, &oacute; M&atilde;e? (bis)<br />Agraciada<br /><br />Se a palavra ensinou<br />Que todos h&atilde;o de concordar<br />E as gera&ccedil;&otilde;es te proclamar<br />Agora eu tamb&eacute;m direi<br />Tu &eacute;s bendita, &oacute; M&atilde;e (bis)<br />Bem-aventurada<br /><br />Surgiu um grande sinal no c&eacute;u<br />Uma mulher revestida de sol<br />A lua debaixo de seus p&eacute;s<br />E na cabe&ccedil;a uma coroa<br /><br />N&atilde;o h&aacute; com que se comparar<br />Perfeito &eacute; quem te criou<br />Se o Criador te coroou<br />Te coroamos, &oacute; M&atilde;e (3x)<br />Nossa Rainha</p>',1,1,'2021-03-19 05:36:49','2021-03-19 05:36:49'),(4,'Posso, Tudo Posso','Celina Borges','Posso, tudo posso Naquele que me fortalece\nNada e ninguém no mundo vai me fazer desistir\n\nQuero, tudo quero, sem medo entregar meus projetos\nDeixar-me guiar nos caminhos que Deus desejou pra mim\nE ali estar\n\nVou perseguir tudo aquilo que Deus já escolheu pra mim\nVou persistir, e mesmo nas marcas daquela dor\nDo que ficou, vou me lembrar\n\nE realizar o sonho mais lindo que Deus sonhou\nEm meu lugar estar na espera de um novo que vai chegar\nVou persistir, continuar a esperar e crer \nE mesmo quando a visão se turva e o coração só chora\nMas na alma, há certeza da vitória\n\nPosso, tudo posso Naquele que me fortalece\nNada e ninguém no mundo vai me fazer desistir\n\nVou perseguir tudo aquilo que Deus já escolheu pra mim\nVou persistir, e mesmo nas marcas daquela dor\nDo que ficou, vou me lembrar\n\nE realizar o sonho mais lindo que Deus sonhou\nEm meu lugar estar na espera de um novo que vai chegar\n\nVou persistir, continuar a esperar e crer\nEu vou sofrendo, mas seguindo enquanto tantos não entendem\nVou cantando minha história, profetizando\nQue eu posso, tudo posso... em Jesus!','<p>Posso, tudo posso Naquele que me fortalece<br />Nada e ningu&eacute;m no mundo vai me fazer desistir<br /><br />Quero, tudo quero, sem medo entregar meus projetos<br />Deixar-me guiar nos caminhos que Deus desejou pra mim<br />E ali estar<br /><br />Vou perseguir tudo aquilo que Deus j&aacute; escolheu pra mim<br />Vou persistir, e mesmo nas marcas daquela dor<br />Do que ficou, vou me lembrar<br /><br />E realizar o sonho mais lindo que Deus sonhou<br />Em meu lugar estar na espera de um novo que vai chegar<br />Vou persistir, continuar a esperar e crer <br />E mesmo quando a vis&atilde;o se turva e o cora&ccedil;&atilde;o s&oacute; chora<br />Mas na alma, h&aacute; certeza da vit&oacute;ria<br /><br />Posso, tudo posso Naquele que me fortalece<br />Nada e ningu&eacute;m no mundo vai me fazer desistir<br /><br />Vou perseguir tudo aquilo que Deus j&aacute; escolheu pra mim<br />Vou persistir, e mesmo nas marcas daquela dor<br />Do que ficou, vou me lembrar<br /><br />E realizar o sonho mais lindo que Deus sonhou<br />Em meu lugar estar na espera de um novo que vai chegar<br /><br />Vou persistir, continuar a esperar e crer<br />Eu vou sofrendo, mas seguindo enquanto tantos n&atilde;o entendem<br />Vou cantando minha hist&oacute;ria, profetizando<br />Que eu posso, tudo posso... em Jesus!</p>',1,1,'2021-03-19 05:45:48','2021-03-19 05:45:48'),(5,'Yeshua','Comunidade Católica Colo de Deus','Te chamam de Deus e de Senhor\nTe chamam de Rei e Salvador\nE eu me atrevo a te chamar \nDe meu Amor\nTe chamam de Deus e de Senhor\nTe chamam de Rei e Salvador\nE eu me atrevo a te chamar \nDe meu Amor\n\nYeshua, Yeshua\nTu és tão lindo\nQue eu nem sei\nMe expressar\nYeshua\nTu és tão lindo\n\nTe chamam de Deus e de Senhor\nTe chamam de Rei e Salvador\nE eu me atrevo a te chamar \nDe meu Amor\nTe chamam de Deus e de Senhor\nTe chamam de Rei e Salvador\nE eu me atrevo a te chamar \nDe meu Amor\n\nYeshua, Yeshua\nTu és tão lindo\nQue eu nem sei\nMe expressar\nYeshua\nTu és tão lindo','<p>Te chamam de Deus e de Senhor<br />Te chamam de Rei e Salvador<br />E eu me atrevo a te chamar <br />De meu Amor<br />Te chamam de Deus e de Senhor<br />Te chamam de Rei e Salvador<br />E eu me atrevo a te chamar <br />De meu Amor<br /><br />Yeshua, Yeshua<br />Tu &eacute;s t&atilde;o lindo<br />Que eu nem sei<br />Me expressar<br />Yeshua<br />Tu &eacute;s t&atilde;o lindo<br /><br />Te chamam de Deus e de Senhor<br />Te chamam de Rei e Salvador<br />E eu me atrevo a te chamar <br />De meu Amor<br />Te chamam de Deus e de Senhor<br />Te chamam de Rei e Salvador<br />E eu me atrevo a te chamar <br />De meu Amor<br /><br />Yeshua, Yeshua<br />Tu &eacute;s t&atilde;o lindo<br />Que eu nem sei<br />Me expressar<br />Yeshua<br />Tu &eacute;s t&atilde;o lindo</p>',1,1,'2021-03-20 00:35:59','2021-03-20 00:35:59'),(6,'O Céu Se Abre','Ministério Adoração e Vida','Hoje o céu, \nSe abre pra derramar\nSobre os corações toda a graça do Pai\nEu também quero me derramar\nDe todo o meu coração nos Braços do Pai\n\nVem Espírito Santo\nCom teu poder, tocar meu ser \nFluir em mim\n\nVem Espírito Santo\nCom teu poder tocar meu ser \nFluir em mim\n\nHoje eu posso ser,\nUm novo Homem pelo teu poder, renascer...\n\nVem Espírito Santo\nCom teu poder tocar meu ser \nFluir em mim (2x)','<p>Hoje o c&eacute;u,&nbsp;<br />Se abre pra derramar<br />Sobre os cora&ccedil;&otilde;es toda a gra&ccedil;a do Pai<br />Eu tamb&eacute;m quero me derramar<br />De todo o meu cora&ccedil;&atilde;o nos Bra&ccedil;os do Pai</p>\n<p>Vem Esp&iacute;rito Santo<br />Com teu poder, tocar meu ser&nbsp;<br />Fluir em mim (2x)</p>\n<p><strong>Hoje eu posso ser,</strong><br /><strong>Um novo Homem pelo teu poder, renascer...</strong></p>\n<p>Vem Esp&iacute;rito Santo<br />Com teu poder tocar meu ser&nbsp;<br />Fluir em mim (2x)</p>',1,1,'2021-03-20 01:23:43','2021-03-20 01:23:43'),(7,'Minha Essência','Thiago Brado','Vim até aqui\nDerramar o meu passado em Ti\nVim banhar os pés que andaram por aí\nSem carinho receber\n\nHoje estou aqui\nNão porque mereço, eu sei\nPois Tu sabes por onde eu andei\nConheces bem o meu perfume\n\nMas Tu sabes também\nQue o meu choro é sincero porém\nNão tenho nada a oferecer, meu Senhor\nMas Te dou a minha vida\n\nÉ tudo que tenho\nRecebe o meu nada\nRefaz a morada\nHabita em mim\n\nMe pega em Teu colo\nMe acalma em Teu peito\nSou Teu, sou eleito\nE a minha essência é exalar Teu cheiro','<p>Vim at&eacute; aqui<br />Derramar o meu passado em Ti<br />Vim banhar os p&eacute;s que andaram por a&iacute;<br />Sem carinho receber<br /><br />Hoje estou aqui<br />N&atilde;o porque mere&ccedil;o, eu sei<br />Pois Tu sabes por onde eu andei<br />Conheces bem o meu perfume<br /><br />Mas Tu sabes tamb&eacute;m<br />Que o meu choro &eacute; sincero por&eacute;m<br />N&atilde;o tenho nada a oferecer, meu Senhor<br />Mas Te dou a minha vida<br /><br />&Eacute; tudo que tenho<br />Recebe o meu nada<br />Refaz a morada<br />Habita em mim<br /><br />Me pega em Teu colo<br />Me acalma em Teu peito<br />Sou Teu, sou eleito<br />E a minha ess&ecirc;ncia &eacute; exalar Teu cheiro</p>',1,1,'2021-03-20 06:53:29','2021-03-20 06:53:29'),(9,'Sublime Amor','Flavinho','Por entre flores, surge uma luz\nque ilumina o meu caminho.\nPor entre flores, renasce a vida\nsufocada por espinhos\n\nRefrão:\nEm meio a dores ela vem nos trazer,\nalegria e esperança e sob o teu\nmanto nos acolher como mãe\nque afaga o filho nos braços, com o\nmais sublime amor.\nMaria, Maria mãe do meu Senhor.\n\nDestrói rancores semeia a unição, o\namor e a paz por entre os homens,\ndos pecadores, intercessora junto a\nCristo Gloriosa.\n\nRefrão.','<p>Por entre flores, surge uma luz<br />que ilumina o meu caminho.<br />Por entre flores, renasce a vida<br />sufocada por espinhos<br /><br />Refr&atilde;o:<br />Em meio a dores ela vem nos trazer,<br />alegria e esperan&ccedil;a e sob o teu<br />manto nos acolher como m&atilde;e<br />que afaga o filho nos bra&ccedil;os, com o<br />mais sublime amor.<br />Maria, Maria m&atilde;e do meu Senhor.<br /><br />Destr&oacute;i rancores semeia a uni&ccedil;&atilde;o, o<br />amor e a paz por entre os homens,<br />dos pecadores, intercessora junto a<br />Cristo Gloriosa.<br /><br />Refr&atilde;o.</p>',1,1,'2021-03-28 18:13:28','2021-03-28 18:13:28'),(10,'Imensa Alegria','Comunidade Católica Shalom','Alegria reluz nos teus olhos\nTodo amor que sonhamos um dia\nDissipando as trevas do medo que havia em nós\nO teu sopro invadindo no peito\nRecriando em nós toda vida\n\nDe tuas mãos e de teu lado aberto a paz vem enfim\nVivo estás hoje aqui\nReunindo os corações em ti\nImensa alegria e felicidade\nTua glória entre nós','<p>Alegria reluz nos teus olhos<br />Todo amor que sonhamos um dia<br />Dissipando as trevas do medo que havia em n&oacute;s<br />O teu sopro invadindo no peito<br />Recriando em n&oacute;s toda vida<br /><br />De tuas m&atilde;os e de teu lado aberto a paz vem enfim<br />Vivo est&aacute;s hoje aqui<br />Reunindo os cora&ccedil;&otilde;es em ti<br />Imensa alegria e felicidade<br />Tua gl&oacute;ria entre n&oacute;s</p>',1,1,'2021-04-01 01:06:52','2021-04-01 01:06:52'),(11,'Senhor nossa paz','Leandro Evaristo','Senhor, nossa paz, tende piedade de nós.\nTende piedade de nós, senhor! Tende piedade de nós!\n \nCristo, nossa páscoa, tende piedade de nós.\nTende piedade de nós, ó cristo! Tende piedade de nós!\n \nSenhor, nossa vida, tende piedade de nós.\nTende piedade de nós, senhor! Tende piedade de nós!','<p dir="ltr">Senhor, nossa paz, tende piedade de n&oacute;s.</p>\n<p dir="ltr"><strong>Tende piedade de n&oacute;s, senhor! Tende piedade de n&oacute;s!</strong></p>\n<p dir="ltr">&nbsp;</p>\n<p dir="ltr">Cristo, nossa p&aacute;scoa, tende piedade de n&oacute;s.</p>\n<p dir="ltr"><strong>Tende piedade de n&oacute;s, &oacute; cristo! Tende piedade de n&oacute;s!</strong></p>\n<p dir="ltr">&nbsp;</p>\n<p dir="ltr">Senhor, nossa vida, tende piedade de n&oacute;s.</p>\n<p dir="ltr"><strong>Tende piedade de n&oacute;s, senhor! Tende piedade de n&oacute;s!</strong></p>\n<p>&nbsp;</p>',1,1,'2021-04-01 01:09:22','2021-04-01 01:09:22'),(12,'Banhados em Cristo','Lone Buyst','Banhados em Cristo somos uma nova criatura.\nAs coisas antigas já se passaram, somos nascidos de novo.\nAleluia, aleluia, aleluia.','<p dir="ltr">Banhados em Cristo somos uma nova criatura.</p>\n<p dir="ltr">As coisas antigas j&aacute; se passaram, somos nascidos de novo.</p>\n<p dir="ltr"><strong>Aleluia, aleluia, aleluia.</strong></p>',1,1,'2021-04-01 01:11:16','2021-04-01 01:11:16'),(13,'Glória A Deus Nas Alturas','Comunidade Católica Shalom','Refrão:\nGlória, Glória a Deus nas alturas.\nGlória, Glória a Deus\nE aos homens toda paz, Sua paz!\n\nSenhor Deus Rei dos céus\nDeus Pai onipotente\nNós Vos louvamos, bendizemos, adoramos,\nVos glorificamos\nE damos graças,  por Vossa imensa Glória...\n\n[Refrão]\n\nSenhor Jesus Cristo, filho unigênito\nSenhor Deus, Cordeiro de Deus,\nFilho de Deus Pai\nVós que tirais o pecado do mundo, tende piedade de nós\nVós que tirais o pecado do mundo, acolhei a nossa súplica\nVós que estais sentado à direita do Pai, tende piedade de nós\n\n[Refrão]\n\nSó Vós sois o Santo\nSó Vós o Senhor\nSó Vós o Altíssimo Cristo Jesus\nCom o Espírito Santo na Glória de Deus Pai. \n\nAmém! Amém! Amém! Amém! (2x)','<p>Refr&atilde;o:<br /><strong>Gl&oacute;ria, Gl&oacute;ria a Deus nas alturas.</strong><br /><strong>Gl&oacute;ria, Gl&oacute;ria a Deus</strong><br /><strong>E aos homens toda paz, Sua paz!</strong><br /><br />Senhor Deus Rei dos c&eacute;us<br />Deus Pai onipotente<br />N&oacute;s Vos louvamos, bendizemos, adoramos,<br />Vos glorificamos<br />E damos gra&ccedil;as, por Vossa imensa Gl&oacute;ria...<br /><br />[Refr&atilde;o]<br /><br />Senhor Jesus Cristo, filho unig&ecirc;nito<br />Senhor Deus, Cordeiro de Deus,<br />Filho de Deus Pai<br />V&oacute;s que tirais o pecado do mundo, tende piedade de n&oacute;s<br />V&oacute;s que tirais o pecado do mundo, acolhei a nossa s&uacute;plica<br />V&oacute;s que estais sentado &agrave; direita do Pai, tende piedade de n&oacute;s<br /><br />[Refr&atilde;o]<br /><br />S&oacute; V&oacute;s sois o Santo<br />S&oacute; V&oacute;s o Senhor<br />S&oacute; V&oacute;s o Alt&iacute;ssimo Cristo Jesus<br />Com o Esp&iacute;rito Santo na Gl&oacute;ria de Deus Pai. <br /><br /><strong>Am&eacute;m! Am&eacute;m! Am&eacute;m! Am&eacute;m! (2x)</strong></p>',1,1,'2021-04-01 01:21:14','2021-04-01 01:21:14'),(14,'Cantai Cristãos, Afinal','Pedro Fernandes','Cantai Cristãos, afinal:\n“Salve, ó vítima pascal!”\nCordeiro inocente, o Cristo\nAbriu-nos do pai o aprisco.\n\nPor toda ovelha imolado,\nDo mundo lava o pecado.\nDuelam forte e mais forte\nÉ a vida que enfrenta a morte.\n\nO Rei da vida, cativo,\nFoi morto, mas reina vivo!\nResponde, pois, ó Maria:\n“No teu caminho o que havia? “\n\n“Vi Cristo ressuscitado,\nO túmulo abandonado.\nOs anjos da cor do sol,\nDobrado ao chão o lençol...\n\nO Cristo, que leva aos céus,\nCaminha à frente dos seus!” \nRessuscitou de verdade.\nÓ Rei, ó Cristo, piedade. (Bis)','<p>Cantai Crist&atilde;os, afinal:<br />&ldquo;Salve, &oacute; v&iacute;tima pascal!&rdquo;<br />Cordeiro inocente, o Cristo<br />Abriu-nos do pai o aprisco.<br /><br />Por toda ovelha imolado,<br />Do mundo lava o pecado.<br />Duelam forte e mais forte<br />&Eacute; a vida que enfrenta a morte.<br /><br />O Rei da vida, cativo,<br />Foi morto, mas reina vivo!<br />Responde, pois, &oacute; Maria:<br />&ldquo;No teu caminho o que havia? &ldquo;<br /><br />&ldquo;Vi Cristo ressuscitado,<br />O t&uacute;mulo abandonado.<br />Os anjos da cor do sol,<br />Dobrado ao ch&atilde;o o len&ccedil;ol...<br /><br />O Cristo, que leva aos c&eacute;us,<br />Caminha &agrave; frente dos seus!&rdquo; <br />Ressuscitou de verdade.<br />&Oacute; Rei, &oacute; Cristo, piedade. (Bis)</p>',1,1,'2021-04-01 01:24:08','2021-04-01 01:24:08'),(15,'Aleluia','Banda Capella','Aleluia, aleluia, aleluia, aleluia. (2X)\n\nDOMINGO DE PÁSCOA:\nO NOSSO CORDEIRO PASCAL FOI IMOLADO,\nCELEBREMOS POIS A FESTA NA SINCERIDADE E VERDADE.\n\n2º DOM PÁSCOA:\nACREDITASTE, TOMÉ, PORQUE ME VISTE.\nFELIZES AOS QUE CRERAM SEM TER VISTO!\n\n3º DOM PÁSCOA:\nSENHOR JESUS REVELAI-NOS O SENTIDO DA ESCRITURA;\nFAZEI O NOSSO CORAÇÃO ARDER, QUANDO FALARDES.\n\n4º DOM PÁSCOA:\nEU SOU O BOM PASTOR, DIZ O SENHOR;\nEU CONHEÇO AS MINHAS OVELHAS E ELAS ME CONHECEM A MIM.\n\n5º DOM PÁSCOA:\nEU SOU O CAMINHO, A VERDADE E A VIDA,\nNINGUÉM CHEGA AO PAI SENÃO POR MIM.\n\n6º DOM PÁSCOA:\nQUEM ME AMA REALMENTE GUARDARÁ MINHA PALAVRA,\nE MEU PAI O AMARÁ, E A ELE NÓS VIREMOS.','<p>Aleluia, aleluia, aleluia, aleluia. (2X)</p>\n<p>DOMINGO DE P&Aacute;SCOA:<br />O NOSSO CORDEIRO PASCAL FOI IMOLADO,<br />CELEBREMOS POIS A FESTA NA SINCERIDADE E VERDADE.</p>\n<p>2&ordm; DOM P&Aacute;SCOA:<br />ACREDITASTE, TOM&Eacute;, PORQUE ME VISTE.<br />FELIZES AOS QUE CRERAM SEM TER VISTO!</p>\n<p>3&ordm; DOM P&Aacute;SCOA:<br />SENHOR JESUS REVELAI-NOS O SENTIDO DA ESCRITURA;<br />FAZEI O NOSSO CORA&Ccedil;&Atilde;O ARDER, QUANDO FALARDES.</p>\n<p>4&ordm; DOM P&Aacute;SCOA:<br />EU SOU O BOM PASTOR, DIZ O SENHOR;<br />EU CONHE&Ccedil;O AS MINHAS OVELHAS E ELAS ME CONHECEM A MIM.</p>\n<p>5&ordm; DOM P&Aacute;SCOA:<br />EU SOU O CAMINHO, A VERDADE E A VIDA,<br />NINGU&Eacute;M CHEGA AO PAI SEN&Atilde;O POR MIM.</p>\n<p>6&ordm; DOM P&Aacute;SCOA:<br />QUEM ME AMA REALMENTE GUARDAR&Aacute; MINHA PALAVRA,<br />E MEU PAI O AMAR&Aacute;, E A ELE N&Oacute;S VIREMOS.</p>',1,1,'2021-04-01 01:28:24','2021-04-01 01:28:24'),(16,'Em procissão vão o pão e o vinho','Católicas','Em procissão vão o pão e o vinho.\nAcompanhados de nossa devoção.\nPois simbolizam aquilo que ofertamos:\nNossa vida e o nosso coração.\n \nAo celebrar nossa páscoa\ne ao vos trazer nossa oferta.\nFazei de nós, ó Deus de amor, imitadores do Redentor.\n \nA nossa igreja que é mãe deseja,\nque a consciência do gesto de ofertar,\nSe atualize durante toda a vida,\ncomo o Cristo se imola sobre o altar.\n \nEucaristia é sacrifício\nAquele mesmo que Cristo ofereceu.\nO mundo e homem serão reconduzidos,\npara a nova aliança com seu Deus .\n \nO Pão e o vinho serão em breve\nO corpo e o sangue do Cristo Salvador\nTal alimento nos une num só corpo,\nPara a glória de Deus em seu louvor.','<p>Em prociss&atilde;o v&atilde;o o p&atilde;o e o vinho.<br />Acompanhados de nossa devo&ccedil;&atilde;o.<br />Pois simbolizam aquilo que ofertamos:<br />Nossa vida e o nosso cora&ccedil;&atilde;o.<br />&nbsp;<br />Ao celebrar nossa p&aacute;scoa<br />e ao vos trazer nossa oferta.<br />Fazei de n&oacute;s, &oacute; Deus de amor, imitadores do Redentor.<br />&nbsp;<br />A nossa igreja que &eacute; m&atilde;e deseja,<br />que a consci&ecirc;ncia do gesto de ofertar,<br />Se atualize durante toda a vida,<br />como o Cristo se imola sobre o altar.<br />&nbsp;<br />Eucaristia &eacute; sacrif&iacute;cio<br />Aquele mesmo que Cristo ofereceu.<br />O mundo e homem ser&atilde;o reconduzidos,<br />para a nova alian&ccedil;a com seu Deus .<br />&nbsp;<br />O P&atilde;o e o vinho ser&atilde;o em breve<br />O corpo e o sangue do Cristo Salvador<br />Tal alimento nos une num s&oacute; corpo,<br />Para a gl&oacute;ria de Deus em seu louvor.</p>',1,1,'2021-04-01 01:31:12','2021-04-01 01:31:12'),(17,'Fonte do Viver','Ministério Amor e Adoração','Eis aqui a fonte do viver\nO pão e o vinho no altar sustenta a humanidade\n\nE em procissão vou receber\nO cristo vivo a se doar para a eternidade\n\nTodos tem o seu lugar, nesta mesa singular\nDe fraternidade e vida\n\nEis a tua vitória, vai além da história\nAmor tão grande assim\n\nEis o meu corpo partido por ti, \nfazei isto em memória de mim\nEis o meu sangue derramado na cruz, \nvenham todos a mim: \neu sou Jesus!','<p>Eis aqui a fonte do viver<br />O p&atilde;o e o vinho no altar sustenta a humanidade<br /><br />E em prociss&atilde;o vou receber<br />O cristo vivo a se doar para a eternidade<br /><br />Todos tem o seu lugar, nesta mesa singular<br />De fraternidade e vida<br /><br />Eis a tua vit&oacute;ria, vai al&eacute;m da hist&oacute;ria<br />Amor t&atilde;o grande assim<br /><br />Eis o meu corpo partido por ti, <br />fazei isto em mem&oacute;ria de mim<br />Eis o meu sangue derramado na cruz, <br />venham todos a mim: <br />eu sou Jesus!</p>',1,1,'2021-04-01 01:32:24','2021-04-01 01:32:24'),(18,'Santo','Ministério Amor e adoração','Santo, Santo, Santo Senhor Deus do universo\nO céu e a terra Proclamam Vossa Glória (2x)\n \nHosana (Hosana), Hosana (Hosana), Hosana nas alturas (2x)\n \nBendito o que vem em nome do Senhor. Hosana nas alturas\nHosana (Hosana), Hosana (Hosana), Hosana nas alturas (2x)','<p dir="ltr">Santo, Santo, Santo Senhor Deus do universo</p>\n<p dir="ltr">O c&eacute;u e a terra Proclamam Vossa Gl&oacute;ria (2x)</p>\n<p dir="ltr">&nbsp;</p>\n<p dir="ltr">Hosana (Hosana), Hosana (Hosana), Hosana nas alturas (2x)</p>\n<p dir="ltr">&nbsp;</p>\n<p dir="ltr">Bendito o que vem em nome do Senhor. Hosana nas alturas</p>\n<p dir="ltr">Hosana (Hosana), Hosana (Hosana), Hosana nas alturas (2x)</p>\n<p>&nbsp;</p>',1,1,'2021-04-01 01:34:45','2021-04-01 01:34:45'),(19,'Cordeiro','Ministerio Amor e Adoração','Cordeiro de Deus,\nQue tirais o pecado do mundo.\nTende Piedade, Piedade de nós.\n\nCordeiro de Deus,\nQue tirais o pecado do mundo.\nTende Piedade, Piedade de nós.\n\nCordeiro de Deus,\nQue tirais o pecado do mundo.\nDai-nos a Paz, a vossa Paz.','<p>Cordeiro de Deus,<br />Que tirais o pecado do mundo.<br />Tende Piedade, Piedade de n&oacute;s.</p>\n<p>Cordeiro de Deus,<br />Que tirais o pecado do mundo.<br />Tende Piedade, Piedade de n&oacute;s.</p>\n<p>Cordeiro de Deus,<br />Que tirais o pecado do mundo.<br />Dai-nos a Paz, a vossa Paz.</p>',1,1,'2021-04-01 01:37:10','2021-04-01 01:37:10'),(20,'Tu Nos Atraístes','Comunidade Católica Shalom','Cada vez que comemos deste pão \no Teu corpo nos renova nesta comunhão\ncada vez que bebemos deste vinho\no Teu sangue nos transforma \nnesta comunhão de amor.\n\nQuem come deste pão\nviverá para sempre\nsó Tu tens palavras de vida, vida eterna\npara onde ir longe de Ti\nTu nos atraístes oh Senhor, eis nos aqui.\n\nDeus entre nós, holocausto de amor\neterna e nova aliança\nem teu sangue elevado na cruz\ncordeiro de Deus\nTu nos atraíste oh Senhor, nós somos teus.\n\nVimos ti Senhor que a glória refugir\nem teu lado aberto encontramos plena paz\nem teu corpo santo somos recriados\nTu nos atraístes oh Senhor, vivo estás.\n\nA igreja tua esposa te espera com ardor\nalimento de eternidade o teu corpo \nnesta comunhão banquete do céu \nTu nos atraístes oh Senhor, eterno bem.','<p>Cada vez que comemos deste p&atilde;o <br />o Teu corpo nos renova nesta comunh&atilde;o<br />cada vez que bebemos deste vinho<br />o Teu sangue nos transforma <br />nesta comunh&atilde;o de amor.<br /><br />Quem come deste p&atilde;o<br />viver&aacute; para sempre<br />s&oacute; Tu tens palavras de vida, vida eterna<br />para onde ir longe de Ti<br />Tu nos atra&iacute;stes oh Senhor, eis nos aqui.<br /><br />Deus entre n&oacute;s, holocausto de amor<br />eterna e nova alian&ccedil;a<br />em teu sangue elevado na cruz<br />cordeiro de Deus<br />Tu nos atra&iacute;ste oh Senhor, n&oacute;s somos teus.<br /><br />Vimos ti Senhor que a gl&oacute;ria refugir<br />em teu lado aberto encontramos plena paz<br />em teu corpo santo somos recriados<br />Tu nos atra&iacute;stes oh Senhor, vivo est&aacute;s.<br /><br />A igreja tua esposa te espera com ardor<br />alimento de eternidade o teu corpo <br />nesta comunh&atilde;o banquete do c&eacute;u <br />Tu nos atra&iacute;stes oh Senhor, eterno bem.</p>',1,1,'2021-04-01 01:38:04','2021-04-01 01:38:04'),(21,'Parabéns Pra Você','Aline Barros','Hoje é dia do seu aniversário\nQue Dia Feliz que dia abençoado\nDesde o berçário o primeiro chorinho\nDeus já te guardava com tanto carinho\n\nJesus é o melhor presente pra você\nTodas as horas o amigão\ntá guardadinho aí nessa caixinha\nEm forma de coração\n\nParabéns, parabéns prá você\nParabéns nesta data querida\nParabéns, parabéns prá você\nDeus te dê muitos anos de vida\n\nÉ benção, é benção\nÉ benção, é benção, é benção\nEu oro, eu oro,\nEu oro, eu oro, eu oro\nPor mais um ....\nAno de vida','<p>Hoje &eacute; dia do seu anivers&aacute;rio<br />Que Dia Feliz que dia aben&ccedil;oado<br />Desde o ber&ccedil;&aacute;rio o primeiro chorinho<br />Deus j&aacute; te guardava com tanto carinho<br /><br />Jesus &eacute; o melhor presente pra voc&ecirc;<br />Todas as horas o amig&atilde;o<br />t&aacute; guardadinho a&iacute; nessa caixinha<br />Em forma de cora&ccedil;&atilde;o<br /><br />Parab&eacute;ns, parab&eacute;ns pr&aacute; voc&ecirc;<br />Parab&eacute;ns nesta data querida<br />Parab&eacute;ns, parab&eacute;ns pr&aacute; voc&ecirc;<br />Deus te d&ecirc; muitos anos de vida<br /><br />&Eacute; ben&ccedil;&atilde;o, &eacute; ben&ccedil;&atilde;o<br />&Eacute; ben&ccedil;&atilde;o, &eacute; ben&ccedil;&atilde;o, &eacute; ben&ccedil;&atilde;o<br />Eu oro, eu oro,<br />Eu oro, eu oro, eu oro<br />Por mais um ....<br />Ano de vida</p>',1,1,'2021-04-01 01:38:37','2021-04-01 01:38:37'),(22,'Ressuscitou','Comunidade Católica Shalom','Ressuscitou\n(Comunidade Shalom)\n\nNovo dia surgiu\nE o povo que andava nas trevas viu\nUma intensa Luz, Teu clarão\nTua Glória \nA resplandecer,\nNovo povo a trilhar \nUm caminho aberto por Tuas mãos\nObra nova enfim já podemos ver, nova criação\nsomos nós este povo alcançado por Tua Luz\nFruto da Tua obra na Cruz\nO Senhor Nosso Deus\nQue merece o Louvor, todo nosso amor\nÉ o Rei que venceu, ao Cordeiro\nA Vitória, Poder, Honra e Glória (2x)\nRessuscitou, Ressuscitou\nUm só povo, um só corpo, um só canto pra Teu louvor\nTua Igreja, Tua Esposa celebra o Teu amor\nSoberano, Majestoso\nGlorioso, Vencedor\nTodos juntos, povo em festa\nBanquete que não findará','<p>Ressuscitou<br />(Comunidade Shalom)<br /><br />Novo dia surgiu<br />E o povo que andava nas trevas viu<br />Uma intensa Luz, Teu clar&atilde;o<br />Tua Gl&oacute;ria <br />A resplandecer,<br />Novo povo a trilhar <br />Um caminho aberto por Tuas m&atilde;os<br />Obra nova enfim j&aacute; podemos ver, nova cria&ccedil;&atilde;o<br />somos n&oacute;s este povo alcan&ccedil;ado por Tua Luz<br />Fruto da Tua obra na Cruz<br />O Senhor Nosso Deus<br />Que merece o Louvor, todo nosso amor<br />&Eacute; o Rei que venceu, ao Cordeiro<br />A Vit&oacute;ria, Poder, Honra e Gl&oacute;ria (2x)<br />Ressuscitou, Ressuscitou<br />Um s&oacute; povo, um s&oacute; corpo, um s&oacute; canto pra Teu louvor<br />Tua Igreja, Tua Esposa celebra o Teu amor<br />Soberano, Majestoso<br />Glorioso, Vencedor<br />Todos juntos, povo em festa<br />Banquete que n&atilde;o findar&aacute;</p>',1,1,'2021-04-01 01:39:38','2021-04-01 01:39:38'),(23,'Deus Existe','Flavinho','Quero saber porquê não acreditas?\nQuero saber porquê, não o tens como Teu Senhor?\nPor que não aceitas que existe,\numa força que move-nos para o Bem!\nQue fé você tem? A fé que convém.\nMas não é de conveniência\nque vive o cristão.\nSua vivência está naquele\nque morreu por nós irmão!\n\nDeus existe, e Ele está no meio de nós\ne por nós se deu numa Cruz.\nPra pagar os nossos pecados\nde incrédulos cristãos.\nDeus existe, e eu O posso tocar\nse a Ele entregar o meu coração,\nPois é Nele que se encontra a Salvação!','<p>Quero saber porqu&ecirc; n&atilde;o acreditas?<br />Quero saber porqu&ecirc;, n&atilde;o o tens como Teu Senhor?<br />Por que n&atilde;o aceitas que existe,<br />uma for&ccedil;a que move-nos para o Bem!<br />Que f&eacute; voc&ecirc; tem? A f&eacute; que conv&eacute;m.<br />Mas n&atilde;o &eacute; de conveni&ecirc;ncia<br />que vive o crist&atilde;o.<br />Sua viv&ecirc;ncia est&aacute; naquele<br />que morreu por n&oacute;s irm&atilde;o!<br /><br />Deus existe, e Ele est&aacute; no meio de n&oacute;s<br />e por n&oacute;s se deu numa Cruz.<br />Pra pagar os nossos pecados<br />de incr&eacute;dulos crist&atilde;os.<br />Deus existe, e eu O posso tocar<br />se a Ele entregar o meu cora&ccedil;&atilde;o,<br />Pois &eacute; Nele que se encontra a Salva&ccedil;&atilde;o!</p>',1,1,'2021-04-01 03:16:42','2021-04-01 03:16:42'),(25,'Rei Senhor','Canção Nova','Rei Senhor, Rei Senhor \nVem louvar o Senhor \nBendizer o Seu nome \nE ver que essa dor \nDo teu peito some \nLevanta o braço, abre o coração \nMorre pra ti mesmo, e terás a paz então \n\nRei Senhor, Rei Senhor \n\nVem cantar ao Senhor \nCriador de tudo \nE receber a alegria \nQue não tem o mundo \nBate palma, bate o pé \nDá um sorriso, com muita fé \n\nRei senhor, Rei Senhor \n\nVai confessar ao Senhor \nOs teus pecados \nNão, não tenhas medo \nPois serás perdoado \nJesus te ama, meu irmão \nEntrega-te a Ele e terás a salvação \n\nRei Senhor, Rei Senhor','<p>Rei Senhor, Rei Senhor <br />Vem louvar o Senhor <br />Bendizer o Seu nome <br />E ver que essa dor <br />Do teu peito some <br />Levanta o bra&ccedil;o, abre o cora&ccedil;&atilde;o <br />Morre pra ti mesmo, e ter&aacute;s a paz ent&atilde;o <br /><br />Rei Senhor, Rei Senhor <br /><br />Vem cantar ao Senhor <br />Criador de tudo <br />E receber a alegria <br />Que n&atilde;o tem o mundo <br />Bate palma, bate o p&eacute; <br />D&aacute; um sorriso, com muita f&eacute; <br /><br />Rei senhor, Rei Senhor <br /><br />Vai confessar ao Senhor <br />Os teus pecados <br />N&atilde;o, n&atilde;o tenhas medo <br />Pois ser&aacute;s perdoado <br />Jesus te ama, meu irm&atilde;o <br />Entrega-te a Ele e ter&aacute;s a salva&ccedil;&atilde;o <br /><br />Rei Senhor, Rei Senhor</p>',1,1,'2021-04-01 03:18:04','2021-04-01 03:18:04'),(26,'Mãe do Céu Morena','Padre Zezinho','Mãe do Céu Morena\nSenhora da América Latina\nDe olhar e caridade tão divina\nDe cor igual a cor de tantas raças\n\nVirgem tão serena\nSenhora destes povos tão sofridos\nPatrona dos pequenos e oprimidos\nDerrama sobre nós as tuas graças\n\nDerrama sobre os jovens tua luz\nAos pobres vem mostrar o teu Jesus\nAo mundo inteiro traz o teu amor de mãe\n\nEnsina quem tem tudo a partilhar\nEnsina quem tem pouco a não cansar\nE faz o nosso povo caminhar em paz\n\nMãe do Céu Morena\nSenhora da América Latina\nDe olhar e caridade tão divina\nDe cor igual a cor de tantas raças\n\nVirgem tão serena\nSenhora destes povos tão sofridos\nPatrona dos pequenos e oprimidos\nDerrama sobre nós as tuas graças\n\nDerrama a esperança sobre nós\nEnsina o povo a não calar a voz\nDesperta o coração de quem não acordou\n\nEnsina que a justiça é condição\nDe construir um mundo mais irmão\nE faz o nosso povo conhecer Jesus',NULL,4,4,'2021-10-12 14:12:19','2021-10-12 14:12:19');
/*!40000 ALTER TABLE `musicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repertorio_musicas`
--

DROP TABLE IF EXISTS `repertorio_musicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repertorio_musicas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idRepertorio` int(11) unsigned NOT NULL COMMENT 'Id do repertório',
  `sequencia` int(11) NOT NULL COMMENT 'Sequencia da música no repertório',
  `idMusica` int(11) unsigned NOT NULL COMMENT 'Id da música no repertório',
  `aprovado` tinyint(1) NOT NULL COMMENT 'Indicador se aprovado',
  `idCategoria` int(11) NOT NULL COMMENT 'Id da categoria da música',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Data de criação do registro',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data de alteracção do registro',
  `motivo` blob DEFAULT NULL COMMENT 'Motivo da reprovação',
  PRIMARY KEY (`id`),
  KEY `idRepertorio` (`idRepertorio`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repertorio_musicas`
--

LOCK TABLES `repertorio_musicas` WRITE;
/*!40000 ALTER TABLE `repertorio_musicas` DISABLE KEYS */;
INSERT INTO `repertorio_musicas` VALUES (1,1,1,14,2,1,'2021-10-12 02:11:43','2021-10-12 02:13:23',NULL),(2,1,3,13,2,3,'2021-10-12 02:11:43','2021-10-12 02:13:23',NULL),(3,1,6,25,2,6,'2021-10-12 02:11:43','2021-10-12 02:13:23',NULL),(4,1,7,16,2,7,'2021-10-12 02:11:43','2021-10-12 02:13:23',NULL),(5,1,8,18,2,8,'2021-10-12 02:11:43','2021-10-12 02:13:23',NULL),(6,1,9,6,2,9,'2021-10-12 02:11:43','2021-10-12 02:13:23',NULL),(7,1,10,20,2,10,'2021-10-12 02:11:43','2021-10-12 02:13:23',NULL),(8,1,11,22,2,12,'2021-10-12 02:11:43','2021-10-12 02:13:23',NULL),(9,3,7,17,3,7,'2021-10-12 02:13:11','2021-10-12 14:19:04','Repertório faltando musicas de comunhão, abertura , xxxxx'),(10,3,8,18,3,8,'2021-10-12 02:13:11','2021-10-12 14:19:04','idem'),(11,3,11,2,3,12,'2021-10-12 02:13:11','2021-10-12 14:19:05','idem');
/*!40000 ALTER TABLE `repertorio_musicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repertorio_status`
--

DROP TABLE IF EXISTS `repertorio_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repertorio_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(40) NOT NULL COMMENT 'Descrição do status',
  `icon` varchar(40) NOT NULL COMMENT 'Ícone do status',
  `tableStyle` varchar(40) NOT NULL COMMENT 'Style CSS nas tabelas',
  `objetoStyle` varchar(40) NOT NULL COMMENT 'Style CSS nos objetos html',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repertorio_status`
--

LOCK TABLES `repertorio_status` WRITE;
/*!40000 ALTER TABLE `repertorio_status` DISABLE KEYS */;
INSERT INTO `repertorio_status` VALUES (1,'Pendente','alert-triangle','table-warning','bg-warning'),(2,'Liberado','check','table-success','bg-success'),(3,'Reprovado','x-circle','table-danger','bg-danger'),(4,'Sem músicas','help-circle','table-danger','bg-danger');
/*!40000 ALTER TABLE `repertorio_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repertorio_templates`
--

DROP TABLE IF EXISTS `repertorio_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repertorio_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL COMMENT 'Descrição do repertório',
  `dataEvento` timestamp NULL DEFAULT NULL COMMENT 'Data da realização do evento',
  `idMinisterio` int(11) NOT NULL COMMENT 'Id do Ministério de música',
  `tipo` varchar(15) NOT NULL COMMENT 'Id do Tipo de repertório',
  `status` int(11) NOT NULL COMMENT 'Id do status do repertório (1=Pendente, 2=Liberado, 3=Reprovado)',
  `approved_by` int(11) DEFAULT NULL COMMENT 'ID do usuário que aprovou o repertório',
  `approved_at` timestamp NULL DEFAULT NULL COMMENT 'Data de aprovação do repertório',
  `created_by` int(11) NOT NULL COMMENT 'ID do usuário que criou o registro',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Data de criação do registro',
  `updated_by` int(11) NOT NULL COMMENT 'ID do usuário que alterou o registro',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data de alteração do registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repertorio_templates`
--

LOCK TABLES `repertorio_templates` WRITE;
/*!40000 ALTER TABLE `repertorio_templates` DISABLE KEYS */;
INSERT INTO `repertorio_templates` VALUES (1,'Segunda-feira 19H30','2021-10-01 19:30:00',0,'Template_DDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(2,'Terça-feira 19H30','2021-10-01 19:30:00',0,'Template_DDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(3,'Quarta-feira 19H30','2021-10-01 19:30:00',0,'Template_DDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(4,'Quinta-feira 19H30','2021-10-01 19:30:00',0,'Template_DDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(5,'Sexta-feira 19H30','2021-10-01 19:30:00',0,'Template_DDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(6,'Sábado 19H','2021-10-01 19:00:00',0,'Template_FDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(7,'Domingo 07H','2021-10-01 07:00:00',0,'Template_FDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(8,'Domingo 09H30','2021-10-01 09:30:00',0,'Template_FDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(9,'Domingo 12H','2021-10-01 12:00:00',0,'Template_FDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(10,'Domingo 17H','2021-10-01 17:00:00',0,'Template_FDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(11,'Domingo 19H30','2021-10-01 19:30:00',0,'Template_FDS',1,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `repertorio_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repertorios`
--

DROP TABLE IF EXISTS `repertorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repertorios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL COMMENT 'Descrição do repertório',
  `dataEvento` timestamp NULL DEFAULT NULL COMMENT 'Data da realização do evento',
  `idMinisterio` int(11) NOT NULL COMMENT 'Id do Ministério de música',
  `tipo` varchar(15) NOT NULL COMMENT 'Id do Tipo de repertório',
  `status` int(11) NOT NULL COMMENT 'Id do status do repertório (1=Pendente, 2=Liberado, 3=Reprovado)',
  `approved_by` int(11) DEFAULT NULL COMMENT 'ID do usuário que aprovou o repertório',
  `approved_at` timestamp NULL DEFAULT NULL COMMENT 'Data de aprovação do repertório',
  `created_by` int(11) NOT NULL COMMENT 'ID do usuário que criou o registro',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Data de criação do registro',
  `updated_by` int(11) NOT NULL COMMENT 'ID do usuário que alterou o registro',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data de alteração do registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repertorios`
--

LOCK TABLES `repertorios` WRITE;
/*!40000 ALTER TABLE `repertorios` DISABLE KEYS */;
INSERT INTO `repertorios` VALUES (1,'Segunda-feira 19H30','2021-10-25 19:30:00',2,'Missa',2,4,'2021-10-12 02:13:23',1,'2021-10-12 02:08:34',2,'2021-10-12 02:13:23'),(2,'Terça-feira 19H30','2021-10-26 19:30:00',3,'Missa',4,NULL,NULL,1,'2021-10-12 02:08:34',1,'2021-10-12 02:08:34'),(3,'Quarta-feira 19H30','2021-10-27 00:00:00',4,'Missa',3,4,'2021-10-12 14:19:05',1,'2021-10-12 02:08:34',4,'2021-10-12 14:19:05'),(4,'Quinta-feira 19H30','2021-10-28 19:30:00',5,'Missa',4,NULL,NULL,1,'2021-10-12 02:08:34',1,'2021-10-12 02:08:34'),(5,'Sexta-feira 19H30','2021-10-29 19:30:00',6,'Missa',4,NULL,NULL,1,'2021-10-12 02:08:34',1,'2021-10-12 02:08:34'),(6,'Sábado 19H','2021-10-23 19:00:00',7,'Missa',4,NULL,NULL,1,'2021-10-12 02:09:08',1,'2021-10-12 02:09:08'),(7,'Domingo 07H','2021-10-24 07:00:00',6,'Missa',4,NULL,NULL,1,'2021-10-12 02:09:08',1,'2021-10-12 02:09:08'),(8,'Domingo 09H30','2021-10-24 09:30:00',5,'Missa',4,NULL,NULL,1,'2021-10-12 02:09:08',1,'2021-10-12 02:09:08'),(9,'Domingo 12H','2021-10-24 12:00:00',4,'Missa',4,NULL,NULL,1,'2021-10-12 02:09:08',1,'2021-10-12 02:09:08'),(10,'Domingo 17H','2021-10-24 17:00:00',3,'Missa',4,NULL,NULL,1,'2021-10-12 02:09:08',1,'2021-10-12 02:09:08'),(11,'Domingo 19H30','2021-10-24 19:30:00',2,'Missa',4,NULL,NULL,1,'2021-10-12 02:09:08',1,'2021-10-12 02:09:08'),(12,'Segunda-feira 19H30','2021-11-01 19:30:00',2,'Missa',4,NULL,NULL,4,'2021-10-12 13:59:15',4,'2021-10-12 13:59:15'),(13,'Terça-feira 19H30','2021-11-02 19:30:00',3,'Missa',4,NULL,NULL,4,'2021-10-12 13:59:15',4,'2021-10-12 13:59:15'),(14,'Quarta-feira 19H30','2021-11-03 19:30:00',5,'Missa',4,NULL,NULL,4,'2021-10-12 13:59:15',4,'2021-10-12 13:59:15'),(15,'Quinta-feira 19H30','2021-11-04 19:30:00',6,'Missa',4,NULL,NULL,4,'2021-10-12 13:59:15',4,'2021-10-12 13:59:15'),(16,'Sexta-feira 19H30','2021-11-05 19:30:00',8,'Missa',4,NULL,NULL,4,'2021-10-12 13:59:15',4,'2021-10-12 13:59:15');
/*!40000 ALTER TABLE `repertorios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'LEANDRO TAVARES DA SILVA','ltavasilva@gmail.com',NULL,'$2y$10$xAeCvz/39bZ1Y6bo5871K.HJVjcTazhMaQiK8LMpGf87Uy/xt/wUS',NULL,'2021-10-12 02:00:39','2021-10-12 02:00:39'),(2,'Gabriel do Nascimento Silva','biel@gmail.com',NULL,'$2y$10$mblaBObnPcd69zX709TjLOy9Kay3JSsMClxDBH2X.gJbv.O6gaJDS',NULL,'2021-10-12 02:03:48','2021-10-12 02:03:48'),(3,'Thais de Souza Nascimento Silva','thais@gmail.com',NULL,'$2y$10$JGqqoZiyROFbXszeSG4aguu/zt.HyxoPFvCMCiYKCOVS11F2hkqFC',NULL,'2021-10-12 02:04:02','2021-10-12 02:04:02'),(4,'Nilton','nilton@gmail.com',NULL,'$2y$10$885UB1n8w4h.gIuSkWirvuehRcBCdLQ/ZljhuiIcUnIqSgsZjOzbu',NULL,'2021-10-12 02:04:22','2021-10-12 02:04:22'),(5,'Jacque','jacque@gmail.com',NULL,'$2y$10$vOkEib9Tn4cRdzEvj08aPugoTiR6NwGI0x9hqR34jYyf6LtK2BL/G',NULL,'2021-10-12 02:05:12','2021-10-12 02:05:12'),(6,'Marcela','marcela@gmail.com',NULL,'$2y$10$hfbHVt1yIe0zSj0HuUshY.DeMHjrgUBi9f88atFUKbGw29p0cN0Ku',NULL,'2021-10-12 02:05:32','2021-10-12 02:05:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_perfil`
--

DROP TABLE IF EXISTS `users_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_perfil` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned NOT NULL COMMENT 'Id do usuário',
  `acessos` varchar(255) NOT NULL COMMENT 'Lista dos acessos separados por ";"',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'data de criação dos registro',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Data de alteração do registro',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_perfil`
--

LOCK TABLES `users_perfil` WRITE;
/*!40000 ALTER TABLE `users_perfil` DISABLE KEYS */;
INSERT INTO `users_perfil` VALUES (1,1,'admin','0000-00-00 00:00:00','0000-00-00 00:00:00',1,1),(2,2,'','2021-10-12 02:03:48','2021-10-12 02:03:48',1,1),(3,3,'ministerios','2021-10-12 02:04:02','2021-10-12 02:04:28',1,1),(4,4,'coordenador','2021-10-12 02:04:22','2021-10-12 02:04:22',1,1),(5,5,'','2021-10-12 02:05:12','2021-10-12 02:05:12',1,1),(6,6,'pascom','2021-10-12 02:05:32','2021-10-12 02:05:32',1,1);
/*!40000 ALTER TABLE `users_perfil` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-12 14:54:21