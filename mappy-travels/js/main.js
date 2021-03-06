/**
 * the user variable is available to any piece of javascript in the application
 *
 * It's data can be used in any html template by using the mustache syntax, eg {{name}} in a piece of html
 *
 * The data will be fetched and stored in the user variable during login. Here is an example of the data available
 */
var user = {name:"Bob", xp:250,
    routes:[
        {origin:{"stopName":"Central Station Forecourt","lat":55.86051,"lng":-4.2580399999999},
            destination:{"stopName":"Broomlea School","lat":55.87402,"lng":-4.32318},
            name:"Work",
            xp:250},
        {origin:{stopName:"Broomlea School",lat:55.87402,lng:-4.32318},
            destination:{stopName:"Xscape Centre",lat:55.87792,lng:-4.37264},
            name:"Laser tag",
            xp:250}]
};


/**
 document ready in JQuery is like window on load in JS - it tells you when everything's ready to go
 *
 * This is the point of entry for our application, like a main method in Java
 */
$('document').ready(function(){

    /**
     * To load a template for testing, comment out the ajax call and load your template instead.
     *
     * (eg loadTemplate('
     */

    //we start by checking if the user is already logged in
    $.ajax({url: 'php/signin.php', success: function(response){
        if (response.username){// login was successful
            user.name = response.username;
            user.routes = response.routes;
            user.xp = parseInt(response.xp);
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
		var colorFlag = true;
		for (var i in user.routes) {
			if (colorFlag) {
				user.routes[i].colorValue = function () {
					return "mdl-color--white";
				}
			} 
			else {
				user.routes[i].colorValue = function () {
					return "mdl-color--grey-100";
				}
			}
			colorFlag = !colorFlag;
		}
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


function loadPrizesPage(){
    console.log("loading prizes");

    request = $.ajax({
        url: "php/prizes.php",
        type: "post",
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        if(response.prizes){
            var prizes = JSON.parse(response.prizes);
            var prizesToUsers = JSON.parse(response.ptu);
            showTemplate(prizes, prizesToUsers, user);
        }
        else{
            $('#error-message').html(response.msg);
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        //Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown, jqXHR
        );

    });
}

function showTemplate(prizes, prizesToUsers, user){
    var bindingObject = {prizes: prizes};
    bindingObject.userXP = user.xp;
    console.log(prizes);
    console.log(bindingObject);
    var prizesLength = prizes.length;
    var ptuLength =  prizesToUsers.length;
	var item1 = true;
    for (var i = 0; i < prizesLength; i++){
        prizes[i].redeemed = false;
        prizes[i].PrizeName = toTitleCase(prizes[i].PrizeName)  ;
        prizes[i]["PrizePic"] = 'data:image/jpeg;base64,' + hexToBase64(prizes[i]["PrizePic"]);
        if(ptuLength > 0){
            for(var j = 0; j < ptuLength; j++){
                if (prizes[i]["id"] === prizesToUsers[j]["PrizeID"]){
                    prizes[i].redeemed = true;
                }
            }
        }
        if (!prizes[i].redeemed){
            prizes[i].redeemed = false;
        }
        prizes[i].canRedeem = function(){
            return (this.PointsRequired <= bindingObject.userXP);
        };
		if (item1) {
				prizes[i].colorValue = function(){
					return "mdl-color--white";
				};
			}
		else {
				prizes[i].colorValue = function(){
					return "mdl-color--grey-100";
				};
			}
		item1 = !item1;
    }
    bindingObject.paste = function(){
        return JSON.stringify(this);
    };
    bindingObject.xpPercentage = function(){
        var percentage = (user.xp/1000)*100;
        if (percentage > 100){
            percentage = 100;
        }
        return percentage;
    };
    //Do template binding
    $.get( 'templates/prizes.template.html', function( template ) {
        //use mustache to bind the template and data
        var html = Mustache.to_html(template, bindingObject);
        //insert the resulting html in the element with id="page-content"
        $('#page-content').html(html);

        /**
         * Now load the scripts into the scripts div
         */
        $.get( 'templates/prizes.scripts.html', function( template ) {
            var scripts = Mustache.to_html(template, bindingObject);
            $('#scripts').html(scripts);
        })
            .fail(function(){
                console.error("Error in call to loadTemplate(): couldn't find prizes.scripts.html");
                $('#scripts').html('');
            });
    });
}

function hexToBase64(str) {
    return btoa(String.fromCharCode.apply(null, str.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" ")));
}

function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}