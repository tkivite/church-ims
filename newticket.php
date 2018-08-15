 <?php

     require_once 'vendor/autoload.php';
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('auto_detect_line_endings', true);


use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://localhost:3000/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);


$payload = '{"Email":"tkivite@gmail.com","Password":"Password123$$"}';
$response = $client->post('users/authenticate', [
  'debug' => TRUE,
  'body' => $payload,
  'headers' => [
    'Content-Type' => 'application/json',
  ]
]);
$body = $response->getBody();
//print_r(json_decode((string) $body));
echo "<table><tr><th>Name</th><th>Value</th></tr>";
foreach ($response->getHeaders() as $name => $values) {
    echo "<tr><td>".$name . "</td><td>" . implode(', ', $values) . "</td></tr>";
}

echo "</table>";

echo "<table><tr><th>Name</th><th>Value</th></tr>";
$obj = json_decode($body);
foreach($obj as $name => $values){
    
    


    echo "<tr><td>".$name . "</td><td>" . $values . "</td></tr>";
}

echo "</table>";


//print_r(json_decode($body));



/*
$response = $client->get('https://api.github.com/');

if ($response->hasHeader('Content-Length')) {
    echo "It exists";
}

// Get a header from the response.
echo $response->getHeader('Content-Length');

// Get all of the response headers.


$body = $response->getBody();
// Implicitly cast the body to a string and echo it
echo $body;
// Explicitly cast the body to a string
$stringBody = (string) $body;
// Read 10 bytes from the body
$tenBytes = $body->read(10);
// Read the remaining contents of the body as a string
$remainingBytes = $body->getContents();
*/

?>