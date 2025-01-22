<?php

use FTP\Connection;

    require_once'connection/connection.php';

    class filmeModel {
        //GET (TODOS)
        public static function getAll()
        {
            $db = new database();
            $query = "SELECT * FROM filmes";
            $result = $db->query($query);

            $dados = [];

            while ($row = $result->fetch_assoc())
            {
                $dados[] = $row;
            }

            return $dados;
        }

        // GET (ID)
        public static function getSpecific($titulo)
        {
            $db = new database();
            $query = "SELECT * FROM filmes WHERE titulo LIKE '%$titulo%'";
            $result = $db->query($query);

            return $result->fetch_row();
        }

        // INSERT

        public static function registerMovie($titulo, $genero, $ano)
        {
            $db = new database();
            $query = "INSERT INTO filmes(titulo, genero, ano) VALUES ('$titulo', '$genero', $ano)";
            $db->query($query);

            return $db->affected_rows > 0;
        }
        //UPDATE

        public static function updateMovie($id, $titulo, $genero, $ano)
        {
            $db = new database();
            $query = "UPDATE filmes SET titulo = '$titulo', genero = '$genero', ano = $ano WHERE id = $id";
            $db->query($query);


            return $db->affected_rows > 0;
        }
        // DELETE

        public static function deleteMovie($id)
        {
            $db = new database();
            $query = "DELETE FROM filmes WHERE id = $id";
            $db->query($query);


            return $db->affected_rows > 0;
        }

    }