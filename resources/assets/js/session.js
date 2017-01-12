var $sessionModal = $("#session-modal");
var $sessionModalIFrame = $sessionModal.find("iframe");
var LastRequestTime = moment();

/**
 * Check if session lifetime exits to prevent errors on login page.
 */
if (typeof SessionLifetime !== 'undefined') {
    /**
     * Setup session modal to be impossible to close manually
     */
    $sessionModal.modal({
        backdrop: 'static',
        keyboard: false,
        show: false
    });

    /**
     * Check session expiration every 5 seconds.
     * If expired, force logout (prevents minor time differences between server and client),
     * and open the session modal on the login page.
     */
    setInterval(function() {
        var SessionExpired = moment(LastRequestTime).add(SessionLifetime, 'minutes').isBefore(moment());

        if (SessionExpired && !$sessionModal.hasClass('in')) {
            $.get(LogoutUrl).success(function() {
                $sessionModalIFrame.attr('src', LoginUrl).one('load', function() {
                    $sessionModal.modal('show');
                });
            });
        }
    }, 5000);

    /**
     * Send an 'authenticated' message to parent.
     * This informs the parent to close the Session Modal.
     */
    parent.postMessage('authenticated', '*');

    window.addEventListener('message', function(e) {
        var key = e.message ? 'message' : 'data';
        var message = e[key];

        if (message == 'authenticated') {
            LastRequestTime = moment();
            $sessionModal.modal('hide');
        }
    });

    /**
     * Extends XMLHttpRequest object to update LastRequestTime at every request
     */
    (function () {
        var __xhr = window.XMLHttpRequest; // back up
        function XMLHttpRequest() { // wrap
            LastRequestTime = moment();
            return new __xhr;
        }
        window.XMLHttpRequest = XMLHttpRequest;
    }());
}