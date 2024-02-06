<div x-data="{ searchTerm: '{{ $searchTerm ?? '' }}' }">
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center h-10">
                <a href="{{ route('enrollment-records') }}" class="font-semibold text-xl text-gray-800 leading-tight no-underline hover:underline">
                    {{ __('Enrollment Records') }}
                </a>
                <x-search-form action="{{ route('enrollment-records') }}" placeholder="Search Enrollment" />
            </div>
        </x-slot>

        <div class="stu-records py-6 max-h-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-hidden sm:rounded-lg shadow-sm">
                        <table class="min-w-full">
                            <thead >
                                <tr class="cursor-default">
                                    <th class="px-6 py-3 text-left">Student Number</th>
                                    <th class="px-6 py-3 text-left">First Name</th>
                                    <th class="px-6 py-3 text-left">Last Name</th>
                                    <th class="px-6 py-3 text-left">Department Name</th>
                                    <th class="px-6 py-3 text-left">Year Level</th>
                                    <th class="px-6 py-3 text-left">Academic Year</th>
                                    <th class="px-6 py-3 text-left">Term</th>
                                    <th class="px-6 py-3 text-left">Continuing Student</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($enrollments as $enrollment)
                                <tr 
                                    class="border-b hover:bg-gray-100" 
                                    x-data="{}" 
                                    @click="window.location.href='{{ route('enrollment-records.show', $enrollment->enrollment_id) }}'" 
                                    style="cursor: pointer;">
                                    <td class="px-6 py-4 text-left">{{$enrollment->student_number}}</td>
                                    <td class="px-6 py-4 text-left">{{$enrollment->first_name}}</td>
                                    <td class="px-6 py-4 text-left">{{$enrollment->last_name.' '.$enrollment->suffix}}</td>
                                    <td class="px-6 py-4 text-left">{{$enrollment->program_code}}</td>
                                    <td class="px-6 py-4 text-left">{{$enrollment->year_level}}</td>
                                    <td class="px-6 py-4 text-left">{{$enrollment->academic_year}}</td>
                                    <td class="px-6 py-4 text-left">{{$enrollment->term}}</td>
                                    <td class="px-6 py-4 text-left">{{$enrollment->is_Continuing}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $enrollments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>