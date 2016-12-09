 'use strict';

window.onload = function(){
 var createChannelButton = document.querySelector('#createChannel');
 var createChannelIdInput = document.querySelector('#createChannelId');
 var refreshChannelButton = document.querySelector('#refreshChannel');
 var channelList = document.querySelector('#channelList');
 var getChannelList;
 var disconnectChannelButton = document.querySelector('#disconnectChannel');

 var chattingTimeline = document.querySelector('#timeline');
 var sendMessageInput = document.querySelector('#sendMessage');
 var sendTextButton = document.querySelector('#sendText');

 var sendFileToRemoteBar = document.querySelector('#sendFileToRemoteBar');
 var sendFileToRemoteBarWrapper = document.querySelector('#sendFileToRemoteBarWrapper');

 var remoteVideo = document.querySelector('#remoteVideo');
 var localVideo = document.querySelector('#localVideo');

 var userIdInput = document.querySelector('#userId');

 var userStat = document.querySelector('#userStat');

 var Remote = document.querySelector('#Remote');

 var userId;
 var app;

 app = new PlayRTC({
  projectKey: '60ba608a-e228-4530-8711-fa38004719c1',
  localMediaTarget: 'localVideo',
  remoteMediaTarget: 'remoteVideo'
});

 getChannelList = function () {
  app.getChannelList(function (result) {
    var channels = result.channels;
    var channelsLength = channels.length;

    while (channelList.hasChildNodes()) {
      channelList.removeChild(channelList.firstChild);
    }

    for (var i = 0; i < channelsLength; i++) {
      var channelListAnchor = document.createElement('a');
      var linkIcon = document.createElement('span');

      channelListAnchor.classList.add('list-group-item');
      channelListAnchor.setAttribute('data-channelid', channels[i].channelId);
      channelListAnchor.textContent = channels[i].channelId;

      linkIcon.classList.add('glyphicon', 'glyphicon-menu-right', 'pull-right');
      linkIcon.setAttribute('aria-hidden', 'true');

      channelListAnchor.appendChild(linkIcon);

      channelList.appendChild(channelListAnchor);
    }
  });
}

getChannelList();

app.on('connectChannel', function (channelId) {
  createChannelIdInput.value = channelId;
  getChannelList();
});

app.on('disconnectChannel', function (channelId) {
  createChannelIdInput.value = '';

  while (chattingTimeline.hasChildNodes()) {
    chattingTimeline.removeChild(chattingTimeline.firstChild);
  }

  getChannelList();
});

app.on('otherDisconnectChannel', function (channelId) {
  remoteVideo.src = '';

  while (chattingTimeline.hasChildNodes()) {
    chattingTimeline.removeChild(chattingTimeline.firstChild);
  }

  getChannelList();
});

app.on('addDataStream', function (pid, uid, dataChannel) {
  dataChannel.on('message', function (message) {
    var chatParagraph;

    if (message.type === 'text') {
      chatParagraph = document.createElement('p');
      chatParagraph.classList.add('local');
      chatParagraph.textContent = message.data;

      chattingTimeline.appendChild(chatParagraph);
    } else if (message.type === 'binary') {
      PlayRTC.utils.fileDownload(message.blob, message.fileName);
      sendFileToRemoteBar.style.width = '0px';
    }
  });

      /*dataChannel.on('progress', function (message) {
        var width = sendFileToRemoteBarWrapper.clientWidth;
        var progressbar = (width / message.fragCount) * (message.fragIndex + 1);

        if (message.totalSize === message.fragSize) {
          return;
        }

        sendFileToRemoteBar.style.width = progressbar + 'px';
      });*/

      dataChannel.on('error', function (event) {
        alert('ERROR. See the log.');
      });
    });

refreshChannelButton.addEventListener('click', function (event) {
  event.preventDefault();
  getChannelList();
}, false);

channelList.addEventListener('click', function (event) {
  var channelId = event.target.dataset.channelid;

  userId = userIdInput.value;

  app.connectChannel(channelId, {
    peer: {
      uid: userId
    }
  });

}, false);

createChannelButton.addEventListener('click', function (event) {
  event.preventDefault();

  userId = userIdInput.value;

  app.createChannel({
    peer: {
      uid: userId
    }
  })

}, false);

disconnectChannelButton.addEventListener('click', function (event) {
  event.preventDefault();
  app.disconnectChannel();
}, false);


sendTextButton.addEventListener('click', function (event) {
  var chatParagraph;
  var message = sendMessageInput.value;

  event.preventDefault();

  if (message) {
    app.sendText(message);

    chatParagraph = document.createElement('p');
    chatParagraph.classList.add('remote');
    chatParagraph.textContent = message;

    chattingTimeline.appendChild(chatParagraph);
  }
  sendMessageInput.value = '';
}, false);

/*window.onload= function(){
  $("sendId").onclick=logIn;
}

function logIn(event) {
  $("userStat").textContent="Owner";
  userId = userIdInput.value;
  $("Remote").addClassName("ownerView");
}
*/
/*userIdSend.addEventListener('click', function (event) {
  userStat.textContent="Owner";
     userId = userIdInput.value;

  // Remote.addClassName("ownerView");

}, false);*/
};