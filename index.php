<?php
	require_once("config.php");
	use Shorturl\Classes\Shorter;
	// я работал на локалке поэтому указал домен прямо вот так
	// если надо могу доработать
	$domain = 'sandbox/shorturl/';

	// создаем объект класса шортер
	$shortlink = new Shorter();

	// проверяем получение параметра url и не пустой ли он.
	if (isset($_POST['url'])&& !empty($_POST['url'])) {
		// отправляю ссылку в ф-цию шорт которая вернёт мне код.
		// прикрепляю код к своему домену для вывода на экран
		$url = "http://".$domain . $shortlink->short($_POST['url']);
	}elseif(isset($_GET['x'])&&!empty($_GET['x'])){
		// если был передан гет параметр x это значит перешли по нашей укороченной ссылке и поэтому перенаправляем
		// на сохранённую в бд ссылку по этому коду
		$full_url = str_replace("\"","",$shortlink->findByCode($_GET['x']));
		header('Location: '.$full_url);
	}else{
		// чтобы при запуске или если урл пустой не получить ошибку выводим это:
		$url="Ссылка не введена!";
	}

	//	Просто для теста можно один раз раскрыть комментарии
	//	$tablename = "url";
	//	$column = "`id` INT(11) NOT NULL AUTO_INCREMENT , `full_url` VARCHAR(100) CHARACTER SET utf8 NOT NULL , `short_url` VARCHAR(10) CHARACTER SET utf8 NOT NULL , PRIMARY KEY (`id`)";
	//	$shortlink->createTable($tablename, $column);

?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="ajax.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title>Hello, world!</title>
</head>
<body>
<h1>Введите свой урл чтобы его укоротить!</h1>
<form class="form-inline" method="post" id="ajax_form" action="index.php">
	<input class="form-control mr-sm-2" name="url" type="search" placeholder="Enter your url here" autocomplete="off" aria-label="Short">
	<button class="btn btn-outline-success my-2 my-sm-0" id="btn" type="submit">Short</button>
</form>

<div id="result_form"><p> Ваша короткая ссылка:<a href="<?=$url;?>" target="_blank"> <?=$url;?> </a></p></div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<?php
	?>



