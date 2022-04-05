<?php
namespace App\Http\Helpers;

    class Helper { 


	public static function exchange_rates($currency){

		
	// set API Endpoint and API key
	$endpoint = 'latest';
	$access_key = env('EXCHANGERATE_API');

	// Initialize CURL:
	$ch = curl_init('http://api.exchangeratesapi.io/v1/'.$endpoint.'?base=EUR&symbols=USD,RON&access_key='.$access_key.'');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Store the data:
	$json = curl_exec($ch);
	curl_close($ch);

	// Decode JSON response:
	$exchangeRates = json_decode($json, true);
    

	// Access the exchange rate values, e.g. GBP:
	return $exchangeRates['rates'][$currency];
	


}
}
?>