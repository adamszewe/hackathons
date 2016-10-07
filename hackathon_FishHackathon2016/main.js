/**
 *
 * Created by adam on 4/23/16.
 */


var mraa = require('mraa');
var five = require('johnny-five');
var Edison = require('edison-io');
var lcd = require ('jsupm_i2clcd');



////////////////////////////////////////////////////////////////////////
// 				COMPONENTS
////////////////////////////////////////////////////////////////////////
var board = new five.Board({
	io: new Edison()
});
//var light = new five.Light({
    //controller: "TSL2561"
    // into an I2C jack
//});
//var lcd = new five.LCD({
  //  controller: "JHD1313M3"
//});
var rotary 	= new five.Sensor("A0");
var light 	= new five.Sensor("A1");
var button      = new five.Button(2);
var alarm       = new five.Piezo(3);
var redLED      = new five.Led(6);
var greenLED    = new five.Led(7);
var blueLED     = new five.Led(8);

var display = new lcd.Jhd1313m1(0, 0x3E, 0x62);


////////////////////////////////////////////////////////////////////////
// 			global variables
////////////////////////////////////////////////////////////////////////
var fishWeight = 0;
var lightValue = 0;


function init() {
    // turn off all the leds
    redLED.stop().off();
    greenLED.stop().off();
    blueLED.stop().off();
}


board.on("ready", function() {

    init();

    board.repl.inject({
        button: button
    });


    button.on("down", function() {
        console.log("down");
    });

    button.on("hold", function() {
        console.log("hold");
        blueLED.on();
    });

    // "up" the button is released
    button.on("up", function() {
        // send the data
        blueLED.stop().off();

        // log the data
        console.log("light: " + lightValue + " weight: " + fishWeight);
        //alarm.frequency(five.Piezo.Notes.d5, 500);
    });






    light.on("change", function() {
        var value = roundNum(this.value, 1);
        lightValue = value;
        console.log("light: " + value);
    });

    rotary.scale(0, 255).on("change", function() {
		display.setCursor(0, 0);
		display.write("                ");
		var value = roundNum(this.value, 1);
        fishWeight = value;
		
		if (value > 1) {
			display.setCursor(0, 0);
			display.write(value + "" );
			console.log("weight: " + value);
		}		
	});
});





// round off output to match C example, which has 6 decimal places
function roundNum(num, decimalPlaces)
{
    var extraNum = (1 / (Math.pow(10, decimalPlaces) * 1000));
    return (Math.round((num + extraNum)
        * (Math.pow(10, decimalPlaces))) / Math.pow(10, decimalPlaces));
}


