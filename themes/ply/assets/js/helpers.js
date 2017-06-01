function playAudio(url, timeout) {
    return new Promise(function(resolve, reject) {
        let audio = new Audio();
        audio.preload = "auto";
        audio.autoplay = true;
        audio.onerror = reject;
        audio.onended = function() {
            setTimeout(resolve, timeout)
        };
        audio.src = url;
    });
}

function forEachPromise(items, fn, context) {
    return items.reduce(function (promise, item, index) {
        return promise.then(function () {
            return fn(item, index, context);
        });
    }, Promise.resolve());
}
export { playAudio, forEachPromise }
