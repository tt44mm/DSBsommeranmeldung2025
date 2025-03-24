<?php
    $validator = new FormValidator();
    $validator->addValidation("MfirstName","req","<p>Este campo es obligatorio.</p>");
    $validator->addValidation("MlastName","req","Este campo es obligatorio.");
    $validator->addValidation("PfirstName","req","Este campo es obligatorio.");
    $validator->addValidation("PlastName","req","Este campo es obligatorio.");
    $validator->addValidation("Street","req","Este campo es obligatorio.");
    $validator->addValidation("Town","req","Este campo es obligatorio.");
    $validator->addValidation("PLZ","req","Este campo es obligatorio.");
    $validator->addValidation("Phone","req","Este campo es obligatorio.");
    $validator->addValidation("Busida","req","Este campo es obligatorio.");
    $validator->addValidation("Busvuelta","req","Este campo es obligatorio.");
    $validator->addValidation("Email1","email","Por favor, escribe una direcci&oacute;n de correo v&aacute;lida");
    $validator->addValidation("Email1","req","Este campo es obligatorio.");
    $validator->addValidation("Email2","eqelmnt=Email1","El correo electr&oacute;nico repetido tiene que ser identico con el correo electr&oacute;nico en el campo anterior");

    $validator->addValidation("nombre0","req","Este campo es obligatorio.");
    $validator->addValidation("apellidos0","req","Este campo es obligatorio.");
    $validator->addValidation("colegio0","req","Campo obligatorio");
    $validator->addValidation("nadar0","req","Este campo es obligatorio.");
    $validator->addValidation("autohinch0","req","Este campo es obligatorio.");
    $validator->addValidation("autopisci0","req","Este campo es obligatorio.");
    $validator->addValidation("idioma0","req","Este campo es obligatorio.");
    $validator->addValidation("obsidioma0","req","Este campo es obligatorio.");
    $validator->addValidation("birthdate0","req","Este campo es obligatorio.");
	$validator->addValidation("birthdate0","regexp=%^(19|20)?[\d]{2}[- /.](0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01])$%","Por favor, escribe una fecha v&aacute;lida.");
	$validator->addValidation("curso0","selmin=1","Este campo es obligatorio, marca por lo menos 1");



    if (array_key_exists('nombre1', $_POST) )
	{
		$validator->addValidation("nombre1","req","Este campo es obligatorio.");
		$validator->addValidation("apellidos1","req","Este campo es obligatorio.");
		$validator->addValidation("colegio1","req","Este campo es obligatorio.");
		$validator->addValidation("nadar1","req","Este campo es obligatorio.");
		$validator->addValidation("autohinch1","req","Este campo es obligatorio.");
		$validator->addValidation("autopisci1","req","Este campo es obligatorio.");
		$validator->addValidation("idioma1","req","Este campo es obligatorio.");
		$validator->addValidation("obsidioma1","req","Este campo es obligatorio.");
		$validator->addValidation("birthdate1","req","Este campo es obligatorio.");
		$validator->addValidation("birthdate1","regexp=%^(0?[1-9]|[12][0-9]|3[01])[- /.](0?[1-9]|1[012])[- /.](19|20)?[\d]{2}$%","Por favor, escribe una fecha v&aacute;lida.");
		$validator->addValidation("curso1","selmin=1","Este campo es obligatorio, marca por lo menos 1");
	}
    if (array_key_exists('nombre2', $_POST) )
	{
		$validator->addValidation("nombre2","req","Este campo es obligatorio.");
		$validator->addValidation("apellidos2","req","Este campo es obligatorio.");
		$validator->addValidation("colegio2","req","Este campo es obligatorio.");
		$validator->addValidation("nadar2","req","Este campo es obligatorio.");
		$validator->addValidation("autohinch2","req","Este campo es obligatorio.");
		$validator->addValidation("autopisci2","req","Este campo es obligatorio.");
		$validator->addValidation("idioma2","req","Este campo es obligatorio.");
		$validator->addValidation("obsidioma2","req","Este campo es obligatorio.");
		$validator->addValidation("birthdate2","req","Este campo es obligatorio.");
		$validator->addValidation("birthdate2","regexp=%^(0?[1-9]|[12][0-9]|3[01])[- /.](0?[1-9]|1[012])[- /.](19|20)?[\d]{2}$%","Por favor, escribe una fecha v&aacute;lida.");
		$validator->addValidation("curso2","selmin=1","Este campo es obligatorio, marca por lo menos 1");
	}
    if (array_key_exists('nombre3', $_POST) )
	{
		$validator->addValidation("nombre3","req","Este campo es obligatorio.");
		$validator->addValidation("apellidos3","req","Este campo es obligatorio.");
		$validator->addValidation("colegio3","req","Este campo es obligatorio.");
		$validator->addValidation("nadar3","req","Este campo es obligatorio.");
		$validator->addValidation("autohinch3","req","Este campo es obligatorio.");
		$validator->addValidation("autopisci3","req","Este campo es obligatorio.");
		$validator->addValidation("idioma3","req","Este campo es obligatorio.");
		$validator->addValidation("obsidioma3","req","Este campo es obligatorio.");
		$validator->addValidation("birthdate3","req","Este campo es obligatorio.");
		$validator->addValidation("birthdate3","regexp=%^(0?[1-9]|[12][0-9]|3[01])[- /.](0?[1-9]|1[012])[- /.](19|20)?[\d]{2}$%","Por favor, escribe una fecha v&aacute;lida.");
		$validator->addValidation("curso3","selmin=1","Este campo es obligatorio, marca por lo menos 1");
	}
    if (array_key_exists('nombre4', $_POST) )
	{
		$validator->addValidation("nombre4","req","Este campo es obligatorio.");
		$validator->addValidation("apellidos4","req","Este campo es obligatorio.");
		$validator->addValidation("colegio4","req","Este campo es obligatorio.");
		$validator->addValidation("nadar4","req","Este campo es obligatorio.");
		$validator->addValidation("autohinch4","req","Este campo es obligatorio.");
		$validator->addValidation("autopisci4","req","Este campo es obligatorio.");
		$validator->addValidation("idioma4","req","Este campo es obligatorio.");
		$validator->addValidation("obsidioma4","req","Este campo es obligatorio.");
		$validator->addValidation("birthdate4","req","Este campo es obligatorio.");
		$validator->addValidation("birthdate4","regexp=%^(0?[1-9]|[12][0-9]|3[01])[- /.](0?[1-9]|1[012])[- /.](19|20)?[\d]{2}$%","Por favor, escribe una fecha v&aacute;lida.");
		$validator->addValidation("curso4","selmin=1","Este campo es obligatorio, marca por lo menos 1");
	}
?>