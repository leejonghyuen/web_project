 'use strict';

window.onload = function(){
  var createChannelButton = document.querySelector('#createChannel');
    var createChannelIdInput = document.querySelector('#createChannelId');
    var appCaller;
    appCaller = new PlayRTC({
      projectKey: '60ba608a-e228-4530-8711-fa38004719c1',
      localMediaTarget: 'callerLocalVideo',
      remoteMediaTarget: 'callerRemoteVideo'
    });
    appCaller.on('connectChannel', function(channelId) {
      createChannelIdInput.value = channelId;
    });
    createChannelButton.addEventListener('click', function(event) {
      event.preventDefault();
      appCaller.createChannel();
    }, false);
};