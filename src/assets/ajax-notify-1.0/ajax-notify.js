$(function () {
  var fetchFrom, fetchUrl, fetchDelay;
  var audios = {}, audiosPlayTime = {};

  function audioPlay(config) {
    if (!audios[config.url]) {
      audios[config.url] = new Audio();
      audios[config.url].controls = true;
      audios[config.url].loop = false;
      audios[config.url].src = config.url;
      audiosPlayTime[config.url] = 1;
      audios[config.url].addEventListener('ended', function () {
        audiosPlayTime[config.url]++;
        if (config.count !== 0 && audiosPlayTime[config.url] > config.count) {
          audios[config.url] = null;
          return;
        }
        setTimeout(function () {
          audioPlay(config);
        }, config.delay)
      });
    }
    audios[config.url].play();
  }

  function startCheck() {
    $.ajax({
      url: fetchUrl,
      data: {from: fetchFrom},
      success: function (data) {
        if (data.info.length > 0) {
          $.each(data.info, function (k, v) {
            $.notify(v.notifyOptions, v.notifySettings ? v.notifySettings : {});
            if (v.audioConfig) {
              audioPlay(v.audioConfig)
            }
          });
          //audioPlay()
        }
        fetchFrom = data.time;
        setTimeout(function () {
          startCheck();
        }, fetchDelay);
      },
      timeout: 5000,
      complete: function (XMLHttpRequest, status) {
        if (status === 'timeout') {
          startCheck();
        }
      }
    })
  }

  var ajaxNotifyEl = $('.ajax-notify[data-enable=1]');
  if (ajaxNotifyEl.length === 1) {
    fetchFrom = ajaxNotifyEl.data('from');
    fetchUrl = ajaxNotifyEl.data('url');
    fetchDelay = ajaxNotifyEl.data('delay');
    startCheck();
  }
});
