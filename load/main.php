<!--<div class="alert alert-warning">
    <h1>Сайт на реконструкции!</h1>
    <p>Настала пора модернизировать наш сервис P2P (DC++)!</p>
    <img src="img/tech_works.png" alt="Технические работы">
</div>-->
<br>
<!--<div class="alert alert-success">
    <strong>Хаб Таганки пока что работает!</strong><br>
    Но уже в ближайшее время, при подключении к Таганке будет происходить переадресация на <b>P2P.eka-net.ru</b>.
</div>-->

<div class="alert alert-danger">
    <strong>ВНИМАНИЕ!</strong><br>
    Клиентскую программу "<b>Taganka 1.0x</b>" настоятельно рекомендуется заменить
    на <b><a href="/soft">новую версию Клиента</a></b>!<br>
</div>

<div class="page-header" id="p2p">
    <h2>Что такое P2P ?</h2>
</div>
<div class="well">
    <p><strong>P2P</strong> ( от англ. peer-to-peer, P2P — равный к равному ) - это компьютерная сеть, основанная на равноправии участников.</p>
</div>
<p>Одним из основных применений технологии P2P являются файлообменные сети.</p>
<p>Наибольшую популярность в файлообменных P2P-сетях имеют протоколы <strong>BitTorrent</strong> и <strong>DC++</strong></p>
<p>Наш P2P-сервис основан на протоколе <strong>DC++</strong></p>

<div class="form-group">
    <button class="btn btn-info" onclick="clickSpoiler('#bittorrent'); return false;"
        >Подробнее о недостатках BitTorrent</button>
</div>
<div id="bittorrent" style="display: none;">
<p><strong>BitTorrent</strong> - отлично подходит для обмена файлами среди участников,
    находящихся в разных частях интернета.</p>
<p>Недостаток Торрентов в том, что для скачивания файлов, сначала необходимо получить "ссылку" (.torrent-файл)
    для чего используются специальные веб-сайты (торрент-трекеры),
    на которых активные пользователи создают <i>раздачи</i>.</p>
<p>Именно использование веб-сайта является "слабым местом" торрентов,
    т.к. законодательными мерами в большинстве развитых стран (в том числе и в России)
    введен в действие механизм блокирования "неугодных закону" <i><b>веб-сайтов</b></i>,
    при чем в кратчайшие сроки.</p>
<p>Важно отметить, что <b>необходимость создания раздач</b> и соблюдение правил её оформления
    не торрент-трекерах тоже является притормаживающим фактором, т.к. далеко не все пользователи прилагают
    усилия необходимые для создания раздач, и поэтому предпочитают только скачивать готовые.</p>
</div>

    <div class="form-group">
        <button class="btn btn-info" onclick="clickSpoiler('#dcpp'); return false;"
            >Подробнее о преимуществах DC++</button>
    </div>
<div id="dcpp" style="display: none;">
<p><strong>DC++</strong> ( а так же его развитие — <strong>ADC</strong> ) - отлично подходит для организации
    локального файлообмена<br> (с числом участников обмена - до нескольких десятков тысяч).</p>
<p>В отличии от "торрентов", DC-сетям сайт не нужен, а для работы требуется только клиентская программа и DC-хаб,
    посредством которого пользователи обмениваются текстовыми сообщениями и поисковыми запросами
    (которые содержат один или несколько параметров файла, такие как:
    часть имени файла, его тип, ограничения по размеру).</p>
<p>Поиск в DC++ сетях осуществляют прямо в Клиентской программе, рассылая поисковый запрос
    сразу ВСЕМ пользователям, подключенным к DC-Хабу прямо СЕЙЧАС, поэтому результаты поиска отличаются
    в зависимости от того, какие пользователи подключены к Хабу в данный момент.</p>
<p>Также DC++ сети удобны наличием "Общего Чата" и "Личных Сообщений", что дает возможность
    не только скачивать отдельные файлы или целые папки, но и обсуждать темы,
    не противоречащие <a href="/#rules" title="Правила нашего DC-Хаба">Правилам Хаба</a>.</p>
<p>DC-хабы часто организуют внутри локальной сети провайдера, обычно благодаря этому
    скорость обмена между пользователями возрастает, а нагрузка на "интернет-канал" провайдера уменьшается
    - в итоге выигрывают от этого ВСЕ пользователи (и те, которые не пользуются DC-сетями тоже)!</p>
</div>

<div class="page-header" id="eka_p2p">
    <h3>Возможности нашего P2P</h3>
</div>
<ul>
    <li><b>"Общий Чат"</b> для совместного общения и обсуждения;</li>
    <li><b>"Личные Сообщения"</b> для приватного диалога между участниками;</li>
    <li><b>"Поиск файлов"</b> по ЧАСТИ имени файла (например, поиск по запросу <i>"маш и медвед"</i>
        найдет файлы с именами как <i>"маш<b>а</b> и медвед<b>ь</b>"</i>, так и <i>"маш<b>и</b> и медвед<b>я</b>"</i>),
        типу файла (Видео / Аудио / Картинки) и размеру (например, "не менее 200 Мб");</li>
    <li><b>"Загрузка файлов"</b> с управляемой очередностью и возможностью "докачки с места прерывания загрузки";</li>
    <li><b>"Загрузка списка-файлов пользователя"</b> - вы можете скачать и посмотреть список файлов ЛЮБОГО пользователя подключенного к Хабу;</li>
    <li><b>"Отображение 30 последних сообщений чата"</b> при подключении пользователя к Хабу,
        сразу же видно о чем только что говорили;</li>
    <li><b>"Периодическая загрузка Анекдотов и Цитат (с БашОрга)"</b> в общий чат, для поднятия настроения.</li>
</ul>
<p>Из других особенностей нашего Хаба можно отметить:</p>
<ul>
    <li><b>Обмен файлами</b> внутри сети "<?php print $cfg['org']['name']; ?>" <b>БЕЗ ограничения скорости</b> и необходимости "прописывать маршруты";</li>
    <li><b>Хорошо преднастроенный Клиент</b> для ОС Windows (<b>FlyLinkDC r5xx</b>);</li>
    <li>Отсутствие блокировки "неправильных" версий Клиентского ПО
        (пользуйтесь тем, что нравится, но помните, что ТехПоддержка не обязана знать особенности других Клиентов);</li>
    <li><b>Необязательная регистрация</b> на Хабе (регистрируйтесь, если хотите закрепить за собой Ник);</li>
</ul>
