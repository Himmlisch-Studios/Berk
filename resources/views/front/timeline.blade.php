<div class="px-4 py-5 w-full bg-white shadow sm:rounded-lg sm:px-6">
    <h2 class="text-lg font-medium text-gray-900">@lang('Activity')</h2>
    <div class="flow-root mt-6">
        <ul role="list" class="-mb-8">
            @foreach ($activities as $activity)
                <li>
                    <div class="relative pb-8">
                        <div class="flex relative space-x-3">
                            <div>
                                @if ($activity->event == 'deleted')
                                    <span
                                        class="flex justify-center items-center w-8 h-8 bg-red-500 rounded-full ring-8 ring-white">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true" fill="none"
                                            stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                @elseif($activity->event == 'created')
                                    <span
                                        class="flex justify-center items-center w-8 h-8 bg-green-500 rounded-full ring-8 ring-white">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true" fill="none"
                                            stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                @else
                                    <span
                                        class="flex justify-center items-center w-8 h-8 bg-blue-500 rounded-full ring-8 ring-white">
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-wrap flex-1 gap-2 justify-between pt-1.5 space-x-4 min-w-0">
                                <div>
                                    <p class="text-sm text-gray-500">
                                        @lang(class_basename($activity->subject_type))
                                        @lang($activity->event)
                                        @lang('by')
                                        <a href="/admin/users/{{ $activity->causer_id }}"
                                            class="font-medium text-gray-900">
                                            {{ $activity->causer?->name ?? class_basename($activity->causer_type) . "($activity->causer_id)" }}
                                        </a>
                                    </p>
                                </div>
                                <div class="text-sm text-right text-gray-500 whitespace-nowrap">
                                    <time
                                        datetime="{{ $activity->created_at->format('Y-m-d') }}">{{ $activity->created_at->diffForHumans() }}</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
