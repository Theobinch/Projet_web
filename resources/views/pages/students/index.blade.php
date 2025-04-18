<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Etudiants') }}
            </span>
        </h1>
    </x-slot>

    <!-- begin: grid -->
    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-2">
            <div class="grid">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">Liste des étudiants</h3>
                        <div class="input input-sm max-w-48">
                            <i class="ki-filled ki-magnifier"></i>
                            <input placeholder="Rechercher un étudiant" type="text"/>
                        </div>
                    </div>
                    <div class="card-body">
                        <div data-datatable="true" data-datatable-page-size="5">
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
                                        <th class="w-[70px]"></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($students as $student)
                                        <tr>

                                            <td>
                                                <!-- bouton qui permet de modifier l'etudiant -->
                                                <a class="hover:text-primary cursor-pointer" href="#"
                                                   data-modal-toggle="#student-modal"
                                                   data-student="{{ route('student.form', $student) }}">
                                                    <i class="ki-filled ki-cursor"></i>
                                                </a>
                                                <!-- permet d'entrer le nom de l'etudiant -->
                                                {{ $student->user?->last_name ?? '---' }}</td>
                                                <!-- permet d'entrer le prenom de l'etudiant -->
                                            <td>{{ $student->user?->first_name ?? '---' }}</td>
                                            <td>
                                                <!-- permet d'entrer l'anniversaire de l'etudiant -->
                                                @if($student->user && $student->user->birth_date)
                                                    {{ \Carbon\Carbon::parse($student->user->birth_date)->format('d/m/Y') }}
                                                @else
                                                    Pas d'anniversaire
                                                @endif

                                            </td>
                                            <td>
                                                <div class="flex items-center justify-between">
                                                    <!-- permet de selectionner l'ecole -->
                                                    <a href="#">
                                                        @if ($student->school->name === 'Coding Factory')
                                                            <i class="text-success ki-filled ki-shield-tick"></i>
                                                        @else
                                                            <i class="text-danger ki-filled ki-shield-cross"></i>
                                                       @endif
                                                    </a>

                                                    <!-- permet de supprimer l'etudiant -->
                                                    <form action="{{ route('student.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet étudiant ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="cursor-pointer text-red-600">
                                                            <i class="ki-filled ki-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
                        Ajouter un étudiant
                    </h3>
                </div>

                <!-- formulaire pour ajouter un etudiant -->
                <form method="POST" action="{{ route('student.store') }}">
                    @csrf

                <div class="card-body flex flex-col gap-5">
                    <!-- permet d'ajouter le nom de l'etudiant -->
                    <x-forms.input name="last_name" :label="__('Nom')" />

                    <!-- permet d'ajouter le prenom de l'etudiant -->
                    <x-forms.input name="first_name" :label="__('Prénom')" />

                    <!-- permet d'ajouter l'email de l'etudiant -->
                    <x-forms.input name="email" :label="__('Email')" />

                    <!-- permet d'ajouter l'anniv de l'etudiant -->
                    <x-forms.input type="date" name="birth_date" :label="__('Date de naissance')" placeholder="" />

                    <!-- permet d'ajouter l'etablissement de l'etudiant -->
                    <x-forms.dropdown type="select" name="school" :label="__('Etablissement')">
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </x-forms.dropdown>

                    <!-- bouton pour soumettre le formulaire -->
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

@include('pages.students.student-modal')
