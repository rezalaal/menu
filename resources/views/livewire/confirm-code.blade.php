<div 
    class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md mx-auto mt-12"
    x-data="otpForm()" 
    x-init="startTimer()" 
    x-cloak
    class="font-dastnevis farsi-numbers"
>
    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">کد تأیید را وارد کنید</h2>
    <p class="text-gray-600 text-sm mb-6 text-center">کد ارسال شده به شماره شما را در کادرهای زیر وارد کنید.</p>

    <!-- ورودی کد -->
    <div class="flex justify-center space-x-2 space-x-reverse mb-6">
        <template x-for="(digit, index) in code" :key="index">
            <input
                x-model="code[index]"
                x-ref="inputs[index]"
                type="text"
                maxlength="1"
                inputmode="numeric"
                pattern="[0-9]*"
                @input="handleInput(index)"
                @keydown.backspace.prevent="handleBackspace(index)"
                class="w-12 h-12 text-center border rounded-xl text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            >
        </template>
    </div>

    <!-- تایمر یا ارسال مجدد -->
    <div class="text-center text-sm text-gray-600 mb-4">
        <template x-if="timeLeft > 0">
            <span>مهلت باقی‌مانده: 
                <span class="font-bold" x-text="formatTime(timeLeft)"></span>
            </span>
        </template>
        <template x-if="timeLeft === 0">
            <button @click="resendCode" class="text-blue-600 hover:underline font-semibold">
                ارسال مجدد کد
            </button>
        </template>
    </div>

    <!-- دکمه تأیید -->
    <button
        @click="submitCode"
        class="w-full bg-blue-600 text-white py-2 rounded-xl font-semibold hover:bg-blue-700 transition"
    >
        تأیید کد
    </button>
</div>
@push('scripts')
<script>
function otpForm() {
    return {
        code: ['', '', '', '', ''],
        timeLeft: 120,
        timer: null,
        inputs: [],
        startTimer() {
            if (this.timer) clearInterval(this.timer);
            this.timer = setInterval(() => {
                if (this.timeLeft > 0) this.timeLeft--;
                else clearInterval(this.timer);
            }, 1000);
        },
        formatTime(seconds) {
            const m = String(Math.floor(seconds / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            return `${m}:${s}`;
        },
        resendCode() {
            this.code = ['', '', '', '', ''];
            this.timeLeft = 120;
            this.startTimer();
            console.log("کد مجدداً ارسال شد");
        },
        handleInput(index) {
            const val = this.code[index];
            if (val.length > 1) this.code[index] = val[0];
            if (val && index < this.code.length - 1) {
                this.$refs.inputs[index + 1].focus();
            }
        },
        handleBackspace(index) {
            if (this.code[index] === '' && index > 0) {
                this.$refs.inputs[index - 1].focus();
            } else {
                this.code[index] = '';
            }
        },
        submitCode() {
            const fullCode = this.code.join('');
            if (fullCode.length < 5) {
                alert("لطفاً همه ارقام کد را وارد کنید.");
                return;
            }
            console.log("کد وارد شده:", fullCode);
            // درخواست به Livewire یا API می‌تونه اینجا انجام بشه
        }
    }
}
</script>
@endpush
