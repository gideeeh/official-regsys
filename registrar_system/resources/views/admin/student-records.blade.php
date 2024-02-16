@extends('admin.records')
@section('content')
<div x-data="{ searchTerm: '{{ $searchTerm ?? '' }}' }">
    <a href="{{ route('student-records') }}" class="font-semibold text-xl text-gray-800 leading-tight no-underline hover:underline">
        <h2 class="text-2xl font-semibold mb-4">Student Records</h2>
    </a>
    <div class="flex justify-between space-x-4">
        <button @click="window.open('{{ route('student.add') }}', '_blank')" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition ease-in-out duration-150">+ Add Student</button>
        <x-search-form action="{{ route('student-records') }}" placeholder="Search Student" />
    </div>
    <div class="mt-4">
        {{ $students->links() }}
    </div>
    <div class="py-4">
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative" style="min-height: 405px;">   
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead >
                    <tr class="cursor-default">
                        <th class="px-6 py-3 text-left">Student Number</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Course</th>
                        <th class="px-6 py-3 text-left">Year Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr class="border-b hover:bg-gray-100" x-data="{}" @click="window.location.href='{{ route('student-records.show', $student->student_id) }}'" style="cursor: pointer;">
                        <td class="px-6 py-4 text-left">{{$student->student_number}}</td>
                        <td class="px-6 py-4 text-left">{{$student->first_name}} {{ substr($student->middle_name, 0, 1)}}.  {{$student->last_name.' '.$student->suffix}}</td>
                        <td class="px-6 py-4 text-left">{{$student->program_code ?? 'Not Available' }}</td>
                        <td class="px-6 py-4 text-left">{{$student->year_level}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection