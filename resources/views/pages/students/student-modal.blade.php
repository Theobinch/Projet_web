@extends('layouts.modal', [
    'id'    => 'student-modal',
    'title'  => 'Informations étudiant',] )

@section('modal-content')
    <form method="POST" action="{{ route('student.store') }}">
        @csrf

        <div class="card-body flex flex-col gap-5">
            <x-forms.input name="last_name" :label="__('Nom')" />

            <x-forms.input name="first_name" :label="__('Prénom')" />

            <x-forms.input name="email" :label="__('Email')" />

            <x-forms.input type="date" name="birth_date" :label="__('Date de naissance')" placeholder="" />

            <x-forms.dropdown type="select" name="school" :label="__('Etablissement')">
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </x-forms.dropdown>

            <x-forms.primary-button>
                {{ __('Valider') }}
            </x-forms.primary-button>
        </div>
        </form>

    <form action="{{ route('student.destroy', $student->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <x-forms.primary-button>
            {{ __('Supprimer') }}
        </x-forms.primary-button>
    </form>
@overwrite
