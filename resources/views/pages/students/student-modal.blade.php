@extends('layouts.modal', [
    'id'    => 'student-modal',
    'title'  => 'Informations étudiant',] )

@section('modal-content')
    <form method="POST" action="{{ route('student.update', $student->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body flex flex-col gap-5">
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

            <x-forms.dropdown
                name="school_id"
                :label="__('Etablissement')"
            >
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}"
                        {{ old('school_id', $student->school->id ?? '') == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </x-forms.dropdown>

            <x-forms.primary-button class="mt-4">
                {{ __('Enregistrer les modifications') }}
            </x-forms.primary-button>
        </div>
    </form>

@overwrite
