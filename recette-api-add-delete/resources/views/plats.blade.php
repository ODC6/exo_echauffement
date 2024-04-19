@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ isset($dish) ? route('update', $dish->id) : route('store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="dish_name" class="form-label">Nom du plat</label>
                            <input type="text" name="dish_name" id="dish_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="dish_ingredient" class="form-label">Ingrédient (Séparé chaque Ingrédient par une
                                virgule)</label>
                            <input type="text" name="dish_ingredient" id="dish_ingredient" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="dish_recette" class="form-label">Recette</label>
                            <textarea name="dish_recette" id="dish_recette" cols="30" rows="10" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="preparation" class="form-label">Temps de préparation</label>
                            <input type="time" name="preparation" id="preparation" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cuissons" class="form-label">Temps de cuissons</label>
                            <input type="time" name="cuissons" id="cuissons" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="temps_total" class="form-label">Temps total</label>
                            <input type="time" name="temps_total" id="temps_total" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_category" class="form-label">Categorie de plat</label>
                            <select name="id_category" id="id_category" class="form-select" required>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <dish-component />
        </div>
    </div>
@endsection
