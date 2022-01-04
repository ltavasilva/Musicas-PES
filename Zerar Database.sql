TRUNCATE TABLE escala_repertorios;

DELETE from escalas;
ALTER TABLE escalas AUTO_INCREMENT = 1;

DELETE FROM ministerios;
ALTER TABLE ministerios AUTO_INCREMENT = 1;

TRUNCATE TABLE musica_categorias;

DELETE from musicas;
ALTER TABLE musicas AUTO_INCREMENT = 1;

DELETE from repertorio_musicas;
ALTER TABLE repertorio_musicas AUTO_INCREMENT = 1;

DELETE from repertorios;
ALTER TABLE repertorios AUTO_INCREMENT = 1;

DELETE from users;
ALTER TABLE users AUTO_INCREMENT = 1;

DELETE from users_perfil;
ALTER TABLE users_perfil AUTO_INCREMENT = 1;