class AppToast {
    static positions = {
        topLeft: 'toasts-top-left',
        topRight: 'toasts-top-right',
        topCenter: 'toasts-top-center',
        bottomLeft: 'toasts-bottom-left',
        bottomRight: 'toasts-bottom-right',
        bottomCenter: 'toasts-bottom-center',
    }

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
            title.textContent = options.title;
            toast.appendChild(title);
        }

        if (options.message) {
            const message = document.createElement('p');
            message.className = 'toast-message';
            message.textContent = options.message;
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
        const position = AppToast.positions[options.positionClass] ?? AppToast.positions.topRight;
        this.container.classList.remove(...Object.values(AppToast.positions));
        this.container.classList.add(position);

        // click callback
        if (typeof options.callback === 'function') {
            toast.addEventListener('click', options.callback);
        }

        // toast api
        let hidden = false;
        toast.hide = () => {
            if (hidden) {
                return;
            }

            hidden = true;
            clearTimeout(timeout);
            toast.classList.add('toast-fade-out');
            toast.addEventListener('animationend', removeToast, { once: true });

            if (options.onHide) {
                options.onHide();
            }
        };

        const removeToast = () => {
            toast.remove();
            delete this.toasts[toast.id];
        };

        if (options.single === true) {
            Object.values(this.toasts).forEach(other => {
                other.remove();
                delete this.toasts[other.id];
            });
        }

        const timeout = options.delay ? setTimeout(toast.hide, options.delay) : null;

        if (options.type) {
            toast.classList.add('toast-' + options.type);
        }

        toast.addEventListener('click', toast.hide);

        this.container.appendChild(toast);

        this.toasts[toast.id] = toast;
    }

    static show(options) {
        const instance = AppToast._getToastInstance()

        instance._show(options);
    }
}

export default AppToast;
