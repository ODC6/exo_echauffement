<script>
import axios from 'axios';
import { API_BASE_URL, API_LARAVEL_BASE } from '../constant';

export default {
    data() {
        return {
            data: [],
            category: {
                id: null,
                category_name: ''
            }
        }
    },
    mounted() {
        this.index_data()
    },
    methods: {
        async index_data() {
            try {
                const response = await axios.get(`${API_BASE_URL}/category/index`)
                this.data = response.data
            } catch (error) {
                console.log(error);
            }
        },

        handleCick(data) {
            this.category = {
                id: data.id,
                category_name: data.name
            }
        },

        async handleSubmit() {
            try {

                let response;
                if (this.category.id != null) {
                    response = await axios.put(`${API_BASE_URL}/category/edit/${this.category.id}`, this.category)
                } else {
                    response = await axios.post(`${API_LARAVEL_BASE}/admin/category/store`, this.category)
                }

                this.index_data()
            } catch (error) {
                console.log(error);
            }
        },


        async deleteData(id) {
            try {
                const response = await axios.delete(`${API_LARAVEL_BASE}/admin/category/delete?id_category=${id}`)
                if (response.data.status == 200) {
                    this.index_data()
                }
            } catch (error) {

            }
        }
    }
}
</script>

<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="handleSubmit">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Categorie</label>
                            <input type="text" name="category_name" id="category_name" v-model="category.category_name"
                                class="form-control" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Categorie</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in data" :key="index">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ row.name }}</td>
                                    <td>
                                        <button class="btn btn-primary mx-3" @click="handleCick(row)">Modifier</button>
                                        <button class="btn btn-danger" @click="deleteData(row.id)">Supprimer</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>