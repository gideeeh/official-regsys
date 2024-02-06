<div x-data="{ searchTerm: '{{ $searchTerm ?? '' }}', showModal: false, showMore: false }">
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center h-10">
            <a href="{{ route('student-records') }}" class="font-semibold text-xl text-gray-800 leading-tight no-underline hover:underline">
                {{ __('Student Records') }}
            </a>
            <x-search-form action="{{ route('student-records') }}" placeholder="Search Student" />
        </div>
    </x-slot>
    
    <div class="py-6 max-h-full">
        <div class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8" >
            <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <main class="indiv-student-panel">
                    <div class="stu-info flex">
                        <div class="img-frame w-3/12">
                            <img class="w-full" src="{{ asset('images/profile_pic_sample.jpg') }}" alt="{{$student->last_name}}">
                        </div>
                        <div class="stu-details w-9/12">
                            <h1>{{$student->first_name}} {{$student->middle_name}} {{$student->last_name}} {{$student->suffix}}</h1>
                            <p>Student Number: {{ $student->student_number }}</p>
                            <p>Course: {{ $student->latestEnrollment->program->program_code }}</p>
                            <p>Year Level: {{ $student->latestEnrollment->year_level }}</p>
                            <p>Scholarship: {{ $student->latestEnrollment->scholarship_type }}</p>
                            <p>Enrollment Status: {{ $student->latestEnrollment->scholarship_type }}</p>
                            <a href="#" @click="showModal = true">Personal Information</a>
                            <div x-show="showModal" @click.away="showModal = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="my-modal">
                                <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white">
                                    <div class="mt-3 text-left modal-content"> 
                                        <h2 class="text-xl leading-6 px-7 font-medium text-gray-900">
                                            {{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}
                                        </h2>
                                        <div class="mt-2 px-7 py-3">
                                            <h3 class="text-lg">Contact Information</h3>
                                            <p>School Email: {{$student->school_email}}</p>
                                            <p>Personal Email: {{$student->personal_email}}</p>
                                            <p>Phone Number: {{$student->phone_number}}</p>
                                            <h3>Personal Information</h3>
                                            <p>Address: {{$student->house_num}} {{$student->street}}, {{$student->brgy}}, {{$student->city_municipality}}, {{$student->province}} {{$student->zipcode}}</p>
                                            <p>Birthday: {{$student->birthdate}}</p>
                                            <h3>Emergency Contacts</h3>
                                            <p>Guardian Name: {{$student->guardian_name}}</p>
                                            <p>Guardian Contact: {{$student->guardian_contact}}</p>
                                            <!-- Click to Show More -->
                                            <button 
                                                @click="showMore = !showMore" 
                                                class="mt-4 px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:bg-blue-700"
                                                x-text="showMore ? 'Show Less' : 'Show More'"
                                            >
                                            </button>

                                            <!-- Extra Information (conditionally rendered) -->
                                            <div x-show="showMore" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                                                <h3 class="text-lg">Additional Information</h3>
                                                <p>Marital Status: {{$student->civil_status}}</p>
                                                <p>Nationality: {{$student->nationality}}</p>
                                                <p>Sex: {{$student->sex}}</p>
                                                <p>Religion: {{$student->religion}}</p>
                                                <p>Elementary: {{$student->elementary}}</p>
                                                <p>Elem Year Grad: {{$student->elem_yr_grad}}</p>
                                                <p>High School: {{$student->highschool}}</p>
                                                <p>HS Year Grad: {{$student->hs_yr_grad}}</p>
                                                <p>College: {{$student->college}}</p>
                                                <p>College Year Final Year: {{$student->collge_year_ended}}</p>
                                                <!-- Add other additional fields here -->
                                            </div>

                                            <!-- Add more personal information fields here -->
                                        </div>
                                        <div class="items-center px-4 py-3">
                                            <button @click="showModal = false" id="ok-btn" class="px-4 py-2 bg-gray-800 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="stu-academic-info">

                    </div>
                </main>
                <aside class="indiv-student-sidepanel">
                    <div class="stu-notes">
                        <h1>Notes For This Student</h1>
                        <h1>Student's Concerns</h1>
                        <h1>Appointment Schedule</h1>
                        <p>Insert Schedule</p>
                        <p>First 50 characters. Clickable for show more</p>
                    </div>
                    <div class="stu-functions">
                        <a href="#">View Current COR</a>
                        <a href="#">View Files</a>
                        <a href="#">Released Records</a>
                        <a href="#">Issue Exam Permit</a>
                        <a href="#">Issue COR</a>
                        <a href="#">Issue Gradeslip</a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
</div>
