<div id="aiModal" class="z-999 hidden bg-coral-body fixed top-0 left-0 w-screen h-screen flex justify-center items-center">
    <livewire:back to="/?page=menu">
    <div class="relative font-iransans-regular bg-white p-6 rounded shadow-lg" dir="rtl">   
        <button 
            id="closeAiBtn" 
            class="absolute top-1 right-1 text-gray-600 hover:text-gray-900 text-2xl font-bold focus:outline-none"
            aria-label="بستن"
        >
            &times;
        </button>     
        <div id="aiContent"></div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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
    }, 1000);

    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'closeAiBtn') {
            document.getElementById('aiModal').classList.add('hidden');
        }
    });
});
</script>
@endpush
