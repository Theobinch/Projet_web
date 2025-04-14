<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">{{ $cohort->name }}</span>
        </h1>
    </x-slot>

    <!-- begin: grid -->
    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-2">
            <div class="grid">
                <div class="card card-grid h-full min-w-full">

                    <div class="card-header">
                        <h3 class="card-title">Enseignants</h3>
                    </div>
                    <div class="card-body">
                        <div data-datatable="true" data-datatable-page-size="30">
                            <div class="scrollable-x-auto">
                                <table class="table table-border" data-datatable-table="true">
                                    <thead>
                                    <tr>
                                        <th class="min-w-[135px]">
                                            <span class="sort asc">
                                                 <span class="sort-label">Nom</span>
                                                 <span class="sort-icon"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[135px]">
                                            <span class="sort">
                                                <span class="sort-label">Prénom</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($cohortTeachers as $cohortTeacher)
                                        <tr>
                                            <td>{{ $cohortTeacher->last_name ?? '---' }}</td>
                                            <td>{{ $cohortTeacher->first_name ?? '---' }}</td>

                                            <td>
                                                <form action="{{ route('cohort_teacher.delete', ['userId' => $cohortTeacher->id, 'cohortId' => $cohort->id]) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer cet enseignant de cette promotion ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cursor-pointer text-red-600">
                                                        <i class="ki-filled ki-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                                <div class="flex items-center gap-2 order-2 md:order-1">
                                    Show
                                    <select class="select select-sm w-16" data-datatable-size="true" name="perpage"></select>
                                    per page
                                </div>
                                <div class="flex items-center gap-4 order-1 md:order-2">
                                    <span data-datatable-info="true"></span>
                                    <div class="pagination" data-datatable-pagination="true"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-header">
                        <h3 class="card-title">Etudiants</h3>
                    </div>
                    <div class="card-body">
                        <div data-datatable="true" data-datatable-page-size="30">
                            <div class="scrollable-x-auto">
                                <table class="table table-border" data-datatable-table="true">
                                    <thead>
                                    <tr>
                                        <th class="min-w-[135px]">
                                            <span class="sort asc">
                                                 <span class="sort-label">Nom</span>
                                                 <span class="sort-icon"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[135px]">
                                            <span class="sort">
                                                <span class="sort-label">Prénom</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[135px]">
                                            <span class="sort">
                                                <span class="sort-label">Date de naissance</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                        </th>
                                        <th class="max-w-[50px]"></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($cohortStudents as $cohortStudent)
                                        <tr>
                                            <td>{{ $cohortStudent->last_name ?? '---' }}</td>
                                            <td>{{ $cohortStudent->first_name ?? '---' }}</td>
                                            <td>
                                                @if($cohortStudent->birth_date)
                                                    {{ \Carbon\Carbon::parse($cohortStudent->birth_date)->format('d/m/Y') }}
                                                @else
                                                    Pas d'anniversaire
                                                @endif
                                            </td>

                                            <td>

                                                <form action="{{ route('cohort_student.delete', ['userId' => $cohortStudent->id, 'cohortId' => $cohort->id]) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer cet étudiant de cette promotion ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cursor-pointer text-red-600">
                                                        <i class="ki-filled ki-trash"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                                <div class="flex items-center gap-2 order-2 md:order-1">
                                    Show
                                    <select class="select select-sm w-16" data-datatable-size="true" name="perpage"></select>
                                    per page
                                </div>
                                <div class="flex items-center gap-4 order-1 md:order-2">
                                    <span data-datatable-info="true"></span>
                                    <div class="pagination" data-datatable-pagination="true"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-1">
            <div class="card h-full">
                <div class="card-header">
                    <h3 class="card-title">
                        Ajouter un étudiant à la promotion
                    </h3>
                </div>

                @if(session('error'))
                    <script type="text/javascript">
                        window.onload = function() {
                            alert("{{ session('error') }}");
                        };
                    </script>
                @endif

                <form method="POST" action="{{ route('cohort.addStudent', $cohort->id) }}">
                    @csrf
                    <div class="card-body flex flex-col gap-5">

                        <x-forms.dropdown type="select" name="user_id" :label="__('Etudiant')">
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->last_name }} {{ $student->first_name }}
                                </option>
                            @endforeach
                        </x-forms.dropdown>

                        <x-forms.primary-button>
                            {{ __('Valider') }}
                        </x-forms.primary-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('cohort.addTeacher', $cohort->id) }}">
                    @csrf
                    <div class="card-body flex flex-col gap-5">

                        <x-forms.dropdown type="select" name="user_id" :label="__('Enseignant')">
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->last_name }} {{ $teacher->first_name }}
                                </option>
                            @endforeach
                        </x-forms.dropdown>

                        <x-forms.primary-button>
                            {{ __('Valider') }}
                        </x-forms.primary-button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end: grid -->
</x-app-layout>
