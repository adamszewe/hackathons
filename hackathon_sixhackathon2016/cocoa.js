/*
 * @author Adam Szewera
 */
var express = require('express');
var http = require('http');
var app = new express();

var DEFAULT_DURATION = 600; // 600 seconds, 10 minutes



app.get('/', function (req, res) {
    res.send('Hello World!');
});

app.get('/getContract', function (req, res) {

    /* connection */
    var hostAddress = "http://localhost:8546";
    var Web3 = require('web3');
    var web3 = new Web3(new Web3.providers.HttpProvider(hostAddress));

    var contract = JSON.parse(req.query.contract);

    var title = contract.title || "CocoaShield - Contract";
    var startDate = contract.startDate || Date.now();
    var endDate = contract.endDate || (Date.now() + DEFAULT_DURATION);
    var contractUnits = contract.contractUnits || 0;

	// todo check if the end date is higher than the start date




    //console.log("bitcoin price is: " + getBitcoinPrice());
    console.log(title);
    console.log(startDate);
    console.log(endDate);
    console.log(contractUnits);




    /* source code of the contract */
    var cocoaSource = 'contract mortal { /* Define variable owner of the type address*/ address owner; /* this function is executed at initialization and sets the owner of the contract */ function mortal() { owner = msg.sender; } /* Function to recover the funds on the contract */ function kill() { if (msg.sender == owner) suicide(owner); } } contract cocoa is mortal { /* title */ string title; /* The date in which the contract has been created */ uint startDate; /* The date in which the contract will cease to be valid */ uint endDate; /* Value in bitcoins of the contract */ string contractPrice; /* Correspondent value in USD at the time of creation */ string contractUnits; /* constructor */ function cocoa(string _title, uint _startDate, uint _endDate, string _contractPrice, string _contractUnits) public { title = _title; startDate = _startDate; endDate = _endDate; contractPrice = _contractPrice; contractUnits = _contractUnits; } /* Function to recover the funds on the contract */ function kill() { if (msg.sender == owner) suicide(owner); } function getTitle() constant returns (string) { return title; } function getStartDate() constant returns (uint) { return startDate; } function getEndDate() constant returns (uint) { return endDate; } function getContractPrice() constant returns (string) { return contractPrice; } function getContractUnits() constant returns (string) { return contractUnits; } }';
    var cocoaCompiled = web3.eth.compile.solidity(cocoaSource)
    //var cocoaContract = web3.eth.contract(cocoaCompiled.cocoa.info.abiDefinition);
    var bitcoinUSDValue = getBitcoinPrice();



    var cocoaContract = web3.eth.contract(cocoaCompiled.cocoa.info.abiDefinition);
    var cocoa = cocoaContract.new(title, startDate, endDate, bitcoinUSDValue, bitcoinUSDValue, {from:web3.eth.accounts[0], data: cocoaCompiled.cocoa.code, gas: 900000}, function(e, blockchainContract){
        if(!e) {
            if(!blockchainContract.address) {
                console.log("Contract transaction send: TransactionHash: " + blockchainContract.transactionHash + " waiting to be mined...");
            } else {

                console.log("----------Contract mined! Address: " + blockchainContract.address);
                console.log(blockchainContract);

                var abi = cocoaCompiled.cocoa.info.abiDefinition;
                var cocoa2 = web3.eth.contract(abi).at(cocoa.address);


		

                var resultContract = {
			"abi" : abi,
			"address" : cocoa.address,
			"startDate" : startDate,
			"endDate" : endDate,
			"bitcoinValue" : bitcoinUSDValue
		}

                res.send(resultContract);
            }
        }
    })

});


app.listen(8080, function () {
    console.log('listening on 8080');
});









/* get the price of bitcoin */
function getBitcoinPrice() {
    var bitcoinPrice = http.get({
            host: 'api.coindesk.com',
            path: '/v1/bpi/currentprice.json'
        },
        function(response) {
            // Continuously update stream with data
            var body = '';
            response.on('data', function(d) { body += d; });
            response.on('end', function() {

                // Data reception is done, do whatever with it!
                var parsed = JSON.parse(body);
                console.log(parsed.bpi.USD.rate);
            });
        }
    );
    return bitcoinPrice;
}

