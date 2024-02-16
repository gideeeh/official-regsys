@extends('admin.records')
@section('content')
<div x-data="{ searchTerm: '{{ $searchTerm ?? '' }}' }">
    <div class="flex justify-between items-center space-x-4">
        <a href="{{ route('student-records') }}" class="font-semibold text-xl text-gray-800 leading-tight no-underline hover:underline">
            <span class="text-2xl font-semibold mb-4">Student Records</span>
        </a>
        <x-search-form action="{{ route('student-records') }}" placeholder="Search Student" />
    </div>
    <div class="mt-6">
        {{ $students->links() }}
    </div>
    <div class="py-4">
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative" style="min-height: 405px;">   
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead >
                    <tr class="cursor-default">
                        <th class="bg-blue-500 text-white p-2">Student Number</th>
                        <th class="bg-blue-500 text-white p-2">Name</th>
                        <th class="bg-blue-500 text-white p-2">Course</th>
                        <th class="bg-blue-500 text-white p-2">Year Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr class="border-b hover:bg-gray-100" x-data="{}" @click="window.location.href='{{ route('student-records.show', $student->student_id) }}'" style="cursor: pointer;">
                        <td class="border-dashed border-t border-gray-200 p-2 py-4">{{$student->student_number}}</td>
                        <td class="border-dashed border-t border-gray-200 p-2 py-4">{{$student->first_name}} {{ substr($student->middle_name, 0, 1)}}.  {{$student->last_name.' '.$student->suffix}}</td>
                        <td class="border-dashed border-t border-gray-200 p-2 py-4">{{$student->program_code ?? 'Not Available' }}</td>
                        <td class="border-dashed border-t border-gray-200 p-2 py-4">{{$student->year_level}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection