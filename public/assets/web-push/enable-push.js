registerServiceWorker();

function registerServiceWorker() {
    if(Notification.permission === "granted"){
        subscribeUserToPush();
    }else if(Notification.permission === 'default'){
        askUserForPermission();
    }else{
        $(document).find('li.allow-notification-header-info').html('<p style="color: maroon;">Allow Web Push Notification <i style="color: maroon; font-size: 20px;" class="mdi mdi-information" id="notification-blocked-info" data-toggle="tooltip" data-placement="top" title="Click on the info or lock icon on the address bar just before the url. Select Allow on the dropdown next to Notifications. If the notifications dropdown is not visible, go to you browser setting."></i></p>');
        $('[data-toggle="tooltip"]').tooltip();
    }
    // return navigator.serviceWorker.register('./web-push/sw.js')
    //     .then(function (registration) {
    //         // console.log('Service worker successfully registered.');
    //         return registration;
    //     })
    //     .catch(function (err) {
    //         // console.error('Unable to register service worker.', err);
    //     });
}


function askUserForPermission() {
    askPermission().then(function (permission) {
        if (permission === 'granted') {
            $(document).find('li.allow-notification-header-info').html('');
            subscribeUserToPush();
        } else {
            $(document).find('li.allow-notification-header-info').html('<p style="color: maroon;">Allow Web Push Notification <i style="color: maroon; font-size: 20px;" class="mdi mdi-information" id="notification-blocked-info" data-toggle="tooltip" data-placement="top" title="Click on the info or lock icon on the address bar just before the url. Select Allow on the dropdown next to Notifications. If the notifications dropdown is not visible, go to you browser setting."></i></p>');
            $('[data-toggle="tooltip"]').tooltip();
        }
    }).catch(function (err) {
        console.log("This is the error ::::", err);
    });

}

function askPermission() {
    return new Promise(function (resolve, reject) {
        Notification.requestPermission().then(function (permission) {
            resolve(permission);
        });
    });
}

function subscribeUserToPush() {
    return navigator.serviceWorker.register('./assets/web-push/sw.js').then(function (registration) {
        var subscribeOptions = {
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(
                'BIOnvD-KGzNpCWWEtr9yjDYW7cCLdN0dNGvwvk2AofqwDtymYW4IM660ru3MayfP1whPVKj6aHp_HH9CNe2GVV8'
            )
        };

        return registration.pushManager.subscribe(subscribeOptions);
    })
        .then(function (pushSubscription) {
            storePushSubscription(pushSubscription);
        }).catch(function (err) {
            // console.log("this is the error ::::", err);
        });
}

function urlBase64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function storePushSubscription(pushSubscription) {
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    fetch(baseUrl + '/web-push/push', {
        method: 'POST',
        body: JSON.stringify(pushSubscription),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    }).then(function (res) {
        return res.json();
    }).then(function (res) {
        console.log(res)
    }).catch(function (err) {
        console.log(err)
    });
}