/**
 *
 * Created by adam on 5/15/16.
 */



////////////////////////////////////////////////////////////////////////
// 				Dependencies & configuration
////////////////////////////////////////////////////////////////////////
var UPDATE_INTERVAL = 5000;

var fs = require('fs');
var util = require('util');
var mraa = require('mraa');
var five = require('johnny-five');
var Edison = require('edison-io');
var mqtt = require('mqtt');

var config = require('/usr/lib/node_modules/iotkit-agent/data/device.json'); // iotkit-agent config file location
topic = util.format('server/metric/%s/%s', config.account_id, config.device_id);
topic_control = util.format('device/%s/control', config.device_id);
ca_certs = ["/usr/lib/node_modules/iotkit-agent/certs/AddTrust_External_Root.pem"]; // default CA cert location

var relayrClient = mqtt.connect({
    servers: [{'host': 'mqtt.relayr.io'}],
    username: "1966236f-27fc-411b-a664-b9e06635de34",
    password: "BuoPzfv3X37f",
    clientId: "TGWYjbyf8QRumZLngZjXeNA",
    protocol: 'mqtts'
});

relayrClient.on('connect', function () {
        // fixme - empty
});


////////////////////////////////////////////////////////////////////////
// 				    Hardware components
////////////////////////////////////////////////////////////////////////
var board = new five.Board({
    io: new Edison()
});

// input
var lightSensor = new five.Sensor("A0");
var temperatureSensor = new five.Temperature({pin: "A1", controller: "GROVE"});
var moistureSensor = new five.Sensor("A2");

var enableiotConfig = {
    servers: [{'host': 'broker.us.enableiot.com'}],
    username: config.device_id,
    password: config.device_token,
    clientId: config.account_id,
    protocol: 'mqtts'
};
var client = mqtt.connect(enableiotConfig);


board.on("ready", function () {
    console.log("ready...");
});


var compTemp = config.sensor_list.filter(function (obj) {
    return obj.name === "temp";
})[0];
var compLight = config.sensor_list.filter(function (obj) {
    return obj.name === "light";
})[0];
var compMoisture = config.sensor_list.filter(function (obj) {
    return obj.name === "moisture";
})[0];
var compDustConcentration = config.sensor_list.filter(function (obj) {
    return obj.name === "dustconcentration";
})[0];



client.on('connect', function () {


    client.subscribe('server/metric/25c983e5-a43d-43dc-8671-0d410abff308/02-00-86-66-6b-70');

    client.on('message', function (topic, message) {
        console.log(message);
    });

    //simple timer to send a message every 1 second
    var publisher = setInterval(function () {
        var now = (new Date).getTime();

        var msg = {
            "accountId": config.account_id,
            "did": config.device_id,
            "on": now,
            "count": 1,
            "data": [
                {
                    "on": now,
                    "value": temperatureSensor.celsius,
                    "cid": compTemp.cid
                },
                {
                    "on": now,
                    "value": lightSensor.value,
                    "cid": compLight.cid
                },
                {
                    "on": now,
                    "value": moistureSensor.value,
                    "cid": compMoisture.cid
                }
            ]
        };



        fs.appendFile('/home/root/datacsv.csv', msg.data, function (err) {
        });

        if (moistureSensor.value < 200) {
            var data = JSON.stringify(
                {
                    path: "main", 
                    meaning: "hydrate", 
                    value: "node1"
                }
            );
            
            relayrClient.publish(
                "/v1/1966236f-27fc-411b-a664-b9e06635de34/cmd",
                data, function () {
                    
                }
            );
        }

        client.publish(topic, JSON.stringify(msg), function () {
            console.log("Observation is submitted");
        });

    }, UPDATE_INTERVAL);
});


process.on('SIGINT', function () {
    console.log('Exiting...');
    process.exit(0);
});



