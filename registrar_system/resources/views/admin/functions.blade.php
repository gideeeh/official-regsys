<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center h-10">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight no-underline hover:underline">
                {{ __('Registrar Functions') }}
            </h2>
        </div>
    </x-slot>

    <div class="stu-records py-6 max-h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="rfunction-container w-full">
                    <div class="rfunctioncard">
                        <div class="thumbnail">
                            <img src="{{asset('images/function-settings.jpg')}}" alt="Settings" class="functioncard-thumbnail">
                        </div>
                        <div class="function-link">
                            <h3 class="font-semibold text-l text-gray-800 leading-tight py-1">Settings</h3>
                        </div>
                        <div class="function-description">
                            <span>Set academic year, term, others</span>
                        </div>
                    </div>
                    <div class="rfunctioncard">
                        
                    </div>
                    <div class="rfunctioncard">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</x-app-layout>