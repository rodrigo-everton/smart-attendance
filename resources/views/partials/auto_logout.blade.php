<script>
    (function() {
        let isNavigating = false;

        // Marca cliques em links internos como navegação
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href) {
                isNavigating = true;
            }
        });

        // Marca submit de formulários como navegação
        document.addEventListener('submit', function() {
            isNavigating = true;
        });

        // Marca F5, Ctrl+R, Ctrl+Shift+R como navegação (refresh)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F5' || (e.ctrlKey && e.key === 'r') || (e.ctrlKey && e.shiftKey && e.key === 'R')) {
                isNavigating = true;
            }
        });

        // Ao fechar a aba (NÃO refresh), envia logout via beacon
        window.addEventListener('beforeunload', function() {
            if (!isNavigating) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (csrfToken) {
                    const formData = new FormData();
                    formData.append('_token', csrfToken);
                    navigator.sendBeacon('/force-logout-beacon', formData);
                }
            }
            isNavigating = false;
        });
    })();
</script>
