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
                                                <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                                                    href="{{ route('cohort.show', 1) }}">
                                                    {{ $cohort->name ?? '---' }}</a>
                                            </td>
                                            <td>
                                                @if ($cohort->start_date && $cohort->end_date)
                                                    {{ \Carbon\Carbon::parse($cohort->start_date)->format('Y') }} -
                                                    {{ \Carbon\Carbon::parse($cohort->end_date)->format('Y') }}
                                                @else
                                                    Pas de début
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex items-center justify-between">
                                                    <a href="#">
                                                        <span>{{ $cohort->students_count ?? '0' }}</span>
                                                    </a>
                                                    <a class="hover:text-primary cursor-pointer" href="#"
                                                       data-modal-toggle="#cohort-modal">
                                                        <i class="ki-filled ki-cursor"></i>
                                                    </a>

                                                    <form action="{{ route('cohort.destroy', $cohort->id) }}" method="POST" onsubmit="return confirm('Tu veux vraiment supp ?');">
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
                        <x-forms.input name="name" :label="__('Nom')" />

                        <x-forms.input name="description" :label="__('Description')" />

                        <x-forms.dropdown name="school_id" :label="__('École')">
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-forms.dropdown>

                        <x-forms.input type="date" name="start_date" :label="__('Début de l\'année')" />

                        <x-forms.input type="date" name="end_date" :label="__('Fin de l\'année')" />

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
