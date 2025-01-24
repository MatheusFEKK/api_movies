<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="searchMovie" style="padding:5rem;">
            <h6>Procurar Filme</h6>
            <form action="" method="GET">
                <input class="shadow" type="text" placeholder="Nome do Filme" name="searchMovieId" style="width:15rem; height:3rem; border-radius: 0.3rem; border:none;">
                <button class="btn btn-primary" name="searchButton">Pesquisar</button>
            </form>
        <div class="container d-flex justify-content-center gap-3">

                <div class="insertMovie">
                    <form action="" method="POST">
                        <h6>Cadastrar Filme</h6>
                        <input class="shadow" type="text" name="nameMovie" placeholder="Nome do Filme" style="width: 15rem; height:3rem; border-radius: 0.5rem; border:none;"><br><br>
                        <input class="shadow" type="text" name="genreMovie" placeholder="Genero do Filme" style="width: 15rem; height:3rem; border-radius: 0.5rem; border:none;"><br><br>
                        <input class="shadow" type="text" name="yearMovie" placeholder="Ano de Lançamento" style="width: 15rem; height:3rem; border-radius: 0.5rem; border:none;"><br><br>
                        <button class="btn btn-primary float-end">Inserir</button>
                    </form>
                </div>

           

        </div>

    </body>
    </html>

<?php

    require_once'models/filmeModel.php';

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $filmes = filmeModel::getAll();
            echo '<div style="width:20rem;"><table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nome do Filme</th>
      <th scope="col">Genero do Filme</th>
      <th scope="col">Ano de Lançamento</th>
      <th scope="col">Modificações</th>
    </tr>
  </thead>
  <tbody>';
            foreach ($filmes as $index => $movies)
            {
                echo '
                    <tr>
                    <th scope="row">'.$movies['id'].'</th>
                    <td>'.$movies['titulo'].'</td>
                    <td>'.$movies['genero'].'</td>
                    <td>'.$movies['ano'].'</td>
                    <td><a class="btn btn-primary" href="index.php?editMovie='.$movies['id'].'">EDITAR</a>
                    <a class="btn btn-danger"  href="index.php?removeMovie='.$movies['id'].'">REMOVER</a></td>
                    </tr>
                ';
            }
            echo '</tbody>
</table></div>';



            if (isset($_GET['editMovie']))
            {
                $movie = $_GET['editMovie'];
                $response = filmeModel::getSpecific($movie);
                echo '<div class="updateMovie">
                <form action="" method="POST">
                    <h6>Atualizar Filme</h6>
                    <input class="shadow"  value="'.$response['id'].'" type="text" name="idAtualizar" placeholder="ID do Filme" style="width: 15rem; height:3rem; border-radius:0.5rem; border:none;" readonly><br><br>
                    <input class="shadow"  value="'.$response['titulo'].'" type="text" name="nameMovieUpdate" placeholder="Titulo Atualizar" style="width: 15rem; height:3rem; border-radius:0.5rem; border:none;"><br><br>
                    <input class="shadow"  value="'.$response['genero'].'" type="text" name="genreMovieUpdate" placeholder="Genero Atualizar" style="width: 15rem; height:3rem; border-radius:0.5rem; border:none;"><br><br>
                    <input class="shadow"  value="'.$response['ano'].'" type="text" name="yearMovieUpdate" placeholder="Ano de Lançamento Atualizar" style="width: 15rem; height:3rem; border-radius:0.5rem; border:none;"><br><br>
                    <button class="btn btn-primary">Atualizar</button>
                </form>
            </div>';
                return;
            }
            
            elseif (isset($_GET['removeMovie']))
            {
                if (filmeModel::deleteMovie($_GET['removeMovie']))
                {
                    echo 'Deleted with success';
                    header('Location: index.php');
                }else {
                    http_response_code(500);
                    echo 'Error trying delete the movie';
                }
            }

            elseif (isset($_GET['searchButton']))
            {
                $response = filmeModel::getSpecific($_GET['searchMovieId']);
                if (!$response){
                    echo 'Movie not founded in the database!';
                    
                }else {
                    echo 'Retorno da pesquisa por ID: '.$_GET['searchMovieId'];
                    echo '<div>Nome do Filme: '. $response['titulo'].'<br>Genero do Filme: '.$response['genero']. '<br>Ano de Lançamento: '.$response['ano'];
                }
            } 

            break;
        case 'POST':
                if (isset($_POST['nameMovie'], $_POST['genreMovie'], $_POST['yearMovie']))
                {
                    if (filmeModel::registerMovie($_POST['nameMovie'], $_POST['genreMovie'], $_POST['yearMovie']))
                    {
                        http_response_code(201);
                        echo 'Acquired with success';
                        header('Location: index.php');
                    }else {
                        http_response_code(400);
                        echo 'Error occured trying to register the Movie';
                    }
                }else {
                http_response_code(400);
                echo 'The data offered is incorrect';
            }

            if (isset($_POST['idAtualizar'], $_POST['nameMovieUpdate'], $_POST['genreMovieUpdate'], $_POST['yearMovieUpdate']))
            {
                if (filmeModel::updateMovie($_POST['idAtualizar'], $_POST['nameMovieUpdate'], $_POST['genreMovieUpdate'], $_POST['yearMovieUpdate']))
                {
                    echo 'Movie updated with success';
                    header('Location: index.php');
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
        
        default:
            http_response_code(405);
            echo 'Method not allowed';
            break;
    }
    ?>