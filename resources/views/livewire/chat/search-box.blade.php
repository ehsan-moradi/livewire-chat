<div>
    <div class="relative text-gray-600 mx-3">
        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 viewBox="0 0 24 24" class="w-6 h-6 text-gray-300">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </span>
        <input type="search" wire:model="search" class="block w-full py-2 pl-10 bg-gray-100 rounded outline-none"
               name="search"
               placeholder="Search"
               autocomplete="off"
               required/>
    </div>
{{--    <div class="absolute w-full h-full inset-0 bg-indigo-50 px-3">--}}
{{--        <ul>--}}
{{--            <li class="hover:bg-gray-100 py-1"><a href="" class="block">ehsan</a></li>--}}
{{--            <li class="hover:bg-gray-100 py-1"><a href="" class="block">احسان</a></li>--}}
{{--            <li class="hover:bg-gray-100 py-1"><a href="" class="block">احسان مرادی</a></li>--}}
{{--        </ul>--}}
{{--    </div>--}}

    @if($search && count($result))
        <div class="absolute w-full h-full inset-0 bg-indigo-100 mt-16" >
            <ul>
                @foreach($result as $item)
                    <li class="hover:bg-gray-100 py-2 px-3 cursor-pointer flex items-center"
                        wire:click="checkConversation({{ $item->id }})"
                    >
                        <img src="{{ $item->avatar_holder }}" alt="{{ $item->name }}" class="w-10 rounded-full mr-2">
                        {{ $item->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($search && !count($result))
        <div class="absolute w-full h-full inset-0 bg-indigo-100 mt-16 text-center text-xl">پیدا نشد</div>
    @endif

</div>
