 'use strict';

window.onload = function(){
  var createChannelIdInput = $('#createChannelId');
  var disconnectChannelButton = $('#disconnectChannel');
  var securityToken = $('#securityToken');
  var appCaller;
  appCaller = new PlayRTC({
    projectKey: '60ba608a-e228-4530-8711-fa38004719c1',
    localMediaTarget: 'callerLocalVideo',
    remoteMediaTarget: 'callerRemoteVideo'
  });
  appCaller.on('connectChannel', function(channelId) {
    createChannelIdInput.val( channelId);
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

  event.preventDefault();
  appCaller.createChannel();

  disconnectChannelButton.on('click', function(event){
    event.preventDefault();
    appCaller.disconnectChannel();
  });
};