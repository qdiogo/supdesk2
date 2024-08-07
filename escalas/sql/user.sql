CREATE SCHEMA `ci_admin` DEFAULT CHARACTER SET utf8 ;

use `ci_admin`;

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(12) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `crm` VARCHAR(15) NOT NULL,
  `dt_nascimento` date NOT NULL,
  `senha` VARCHAR(40) NOT NULL,
  `tipo` SMALLINT(1),
  `status` SMALLINT(1),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `crm` (`crm`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `grupo` (
  `id` INT(12) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `status` SMALLINT(1) NOT NULL,
  `visualizar` SMALLINT(1),
  `id_user_admin` INT(12),
  PRIMARY KEY (`id`),
  FOREIGN KEY (id_user_admin) REFERENCES user(id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_grupo` (
  `id_user` INT(12) NOT NULL,
  `id_grupo` INT(12) NOT NULL,
  `user_status` SMALLINT(1),
  PRIMARY KEY (id_user, id_grupo),
  FOREIGN KEY (id_user) REFERENCES user(id),
  FOREIGN KEY (id_grupo) REFERENCES grupo(id))
  ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  CREATE TABLE IF NOT EXISTS `solicitacao_grupo` (
  `id` INT(12) NOT NULL AUTO_INCREMENT,
  `id_user` INT(12) NOT NULL,
  `id_grupo` INT(12) NOT NULL,
  `status` SMALLINT(1),
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  
  
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'roger', 'roger@email.com', '33512939848', '1111', '1985-06-19', 'e10adc3949ba59abbe56e057f20f883e', '0', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Thanos', 'thanos@adm.com.br', '99881683149', '2395', '1990-05-18', 'e10adc3949ba59abbe56e057f20f883e', '0', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Luff', 'luff@adm.com.br', '99283204115', '1644', '2003-11-25', 'e10adc3949ba59abbe56e057f20f883e', '0', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Thor', 'thor@adm.com.br', '98189271172', '2407', '1996-04-06', 'e10adc3949ba59abbe56e057f20f883e', '0', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Stark', 'stark@adm.com.br', '98047426168', '2396', '1997-08-25', 'e10adc3949ba59abbe56e057f20f883e', '0', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Odin', 'odin@adm.com.br', '97614173104', '2343', '2003-10-21', 'e10adc3949ba59abbe56e057f20f883e', '0', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Miles', 'miles@adm.com.br', '97200581100', '2374', '1994-05-03', 'e10adc3949ba59abbe56e057f20f883e', '2', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Zeus', 'zeus@adm.com.br', '96765283153', '2056', '1986-09-04', 'e10adc3949ba59abbe56e057f20f883e', '2', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Kratos', 'kratos@adm.com.br', '96668890130', '2066', '1992-05-19', 'e10adc3949ba59abbe56e057f20f883e', '2', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Crush', 'crush@adm.com.br', '96132493115', '2362', '2015-03-22', 'e10adc3949ba59abbe56e057f20f883e', '2', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Aloi', 'aloi@adm.com.br', '93422300163', '1954', '1992-07-14', 'e10adc3949ba59abbe56e057f20f883e', '2', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Coraline', 'coraline@adm.com.br', '93228066134', '2332', '1988-03-27', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Aline', 'aline@adm.com.br', '92075053120', '1858', '1998-05-20', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Aime', 'aime@adm.com.br', '91495741168', '2444', '1992-10-12', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Maria', 'maria@adm.com.br', '90975790153', '1664', '1984-07-16', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Amalia', 'amalia@adm.com.br', '89448049153', '2370', '2016-02-12', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Jose', 'jose@adm.com.br', '88975096149', '2453', '1985-01-30', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Drax', 'drax@adm.com.br', '88884252172', '2323', '1994-06-25', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Gomora', 'gomora@adm.com.br', '88677990100', '2446', '1997-07-16', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Loki', 'loki@adm.com.br', '87100940168', '2393', '2013-06-28', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Herschel', 'herschel@adm.com.br', '84586753153', '2408', '2012-01-30', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Ketty', 'ketty@adm.com.br', '83024506187', '1917', '2013-11-06', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Teach', 'teach@adm.com.br', '78477344191', '2441', '2015-02-22', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Merle', 'merle@adm.com.br', '78407621153', '1841', '2000-01-28', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Ace', 'ace@adm.com.br', '77374738153', '2442', '2001-06-11', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Usop', 'usop@adm.com.br', '76382818100', '1812', '2002-06-19', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Frank', 'frank@adm.com.br', '75446081072', '1878', '2005-11-08', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Robin', 'robin@adm.com.br', '73873438100', '2299', '1981-12-02', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Chopper', 'chopper@adm.com.br', '73068730163', '2369', '2004-02-22', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Natsu', 'natsu@adm.com.br', '70563888172', '2392', '2014-06-14', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Shanx', 'shanx@adm.com.br', '70506817172', '2394', '1981-12-15', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Carmine', 'carmine@adm.com.br', '65255127191', '1676', '1989-08-31', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Fenix', 'fenix@adm.com.br', '61357553153', '2433', '1994-08-18', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Marcus', 'marcus@adm.com.br', '60037768115', '2117', '2005-12-25', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Dom', 'dom@adm.com.br', '58294341134', '2086', '1996-05-04', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Locust', 'locust@adm.com.br', '58025561020', '2427', '2015-11-02', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Brook', 'brook@adm.com.br', '56215266191', '2306', '2000-02-04', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Jack', 'jack@adm.com.br', '55813054120', '2315', '1998-01-19', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Galo', 'galo@adm.com.br', '51901811115', '1937', '1993-11-06', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Chuck', 'chuck@adm.com.br', '51835762115', '2409', '1985-10-29', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Norris', 'norris@adm.com.br', '51827697172', '2376', '1985-05-27', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Liaa', 'liaa@adm.com.br', '51184877815', '2354', '1989-10-12', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Lyli', 'lyli@adm.com.br', '51110687168', '1999', '1981-04-12', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Lars', 'lars@adm.com.br', '44783132100', '2412', '2003-01-06', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Uric', 'uric@adm.com.br', '43698484153', '2338', '2002-10-09', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'James', 'james@adm.com.br', '43674879115', '2377', '2010-05-30', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Jonathan', 'jonathan@adm.com.br', '40485986191', '2367', '1995-04-24', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Davis', 'davis@adm.com.br', '36725005187', '2422', '1995-07-27', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Jones', 'jones@adm.com.br', '34076875915', '1436', '2008-09-11', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `ci_admin`.`user` (`id`, `nome`, `email`, `cpf`, `crm`, `dt_nascimento`, `senha`, `tipo`, `status`) VALUES (default, 'Kronos', 'kronos@adm.com.br', '33756961168', '2336', '1999-12-27', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');


INSERT INTO `ci_admin`.`grupo` (`id`, `nome`, `status`, `visualizar`, `id_user_admin`) VALUES (default, 'Teste 1', '1', '0', '7');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('7', '1', '1');
INSERT INTO `ci_admin`.`grupo` (`id`, `nome`, `status`, `visualizar`, `id_user_admin`) VALUES (default, 'Teste 2', '1', '0', '8');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('8', '2', '1');
INSERT INTO `ci_admin`.`grupo` (`id`, `nome`, `status`, `visualizar`, `id_user_admin`) VALUES (default, 'Teste 3', '1', '0', '9');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('9', '3', '1');
INSERT INTO `ci_admin`.`grupo` (`id`, `nome`, `status`, `visualizar`, `id_user_admin`) VALUES (default, 'Teste 4', '1', '0', '10');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('10', '4', '1');
INSERT INTO `ci_admin`.`grupo` (`id`, `nome`, `status`, `visualizar`, `id_user_admin`) VALUES (default, 'Teste 5', '1', '0', '11');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('11', '5', '1');

INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('15', '1', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('16', '1', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('17', '1', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('18', '1', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('19', '1', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('20', '1', '1');

INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('21', '2', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('22', '2', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('23', '2', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('24', '2', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('25', '2', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('26', '2', '1');

INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('27', '3', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('28', '3', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('29', '3', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('30', '3', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('31', '3', '1');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('32', '3', '1');

INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('15', '3', '0');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('16', '3', '0');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('17', '2', '0');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('18', '2', '0');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('31', '1', '0');
INSERT INTO `ci_admin`.`user_grupo` (`id_user`, `id_grupo`, `user_status`) VALUES ('32', '1', '0');




  
  
  
  


