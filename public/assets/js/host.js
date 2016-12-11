'use strict';

window.onload = function(){
  var connectChannelIdInput = document.querySelector('#connectChannelId');
  var connectChannelButton = document.querySelector('#connectChannel');
  var appCallee;
  appCallee = new PlayRTC({
    projectKey: '60ba608a-e228-4530-8711-fa38004719c1',
    localMediaTarget: 'calleeLocalVideo',
    remoteMediaTarget: 'calleeRemoteVideo'
  });
  connectChannelButton.addEventListener('click', function(event) {
    var channelId = connectChannelIdInput.value;
    event.preventDefault();
    if (!channelId) {
      return;
    }
    appCallee.connectChannel(channelId);
  }, false);
}