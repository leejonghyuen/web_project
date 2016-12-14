'use strict';

window.onload = function(){
  var disconnectChannelButton = $('#disconnectChannel');
  var securityToken = $('#securityToken');
  var appCaller;
  appCaller = new PlayRTC({
    projectKey: '60ba608a-e228-4530-8711-fa38004719c1',
    remoteMediaTarget: 'callerRemoteVideo'
  });
  appCaller.on('connectChannel', function(channelId) {
    var data = new Array();
    data[ securityToken.attr("name")] = securityToken.val();
    data[ "channelId"] = channelId;
    data = $.extend({}, data);
    $.ajax({
      url: "/interphone/calling",
      method: 'POST',
      dataType: 'json',
      data: data
    }).done(function( response) {
      
    });
  });

  appCaller.on('addDataStream', function(peerid, uid, dataChannel) {
    event.preventDefault();
    $('#loading-text').text('상대방과 인터폰이 연결되었습니다. 마이크를 통해 나를 알려주세요');
    alert('연결되었어요!');
  });

  appCaller.on('error', function(errorCode,errorMsg) {
    event.preventDefault();
    alert( errorMsg);
    location.href='/';
  });

  event.preventDefault();
  appCaller.createChannel();

  disconnectChannelButton.on('click', function(event){
    event.preventDefault();
    appCaller.disconnectChannel();
  });
};