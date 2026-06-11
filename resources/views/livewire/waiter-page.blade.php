<div wire:poll.5s class="p-6 max-w-xl mx-auto mt-6 pb-32" dir="rtl">
    <div class="bg-gradient-brand rounded-3xl shadow-soft p-6 mb-6 text-center">
        <h2 class="font-dastnevis text-2xl text-white text-shadow">وضعیت میزها</h2>
    </div>

    @if($calledTables->isEmpty())
        <div class="card-coral p-8 text-center">
            <p class="font-iransans-thin text-coral-from/50">هیچ میزی در حال حاضر درخواست گارسون ندارد.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($calledTables as $table)
                <div class="card-coral p-4 flex items-center justify-between border-r-4 border-amber-400 animate-fade-in-up">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        <span class="font-iransans-thin text-coral-from">میز <strong>{{ $table->name }}</strong> نیاز به گارسون دارد!</span>
                    </div>
                    <button wire:click="markAsHandled({{ $table->id }})"
                        class="btn-secondary text-xs px-4 py-1.5 rounded-lg">
                        رسیدگی شد
                    </button>
                </div>
            @endforeach
        </div>
    @endif
</div>
