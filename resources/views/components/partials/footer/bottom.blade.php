<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="https://github.com/svenbw/csa" target="_blank" class="link-secondary" rel="noopener">Source code</a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        {{ __('tabler::common.copyright') }} &copy; @appYear()
                        <a href="" class="link-secondary">{{config('app.bottom_title', 'svenbw tabler')}}</a>.
                        {{ __('tabler::common.all_rights_reserved') }}
                    </li>
                    <li class="list-inline-item">
                        @appVersion()
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
