<form method="POST" action="{{ route('student.update', $student->id) }}">
    @csrf
    @method('PUT')

        <x-forms.input
            name="last_name"
            :label="__('Nom')"
            :value="old('last_name', $student->last_name)"
            :messages="$errors->get('last_name')"
        />

        <x-forms.input
            name="first_name"
            :label="__('Prénom')"
            :value="old('first_name', $student->first_name)"
            :messages="$errors->get('first_name')"
        />

        <x-forms.input
            type="date"
            name="birth_date"
            :label="__('Date de naissance')"
            :value="old('birth_date', $student->birth_date)"
            :messages="$errors->get('birth_date')"
        />

        <x-forms.input
            type="email"
            name="email"
            :label="__('Email')"
            :value="old('email', $student->email)"
            :messages="$errors->get('email')"
        />

        <x-forms.primary-button class="mt-4">
            {{ __('Enregistrer les modifications') }}
        </x-forms.primary-button>
</form>

