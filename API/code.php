<?php
$('form').submit function (e) {
    e.preventDefault();

    var searchInput = $('#search');
    var searchTerm = searchInput.val();
    var submitButton = $('#submit');

    submitButton.prop('disabled', true).val("Loading");
    searchInput.prop('disabled', true);

     // the AJAX part
     var movieAPI = "http://www.omdbapi.com/?";
     var movieOptions = {
         s: searchTerm
     };
     function displayMovies(data) {
         if($.isEmptyObject(data)) {
             $('#details').html('<li>' + searchTerm + 'is not a valid search term! </li>');
             submitButton.prop('disabled', false).val("Search");
       searchInput.prop('disabled', false);
         } else {
             var listHTML = '<ul>';
             $.each(data.search, function(i,movie) {
                 listHTML += '<li>' + movie.Title + '</li>'
             }); // end each
             listHTML += '</ul>';
             $('#details').html(listHTML);
             submitButton.prop('disabled', false).val("Search");
       searchInput.prop('disabled', false);
         }
     }
     $.getJSON(movieAPI, movieOptions, displayMovies);
 });
?> // end click
