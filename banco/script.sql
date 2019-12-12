CREATE TABLE usuarios(
    usuario VARCHAR(45) NOT NULL,
    senha VARCHAR(45) NOT NULL,
    PRIMARY KEY (usuario)
) ENGINE = INNODB;

CREATE TABLE estacoes (
	nome VARCHAR(45) NOT NULL,
	est_usuario VARCHAR(45) NOT NULL,
	PRIMARY KEY (nome),
	INDEX fk_estacoes_usuario_idx (est_usuario ASC),
	CONSTRAINT fk_estacoes_usuario
	FOREIGN KEY (est_usuario)
	REFERENCES usuarios (usuario)
	ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE = INNODB;