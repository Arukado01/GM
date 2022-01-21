<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>

    <style type="text/css">
        body {
            padding: 0;
            margin: 0;
        }

        table {
            width: 100%;
            border-spacing: 0;
            font-family: Avenir, Helvetica, sans-serif;
            font-size: 18px;
        }

        .btn-in {
            font-family: Avenir, Helvetica, sans-serif;
            box-sizing: border-box;
            border-radius: 3px;
            color: #fff;
            display: inline-block;
            text-decoration: none;
            background-color: #3097d1;
            border: 10px solid #3097d1;
            border-right-width: 18px;
            border-left-width: 18px;
        }
    </style>
</head>
<body>
<table>
    <tbody>
    <tr>
        <td style="vertical-align: middle; text-align: center; background-color: #0b76cc; color: white;">
            <h2>{{ config('app.name') }}</h2>
        </td>
    </tr>
    <tr>
        <td style="padding: 18px; font-size: 18px;">
            <p><strong>Hola {{ $user->full_name }}!!</strong></p>
            <p>
                Se te ha creado un nuevo usuario en la plataforma <strong>GM Proyectos</strong> y estas son tus
                credenciales de acceso:
            </p>
        </td>
    </tr>
    <tr>
        <td style="vertical-align: middle; text-align: center;color: #0b76cc">
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Contraseña:</strong> {{ $psw }}
        </td>
    </tr>
    <tr>
        <td style="padding: 18px;">
            <p>
                Al momento de ingresar a la plataforma se le solicitara un cambio de contraseña ya que la actual es
                generada automáticamente por el sistema.
            </p>
        </td>
    </tr>
    <tr>
        <td style="vertical-align: middle; text-align: center;">
            <a href="{{ env('APP_URL') }}" target="_blank" class="btn-in">
                Ingresar
            </a>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0"
                   style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-top:1px solid #edeff2;margin-top:25px;padding-top:25px">
                <tbody>
                <tr>
                    <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;
                            line-height:1.5em;margin-top:0;text-align:center;font-size:12px;">
                            Si tiene problemas para hacer clic en el botón "Ingresar", haga click o copie y
                            pegue la siguiente URL en su navegador favorito: <br>
                            <a href="{{ env('APP_URL') }}"
                               style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4"
                               target="_blank">
                                {{ env('APP_URL') }}
                            </a>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
