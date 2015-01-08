/**
 * Created by kasu on 13.02.14.
 */

/*XMPP.BOSH_SERVICE = 'http://127.0.0.1:7070/http-bind/';
 XMPP.SERVER_ROOM = 'conference.localhost';
 XMPP.SERVER = 'localhost';*/

VII = {};

XMPP.BOSH_SERVICE = 'http://server.advokatmarket.com:7070/http-bind/';
XMPP.SERVER = 'server.advokatmarket.com';
XMPP.SERVER_ROOM = 'conference.'+XMPP.SERVER;

XMPP.room = XMPP.hash+'@'+XMPP.SERVER_ROOM;
XMPP.nick = XMPP.hash+'_'+(new Date()).getTime()+'_'+XMPP.type_user;
XMPP.psw = 'password';
XMPP.connection = null;
XMPP.onlinePartner = false;
XMPP.presence = {client:{},lawyer:{}};


VII.drawMsg = function(name,msg,status){
    if(status == 'default'){
        msg = VII.nl2br(msg);
        var full_name = XMPP.info['me']['name']+(XMPP.info['me']['first_name'] != '' ? ' '+XMPP.info['me']['first_name'] : '');
        var class_2 = name == full_name ? 'me' : 'to';
        console.log(class_2);
        $('.col-z2').append('<div class="item grid maxwidth '+class_2+'"><div class="col-d1">'+name+':</div><div class="col-d2">'+msg+'</div></div>');
    }else{
        switch(status){
            case 'system':
                $('.col-z2').append('<div class="item grid maxwidth"><div class="col-d3">'+msg+'</div></div>');
                break;
            case 'link_pay':
                $('.col-z2').append('<div class="item grid maxwidth"><div class="col-d4"><button id="sale">Оплатити</button></div></div>');
                break;
        }
    }
    VII.scrollBot();
};

VII.changePresence = function(mode){
    var type = mode ? 'online' : 'offline';
    var type_ = mode ? 'offline' : 'online';
    $('.presence1').removeClass(type_);
    $('.presence1').addClass(type);
};

