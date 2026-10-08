(function (blocks) {
  function formatValue(value) {
    return String(value).padStart(2, '0');
  }

  function setValue(element, name, value) {
    var target = element.querySelector('[data-countdown-value="' + name + '"]');

    if (target) {
      target.textContent = formatValue(value);
    }
  }

  function updateCountdown(element) {
    var goLive = element.dataset.goLive;
    var targetTime = new Date(goLive).getTime();

    if (!goLive || Number.isNaN(targetTime)) {
      return false;
    }

    var difference = Math.max(0, targetTime - Date.now());
    var totalSeconds = Math.floor(difference / 1000);
    var days = Math.floor(totalSeconds / 86400);
    var hours = Math.floor((totalSeconds % 86400) / 3600);
    var minutes = Math.floor((totalSeconds % 3600) / 60);
    var seconds = totalSeconds % 60;

    setValue(element, 'days', days);
    setValue(element, 'hours', hours);
    setValue(element, 'minutes', minutes);
    setValue(element, 'seconds', seconds);

    return difference > 0;
  }

  blocks.register('[data-countdown]', function (element) {
    if (!updateCountdown(element)) {
      return;
    }

    var interval = window.setInterval(function () {
      if (!updateCountdown(element)) {
        window.clearInterval(interval);
      }
    }, 1000);

    return function () {
      window.clearInterval(interval);
    };
  });
}(window.stilpressBlocks));
