<form method="POST" action="{{ route('teacher.update', $teacher->id) }}">
    @csrf
    @method('PUT')

        <x-forms.input
            name="last_name"
            :label="__('Nom')"
            :value="old('last_name', $teacher->last_name)"
            :messages="$errors->get('last_name')"
        />

        <x-forms.input
            name="first_name"
            :label="__('Prénom')"
            :value="old('first_name', $teacher->first_name)"
            :messages="$errors->get('first_name')"
        />

        <x-forms.input
            type="email"
            name="email"
            :label="__('Email')"
            :value="old('email', $teacher->email)"
            :messages="$errors->get('email')"
        />

        <x-forms.primary-button class="mt-4">
            {{ __('Enregistrer les modifications') }}
        </x-forms.primary-button>
</form>

