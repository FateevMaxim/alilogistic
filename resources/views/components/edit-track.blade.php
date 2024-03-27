
<button data-modal-target="edit-modal{{$track->id}}" data-modal-toggle="edit-modal{{$track->id}}" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
        </svg>
</button>


<div id="edit-modal{{$track->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
    <div class="relative w-full h-full max-w-md md:h-auto">
        <div class="relative bg-white rounded-lg shadow">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="edit-modal{{$track->id}}">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Закрыть</span>
            </button>
            <div class="p-6 text-center">
                <h4 class="mb-5 text-lg font-normal text-gray-500">Редактирование трек кода</h4>
                <form method="POST" action="{{ route('edit-client-product') }}">
                    @csrf
                    <input type="hidden" name="track_id" value="{{$track->id}}" />
                    <x-text-input id="edit_track_code" class="block mt-1 w-full mb-2 border-2 text-gray-900" type="text" placeholder="Введите трек код" name="edit_track_code" value="{{$track->track_code}}" required />
                    <textarea id="edit_detail" name="edit_detail" rows="5" required="required" class="block mb-2 mx-auto w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Детали...">{{$track->detail}}</textarea>
                    <button type="submit" class="items-center px-4 py-3 bg-[#6e6e6e] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700  focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Сохранить') }}
                    </button>
                    <button data-modal-hide="edit-modal{{$track->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Отмена</button>
                </form>
            </div>
        </div>
    </div>
</div>
