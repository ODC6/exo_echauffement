<script>
import axios from 'axios';
import { API_BASE_URL } from '../constant';


export default {
    data() {
        return {
            data: [],
        }
    },
    mounted() {
        this.fetch_data()
    },
    methods: {
        async fetch_data() {
            try {
                const response = await axios.get(`${API_BASE_URL}/dish/index`)
                this.data = response.data
                console.log(this.data);
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>


<template>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom du plat</th>
                            <th scope="col">Ingredient</th>
                            <th scope="col">Recette</th>
                            <th scope="col">Temps total</th>
                            <th scope="col">Catégorie</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in data" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ row[1] }}</td>
                            <td>{{ row[3] }}</td>
                            <td>{{ row[4] }}</td>
                            <td>{{ row[7] }}</td>
                            <td>{{ row[9] }}</td>
                            <td>
                                <img
                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAWdJREFUSEvFlLlKRDEUhr9pLOwEcQoFwUJRcasVt9Z3EsX38QnGfXkDC/cFRRQLtXCpND+cyJ0xud7ccZg0uWSG7zv5c5IKLR6VFvNpRtABLAGdwDrwHiq2rKAL2AQmDXoJzAM3jZIyAsG3gAngHngFhux7CnjISlIF3cCGi2QcOAMWgQ+gZmurDr5SVtDjYtgGhg1wbrF8mnQMWAOWywiqFovgj8AzMAjcAm/2rXVJNP+MIhEJfggMAHfucGeBFxfPLjBiJL9+kXrIjfBp4BrIdpHgfv1Xp+btoNeq9JVn4XvAqMnmbA7e2ZhA8AOg32KJwbWuHURHSCDozn/AZQ0JrgyuWbdTmav/dXPVJaeugIW/KvdbCgm+7Mc+gwiu/lfmJ9ZFdbc1NSIvkFzwfXsKjt1d0IEWhsci8oJsYYLPAE+pz3teRJ51ZGeRDI/tILXI3P8XeSqaEhaJKFVQx2yLILXi9p7BNyiKUBlj03X8AAAAAElFTkSuQmCC" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>