<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-brand-logo" href="http://<?php print $cfg['org']['url']; ?>" title="<?php print $cfg['org']['name']; ?>" target="_blank"><img src="img/logo_50.png" alt="<?php print $cfg['org']['name']; ?>" height="50"></a>
            <a class="navbar-brand" href="/" title="Главная"><b>P2P</b></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/rules">Правила</a></li>
                <li><a href="/soft">Скачать</a></li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Регистрация <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/reg">Зарегистрироваться</a></li>
                        <li><a href="/reg#pass">Сменить пароль</a></li>
                    </ul>
                </li>
                <li><a href="/help">Помощь</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div><!-- END OF - Fixed navbar -->
