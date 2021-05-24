<?php
//pripojeni do db na serveru eso.vse.cz
//TODO v následujícím řádku uveďte vlastní jméno a heslo k DB
$db = new PDO('mysql:host=127.0.0.1;dbname=garo01;charset=utf8', 'garo01', 'Eishaequoongee7Aoz');

//vyhazuje vyjimky v pripade neplatneho SQL vyrazu
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