VII.reload = function(mode){
    if(mode = 'pay'){
        var url = XMPP.uri_server.replace(/(.*\/).*\//,"$1");
        window.location.assign(url+'/msg/testpay&id='+XMPP.idCons);
    }
}

VII.action = {
    default:function(data){
        var name = data.origin == XMPP.type_user ? XMPP.info.me['name'] : XMPP.info.to['name'];
        var first_name = data.origin == XMPP.type_user ? XMPP.info.me['first_name'] : XMPP.info.to['first_name'];
        var full_name = name+(first_name ? ' '+first_name : '');
        VII.drawMsg(full_name,data.msg,data.type);
    },
    start:function(){
        VII.actionInit('start');
        $('#pay_consultation').click(function(){
            $('#basic-modal-content').modal({
                persist:true
            });
        });
    },
    pay:function(obj){
        VII.actionInit('pay');
        if(obj) XMPP.cost = obj.cost;
        if(XMPP.type_user == XMPP.ROLE_CLIENT){
            VII.drawMsg(null,'Вам пришел запрос на оплату. В размере '+XMPP.cost+' грн.','system');
            VII.drawMsg(null,null,'link_pay');
            $('#sale').click(function(){
                console.log('Переход на оплату');
                VII.reload('pay');
                VII.action['cons']();
            });

        }else{
            VII.drawMsg(null,'Вы отправили запрос на оплату. В размере '+XMPP.cost+' грн.','system');
            $('#pay_button').remove();
            $.modal.close();
        }
        VII.hiddenInputPanel(true);
    },
    cons:function(){
        console.log('cons');
        if(XMPP.type_user == XMPP.ROLE_CLIENT){
            var obj = {data:{
                method:'cons'
            }};
            var obj_str = JSON.stringify(obj);
            XMPP.connection.muc.sendMessage(XMPP.room,XMPP.nick,obj_str);
            openAll();
        }else{
            if(XMPP.status !== 'cons'){
                VII.drawMsg(null,'Клиент оплатил консультацию.','system');
            }
            openAll();
        }
        function openAll(){
            $('#cons-st').html('<div class="over-block"><div>Стоимость услуги: <span>'+XMPP.cost+' грн</span></div><div>Оплачено</div></div>');
            VII.hiddenInputPanel(false);
        }
        VII.actionInit('cons');
    },
    reviews:function(){
        if(XMPP.type_user == XMPP.ROLE_CLIENT){
            $('#basic-modal-content-reviews').modal({
                persist:true
            });
            $('.block-review').css('display','block');
            $('#review_consultation').click(function(){
                $('#basic-modal-content-reviews').modal({
                    persist:true
                });
            });
            VII.action['end']();
        }else{
            VII.action['end']();
        }
    },
    end:function(){
        VII.drawMsg(null,'Консультация окончена!','system');
        VII.hiddenInputPanel(true);
        $('.block-cons').css('display','none');

        XMPP.connection.disconnect();
    },
    cancel:function(){
        VII.action['end']();
    }
};

VII.scrollBot = function(){
    $('.col-z2').scrollTop(5000000);
};

VII.hiddenInputPanel = function(mode){
    if(mode){
        $('.col-z3').css('display','none');
    }else{
        $('.col-z3').css('display','block');
    }
};

VII.actionInit = function(act){
    XMPP.status = act;
    $('#options-block').attr('class','status-'+act);
};

VII.sendMsgWrap = function(msg){
    if(msg !== ''){
        VII.sendMsg(msg);
    }
};

VII.sendMsg = function(msg,obj){
        if(obj === undefined){
            var obj = {};
            obj.data = {};
            obj.data.method = 'default';
            obj.data.msg = msg;
            obj.data.ts = (new Date()).getTime();
            obj.data.origin = XMPP.type_user;
            obj.data.type = 'default';
            obj.data.id = XMPP.idCons;
        }
        var obj_str = JSON.stringify(obj);
        VII.action[obj.data.method](obj.data);
        XMPP.connection.muc.sendMessage(XMPP.room,XMPP.nick,obj_str);
        console.log(obj.data,'qqqq');
        XMPP.send_ajax(obj.data,'addmsg');
}

VII.nl2br = function(str, is_xhtml){
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

VII.sendPay = function(form,data,hasError){
    console.log(form,data,hasError,'pay');
    if(hasError){return false;}
    var cost = $('#ChatForm_pay_cost').val();
    XMPP.cost = cost;
    var obj = {data:{
        method:'pay',
        cost:cost,
        idCons:XMPP.idCons
    }};
    VII.action[obj.data.method](obj.data);
    var obj_str = JSON.stringify(obj);
    XMPP.connection.muc.sendMessage(XMPP.room,XMPP.nick,obj_str);
    XMPP.send_ajax(obj.data,'addcmnd');
}

VII.sendReviews = function(form,data,hasError){
    console.log(form,data,hasError,'pay');
    if(hasError){return false;}
    var txt = $('#ChatForm_txt').val();
    var obj = {data:{
        method:'reviews',
        txt:txt,
        idCons:XMPP.idCons
    }};
    var obj_str = JSON.stringify(obj);
    XMPP.send_ajax(obj.data,'addcmnd');
    $.modal.close();
}

XMPP.send_ajax = function(val,method){
    var xmlhttp = XMPP.getxmlhttp();
    var method = method || 'addmsg';
    var uri = XMPP.uri_server+method;
    var param =	"data="+JSON.stringify(val);
    xmlhttp.open("POST",uri,true);
    xmlhttp.setRequestHeader("Cache-Control","no-store");
    xmlhttp.setRequestHeader("Cache-Control","no-store,no-cache,must-revalidate");
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(param);
}

XMPP.getxmlhttp = function(){
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined'){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

XMPP.onConnect = function(status)
{
    if(status == Strophe.Status.CONNECTING){
        console.log('Strophe is connecting.');
    }else if(status == Strophe.Status.CONNFAIL){
        console.log('Strophe failed to connect.');
    }else if(status == Strophe.Status.DISCONNECTING){
        console.log('Strophe is disconnecting.');
    }else if(status == Strophe.Status.DISCONNECTED){
        console.log('Strophe is disconnected.');
    }else if(status == Strophe.Status.CONNECTED){
        console.log('Strophe is connected.');
        XMPP.connection.send($pres().tree());
        setTimeout(XMPP.parseRoomList,1000);
    }
}

XMPP.onMessage = function(o){

    var items = o;
    var nick = items.getAttribute('from').replace(/.*\//,'');
    var from = items.getAttribute('from');
    var type = items.getAttribute('type');
    var isX = items.getElementsByTagName('x').length;
    var type_user = nick.replace(/.*_/,'');
    var msg = Strophe.getText(items.getElementsByTagName('body')[0]);
    if((type == 'groupchat')&&(isX == 0)&&(from !== XMPP.room)&&(nick !== XMPP.nick)){
        var msg = JSON.parse(msg);
        VII.action[msg.data.method](msg.data);
        console.log(msg,'out');
    }
    return true;
}

XMPP.addItemPresence = function(nick,jid){
    console.log(nick,jid,'add item presence');
    var type = nick.replace(/.*_/,'');
    XMPP.presence[type][nick] = jid;
}

XMPP.removeItemPresence = function(nick){
    console.log(nick,'remove item presence');
    var type = nick.replace(/.*_/,'');
    if(XMPP.presence[type][nick]){
        XMPP.presence[type][nick] = null;
        delete XMPP.presence[type][nick];
    }
}

XMPP.hasOnline = function(){
    var rev = XMPP.type_user == 'client'?'lawyer':'client';
    var isNotNull = !XMPP.emptyObject(XMPP.presence[rev]);
    if(XMPP.onlinePartner !== isNotNull){
        XMPP.onlinePartner = isNotNull;
        VII.changePresence(XMPP.onlinePartner);
    }
}

XMPP.emptyObject = function(obj) {
    for (var i in obj) {
        return false;
    }
    return true;
}

XMPP.onPresence = function(o){

    var items = o;
    console.log(items);
    if(items.getAttribute('type') === 'unavailable'){
        var nick = items.getAttribute('from').replace(/.*\//,'');
        XMPP.removeItemPresence(nick);
    }else{
        var nick = items.getAttribute('from').replace(/.*\//,'');
        var jid = items.getAttribute('to');
        XMPP.addItemPresence(nick,jid);
    }
    XMPP.hasOnline();
    return true;
}

XMPP.createRoom = function(){
    console.log('create');
    XMPP.connection.muc.join(XMPP.room,XMPP.nick,XMPP.onMessage,XMPP.onPresence,XMPP.psw);
    XMPP.connection.muc.configure(XMPP.room);
    XMPP.connection.muc.saveConfiguration(XMPP.room,[$build('password').t(XMPP.psw).tree()]);
}

XMPP.joinRoom = function(){
    console.log('join');
    XMPP.connection.muc.join(XMPP.room,XMPP.nick,XMPP.onMessage,XMPP.onPresence,XMPP.psw);
}

XMPP.parseRoomList = function(){
    XMPP.connection.muc.listRooms(XMPP.SERVER_ROOM,function(o){

        var items = o.getElementsByTagName('item');
        for(var k in items){

            if(typeof items[k] !== "object") continue;
            var name_room = items[k].getAttribute('name');
            console.log(name_room,'k');
            if(name_room == XMPP.hash){
                XMPP.joinRoom();

                VII.callAction(false);
                return false;
            }
        }
        XMPP.createRoom();
        VII.callAction(false);
    });
}

VII.callAction = function(hasStart){
    if(!hasStart){
        if(XMPP.status === 'cons'){
            VII.action[XMPP.status]();
        }
    }else{
        if(XMPP.status !== 'cons'){
            VII.action[XMPP.status]();
        }
    }
}

$(document).ready(function(){
    VII.callAction(true);
    XMPP.connection = new Strophe.Connection(XMPP.BOSH_SERVICE);
    XMPP.connection.connect('id',null,XMPP.onConnect);
    VII.scrollBot();

    $('#send').bind('click', function(){
        var msg = $('#msg-value').val();
        VII.sendMsgWrap(msg);
        setTimeout(function(){
            $('#msg-value').html(null);
            $('#msg-value').val(null);
            $('#msg-value').focus();
        },50);
    });
    $('#msg-value').on('keydown',function(obj){
        var self = this;
        if(obj.which == 13 && (obj.shiftKey == 0)){
            var msg = $(this).val();
            VII.sendMsgWrap(msg);
            setTimeout(function(){
                $(self).html(null);
                $(self).val(null);
            },50);
        }
    });
    $('#close_consultation').click(function(){
        var obj = {data:{
            method:'close_consultation',
            idCons:XMPP.idCons
        }};
        XMPP.send_ajax(obj.data,'addcmnd');
        var obj = {data:{
            method:'reviews',
            idCons:XMPP.idCons
        }};
        var obj_str = JSON.stringify(obj);
        XMPP.connection.muc.sendMessage(XMPP.room,XMPP.nick,obj_str);
        VII.action['reviews']();
    });

});









