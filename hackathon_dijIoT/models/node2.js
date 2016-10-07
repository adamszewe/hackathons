/**
 * 
 * Created by adam on 5/15/16.
 */


var mqtt = require('mqtt');

var relayrClient = mqtt.connect({
    servers:[{'host':'mqtt.relayr.io'}],
    username: "61fb5386-91f1-4f38-9a7c-307cf5e50816",
    password: "p72p5nCoH-WD",
    clientId: "TYftThpHxTziafDB89eUIFg",
    protocol : 'mqtts'
});


relayrClient.on('message', function(topic, message) {
});

relayrClient.on('connect', function() {

    //subscribe to commands sent from the dashboard or other clients


    // relayrClient.subscribe("/v1/61fb5386-91f1-4f38-9a7c-307cf5e50816/cmd");
    //simple timer to send a message every 1 second
    var publisher = setInterval(function(){

        // publish a message to a topic
        var data = JSON.stringify({meaning:"someMeaning", value: "30"});

        relayrClient.publish("/v1/61fb5386-91f1-4f38-9a7c-307cf5e50816/data", data, function() {
            console.log(data);
        });

    }, 1000);

});


