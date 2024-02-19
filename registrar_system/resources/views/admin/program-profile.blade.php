@extends('admin.functions')
@section('content')
<div x-data="{ manageProgramModal: false, currentYear: '', currentTerm: '', selectedSubjects: [] }">
    <x-alert-message />
    <span>Program Profile:  </span>
    <h2>{{$program->program_name}}</h2>
    <span>About: </span>
    <span>Program Coordinator:</span>
    <span>Total Enrolled Students:</span>
    <span>Total Units:</span>
    <h2>Curriculum Details</h2>
    <h3>1st Year</h3>
    <h3>Term 1</h3><span @click="manageProgramModal=true; currentYear = '1'; currentTerm = '1'">Manage</span>
    <h3>Term 2</h3><span @click="manageProgramModal=true; currentYear = '1'; currentTerm = '2'">Manage</span>
    <h3>Term 3</h3><span @click="manageProgramModal=true; currentYear = '1'; currentTerm = '3'">Manage</span>
    <h3>2nd Year</h3>
    <h3>Term 1</h3><span @click="manageProgramModal=true">Manage</span>
    <h3>Term 2</h3><span @click="manageProgramModal=true">Manage</span>
    <h3>Term 3</h3><span @click="manageProgramModal=true">Manage</span>
    <h3>3rd Year</h3>
    <h3>Term 1</h3><span @click="manageProgramModal=true">Manage</span>
    <h3>Term 2</h3><span @click="manageProgramModal=true">Manage</span>
    <h3>Term 3</h3><span @click="manageProgramModal=true">Manage</span>
    <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
        <option value="AL">Alabama</option>
        <option value="WY">Wyoming</option>
    </select>
    <!-- Manage Program Modal -->
    <h1>{{$program_id}}</h1>
    <div x-show="manageProgramModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4 z-50">
        <div class="modal-content bg-white p-8 rounded-lg shadow-lg overflow-auto max-w-md w-full max-h-[80vh]">
            <h3 class="text-lg font-bold mb-4" x-text="'Manage Subjects: Year - ' + currentYear + ' Term - ' + currentTerm"></h3>
            <form action="{{ route('program-subject.save', ['program_id' => $program_id]) }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="program_id" x-model="{{ $program_id }}">
                <input type="hidden" name="year" x-model="currentYear">
                <input type="hidden" name="term" x-model="currentTerm">
                <div>
                    <label for="assign_subject" class="block text-sm font-medium text-gray-700">Pre-Requisite 1:</label>
                    <select id="assign_subject" name="subject_ids[]" multiple="multiple" x-model="selectedSubjects" style="width: 75%;">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" @click="manageProgramModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition ease-in-out duration-150">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition ease-in-out duration-150">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

    $('#assign_subject').select2({
        width: 'resolve',
        placeholder: "Select a subject",
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: '/admin/functions/get-subjects',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.subject_id,
                            text: item.subject_name 
                        };
                    })
                };
            },
            cache: true
        }
    });
});
</script>
@endsection