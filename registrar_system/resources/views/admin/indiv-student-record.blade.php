<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center h-10">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <!-- Probably insert name??? -->
                {{__('Student Records')}}
            </h2>
            <div class="flex items-center space-x-4">
                <form action="/search" method="GET" id="searchForm">
                    <div class="relative flex">
                        <x-text-input 
                            class="h-6 center-placeholder searchbar" 
                            name="query" 
                            placeholder="Search Student" 
                            autocomplete="off"
                            spellcheck="false"
                            maxlength="38"/>
                        <button type="submit" class="input-icon">
                            <x-css-search />
                        </button>
                    </div>
                </form>                
            </div>
        </div>
    </x-slot>
    
    <div class="stu-records py-6 max-h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="student-information relative max-w">
                    <div class="student-prof-pic">
                        <img class="profile-pic" src="{{url('/images/profile_pic_sample.jpg')}}" alt="Profile Picture">
                    </div>
                    <div class="student-info-details">
                        <table>
                            <tr>
                                <td>Name</td>
                                <td>{{$student->first_name}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8" >
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            </div>
        </div>
    </div>
</x-app-layout>
