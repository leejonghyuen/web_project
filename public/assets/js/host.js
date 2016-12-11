'use strict';

window.onload = function(){
  var connectChannelIdInput = document.querySelector('#connectChannelId');
  var appCallee;
  appCallee = new PlayRTC({
    projectKey: '60ba608a-e228-4530-8711-fa38004719c1',
    remoteMediaTarget: 'calleeRemoteVideo'
  });
  var channelId = connectChannelIdInput.value;
  
  appCallee.on('addDataStream', function(peerid, uid, dataChannel) {
    event.preventDefault();
    $('#calleeRemoteVideo').show();
    $('#loading-container').hide();
  });

  appCallee.on('disconnectChannel', function(peerid, uid, dataChannel) {
    event.preventDefault();
    alert('나의 연결이 끊어졌습니다. 재연결합니다');
    location.reload();
  });

  appCallee.on('otherDisconnectChannel', function(peerid, uid, dataChannel) {
    event.preventDefault();
    alert('상대방이 연결을 끊었습니다');
  });

  appCallee.on('error', function(errorCode,errorMsg) {
    event.preventDefault();
    alert( errorMsg);
  });

  appCallee.connectChannel(channelId);
}