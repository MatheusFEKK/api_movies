<?php

    require_once'models/filmeModel.php';

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $filmes = filmeModel::getAll();
            echo '<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nome do Filme</th>
      <th scope="col">Genero do Filme</th>
      <th scope="col">Ano de Lançamento</th>
    </tr>
  </thead>
  <tbody>';
            foreach ($filmes as $index => $movies)
            {
                echo '<div> <table class="table">
                    <tr>
                    <th scope="row">1</th>
                    <td>'.$movies['titulo'].'</td>
                    <td>'.$movies['genero'].'</td>
                    <td>'.$movies['ano'].'</td>
                    <td><a href="index.php?</td>
                    </tr>
                ';
            }
            echo '</div></tbody>
</table><br>';
            if (isset($_GET['searchMovieId']))
            {
                $movie = $_GET['searchMovieId'];
                $response = filmeModel::getSpecific($movie);
                echo 'Nome do filme: '.$response[1]. '<br>Genêro do filme: '.$response[2]. '<br>Ano de lançamento:'. $response[3];
                return;
            }else {
                echo json_encode(['mess age' => 'Movie not founded, showing the movies that are in the database']);
            }
            
            break;
        case 'POST':
                if (isset($_POST['nameMovie'], $_POST['genreMovie'], $_POST['yearMovie']))
                {
                    if (filmeModel::registerMovie($_POST['nameMovie'], $_POST['genreMovie'], $_POST['yearMovie']))
                    {
                        http_response_code(201);
                        echo 'Acquired with success';
                    }else {
                        http_response_code(400);
                        echo 'Error occured trying to register the Movie';
                    }
                }
            else {
                http_response_code(400);
                echo 'The data offered is incorrect';
            }

            break;
        case 'POST':
            if (isset($_POST['idAtualizar'], $_POST['nameMovieUpdate'], $_POST['genreMovieUpdate'], $_POST['yearMovieUpdate']))
            {
                if (filmeModel::updateMovie($_POST['idAtualizar'], $_POST['nameMovieUpdate'], $_POST['genreMovieUpdate'], $_POST['yearMovieUpdate']))
                {
                    echo 'Movie updated with success';
                }else {
                    http_response_code(400);
                    echo 'Error trying to update the movie';
                }
            }
            else {
                http_response_code(400);
                echo 'The data to update is incorrect';
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
        <div class="container d-flex justify-content-center gap-3">
            <div class="searchMovie">
                <h6>Procurar Filme</h6>
                    <input oninput="searchMovie()" type="text" placeholder="Nome do Filme" id="searchMovieId">
                    <div id="result">
                    </div>
                </div><br>

                <div class="insertMovie">
                    <form action="" method="POST">
                        <h6>Cadastrar Filme</h6>
                        <input class="shadow" type="text" name="nameMovie" placeholder="Nome do Filme" style="width: 15rem; height:3rem; border-radius: 0.5rem; border:none;"><br><br>
                        <input class="shadow" type="text" name="genreMovie" placeholder="Genero do Filme" style="width: 15rem; height:3rem; border-radius: 0.5rem; border:none;"><br><br>
                        <input class="shadow" type="text" name="yearMovie" placeholder="Ano de Lançamento" style="width: 15rem; height:3rem; border-radius: 0.5rem; border:none;"><br><br>
                        <button class="btn btn-primary float-end">Inserir</button>
                    </form>
                </div>

            <div class="updateMovie">
                <form action="" method="POST">
                    <h6>Atualizar Filme</h6>
                    <input class="shadow" type="text" name="idAtualizar" placeholder="ID do Filme" style="width: 15rem; height:3rem; border-radius:0.5rem; border:none;"><br><br>
                    <input class="shadow" type="text" name="nameMovieUpdate" placeholder="Titulo Atualizar" style="width: 15rem; height:3rem; border-radius:0.5rem; border:none;"><br><br>
                    <input class="shadow" type="text" name="genreMovieUpdate" placeholder="Genero Atualizar" style="width: 15rem; height:3rem; border-radius:0.5rem; border:none;"><br><br>
                    <input class="shadow" type="text" name="yearMovieUpdate" placeholder="Ano de Lançamento Atualizar" style="width: 15rem; height:3rem; border-radius:0.5rem; border:none;"><br><br>
                    <button class="btn btn-primary">Atualizar</button>
                </form>
            </div>

        </div>

        <script src="js/script.js"></script>
    </body>
    </html>