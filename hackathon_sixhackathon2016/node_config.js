
if (eth.accounts.length === undefined) {
	personal.newAccount()
	// prompt for the password
} 

console.log(eth.accounts[0]);
