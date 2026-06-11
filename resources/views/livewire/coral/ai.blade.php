<div id="aiModal" class="z-999 hidden fixed inset-0 bg-coral-body/95 backdrop-blur-sm flex flex-col justify-center items-center p-4">
    <div class="relative card-coral w-full max-w-lg max-h-[80vh] flex flex-col overflow-hidden animate-scale-in" dir="rtl">
        <div class="bg-gradient-header px-6 py-4 flex items-center justify-between">
            <h3 class="font-dastnevis text-coral-from text-lg">پیشنهاد ویژه</h3>
            <button
                id="closeAiBtn"
                class="w-8 h-8 flex items-center justify-center rounded-full bg-white/60 text-coral-from hover:bg-coral hover:text-white transition-all"
                aria-label="بستن"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div id="aiContent" class="flex-1 overflow-auto p-6 font-iransans-thin text-sm text-coral-from/80 leading-relaxed"></div>

        <div class="p-4 border-t border-coral/10">
            <button
                id="backHomeBtn"
                class="btn-outline w-full py-2.5 rounded-xl text-sm"
            >
                بازگشت به خانه
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/marked.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        fetch('/api/get-offer')
            .then(response => response.json())
            .then(data => {
                if (data.offer) {
                    const html = marked.parse(data.offer);
                    document.getElementById('aiContent').innerHTML = html;
                    document.getElementById('aiModal').classList.remove('hidden');
                }
            })
            .catch(err => console.error('API error:', err));
    }, 20000);

    const aiModal = document.getElementById('aiModal');
    const closeBtn = document.getElementById('closeAiBtn');
    const backHomeBtn = document.getElementById('backHomeBtn');

    function closeModal() {
        aiModal.classList.add('hidden');
    }

    closeBtn.addEventListener('click', closeModal);
    backHomeBtn.addEventListener('click', closeModal);

    document.addEventListener('keydown', function(e) {
        if(e.key === "Escape" && !aiModal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endpush
