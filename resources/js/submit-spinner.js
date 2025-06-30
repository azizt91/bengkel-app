document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            const btn = form.querySelector('[data-submit-spinner]');
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');

                if (!btn.querySelector('svg')) {
                    const spinner = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    spinner.setAttribute('class', 'animate-spin -ml-1 mr-2 h-5 w-5 text-white inline');
                    spinner.setAttribute('fill', 'none');
                    spinner.setAttribute('viewBox', '0 0 24 24');
                    spinner.innerHTML = '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>';
                    btn.prepend(spinner);
                }
            }
        });
    });
});
