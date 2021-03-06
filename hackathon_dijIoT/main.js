/**
 * Created by adam on 5/15/16.
 */

/*
 * Central station:
 *      stepper
 *      pump
 *      water sensor
 *      light sensor
 *      temperature sensor
 *      UV sensor
 *      
 *      channel subscription
 *
 */



////////////////////////////////////////////////////////////////////////
// 				Dependencies & configuration
////////////////////////////////////////////////////////////////////////
var UPDATE_INTERVAL = 5000;

var util = require('util');
var mraa = require('mraa');
var five = require('johnny-five');
var Edison = require('edison-io');
var mqtt = require('mqtt');
var groveMotorDriver_lib = require('jsupm_grovemd');
var grooveWaterLib = require('jsupm_grovewater');
var Uln200xa_lib = require('jsupm_uln200xa');

var config = require('/usr/lib/node_modules/iotkit-agent/data/device.json'); // iotkit-agent config file location
topic = util.format('server/metric/%s/%s', config.account_id, config.device_id);
topic_control = util.format('device/%s/control', config.device_id);
ca_certs = ["/usr/lib/node_modules/iotkit-agent/certs/AddTrust_External_Root.pem"]; // default CA cert location

var enableiotConfig = {
    servers: [{'host': 'broker.us.enableiot.com'}],
    username: config.device_id,
    password: config.device_token,
    clientId: config.account_id,
    protocol: 'mqtts'
};
var client = mqtt.connect(enableiotConfig);


////////////////////////////////////////////////////////////////////////
// 				    Hardware components
////////////////////////////////////////////////////////////////////////
var board = new five.Board({
    io: new Edison()
});

// input
var lightSensor = new five.Sensor("A0");
var temperatureSensor = new five.Temperature({pin: "A1", controller: "GROVE"});
var grooveWaterSensor = new grooveWaterLib.GroveWater(2);
var myUln200xa_obj = new Uln200xa_lib.ULN200XA(4096, 3, 4, 5, 6);

// output
var yellowLED = new five.Led(7);
var greenLED = new five.Led(8);

var i2c_addr1 = 15; // set address of board 1 to 15, or 1111 on the switches 
var waterPump = new groveMotorDriver_lib.GroveMD(
    groveMotorDriver_lib.GROVEMD_I2C_BUS,
    i2c_addr1
);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                          Stepper Motor
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
myUln200xa_obj.goForward = function () {
    myUln200xa_obj.setSpeed(5); // 5 RPMs
    myUln200xa_obj.setDirection(Uln200xa_lib.ULN200XA.DIR_CW);
    myUln200xa_obj.stepperSteps(1024);
};

myUln200xa_obj.reverseDirection = function () {
    myUln200xa_obj.setDirection(Uln200xa_lib.ULN200XA.DIR_CCW);
    myUln200xa_obj.stepperSteps(1024);
};

myUln200xa_obj.stop = function () {
    myUln200xa_obj.release();
};

myUln200xa_obj.quit = function () {
    myUln200xa_obj = null;
    Uln200xa_lib.cleanUp();
    Uln200xa_lib = null;
    console.log("Exiting");
    process.exit(0);
};


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                          utils
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
board.on("ready", function () {

    // turn off all the leds
    yellowLED.stop().off();
    greenLED.stop().off();

    yellowLED.on();
});


////////////////////////////////////////////////////////////////////////
// 				relayr.io - update
////////////////////////////////////////////////////////////////////////
client.on('message', function (topic, message) {
    console.log(topic);
    console.log(message);
    var jsonMessage = JSON.parse(message);
    console.log(jsonMessage);


});


var compTemp = config.sensor_list.filter(function (obj) {
    return obj.name === "temp";
})[0];
var compLight = config.sensor_list.filter(function (obj) {
    return obj.name === "light";
})[0];

var compYellowLED = config.sensor_list.filter(function (obj) {
    return obj.name === "yellowled";
})[0];
var compGreenLED = config.sensor_list.filter(function (obj) {
    return obj.name === "greenled";
})[0];


console.log('topic: ' + topic);

client.on('connect', function () {

    setInterval(function() {


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
            ]
        };
        
        client.publish(topic, JSON.stringify(msg), function () {
            console.log("Observation is submitted");
        });


    }, UPDATE_INTERVAL);
    

});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                      Water Sensor & pump control
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function waterLoop() {
    // fixme which pump should we activate ?

    
    if (grooveWaterSensor.isWet()) {
        waterPump.setMotorDirections(groveMotorDriver_lib.GroveMD.DIR_CCW, groveMotorDriver_lib.GroveMD.DIR_CW); 
        waterPump.setMotorSpeeds(120, 0); 
    } else {
        waterPump.setMotorSpeeds(0, 0); 
        console.log("water pump stop");
    }
}


// myUln200xa_obj.goForward();
// Run ULN200xa driven stepper
// myUln200xa_obj.goForward();
// setTimeout(myUln200xa_obj.reverseDirection, 2000);
// setTimeout(function() {
//     myUln200xa_obj.stop();
//     myUln200xa_obj.quit();
// }, 2000);


process.on('SIGINT', function () {
    console.log('Exiting...');
    process.exit(0);
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                      Relayr Part :D
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


var relayrClient = mqtt.connect({
    servers: [{'host': 'mqtt.relayr.io'}],
    username: "1966236f-27fc-411b-a664-b9e06635de34",
    password: "BuoPzfv3X37f",
    clientId: "TGWYjbyf8QRumZLngZjXeNA",
    protocol: 'mqtts'
});

relayrClient.subscribe("/v1/1966236f-27fc-411b-a664-b9e06635de34/cmd");





relayrClient.on('message', function (topic, message) {
    var jsonMessage = JSON.parse(message);
    console.log(jsonMessage);

    if (jsonMessage != undefined && jsonMessage.meaning != undefined && jsonMessage.meaning === 'hydrate') {
        
        if (jsonMessage.value != undefined && jsonMessage.value === 'node1') {
            // host 1 
            
            waterThis();
            
            
        } else if (jsonMessage.value != undefined && jsonMessage.value === 'node2') {
           // node 2 
            
        }
    } else {

        yellowLED.stop().off();
        myUln200xa_obj.stop();
        waterPump.setMotorSpeeds(0, 0); 
        
    }
    
    
    
    
    
});

relayrClient.on('connect', function () {

    var publisher = setInterval(function () {
        var data = JSON.stringify({meaning: "someMeaning", value: "r5"});
        // fixme - does nothing
    }, 1000);
});



function waterThis() {

    yellowLED.on();
    yellowLED.blink(500);

    // todo turn the stepper motor by 90
    myUln200xa_obj.goForward();
    
    // transfer the water
    waterLoop();
    // stop the pump
    
    // turn the stepper backwards
    myUln200xa_obj.reverseDirection();
    
    // turn off the led
    yellowLED.stop().off();
    
}


