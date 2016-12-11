 'use strict';

window.onload = function(){
  var createChannelButton = $('#createChannel');
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
    createChannelIdInput.val( channelId);;
  });
  createChannelButton.on('click', function(event) {
    event.preventDefault();
    appCaller.createChannel();
    appCaller.on('addLocalStream', function(){
      var data = new Array();
      data[ securityToken.attr("name")] = securityToken.val();
      data = $.extend({}, data);
      $.ajax({
        url: "/visitor/opened",
        method: 'POST',
        dataType: 'json',
        data: data
      }).done(function( response) {
        console.log( response.abc);
      });
    });
  });
  disconnectChannelButton.on('click', function(event){
    event.preventDefault();
    appCaller.disconnectChannel();
  });
};