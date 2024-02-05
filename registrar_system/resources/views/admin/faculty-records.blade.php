<div x-data="{ searchTerm: '{{ $searchTerm ?? '' }}' }">
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center h-10">
                <a href="{{ route('faculty-records') }}" class="font-semibold text-xl text-gray-800 leading-tight no-underline hover:underline">
                    {{ __('Faculty Records') }}
                </a>
                <div class="flex items-center space-x-4">
                    <form action="/admin/faculty-records" method="GET" id="searchForm" x-ref="searchForm">
                        <div class="relative flex">
                            <x-text-input 
                                class="h-6 center-placeholder searchbar" 
                                name="query" 
                                placeholder="Search Faculty" 
                                autocomplete="off"
                                spellcheck="false"
                                maxlength="38"
                                x-model="searchTerm" /> <!-- Bind input to searchTerm using x-model -->

                            <!-- Show search icon when searchTerm is empty -->
                            <button type="submit" class="input-icon" x-show="!searchTerm">
                                <x-css-search />
                            </button>

                            <!-- Show clear icon when searchTerm is not empty -->
                            <div x-show="searchTerm" @click.prevent="searchTerm = ''; $nextTick(() => $refs.searchForm.dispatchEvent(new Event('submit')));" class="input-icon" style="cursor: pointer;">
                                <x-tabler-x />
                            </div>
                        </div>
                    </form>              
                </div>
            </div>
        </x-slot>

        <div class="stu-records py-6 max-h-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-hidden sm:rounded-lg shadow-sm">
                        <table class="min-w-full">
                            <thead >
                                <tr class="cursor-default">
                                    <th class="px-6 py-3 text-left">First Name</th>
                                    <th class="px-6 py-3 text-left">Last Name</th>
                                    <th class="px-6 py-3 text-left">Department Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($professors as $professor)
                                <tr class="border-b hover:bg-gray-100" x-data="{}" @click="window.location.href='{{ route('faculty-records.show', $professor->prof_id) }}'" style="cursor: pointer;">
                                    <td class="px-6 py-4 text-left">{{$professor->first_name}}</td>
                                    <td class="px-6 py-4 text-left">{{$professor->last_name.' '.$professor->suffix}}</td>
                                    <td class="px-6 py-4 text-left">{{$professor->dept_name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $professors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>