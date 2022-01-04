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
INSERT INTO `musicas` VALUES (1,'A alegria do senhor é nossa força','Vida Reluz','A ALEGRIA DO SENHOR 
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