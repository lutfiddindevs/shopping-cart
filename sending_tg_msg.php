<?php

function send_tg_msg($message) {
	$chat_id = '977895740';
	$url = 'https://api.telegram.org/bot1527145402:AAEp7sF_daSULJruolH4zr11f7OQE7o7_YY/sendMessage';

	$data = [
		'chat_id' => $chat_id,
		'text' => $message,
		'parse_mode' => 'HTML',
	];

	$options = array('http' => array(

		'method' => 'POST',
		'header' => "Content-Type:application/x-www-form-urlencoded\r\n",
		'content' => http_build_query($data)

	)
);

	$context = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
}
