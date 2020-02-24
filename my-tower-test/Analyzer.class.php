 <?php

class Analyzer{
   
    public function get_continent($ip){
        set_time_limit ( 3000 );
         $ip = $ip;
        
        $access_key = '0ef169b8acee5692396838ba4efb3ba4';
        $ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch); 

curl_close($ch);

// Decode JSON response:
$api_result = json_decode($json, true);
// die(print_r($api_result));
$continent = $api_result['continent_name'];
return $continent;



    

    
  

    
}
}
