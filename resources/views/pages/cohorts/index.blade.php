<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Promotions') }}
            </span>
        </h1>
    </x-slot>

    <!-- begin: grid -->
    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-2">
            <div class="grid">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">Mes promotions</h3>
                    </div>
                    <div class="card-body">
                        <div data-datatable="true" data-datatable-page-size="5">
                            <div class="scrollable-x-auto">
                                <table class="table table-border" data-datatable-table="true">
                                    <thead>
                                    <tr>
                                        <th class="min-w-[280px]">
                                            <span class="sort asc">
                                                 <span class="sort-label">Promotion</span>
                                                 <span class="sort-icon"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[135px]">
                                            <span class="sort">
                                                <span class="sort-label">Année</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                        </th>
                                        <th class="min-w-[135px]">
                                            <span class="sort">
                                                <span class="sort-label">Etudiants</span>
                                                <span class="sort-icon"></span>
                                            </span>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($cohorts as $cohort)
                                        <tr>
                                            <td>
                                                <!-- ouverture du modal pour modifier -->
                                                <a class="hover:text-primary cursor-pointer" href="#"
                                                   data-modal-toggle="#cohort-modal"
                                                   data-cohort="{{ route('cohort.form', $cohort) }}">
                                                    <i class="ki-filled ki-cursor"></i>
                                                </a>

                                                <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                                                    href="{{ route('cohort.show', $cohort->id) }}">
                                                    {{ $cohort->name ?? '---' }}</a>
                                            </td>
                                            <td>
                                                <!-- date de debut et fin de la promo -->
                                                @if ($cohort->start_date && $cohort->end_date)
                                                    {{ \Carbon\Carbon::parse($cohort->start_date)->format('Y') }} -
                                                    {{ \Carbon\Carbon::parse($cohort->end_date)->format('Y') }}
                                                @else
                                                    Pas de début
                                                @endif
                                            </td>
                                            <td>
                                                <!-- nombre des etudiants et bouton supprimer -->
                                                <div class="flex items-center justify-between">
                                                    <a href="#">
                                                        <span>{{ $cohort->studentCount }}</span>
                                                    </a>

                                                    <!-- formulaire pour supprimer la promotion -->
                                                    <form action="{{ route('cohort.destroy', $cohort->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette promotion ?')">
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
                        Ajouter une promotion
                    </h3>
                </div>

                <form method="POST" action="{{ route('cohort.store') }}">
                    @csrf

                    <div class="card-body flex flex-col gap-5">
                        <!-- nom de la promo -->
                        <x-forms.input name="name" :label="__('Nom')" />

                        <!-- description de la promo -->
                        <x-forms.input name="description" :label="__('Description')" />

                        <!-- ecole de la promo -->
                        <x-forms.dropdown name="school_id" :label="__('École')">
                            <!-- montre les ecoles disponible -->
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-forms.dropdown>

                        <!-- date de debut de la promo -->
                        <x-forms.input type="date" name="start_date" :label="__('Début de l\'année')" />

                        <!--date de fin de la promo -->
                        <x-forms.input type="date" name="end_date" :label="__('Fin de l\'année')" />

                        <!-- bouton pour transmettre le formulaire -->
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

@include('pages.cohorts.cohort-modal')
