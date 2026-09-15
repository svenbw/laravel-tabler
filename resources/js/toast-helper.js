class AppToast {
    toasts = {}
    container = undefined
    instanceId = 0

    constructor(container) {
        this.container = container
    }

    static _getToastInstance() {
        let container = document.getElementById('toast-container')
        if (! container) {
            container = AppToast._createToastContainer()
            container._AppToast = new AppToast(container)
        }

        return container._AppToast
    }

    static _createToastContainer() {
        const container = document.createElement('div')
        container.id = 'toast-container'
        container.setAttribute('role', 'alert')
        container.setAttribute('aria-live', 'assertive')
        container.setAttribute('aria-atomic', 'true')
        document.body.appendChild(container)

        return container
    }

    _show(options) {
        const toast = document.createElement('div');
        toast.id = 'toast-' + (++this.instanceId);
        toast.className = 'toast-toast';

        if (options.title) {
            const title = document.createElement('strong');
            title.className = 'toast-title';
            title.innerHTML = options.title;
            toast.appendChild(title);
        }

        if (options.message) {
            const message = document.createElement('p');
            message.className = 'toast-message';
            message.innerHTML = options.message;
            toast.appendChild(message);
        }

        if (options.image) {
            const img = document.createElement('img');
            img.src = options.image;
            img.className = 'toast-image';
            toast.appendChild(img);
        }

        if (options.onHide) {
            // do something
        }

        // position
        var position = options.positionClass;
        switch (position) {
            case 'topLeft':
                this.container.classList.add('toasts-top-left');
                break;
            case 'bottomLeft':
                this.container.classList.add('toasts-bottom-left');
                break;
            case 'bottomRight':
                this.container.classList.add('toasts-bottom-right');
                break;
            case 'topRight':
                this.container.classList.add('toasts-top-right');
                break;
            case 'topCenter':
                this.container.classList.add('toasts-top-center');
                break;
            case 'bottomCenter':
                this.container.classList.add('toasts-bottom-center');
                break;
            default:
                this.container.classList.add('toasts-top-right');
                break;
        }

        // click callback
        if (typeof options.callback === 'function') {
            toast.addEventListener('click', options.callback);
        }

        // toast api
        toast.hide = function () {
            toast.className += ' toast-fade-out';
            toast.addEventListener('animationend', removeToast, false);

            if (options.onHide) {
                options.onHide();
            }
        };

        if (options.single === true) {
            var elements =
                document.getElementsByClassName('toast-toast');
            while (elements.length > 0) {
                elements[0].parentNode.removeChild(elements[0]);
            }
        }

        if (options.delay) {
            setTimeout(toast.hide, options.delay);
        }

        if (options.type) {
            toast.className += ' toast-' + options.type;
        }

        toast.addEventListener('click', toast.hide);

        function removeToast() {
            const container = document.getElementById('toast-container')
            container.removeChild(toast);
        }

        this.container.appendChild(toast);

        this.toasts[toast.id] = toast;

    } 

    static show(options) {
        const instance = AppToast._getToastInstance()

        instance._show(options);
    }
}

export default AppToast;
