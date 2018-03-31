/**
 * the user variable is available to any piece of javascript in the application
 *
 * It's data can be used in any html template by using the mustache syntax, eg {{name}} in a piece of html
 *
 * The data will be fetched and stored in the user variable during login. Here is an example of the data available
 */
var user = {name: 'bob', xp: 250,
    routes: [
        {name: "work", origin: {lat:55.4642, lng: -4.2518}, destination:{lat:55.8642, lng: -4.2418}},
        {name: "rob's house", origin: {lat:55.4642, lng: -4.2518}, destination:{lat:55.8642, lng: -4.2418}}
    ]};


/**
 document ready in JQuery is like window on load in JS - it tells you when everything's ready to go
 *
 * This is the point of entry for our application, like a main method in Java
 */
$('document').ready(function(){
    //we start by checking if the user is already logged in
    $.ajax({url: 'php/signin.php', success: function(response){
        if (response.username){// login was successful
            user.name = response.username;
            user.routes = response.routes;
            user.xp = response.xp;
            loadTemplate('home');
        }
        else {
            //not logged in this session, so redirect to login
            loadTemplate('login');
        }
    }});

});


/***This function is available globally as a standard way of loading scripts, using mustache to bind the properties of
 *  the user variable.
 *
 *  You may wish to define your own (see home.scripts.html or new-route.scripts.html)
 *
 * @param templateName - load the .template.html file & .scripts.html of this name from the templates folder
 */
function loadTemplate(templateName){
    $.get( 'templates/'+templateName+'.template.html', function( template ) {
        //use mustache to bind the template and data
        var html = Mustache.to_html(template, user);
        //insert the resulting html in the element with id="page-content"
        $('#page-content').html(html);

        /**
         * Now load the scripts into the scripts div
         */
        $.get( 'templates/'+templateName+'.scripts.html', function( template ) {
            var scripts = Mustache.to_html(template, user);
            $('#scripts').html(scripts);
        })
            .fail(function(){
            console.error("Error in call to loadTemplate(): couldn't find " + templateName+".scripts.html");
            $('#scripts').html('');
        });
    });
}
