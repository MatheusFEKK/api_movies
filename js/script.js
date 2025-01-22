function searchMovie()
{
    let ajaxRequest = new XMLHttpRequest();
    let inputSearch = document.getElementById('searchMovieId').value
    let divResult   = document.getElementById('result');

    ajaxRequest.open('GET','index.php?searchMovieId='+inputSearch, false);
    ajaxRequest.send(null);

    divResult.innerHTML = ajaxRequest.response
};