# Blog de Receitas Culinárias

## Projeto feito pelos alunos
    LORENZO DE ANDRADE SOUZA JANOTA – 838633
    CAIO NEVES MAITAN – 837704
    ENZO BOTOLOTO FLOR – 838500
    JOÃO VITOR BERNARDES VIEIRA - 837901

## Descrição

O Blog de Receitas Culinárias é uma plataforma web onde usuários podem compartilhar suas receitas favoritas, incluindo imagens e instruções detalhadas. Os usuários podem interagir com as receitas através de avaliações e comentários, e também têm a opção de compartilhar receitas em redes sociais.
Funcionalidades
## Cadastro de Imagens
    Inserir: Permite o upload de imagens dos pratos. As imagens são validadas quanto ao tipo e tamanho antes de serem armazenadas.
    Deletar: Usuários podem remover imagens do banco de dados e do servidor.
    Atualizar: Opção para editar descrições associadas às imagens e substituir imagens existentes.

## Cadastro de Textos
    Inserir: Formulário para adicionar novas receitas com suporte para formatação básica.
    Deletar: Remover receitas do banco de dados.
    Atualizar: Editar e atualizar o conteúdo das receitas existentes.

## Pontuações e Comentários
    Pontuações: Sistema de avaliação por estrelas ou notas, integrado ao banco de dados para registrar a opinião dos usuários sobre as receitas.
    Comentários: Seção para adicionar e exibir comentários sobre as receitas, com moderação opcional para manter a qualidade das interações.

## Compartilhamento
    Links: Geração de URLs únicas para cada receita, permitindo o compartilhamento nas redes sociais e por e-mail.

# Tecnologias Utilizadas
    FrontEnd: HTML, CSS, JavaScript
    BackEnd: PHP para processamento de formulários e manipulação de dados.


# SQL

CREATE DATABASE blog;

CREATE TABLE posts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);


CREATE TABLE comments (
    id INT(11) NOT NULL AUTO_INCREMENT,
    post_id INT(11) NOT NULL,
    user VARCHAR(100) NOT NULL,
    text TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);


CREATE TABLE images (
    id INT(11) NOT NULL AUTO_INCREMENT,
    post_id INT(11) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);



CREATE TABLE ratings (
    id INT(11) NOT NULL AUTO_INCREMENT,
    post_id INT(11) NOT NULL,
    rating INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);




