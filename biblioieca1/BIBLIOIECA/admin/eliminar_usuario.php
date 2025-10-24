<?php
// eliminar_usuario.php
require 'supabase.php'; // Archivo donde configuras tu conexión a Supabase

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del usuario desde el formulario o la petición
    $id = $_POST['id'] ?? null;

    if (!$id) {
        echo json_encode(["error" => "Falta el ID del usuario"]);
        exit;
    }

    // Endpoint REST de Supabase (reemplaza {TU_URL_SUPABASE} y {TU_TABLA})
    $url = 'https://{TU_URL_SUPABASE}.supabase.co/rest/v1/usuarios?id=eq.' . $id;

    // Tu API key
    $apiKey = '{TU_API_KEY}';

    // Inicializar cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiKey,
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
        'Prefer: return=minimal'
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo json_encode(["error" => $error]);
    } else {
        echo json_encode(["message" => "Usuario eliminado correctamente"]);
    }
}
?>
