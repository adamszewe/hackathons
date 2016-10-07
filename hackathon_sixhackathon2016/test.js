var greeterSource = 'contract mortal { address owner; function mortal() { owner = msg.sender; } function kill() { if (msg.sender == owner) suicide(owner); } } contract greeter is mortal { string greeting; uint32 timestamp; function greeter(string _greeting, uint32 _timestamp) public { greeting = _greeting; timestamp = _timestamp; } function greet() constant returns (uint32) { return timestamp; } }'

var greeterCompiled = web3.eth.compile.solidity(greeterSource)

var _greeting = "Hello World!"
var greeterContract = web3.eth.contract(greeterCompiled.greeter.info.abiDefinition);
var timestamp = Date.now();

var greeter = greeterContract.new(_greeting, timestamp,{from:web3.eth.accounts[0], data: greeterCompiled.greeter.code, gas: 300000}, function(e, contract){
    if(!e) {

      if(!contract.address) {
        console.log("Contract transaction send: TransactionHash: " + contract.transactionHash + " waiting to be mined...");

      } else {
        console.log("Contract mined! Address: " + contract.address);
        console.log(contract);
      }

    }
})

var abi = greeterCompiled.greeter.info.abiDefinition;


greeter.address;

var greeter = eth.contract(abi).at(greeter.address);

greeter.greet()





// contract specification
contract mortal {
    /* Define variable owner of the type address*/
    address owner;

    /* this function is executed at initialization and sets the owner of the contract */
    function mortal() { owner = msg.sender; }

    /* Function to recover the funds on the contract */
    function kill() { if (msg.sender == owner) suicide(owner); }
}

contract greeter is mortal {
    /* define variable greeting of the type string */
    string greeting;

    /* this runs when the contract is executed */
    function greeter(string _greeting) public {
        greeting = _greeting;
    }
ng 
    /* main function */
    function greet() constant returns (string) {
        return greeting;
    }
}







contract mortal {
    /* Define variable owner of the type address*/
    address owner;

    /* this function is executed at initialization and sets the owner of the contract */
    function mortal() { owner = msg.sender; }

    /* Function to recover the funds on the contract */
    function kill() { if (msg.sender == owner) suicide(owner); }
}

contract cocoa is mortal {

	/* title */
	string title;
    
	/* The date in which the contract has been created */
    uint startDate;

	/* The date in which the contract will cease to be valid */
	uint endDate;

	/* Value in bitcoins of the contract */
	string contractPrice;

	/* Correspondent value in USD at the time of creation */
	string contractUnits;




    /* constructor */
	function cocoa(string _title, uint _startDate, uint _endDate, string _contractPrice, string _contractUnits) public {
        title = _title;
        startDate = _startDate;
        endDate = _endDate;
        contractPrice = _contractPrice;
        contractUnits = _contractUnits;
	}

    /* Function to recover the funds on the contract */
    function kill() { if (msg.sender == owner) suicide(owner); }


	function getTitle() constant returns (string) { return title; }

    function getStartDate() constant returns (uint) { return startDate; }

	function getEndDate() constant returns (uint) { return endDate; }

	function getContractPrice() constant returns (string) { return contractPrice; }

	function getContractUnits() constant returns (string) { return contractUnits; }


}



















var cocoaCode = 'contract cocoa {

 /* title */ string title; /* The date in which the contract has been created */ uint32 startDate;

 /* The date in which the contract will cease to be valid */ uint32 endDate;

 /* Value in bitcoins of the contract */ string contractPrice;

 /* Correspondent value in USD at the time of creation */ string contractUnits; 

 /* constructor */ function cocoa(string title, uint32 _startDate, uint32 _endDate, string _contractPrice, string _contractUnits) { title = _title; startDate = _startDate; endDate = _endDate; contractPrice = _contractPrice; contractUnits = _contractUnits; }

 /* Function to recover the funds on the contract */ function kill() { if (msg.sender == owner) suicide(owner); } 

 function getTitle constant return (string) { return title; } function getStartDate constant return (uint32) { return startDate; } function getEndDate constant return (uint32) { return endDate; } function getContractPrice constant return (string) { return contractPrice; } function getContractUnits constant return (string) { return contractUnits; } 

 

 

}';







cocoashield(string title, uint32 _startDate, uint32 _endDate, string _contractPrice, string _contractUnits) {






/* with NodeJS              */


web3.setProvider(new web3.providers.HttpProvider('http://localhost:8545'));






var cocoaSource = 'contract mortal { /* Define variable owner of the type address*/ address owner; /* this function is executed at initialization and sets the owner of the contract */ function mortal() { owner = msg.sender; } /* Function to recover the funds on the contract */ function kill() { if (msg.sender == owner) suicide(owner); } } contract cocoa is mortal { /* title */ string title; /* The date in which the contract has been created */ uint startDate; /* The date in which the contract will cease to be valid */ uint endDate; /* Value in bitcoins of the contract */ string contractPrice; /* Correspondent value in USD at the time of creation */ string contractUnits; /* constructor */ function cocoa(string _title, uint _startDate, uint _endDate, string _contractPrice, string _contractUnits) public { title = _title; startDate = _startDate; endDate = _endDate; contractPrice = _contractPrice; contractUnits = _contractUnits; } /* Function to recover the funds on the contract */ function kill() { if (msg.sender == owner) suicide(owner); } function getTitle() constant returns (string) { return title; } function getStartDate() constant returns (uint) { return startDate; } function getEndDate() constant returns (uint) { return endDate; } function getContractPrice() constant returns (string) { return contractPrice; } function getContractUnits() constant returns (string) { return contractUnits; } }';

var cocoaCompiled = web3.eth.compile.solidity(cocoaSource)

var cocoaContract = web3.eth.contract(cocoaCompiled.cocoa.info.abiDefinition);
var timestamp = Date.now();

var cocoa = cocoaContract.new("title", timestamp, timestamp + 3600, "400", "25", {from:web3.eth.accounts[0], data: cocoaCompiled.cocoa.code, gas: 600000}, function(e, contract){
    if(!e) {

      if(!contract.address) {
        console.log("Contract transaction send: TransactionHash: " + contract.transactionHash + " waiting to be mined...");

      } else {
        console.log("Contract mined! Address: " + contract.address);
        console.log(contract);		
      }

    }
})



var abi = cocoaCompiled.cocoa.info.abiDefinition;
cocoa.address;



var cocoa2 = eth.contract(abi).at(cocoa.address);

















var cocoa = cocoaContract.new("title", timestamp, timestamp + 3600, "400", "25", {from:web3.eth.accounts[0], data: cocoaCompiled.cocoa.code, gas: 600000}, function(e, contract){
    if(!e) {

      if(!contract.address) {
        console.log("Contract transaction send: TransactionHash: " + contract.transactionHash + " waiting to be mined...");

      } else {


        console.log("Contract mined! Address: " + contract.address);
        console.log(contract);

		var abi = cocoaCompiled.cocoa.info.abiDefinition;
		var cocoa2 = eth.contract(abi).at(cocoa.address);
		
		console.log(cocoa2.getTitle());
		cocoa2.getContractPrice();
		
      }

    }
})


