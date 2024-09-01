self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        console.log("this is the message here here", msg);
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            data: msg.data
        }));
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    var data = event.notification.data;

    var url = data.url;

    /**
     * if exists open browser tab with matching url just set focus to it,
     * otherwise open new tab/window with sw root scope url
     */
    event.waitUntil(
        clients.openWindow(url)
    );
});