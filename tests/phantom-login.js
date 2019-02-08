/**
 * This script fetches new oauth tokens via phantomjs
 *
 * @author www.pcsg.de (Henning Leutz - https://twitter.com/de_henne)
 * @use phantom user1 --debug
 */

let debug          = false;
let testindex      = 0;
let loadInProgress = false;

var system = require('system');
var args   = system.args;

let username = '';
let password = '';

username = args[1];
password = args[2];

if (typeof args[3] !== 'undefined' && args[3] === '--debug') {
    debug = true;
}

/********** PHANTOM SETTINGS *********************/

let webPage = require('webpage');
let page    = webPage.create();

page.settings.javascriptEnabled = true;
page.settings.loadImages        = false; // is faster

phantom.cookiesEnabled    = true;
phantom.javascriptEnabled = true;

/********** SETTINGS END *****************/

let logger = function (msg) {
    if (debug) {
        console.log(msg);
    }
};

page.onConsoleMessage = function (msg) {
    if (debug) {
        console.log(msg);
    }
};

function clickHelper(boundingClientRect) {
    page.sendEvent(
        'click',
        boundingClientRect.left + boundingClientRect.width / 2,
        boundingClientRect.top + boundingClientRect.height / 2
    );
}

/********** DEFINE STEPS ***********************/

let steps = [

    function () {
        logger('');
        logger('Step 1 - Open oauth page');

        page.open("http://henbug.seaofsin.de/makerlist/", function (status) {

        });
    },

    function () {
        logger('');
        logger('Step 2 - Login');

        let submit = page.evaluate(function (username, password) {
            var formSelector = 'form[action="/api-auth/login/"]';
            var LoginForm    = document.querySelector('form[action="/api-auth/login/"]');

            if (LoginForm) {
                document.querySelector(formSelector + ' [name="username"]').value = username;
                document.querySelector(formSelector + ' [name="password"]').value = password;

                return document.querySelector('[type="submit"]').getBoundingClientRect();
            }

            logger('*** LOGIN FAILED ***');

            return null;
        }, username, password);

        if (submit) {
            logger('- submit');
            loadInProgress = true;
            clickHelper(submit);

            setTimeout(function () {

            })
        }
    },

    function () {
        logger('');
        logger('Step 3 - Accept permissions');

        page.evaluate(function () {
            let a = document.querySelector('input[name="allow"]');
            let e = document.createEvent('MouseEvents');

            e.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
            a.dispatchEvent(e);
        });

        logger('- submit');
        loadInProgress = true;
        //clickHelper(submit);
    },

    function () {
        logger('');
        logger('Step 4 - Read oauth tokens');

        let result = page.evaluate(function () {
            return document.body.innerHTML.replace('<pre>', '').replace('</pre>', '');
        });

        console.log(result);
    }
];

/********** END STEPS ***********************/

logger('All settings loaded, start with execution');

let interval = setInterval(executeRequestsStepByStep, 50);

function executeRequestsStepByStep() {
    if (loadInProgress === false && typeof steps[testindex] == "function") {
        steps[testindex]();
        testindex++;
    }

    if (typeof steps[testindex] !== "function") {
        clearInterval(interval);
        exit();
    }
}

function exit() {
    page.stop();
    page.close();
    phantom.exit(0);
}

/**
 * listener
 */

page.onLoadStarted = function () {
    loadInProgress = true;
    logger('Loading started');
};

page.onLoadFinished = function () {
    loadInProgress = false;
    logger('Loading finished');
};

page.onConsoleMessage = function (msg) {
    logger(msg);
};
