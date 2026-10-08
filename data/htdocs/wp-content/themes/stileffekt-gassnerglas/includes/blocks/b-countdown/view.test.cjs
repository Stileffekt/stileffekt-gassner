const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

const script = fs.readFileSync(path.join(__dirname, 'view.js'), 'utf8');
const fixedNow = new Date('2026-08-31T10:00:00+00:00').getTime();

function createCountdownElement(goLive) {
  const nodes = {
    days: {textContent: ''},
    hours: {textContent: ''},
    minutes: {textContent: ''},
    seconds: {textContent: ''},
  };

  return {
    dataset: {goLive},
    nodes,
    querySelector(selector) {
      const match = selector.match(/\[data-countdown-value="([^"]+)"\]/);

      if (!match) {
        return null;
      }

      return nodes[match[1]] ?? null;
    },
  };
}

function FixedDate(value) {
  if (value === undefined) {
    return new Date(fixedNow);
  }

  return new Date(value);
}

FixedDate.now = () => fixedNow;
FixedDate.parse = Date.parse;
FixedDate.UTC = Date.UTC;

const futureCountdown = createCountdownElement('2026-09-02T12:03:04+00:00');
const expiredCountdown = createCountdownElement('2026-08-30T10:00:00+00:00');
const intervals = [];

vm.runInNewContext(script, {
  Date: FixedDate,
  Number,
  String,
  document: {
    readyState: 'complete',
    querySelectorAll() {
      return [futureCountdown, expiredCountdown];
    },
    addEventListener() {
      throw new Error('DOMContentLoaded listener should not be needed for a ready document');
    },
  },
  window: {
    setInterval(callback, delay) {
      intervals.push({callback, delay});
      return intervals.length;
    },
  },
});

assert.equal(futureCountdown.nodes.days.textContent, '02');
assert.equal(futureCountdown.nodes.hours.textContent, '02');
assert.equal(futureCountdown.nodes.minutes.textContent, '03');
assert.equal(futureCountdown.nodes.seconds.textContent, '04');

assert.equal(expiredCountdown.nodes.days.textContent, '00');
assert.equal(expiredCountdown.nodes.hours.textContent, '00');
assert.equal(expiredCountdown.nodes.minutes.textContent, '00');
assert.equal(expiredCountdown.nodes.seconds.textContent, '00');

assert.equal(intervals.length, 2);
assert.deepEqual(intervals.map((interval) => interval.delay), [1000, 1000]);
