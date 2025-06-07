<div wire:poll.5s class="p-6 bg-white rounded shadow max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4 text-gray-700">📋 وضعیت میزها</h2>

    @if($calledTables->isEmpty())
        <p class="text-gray-500">هیچ میزی در حال حاضر درخواست گارسون ندارد.</p>
    @else
        <ul class="space-y-3">
            @foreach($calledTables as $table)
                <li class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded flex justify-between items-center">
                    <span>🛎️ میز <strong>{{ $table->name }}</strong> نیاز به گارسون دارد!</span>
                    <button wire:click="markAsHandled({{ $table->id }})"
                            class="bg-lime-600 hover:bg-lime-700 text-white px-3 py-1 rounded">
                        رسیدگی شد ✅
                    </button>
                </li>
            @endforeach
        </ul>
    @endif



</div>
