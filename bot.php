$tokenbot = $Hook['env']['tokenbot'];
$endpoint = "https://api.telegram.org/bot$tokenbot/";

$messages = $Hook["params"];
if (isset($messages['message'])) {
$messages = $messages['message'];
} else {
echo 'URL hook.io: https://'.$Hook['input']['host'].$Hook['input']['path'];
}
// ngucapin selamat datang member baru
if (isset($messages['new_chat_member'])) {
$pesan = "Hai ".$messages['new_chat_member']['first_name']."!\n";
$pesan.= "Selamat datang di Grup ".$messages['chat']['title'];
kirimPesan($messages['chat']['id'], $pesan);
}

// ngucapin selamat tinggal buat user yang pergi
// HANYA jika telegram mengirimkan signal left member
if (isset($messages['left_chat_member'])) {
$pesan = "Sampai jumpa lagi ".$messages['left_chat_member']['first_name'] ;
kirimPesan($messages['chat']['id'], $pesan);
}

// fungsi Kirim Pesan
function kirimPesan($chat_id, $text)
{
global $endpoint;
$data = array(
'chat_id' => $chat_id,
'text' => $text
);

// Buat parameter pengiriman
$options = array(
'http' => array(
'header' => "Content-type: application/x-www-form-urlencoded\r\n",
'method' => 'POST',
'content' => http_build_query($data),
),
);
$context = stream_context_create($options);
$result = file_get_contents($endpoint.'sendMessage', false, $context);
return $result;
}
