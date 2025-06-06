<div dir="rtl" class="text-center mt-10 p-6">
    <h1 class="text-2xl font-bold mb-6 text-lime-950">صفحه گارسون</h1>

    <!--[if BLOCK]><![endif]--><?php if($notification): ?>
        <div class="text-red-600 text-xl font-bold mb-4"><?php echo e($notification); ?></div>
    <?php else: ?>
        <div class="text-gray-600">منتظر صدا زدن گارسون...</div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            window.Echo.channel('waiter-channel')
                .listen('.waiter-called', function (data) {
                    Livewire.emit('waiterCalled', data.tableId);
                    // اگر خواستی، صدای بوق هم پخش کن
                    // new Audio('/sounds/beep.mp3').play();
                });
        });
    </script>

</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/waiter-page.blade.php ENDPATH**/ ?>