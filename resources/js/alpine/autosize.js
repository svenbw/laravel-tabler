function Autosize(Alpine) {
    Alpine.directive('autosize', (el, {}, { cleanup }) => {
        const previousResize = el.style.resize;
        const previousMinHeight = el.style.minHeight;
        el.style.resize = 'none';

        let minHeightSet = false;

        const resize = () => {
            if (!el.scrollHeight) {
                return;
            }
            if (!minHeightSet) {
                el.style.minHeight = el.getBoundingClientRect().height + 'px';
                minHeightSet = true;
            }
            el.style.height = '4px';
            el.style.height = `${el.scrollHeight}px`;
        };

        resize();

        el.addEventListener('input', resize);

        const observer = new ResizeObserver(() => resize());
        observer.observe(el);

        cleanup(() => {
            observer.disconnect();
            el.removeEventListener('input', resize);
            el.style.resize = previousResize;
            el.style.minHeight = previousMinHeight;
        });
    });
}

export default Autosize;
