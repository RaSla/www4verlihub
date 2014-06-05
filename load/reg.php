<h2 id="reg">Регистрация на Хабе</h2>

<div class="row">

    <div class="alert alert-warning"><p><b>ВНИМАНИЕ!</b><br>
            Регистрация на Хабе НЕ ОБЯЗАТЕЛЬНА!</p>
    </div>

    <div class="col-xs-6 col-sm-6">
        <h3>Зарегистрироваться</h3>

<p>Регистрация поможет Вам сохранить за собой выбранное Имя (Ник) на Хабе.</p>
<!--<p>После заполнения формы, на указанный почтовый ящик будет отправленно письмо
с активационной ссылкой, по которой необходимо перейти в течение 24 часов.</p>-->
    </div>

    <div class="col-xs-6 col-sm-6">
    <h3 id="pass">Сменить пароль</h3>

<p>Если Вы забыли пароль к зарегистрированному Имени (Нику),
    то можете изменить пароль.</p>
<!--<p>Вам будет выслано письмо с активационной ссылкой
    на адрес электронной почты, указанный при регистрации.
</p>-->
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6">
        <button id="btn_reg" onclick="showForm( form_reg );" class="btn">Регистрация</button>
    </div>
    <div class="col-xs-6 col-sm-6">
        <button id="btn_pass" onclick="showForm( form_pass );" class="btn">Смена пароля</button>
    </div>
</div>

<form id="form" class="navbar-form alert-info" role="form" onsubmit="onSubmit(); return false;" style="display: none;">
    <div class="row">
        <div class="col-xs-6 col-sm-3">
            <label for="email">Электронная почта:</label>
            <div class="form-group">
                <input id="email" type="text" placeholder="E-mail" class="form-control" onchange="onChangeEmail();">
            </div>
        </div>
        <div class="col-xs-12 col-sm-9">
            Ящик электронной почты.<br>
            * На 1 ящик можно зарегистрировать ТОЛЬКО 1 Ник.
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-sm-3">
            <label for="login">Ник:</label>
            <div class="form-group">
                <input id="login" type="text" placeholder="Логин" class="form-control" onchange="onChangeLogin();">
            </div>
        </div>
        <div class="col-xs-12 col-sm-9">
            * Длина Ника: от 4 до 30 символов; <br>
            * Символы Ника: буквы Латиницы, цифры и символ "подчеркивание".
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-sm-3">
            <label for="passwd1">Пароль:</label>
        </div>
        <div class="col-xs-12 col-sm-9">
            * Длина Пароля: от 4 до 30 символов.
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-sm-3">
            <div class="form-group">
                <input id="passwd1" type="password" placeholder="Пароль" class="form-control" onchange="onChangePasswd(); return false;">
            </div>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="form-group">
                <input id="passwd2" type="password" placeholder="Повтор пароля" class="form-control" onchange="onChangePasswd();">
            </div>
        </div>
    </div>
<br>
    <div class="row">
        <div class="col-xs-6 col-sm-3">
            <button id="btn_ok" type="submit" class="btn">Зарегистрироваться</button>
        </div>
    </div>
<br>
</form>

<div class="alert hidden" id="alert"><p><b>ВНИМАНИЕ!</b><br>
        Доступ к нашему DC++ Хабу возможен только внутри сети <b>Еканет</b>,<br>
        при активном PPPoE-подключении к интернету (IP: 85.x.x.x и 89.x.x.x ).</p>
</div>
