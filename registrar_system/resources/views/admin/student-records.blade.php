<div x-data="{ searchTerm: '{{ $searchTerm ?? '' }}' }">
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center h-10">
                <a href="{{ route('student-records') }}" class="font-semibold text-xl text-gray-800 leading-tight no-underline hover:underline">
                    {{ __('Student Records') }}
                </a>
                <x-search-form action="{{ route('student-records') }}" placeholder="Search Student" />
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
                                    <th class="px-6 py-3 text-left">Course</th>
                                    <th class="px-6 py-3 text-left">Year Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                <tr class="border-b hover:bg-gray-100" x-data="{}" @click="window.location.href='{{ route('student-records.show', $student->student_id) }}'" style="cursor: pointer;">
                                    <td class="px-6 py-4 text-left">{{$student->student_number}}</td>
                                    <td class="px-6 py-4 text-left">{{$student->first_name}}</td>
                                    <td class="px-6 py-4 text-left">{{$student->last_name.' '.$student->suffix}}</td>
                                    <td class="px-6 py-4 text-left">{{$student->program_code}}</td>
                                    <td class="px-6 py-4 text-left">{{$student->year_level}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>