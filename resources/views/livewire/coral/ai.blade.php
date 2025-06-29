<div id="aiModal" class="z-999 hidden bg-coral-body fixed top-0 left-0 w-screen h-screen flex flex-col justify-center items-center p-4">
    <livewire:back to="/?page=menu" />

    <div class="relative font-iransans-regular bg-white p-6 rounded shadow-lg max-w-lg w-full max-h-[80vh] flex flex-col" dir="rtl">
        <button 
            id="closeAiBtn" 
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl font-bold focus:outline-none"
            aria-label="بستن مودال"
            title="بستن"
        >
            &times;
        </button>     

        <div id="aiContent" class="overflow-auto flex-1 mb-4"></div>

        <button
            id="backHomeBtn"
            class="self-center text-coral border border-coral py-2 px-5 rounded font-iransans-thin hover:bg-coral hover:text-white transition focus:outline-none focus:ring-2 focus:ring-coral"
            aria-label="بازگشت به خانه"
            title="بازگشت به خانه"
        >
            بازگشت به خانه
        </button>
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

    // بستن مودال با کلید ESC
    document.addEventListener('keydown', function(e) {
        if(e.key === "Escape" && !aiModal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endpush
