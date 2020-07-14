import Plugin from 'src/plugin-system/plugin.class';
import HttpClient from 'src/service/http-client.service';
import DomAccess from 'src/helper/dom-access.helper';

export default class MettwarePlugin extends Plugin {
    static options = {
        csrfToken: '',
        stopRoute: ''
    };

    init() {
        this._client = new HttpClient();
        this._stopButton = DomAccess.querySelector(this.el, '.stop-button', false);
        this._message = DomAccess.querySelector(this.el, '.message-wrapper', false);
        this.addEventListener();
    }

    addEventListener() {
        if (!this._stopButton) {
            return;
        }

        this._stopButton.addEventListener('click', this.onClickStop.bind(this));
    }

    onClickStop() {
        this._client.post(this.options.stopRoute, JSON.stringify({ '_csrf_token': this.options.csrfToken }), this.onStopped.bind(this));
    }

    onStopped(response) {
        this._message.innerHTML = response;
    }
}
