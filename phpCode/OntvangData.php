<?php
$host = "0.0.0.0"; // Luistert naar alle inkomende IP's
$port = 12345;     // Poortnummer instellen waarop het apparaat data stuurt

// Creeër een socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, $host, $port);
socket_listen($socket);

echo "Server luistert op $host:$port\n";

while (true) {
    $client = socket_accept($socket);
    $data = socket_read($client, 1024); // Ontvang maximaal 1024 bytes per bericht

    if ($data) {
        // Pars de data en sla deze op in de database
        $parsedData = parseMessage($data);
        storeInDatabase($parsedData);
    }

    socket_close($client);
}

socket_close($socket);

// Functie om een bericht te parsen op basis van het protocol
function parseMessage($data) {
    $header = substr($data, 0, 2);
    $properties = substr($data, 2, 2);
    $length = hexdec(substr($data, 4, 4));
    $checksum = substr($data, 8, 4);
    $sequenceId = substr($data, 12, 4);
    $messageBody = substr($data, 16);

    // Andere parsing-logica volgens het protocol
    return [
        'header' => $header,
        'properties' => $properties,
        'length' => $length,
        'sequence_id' => $sequenceId,
        'message_body' => $messageBody,
    ];
}

// Functie om data op te slaan in de database
function storeInDatabase($parsedData) {
    $pdo = new PDO("mysql:host=localhost;dbname=sos_database", "username", "password");
    $stmt = $pdo->prepare("INSERT INTO sos_data (header, properties, length, sequence_id, message_body) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $parsedData['header'],
        $parsedData['properties'],
        $parsedData['length'],
        $parsedData['sequence_id'],
        $parsedData['message_body'],
    ]);
}
?>
