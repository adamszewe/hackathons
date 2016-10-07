/**
 *
 * Created by adam on 5/15/16.
 */




//Install mqtt library using: npm install mqtt
var mqtt = require('mqtt');

var relayrClient = mqtt.connect({
    servers:[{'host':'mqtt.relayr.io'}],
    username: "1966236f-27fc-411b-a664-b9e06635de34",
    password: "BuoPzfv3X37f",
    clientId: "TGWYjbyf8QRumZLngZjXeNA",
    protocol : 'mqtts'
});


relayrClient.on('connect', function() {

    //subscribe to commands sent from the dashboard or other clients
    relayrClient.subscribe("/v1/1966236f-27fc-411b-a664-b9e06635de34/cmd");

    relayrClient.on('message', function(topic, message) {
    });

    //simple timer to send a message every 1 second
    var publisher = setInterval(function(){

        // publish a message to a topic
        var data = JSON.stringify({meaning:"someMeaning", value: "30"});

        // relayrClient.publish("/v1/1966236f-27fc-411b-a664-b9e06635de34/data", data, function() {
        
        relayrClient.publish("/v1/61fb5386-91f1-4f38-9a7c-307cf5e50816/data", data, function() {
            
        });

    }, 1000);

});


