<form method="POST" action="{{ route('cohort.update', $cohort->id) }}">
    @csrf
    @method('PUT')

    <div class="card-body flex flex-col gap-5">
        <x-forms.input
            name="name"
            :label="__('Nom')"
            :value="old('name', $cohort->name)"
            :messages="$errors->get('name')"
        />

        <x-forms.input type="date"
            name="start_date"
            :label="__('Date de début')"
            :value="old('start_date', \Carbon\Carbon::parse($cohort->start_date)->format('Y-m-d'))"
            :messages="$errors->get('start_date')"
        />

        <x-forms.input
            type="date"
            name="end_date"
            :label="__('Date de fin')"
            :value="old('end_date', \Carbon\Carbon::parse($cohort->end_date)->format('Y-m-d'))"
            :messages="$errors->get('end_date')"
        />

        <x-forms.primary-button class="mt-4">
            {{ __('Enregistrer les modifications') }}
        </x-forms.primary-button>
    </div>
</form>

