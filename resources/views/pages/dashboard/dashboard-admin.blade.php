<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Dashboard') }}
            </span>
        </h1>
    </x-slot>

    <!-- begin: grid -->

    <div class="grid lg:grid-cols-2 gap-5 lg:gap-7.5 items-stretch">
        <!-- permet d'afficher le nombre des promotions present dans la bdd -->
        <form method="GET" action="{{ route('cohort.index') }}">
            <div class="lg:col-span-2">
                <div class="grid">
                    <div class="card card-grid h-full min-w-full">
                        <div class="card-header">
                            <h3 class="card-title">
                                Promotions
                            </h3>
                            <a href="#">
                                <span>{{ $cohortCount }}</span>
                            </a>
                        </div>
                        <div class="card-body flex flex-col gap-5">
                            <!-- bouton d'acces rapide qui ramene sur la page cohort index -->
                            <x-forms.primary-button>
                                {{ __('Accès rapide') }}
                            </x-forms.primary-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- permet d'afficher le nombre d'enseignant present dans la bdd -->
        <form method="GET" action="{{ route('teacher.index') }}">
            <div class="lg:col-span-2">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">
                            Enseignants
                        </h3>
                        <a href="#">
                            <span>{{ $teacherCount }}</span>
                        </a>
                    </div>
                    <!-- bouton d'acces rapide qui ramene sur la page teacher index -->
                    <x-forms.primary-button>
                        {{ __('Accès rapide') }}
                    </x-forms.primary-button>
                </div>
            </div>
        </form>

        <!-- permet d'afficher le nombre d'etudiant present dans la bdd -->
        <form method="GET" action="{{ route('student.index') }}">
            <div class="lg:col-span-2">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">
                            Etudiants
                        </h3>
                        <a href="#">
                            <span>{{ $studentCount }}</span>
                        </a>
                    </div>
                    <!-- bouton d'acces rapide qui ramene sur la page student index -->
                    <x-forms.primary-button>
                        {{ __('Accès rapide') }}
                    </x-forms.primary-button>
                </div>
            </div>
        </form>

        <!-- permet d'afficher le nombre de groupe present dans la bdd -->
        <form method="GET" action="{{ route('group.index') }}">
            <div class="lg:col-span-2">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">
                            Groupes
                        </h3>
                        <h4>0</h4>
                    </div>
                    <!-- bouton d'acces rapide qui ramene sur la page group index -->
                    <x-forms.primary-button>
                        {{ __('Accès rapide') }}
                    </x-forms.primary-button>
                </div>
            </div>
        </form>

    </div>

    <!-- end: grid -->
</x-app-layout>
