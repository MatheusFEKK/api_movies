<?php

    require_once'models/filmeModel.php';

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['searchMovieId']))
            {
                $movie = $_GET['searchMovieId'];
                $response = filmeModel::getSpecific($movie);
                echo '<div class="d-flex justify-content-center">Nome do filme: '.$response[1]. '<br>Genêro do filme: '.$response[2]. '<br>Ano de lançamento:'. $response[3].'</div>';
            }else {
                echo json_encode(['message' => 'Movie not founded, showing the movies that are in the database']);
                $filmes = filmeModel::getAll();
            }
            
            break;
        case 'POST':
            $dados = json_decode(file_get_contents('php://input'), true);
            
                if (isset($dados['titulo'], $dados['genero'], $dados['ano']))
                {
                    if (filmeModel::registerMovie($dados['titulo'], $dados['genero'], $dados['ano']))
                    {
                        http_response_code(201);
                        echo json_encode(['message' => 'Acquired with success']);
                    }else {
                        http_response_code(400);
                        echo json_encode(['message' => 'Error occured trying to register the Movie']);
                    }
                }
            else {
                http_response_code(400);
                echo json_encode($dados);
                echo json_encode(['message' => 'The data offered is incorrect']);
            }

            break;
        case 'PUT':
            $dados = json_decode(file_get_contents('php://input'), true);
            if (isset($dados['id'], $dados['titulo'], $dados['genero'], $dados['ano']))
            {
                if (filmeModel::updateMovie($dados['id'], $dados['titulo'], $dados['genero'], $dados['ano']))
                {
                    echo json_encode(['message' => 'Movie updated with success']);
                }else {
                    http_response_code(400);
                    echo json_encode(['message' => 'Error trying to update the movie']);
                }
            }
            else {
                http_response_code(400);
                echo json_encode(['message' => 'The data to update is incorrect']);
            }

            break;
        case 'DELETE':
            if (isset($dados['id']))
            {
                if (filmeModel::deleteMovie($dados['id']))
                {
                    echo json_encode(['message' => 'Deleted with success']);
                }else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Error trying delete the movie']);
                }
            }else {
                http_response_code(400);
                echo json_encode(['message' => 'ID not offered']);
            }

            break;
        
        default:
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            break;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="container d-flex justify-content-center">
            <div class="searchMovie">
                <h6>Procurar Filme</h6>
                <form action="" method="GET">
                    <input type="text" name="searchMovieId" placeholder="Nome do Filme">
                    <button class="btn btn-primary">Procurar</button>
                </form>

                <div class="insertMovie">
                    <form action="" method="POST">
                        <input type="text" name="nameMovie">
                        <input type="text" name="genreMovie">
                        <input type="text" name="yearMovie">
                        <button class="btn btn-primary"></button>
                    </form>
                </div>
            </div>

        </div>
    </body>
    </html>