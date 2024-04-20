<?php

$request = json_decode(file_get_contents('php://input'), true);
$__userName = $request['name'];
$__password = $request['password'];
$__email = $request['email'];

//тут я хотел хотел написать request class  но потом так и оставил и не использовал