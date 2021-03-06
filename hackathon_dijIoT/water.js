var groovewater = require('jsupm_grovewater');
var groveMotorDriver_lib = require('jsupm_grovemd'); 

var i2c_addr1 = 15; // set address of board 1 to 15, or 1111 on the switches 
var waterPump = new groveMotorDriver_lib.GroveMD(
    groveMotorDriver_lib.GROVEMD_I2C_BUS,
    i2c_addr1
);
var gw = new groovewater.GroveWater(2);

//console.log(grooveWaterSensor.isWet());
//


function readWaterState() {
	if (gw.isWet()) {
		console.log('is wet');
        waterPump.setMotorDirections(groveMotorDriver_lib.GroveMD.DIR_CCW, groveMotorDriver_lib.GroveMD.DIR_CW); //set the directions of the motors on board 1
		waterPump.setMotorSpeeds(64, 0); //set the speeds of the motors on board 1
	} else {
		console.log('is not wet');
		waterPump.setMotorSpeeds(0, 0); //set the speeds of the motors on board 1

	}
}
setInterval(readWaterState, 1000);





process.on('SIGINT', function() {
	console.log('Exiting...');
	process.exit(0);
});

