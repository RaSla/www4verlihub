/**
 * utf-8 кодировочка
 * Created by RaSla@Mail.Ru on 05.06.2014
 */

initSpoilers();

/* --- SPOILERS --- */

function initSpoilers()
{
//    $('.spoiler-body').hide();
    $('.spoiler-head').off('click');
    $('.spoiler-head').click(function(){
        $(this).next().toggle();
    });
}

function clickSpoiler( sp )
{
//    $('button').removeClass('btn-info');
//    console.log( 'w='+$('#form').width() );
    if ($(sp).is(":hidden")) {
        $(sp).slideDown("fast");
        var go_2_anchor = $(sp).offset().top -100;
        $("body").animate({
            scrollTop : go_2_anchor
        }, 500);
    } else {
        $(sp).slideUp("fast");
    }
}

/* --- AJAX --- */
var ajax_res = { rez: '', str: '' };	// результат выполнения ajaxCmd()

function ajaxCmd( cmds, prms, callback_do )
{
// console.log('ajaxCmd: "' + cmds +'"; AjaxPrm1: "'+ prms +'"');
    var data = { cmd: cmds, params: prms };
    $.ajax( "post-ajax", {
        type: "post", cache: false, async: false,
        data: data,
        dataType: "json",
        error: function() {
            ajax_res.rez = -1;
            ajax_res.str = 'Error on ajaxCmd()';
            if( $.isFunction( callback_do ) ) callback_do.apply();
        },
        success: function(jsn) {
            ajax_res = jsn;
            if( $.isFunction( callback_do ) ) callback_do.apply();
        }
    } );
    //console.log( 'ajax_res.rez = '+ajax_res.rez );
}

/* --- REG --- */

var bad = 'alert-danger';
var good = 'alert-success';
var bgood = 'btn-success';
var h = 'hidden';
var email_pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
var login_pattern = /^([a-z0-9_-])+$/i;
var err = '';
var form_tag = '';

var al = $('#alert');

var form_reg = {
    btn_id : 'btn_reg',
    btn_text : 'Зарегистрироваться',
    tag: 'reg'
}
var form_pass = {
    btn_id : 'btn_pass',
    btn_text : 'Сменить пароль',
    tag: 'pass'
}

function showForm( vname )
{
    $('button').removeClass('btn-info');
//    console.log( 'w='+$('#form').width() );
    if ($("#form").is(":hidden")) {
        $('#btn_ok').text( vname.btn_text );
        $('#'+vname.btn_id).addClass('btn-info');
        $("#form").slideDown("fast");
        form_tag = vname.tag;
    } else {
        $("#form").slideUp("fast");
        al.addClass( h );
        var p = $("#passwd1, #passwd2");
        p.val('');
        p.removeClass( bad +' '+ good );
    }
//    $('#form').slideToggle("fast");
//    $('#'+vname.btn_id).val();
//    alert( vname.btn_text );
}

function showError( err ){
    if( err == '' ){
        al.addClass( h );
    } else {
        al.addClass( bad );
        al.removeClass( h+' '+good );
        al.html( '<p><b>ОШИБКА!</b><br>' +err+ '</p>' );
    }
}

function showMsg( msg ){
    if( msg == '' ){
        al.addClass( h );
    } else {
        al.addClass( good );
        al.removeClass( h+' '+bad );
        al.html( '<p><b>Сообщение!</b><br>' +msg+ '</p>' );
    }
}

function setClass( id )
{
    var btn = $('#btn_ok');
    if( err == '' ){
        id.addClass( good );
        id.removeClass( bad );
    } else {
        id.addClass( bad );
        id.removeClass( good );
        id.focus();
    }
    showError( err );
    var i = $('input.alert-success').size();
//    console.log('i='+i);
    if( i != 4 ){
        btn.removeClass( bgood );
    } else {
        btn.addClass( bgood );
    }
}

function onChangeEmail()
{
    var id = $('#email');
    var v = id.val();
    var s = v.length;
    err = '';
    if( s > 60 ) err = 'Неверная длина e-mail (не допускается более 60 символов)';
    else if( !email_pattern.test( v ) ) err = 'Неверно указан e-mail';
    setClass( id );
}

function onChangeLogin()
{
    var id = $('#login');
    var v = id.val();
    var s = v.length;
    err = '';
    if( (s < 4) || (s > 30) ) err = 'Неверная длина Логина';
    else if( !login_pattern.test( v ) ) err = 'Недопустимые символы в Логине';
    setClass( id );
}

function onChangePasswd()
{
    var id = $('#passwd1');
    var v = id.val();
    var s = v.length;
    err = '';
    if( (s < 4) || (s > 30) ) err = 'Неверная длина Пароля (допустимо от 4 до 30)';
    setClass( id );

    if( err == ''){
        var id = $('#passwd2');
        var v = id.val();
        var s = v.length;
        if( v != $('#passwd1').val() ) err = 'Пароли не совпадают';

        setClass( id );
    }
}

function onSubmit()
{
// Простые проверки на Клиенте
    onChangeEmail();
    if( err == '' ) onChangeLogin();
    if( err == '' ) onChangePasswd();
// TODO Проверки на стороне Сервера - занят ли Логин
    if( err == '' ){
        var l = $('#login').val();
        var m = $('#email').val();
        var p = $('#passwd1').val();
// регистрация нового ника
        if( form_tag == form_reg.tag )
            ajaxCmd( 'user', { action: 'reg_new_user', login : l, email : m, passwd: p }, function(){
                var r = ajax_res.rez;
                var s = ajax_res.str;
                //console.warn('r='+r+' s='+s);
                if( r == 0 ) {
                    if( s == 'lm' ) s='Этот Ник уже зарегистрирован на указанный почтовый ящик.';
                    else if( s == 'l' ) s='Такой Ник уже зарегистрирован.';
                    else if( s == 'm' ) s='На этот почтовый ящик уже зарегистрирован другой Ник.';
                    showError( s );
                }
                else showMsg( 'Регистрация прошла успешно!' );
            } );
// смена пароля
        else if( form_tag == form_pass.tag )
            ajaxCmd( 'user', { action: 'change_passwd', login : l, email : m, passwd: p }, function(){
                var r = ajax_res.rez;
                var s = ajax_res.str;
//            console.warn('r='+r+' s='+s);
                if( r == 0 ){
                    if( s == 'l' || s == 'm' || s == '' ) s='Не найдено регистрационной пары (Ник / почтовый ящик).';
                    else if( s == 'lm' ) s='Регистрационная пара (Ник / почтовый ящик) найдена, но пароль изменить не удалось' +
                        '<br>(скорее всего новый пароль совпадает с текущим)';
                    showError( s );
                }
                else showMsg( 'Смена пароля прошла успешно!' );
            } );
    }
}
